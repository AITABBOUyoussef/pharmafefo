<div class="bg-white p-8 rounded-lg shadow-md max-w-md mx-auto mt-10 border border-gray-200">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-2">Nouvelle Entrée en Stock</h2>
    
    <!-- L'attribut action kiwri l'formulaire fin ysifet data, w POST hiya tariqa sécurisée -->
    <form action="index.php?action=save_batch" method="POST">
        
        <!-- 1. Le Médicament (Liste déroulante) -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Médicament</label>
            <select name="product_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500" required>
                <option value="">Sélectionnez un médicament...</option>
                <!-- Hado mn be3d ghadi njibohom dynamiquement mn PHP -->
                <option value="1">Doliprane 1000mg</option>
                <option value="2">Amoxicilline 500mg</option>
            </select>
        </div>

        <!-- 2. Numéro de Lot -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Numéro de Lot</label>
            <input type="text" name="batch_number" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500" placeholder="Ex: LOT-1234" required>
        </div>

        <!-- 3. Quantité Reçue -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Quantité Reçue</label>
            <input type="number" name="quantity" min="1" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500" placeholder="Ex: 50" required>
        </div>

        <!-- 4. Date de Péremption (DLU) -->
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Date de Péremption (DLU)</label>
            <input type="date" name="expiration_date" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500" required>
        </div>

        <!-- Bouton de validation -->
        <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 transition duration-200">
            Enregistrer l'entrée
        </button>

    </form>
</div>