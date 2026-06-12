<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PharmaFEFO - Tableau de Bord</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex h-screen overflow-hidden antialiased font-sans">

    <!-- Sidebar (Khelitha kima hiya bach manketerch lcode hna) -->
    <aside class="w-64 bg-slate-900 text-gray-300 flex flex-col shadow-xl">
        <div class="h-16 flex items-center px-6 border-b border-slate-800">
            <span class="text-xl font-bold text-white tracking-wider">⚕️ PharmaFEFO</span>
        </div>
        <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="#" class="block px-3 py-2 bg-slate-800 text-white rounded-md">Tableau de Bord</a>
            <a href="#" class="block px-3 py-2 hover:bg-slate-800 rounded-md">Entrées & Sorties</a>
        </nav>
    </aside>

    <!-- Zone de Contenu -->
    <main class="flex-1 flex flex-col overflow-hidden">
        <header class="h-16 bg-white shadow-sm flex items-center px-8 border-b border-gray-200">
            <h1 class="text-2xl font-semibold text-gray-800">Surveillance des Péremptions</h1>
        </header>

        <div class="flex-1 overflow-y-auto p-8">
            <div class="bg-white rounded-lg shadow border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 rounded-t-lg">
                    <h2 class="text-lg font-medium text-gray-800">Lots classés par criticité</h2>
                </div>
                
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50 text-gray-500 uppercase tracking-wider text-xs">
                        <tr>
                            <th class="px-6 py-3 text-left font-medium">Médicament</th>
                            <th class="px-6 py-3 text-left font-medium">Numéro de Lot</th>
                            <th class="px-6 py-3 text-left font-medium">DLU</th>
                            <th class="px-6 py-3 text-left font-medium">Criticité</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        
                        <?php if (empty($lots)): ?>
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">Aucun lot en stock.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($lots as $lot): ?>
                                
                                <?php
                                    $bgColor = '';
                                    $textColor = '';
                                    $dotColor = '';
                                    
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
    </main>

</body>
</html>