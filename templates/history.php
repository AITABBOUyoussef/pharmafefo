<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>PharmaFEFO - Historique des Mouvements</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex h-screen overflow-hidden antialiased font-sans">

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
            <a href="index.php?action=dashboard" class="block px-3 py-2 hover:bg-slate-800 text-gray-300 rounded-md transition-colors">Tableau de Bord</a>
            <a href="index.php?action=history" class="block px-3 py-2 bg-slate-800 text-white rounded-md font-medium shadow-sm">Entrées & Sorties</a>
        </nav>
        <div class="p-4 border-t border-slate-800">
            <a href="index.php?action=logout" class="block w-full text-center px-4 py-2 text-sm text-red-400 border border-red-900 rounded hover:bg-red-500 hover:text-white transition-colors">Se déconnecter</a>
        </div>
    </aside>

    <main class="flex-1 flex flex-col overflow-hidden relative">
        <header class="h-16 bg-white shadow-sm flex items-center px-8 border-b border-gray-200 z-10">
            <h1 class="text-2xl font-semibold text-gray-800">Historique des Mouvements (Traçabilité)</h1>
        </header>

        <div class="flex-1 overflow-y-auto p-8 z-0">
            <div class="bg-white rounded-lg shadow border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50 text-gray-500 uppercase tracking-wider text-xs">
                        <tr>
                            <th class="px-6 py-3 text-left font-medium">Date & Heure</th>
                            <th class="px-6 py-3 text-left font-medium">Utilisateur</th>
                            <th class="px-6 py-3 text-left font-medium">Type</th>
                            <th class="px-6 py-3 text-left font-medium">Médicament</th>
                            <th class="px-6 py-3 text-left font-medium">N° Lot</th>
                            <th class="px-6 py-3 text-left font-medium">Quantité</th>
                            <th class="px-6 py-3 text-left font-medium">Note</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if (empty($movements)): ?>
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500 font-medium">Aucun mouvement enregistré pour le moment.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($movements as $mov): ?>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 text-gray-600 font-medium"><?= date('d/m/Y H:i', strtotime($mov['movement_date'])) ?></td>
                                    <td class="px-6 py-4 text-gray-800 font-semibold"><?= htmlspecialchars($mov['user_name']) ?></td>
                                    <td class="px-6 py-4">
                                        <?php if ($mov['type'] === 'ENTRY'): ?>
                                            <span class="px-2.5 py-1 bg-blue-100 text-blue-800 text-xs font-bold rounded-full">ENTRÉE</span>
                                        <?php else: ?>
                                            <span class="px-2.5 py-1 bg-orange-100 text-orange-800 text-xs font-bold rounded-full">SORTIE</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 text-gray-900 font-medium"><?= htmlspecialchars($mov['product_name']) ?></td>
                                    <td class="px-6 py-4 text-gray-500"><?= htmlspecialchars($mov['batch_number']) ?></td>
                                    <td class="px-6 py-4 text-gray-900 font-bold"><?= htmlspecialchars($mov['quantity']) ?></td>
                                    <td class="px-6 py-4 text-gray-500 text-xs"><?= htmlspecialchars($mov['note']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>