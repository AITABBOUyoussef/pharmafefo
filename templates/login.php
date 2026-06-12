<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PharmaFEFO - Connexion</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 flex items-center justify-center h-screen antialiased font-sans">

    <div class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-sm">
        
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-slate-800 tracking-wider mb-1">⚕️ PharmaFEFO</h1>
            <p class="text-sm text-gray-500">Gestion Intelligente de Stock</p>
        </div>

        <?php if (isset($_GET['error']) && $_GET['error'] == 'invalid_credentials'): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm text-center">
                Email ou mot de passe incorrect.
            </div>
        <?php endif; ?>

        <form action="index.php?action=login_process" method="POST">
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Adresse Email</label>
                <input type="email" id="email" name="email" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none transition-colors" placeholder="pharmacien@pharmafefo.com" required>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Mot de passe</label>
                <input type="password" id="password" name="password" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none transition-colors" placeholder="••••••••" required>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded-lg shadow-lg transition duration-200">
                Se Connecter
            </button>
            
        </form>

    </div>

</body>
</html>