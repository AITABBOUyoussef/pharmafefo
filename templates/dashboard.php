<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>PharmaFEFO - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex h-screen overflow-hidden">
    <aside class="w-64 bg-slate-900 text-gray-300 flex flex-col shadow-xl z-20">
        <div class="h-16 flex items-center px-6 border-b border-slate-800">
       
            <span class="text-xl font-bold text-white">⚕️ PharmaFEFO</span>
        </div>
        <div class="px-6 py-4 border-b border-slate-800 bg-slate-800/50">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">
                    <?= substr($_SESSION['user_name'] ?? 'U', 0, 1) ?>
                </div>
                <div>
                    <p class="text-sm font-medium text-white"><?= htmlspecialchars($_SESSION['user_name'] ?? 'Utilisateur') ?></p>
                    <p class="text-xs text-blue-400"><?= htmlspecialchars($_SESSION['user_role'] ?? '') ?></p>
                </div>
            </div>
        </div>
       <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="index.php?action=dashboard" class="block px-3 py-2 bg-slate-800 text-white rounded-md font-medium shadow-sm">Tableau de Bord</a>
            <a href="index.php?action=history" class="block px-3 py-2 hover:bg-slate-800 text-gray-300 rounded-md transition-colors">Entrées & Sorties</a>
        </nav>
        <div class="p-4 border-t border-slate-800">
            <a href="index.php?action=logout" class="block w-full text-center px-4 py-2 text-sm text-red-400 border border-red-900 rounded">Se déconnecter</a>
        </div>
    </aside>

    <main class="flex-1 flex flex-col relative">
        <header class="h-16 bg-white shadow-sm flex items-center justify-between px-8 border-b z-10">
            <h1 class="text-2xl font-semibold">Surveillance Stock</h1>
            <div class="flex gap-3">
                <button onclick="document.getElementById('modalSortie').classList.remove('hidden')" class="bg-orange-500 text-white px-4 py-2 rounded">- Sortie FEFO</button>
                <button onclick="document.getElementById('modalEntree').classList.remove('hidden')" class="bg-blue-600 text-white px-4 py-2 rounded">+ Entrée</button>
            </div>
        </header>

        <div class="p-8 flex-1 overflow-y-auto">
            <?php if(isset($_GET['success'])): ?><div class="bg-green-100 text-green-700 p-3 rounded mb-4">Opération réussie !</div><?php endif; ?>
            <?php if(isset($_GET['error'])): ?><div class="bg-red-100 text-red-700 p-3 rounded mb-4">Erreur: Stock insuffisant ou problème.</div><?php endif; ?>

            <table class="min-w-full bg-white rounded-lg shadow overflow-hidden">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase text-left">
                    <tr>
                        <th class="px-6 py-3">Produit</th>
                        <th class="px-6 py-3">Lot</th>
                        <th class="px-6 py-3">Qté</th>
                        <th class="px-6 py-3">Péremption</th>
                        <th class="px-6 py-3">État</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    <?php foreach ($lots as $lot): ?>
                        <?php
                        $bgColor = ''; $textColor = ''; $dotColor = '';
                            if ($lot['criticality_level'] === 'RED') {
                                $bgColor = 'bg-red-100'; $textColor = 'text-red-800'; $dotColor = 'bg-red-500';
                            } elseif ($lot['criticality_level'] === 'ORANGE') {
                                $bgColor = 'bg-orange-100'; $textColor = 'text-orange-800'; $dotColor = 'bg-orange-500';
                            } else {
                                $bgColor = 'bg-green-100'; $textColor = 'text-green-800'; $dotColor = 'bg-green-500';
                            }
                        ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900"><?= htmlspecialchars($lot['product_name']) ?></td>
                            <td class="px-6 py-4 text-gray-500"><?= htmlspecialchars($lot['batch_number']) ?></td>
                            <td class="px-6 py-4 font-bold text-gray-900"><?= htmlspecialchars($lot['qty_available']) ?></td>
                            <td class="px-6 py-4 font-semibold text-gray-900"><?= date('d/m/Y', strtotime($lot['expiration_date'])) ?></td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $bgColor ?> <?= $textColor ?>">
                                    <span class="w-1.5 h-1.5 <?= $dotColor ?> rounded-full mr-1.5"></span>
                                    <?= htmlspecialchars($lot['criticality_label']) ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div id="modalEntree" class="hidden absolute inset-0 bg-black/50 flex justify-center items-center z-50 backdrop-blur-sm">
            <form action="index.php?action=save_batch" method="POST" class="bg-white p-6 rounded-lg shadow-xl w-96">
                <h3 class="text-lg font-bold mb-4">Nouvelle Entrée</h3>
                <select name="product_id" class="w-full border p-2 mb-3 rounded" required>
                    <option value="1">Doliprane 1000mg</option>
                    <option value="2">Amoxicilline 500mg</option>
                </select>
                <input type="text" name="batch_number" placeholder="Num Lot" class="w-full border p-2 mb-3 rounded" required>
                <input type="number" name="quantity" placeholder="Quantité" class="w-full border p-2 mb-3 rounded" required>
                <input type="date" name="expiration_date" class="w-full border p-2 mb-4 rounded" required>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('modalEntree').classList.add('hidden')" class="bg-gray-200 px-4 py-2 rounded">Annuler</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Enregistrer</button>
                </div>
            </form>
        </div>

      <div id="modalSortie" class="hidden absolute inset-0 bg-black/50 flex justify-center items-center z-50 backdrop-blur-sm">
            <form action="index.php?action=exit_stock" method="POST" class="bg-white p-6 rounded-lg shadow-xl w-96">
                <h3 class="text-lg font-bold mb-4">Sortie FEFO</h3>
                
                <select name="product_id" class="w-full border p-2 mb-3 rounded" required>
                    <option value="">Sélectionnez un médicament...</option>
                    <?php foreach ($products as $product): ?>
                        <option value="<?= htmlspecialchars($product['id']) ?>">
                            <?= htmlspecialchars($product['designation']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <input type="number" name="quantity" placeholder="Quantité à sortir" min="1" class="w-full border p-2 mb-3 rounded" required>
                
                <input type="text" name="note" placeholder="Motif (ex: Vente, Ordonnance...)" class="w-full border p-2 mb-4 rounded focus:ring-2 focus:ring-orange-500 outline-none">
                
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('modalSortie').classList.add('hidden')" class="bg-gray-200 px-4 py-2 rounded">Annuler</button>
                    <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded">Valider Sortie</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>