<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PharmaFEFO - Tableau de Bord</title>
    <!-- CDN Tailwind CSS (Standard pour le dev rapide) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Configuration des couleurs personnalisées Tailwind si besoin -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        pharma: {
                            900: '#0f172a', // Slate 900
                            800: '#1e293b', // Slate 800
                            500: '#3b82f6', // Blue 500
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 flex h-screen overflow-hidden antialiased font-sans">

    <!-- Sidebar (Menu Latéral Professionnel) -->
    <aside class="w-64 bg-pharma-900 text-gray-300 flex flex-col shadow-xl">
        <div class="h-16 flex items-center px-6 border-b border-pharma-800">
            <span class="text-xl font-bold text-white tracking-wider">⚕️ PharmaFEFO</span>
        </div>
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <a href="#" class="flex items-center gap-3 px-3 py-2 bg-pharma-800 text-white rounded-md transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Tableau de Bord
            </a>
            <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-pharma-800 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                Réception (Entrées)
            </a>
            <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-pharma-800 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Sorties FEFO
            </a>
        </nav>
        <div class="p-4 border-t border-pharma-800">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-pharma-500 flex items-center justify-center text-white font-bold">P</div>
                <div class="text-sm">
                    <p class="text-white font-medium">Pharmacien Titulaire</p>
                    <p class="text-gray-400 text-xs">Connecté</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Zone de Contenu Principal -->
    <main class="flex-1 flex flex-col overflow-hidden">
        <!-- Topbar -->
        <header class="h-16 bg-white shadow-sm flex items-center justify-between px-8 border-b border-gray-200">
            <h1 class="text-2xl font-semibold text-gray-800">Surveillance des Péremptions</h1>
        </header>

        <!-- Contenu -->
        <div class="flex-1 overflow-y-auto p-8">
            
            <!-- Tableau des Lots (Data Table) -->
            <div class="bg-white rounded-lg shadow border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gray-50 rounded-t-lg">
                    <h2 class="text-lg font-medium text-gray-800">Lots classés par criticité</h2>
                    <button class="text-sm text-red-600 hover:text-red-800 font-medium flex items-center gap-1 bg-red-50 px-3 py-1.5 rounded-md border border-red-100 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        Filtrer "Alerte Rouge"
                    </button>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-gray-500 uppercase tracking-wider text-xs">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left font-medium">Médicament</th>
                                <th scope="col" class="px-6 py-3 text-left font-medium">Numéro de Lot</th>
                                <th scope="col" class="px-6 py-3 text-left font-medium">DLU</th>
                                <th scope="col" class="px-6 py-3 text-left font-medium">Criticité</th>
                                <th scope="col" class="px-6 py-3 text-right font-medium">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            
                            <!-- Ligne Rouge (< 30 jours) -->
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">Doliprane 1000mg</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-500">LOT-8475</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-900 font-semibold">15/06/2026</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1.5"></span>
                                        Rouge (< 30 jours)
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="#" class="text-pharma-500 hover:text-pharma-800">Gérer</a>
                                </td>
                            </tr>

                            <!-- Ligne Orange (< 90 jours) -->
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">Amoxicilline 500mg</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-500">LOT-1120</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-500">20/08/2026</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                        <span class="w-1.5 h-1.5 bg-orange-500 rounded-full mr-1.5"></span>
                                        Orange (< 90 jrs)
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="#" class="text-pharma-500 hover:text-pharma-800">Gérer</a>
                                </td>
                            </tr>

                            <!-- Ligne Verte (> 6 mois) -->
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">Spasfon</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-500">LOT-9988</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-500">10/12/2027</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span>
                                        Vert (> 6 mois)
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="#" class="text-pharma-500 hover:text-pharma-800">Gérer</a>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

</body>
</html>