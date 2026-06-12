<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PharmaFEFO - Tableau de Bord</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex h-screen overflow-hidden antialiased font-sans">

    <aside class="w-64 bg-slate-900 text-gray-300 flex flex-col shadow-xl z-20">
        <div class="h-16 flex items-center px-6 border-b border-slate-800">
            <span class="text-xl font-bold text-white tracking-wider">⚕️ PharmaFEFO</span>
        </div>
        <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="index.php?action=dashboard" class="block px-3 py-2 bg-slate-800 text-white rounded-md">Tableau de Bord</a>
            <a href="#" class="block px-3 py-2 hover:bg-slate-800 rounded-md transition-colors">Entrées & Sorties</a>
        </nav>
    </aside>

    <main class="flex-1 flex flex-col overflow-hidden relative">
        
        <header class="h-16 bg-white shadow-sm flex items-center justify-between px-8 border-b border-gray-200 z-10">
            <h1 class="text-2xl font-semibold text-gray-800">Surveillance des Péremptions</h1>
            
            <div class="flex gap-3">
                <button onclick="document.getElementById('exitStockModal').classList.remove('hidden')" class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded shadow transition-colors">
                    - Nouvelle Sortie
                </button>
                <button onclick="document.getElementById('addStockModal').classList.remove('hidden')" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow transition-colors">
                    + Nouvelle Entrée
                </button>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-8 z-0">
            <div class="bg-white rounded-lg shadow border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 rounded-t-lg">
                    <h2 class="text-lg font-medium text-gray-800">Lots classés par criticité</h2>
                </div>
                
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50 text-gray-500 uppercase tracking-wider text-xs">
                        <tr>
                            <th class="px-6 py-3 text-left font-medium">Médicament</th>
                            <th class="px-6 py-3 text-left font-medium">Numéro de Lot</th>
                            <th class="px-6 py-3 text-left font-medium">Quantité</th>
                            <th class="px-6 py-3 text-left font-medium">DLU (Péremption)</th>
                            <th class="px-6 py-3 text-left font-medium">Criticité</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if (empty($lots)): ?>
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Aucun lot en stock.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($lots as $lot): ?>
                                <?php
                                    // Logique des couleurs selon le niveau de criticité
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
                                    <td class="px-6 py-4 text-gray-900 font-medium"><?= htmlspecialchars($lot['qty_available']) ?></td>
                                    <td class="px-6 py-4 font-semibold text-gray-900"><?= date('d/m/Y', strtotime($lot['expiration_date'])) ?></td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $bgColor ?> <?= $textColor ?>">
                                            <span class="w-1.5 h-1.5 <?= $dotColor ?> rounded-full mr-1.5"></span>
                                            <?= htmlspecialchars($lot['criticality_label']) ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="addStockModal" class="hidden absolute inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50 backdrop-blur-sm transition-opacity">
            <div class="bg-white rounded-lg shadow-2xl w-full max-w-md overflow-hidden relative">
                
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
                    <h3 class="text-lg font-bold text-gray-800">Nouvelle Entrée en Stock</h3>
                    <button onclick="document.getElementById('addStockModal').classList.add('hidden')" class="text-gray-400 hover:text-red-500 font-bold text-xl focus:outline-none">
                        &times;
                    </button>
                </div>

                <form action="index.php?action=save_batch" method="POST" class="p-6">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Médicament</label>
                        <select name="product_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none" required>
                            <option value="">Sélectionnez un médicament...</option>
                            <option value="1">Doliprane 1000mg</option>
                            <option value="2">Amoxicilline 500mg</option>
                            <option value="3">Spasfon</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Numéro de Lot</label>
                        <input type="text" name="batch_number" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Ex: LOT-1234" required>
                    </div>

                    <div class="flex gap-4 mb-6">
                        <div class="w-1/2">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Qté Reçue</label>
                            <input type="number" name="quantity" min="1" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none" placeholder="0" required>
                        </div>
                        <div class="w-1/2">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Date (DLU)</label>
                            <input type="date" name="expiration_date" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none" required>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 mt-2">
                        <button type="button" onclick="document.getElementById('addStockModal').classList.add('hidden')" class="px-4 py-2 bg-gray-200 text-gray-800 rounded font-medium hover:bg-gray-300 transition duration-200">
                            Annuler
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded font-medium hover:bg-blue-700 transition duration-200 shadow">
                            Enregistrer l'entrée
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div id="exitStockModal" class="hidden absolute inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50 backdrop-blur-sm transition-opacity">
            <div class="bg-white rounded-lg shadow-2xl w-full max-w-md overflow-hidden relative">
                
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
                    <h3 class="text-lg font-bold text-gray-800">Sortie de Stock (FEFO)</h3>
                    <button onclick="document.getElementById('exitStockModal').classList.add('hidden')" class="text-gray-400 hover:text-red-500 font-bold text-xl focus:outline-none">
                        &times;
                    </button>
                </div>

                <form action="index.php?action=exit_stock" method="POST" class="p-6">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Médicament à faire sortir</label>
                        <select name="product_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-orange-500 outline-none" required>
                            <option value="">Sélectionnez un médicament...</option>
                            <option value="1">Doliprane 1000mg</option>
                            <option value="2">Amoxicilline 500mg</option>
                            <option value="3">Spasfon</option>
                        </select>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Quantité à retirer</label>
                        <input type="number" name="quantity" min="1" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-orange-500 outline-none" placeholder="Ex: 5" required>
                        <p class="text-xs text-gray-500 mt-2">Le système sélectionnera automatiquement le lot le plus proche de sa date de péremption.</p>
                    </div>

                    <div class="flex justify-end gap-3 mt-2">
                        <button type="button" onclick="document.getElementById('exitStockModal').classList.add('hidden')" class="px-4 py-2 bg-gray-200 text-gray-800 rounded font-medium hover:bg-gray-300 transition duration-200">
                            Annuler
                        </button>
                        <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded font-medium hover:bg-orange-600 transition duration-200 shadow">
                            Valider la sortie
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </main>
</body>
</html>