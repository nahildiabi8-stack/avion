<?php
require_once __DIR__ . '/../src/Managers/Manager.php';
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - ComparOperator</title>
    <link href="../assets/tailwind/output.css" rel="stylesheet">
</head>
<body class="bg-blue-50 text-gray-900 min-h-screen flex items-center justify-center select-none">

    <div class="w-full max-w-md">

        <!-- Logo -->
        <div class="text-center mb-8">
            <a href="index.php" class="text-2xl font-black tracking-tight">Compar<span class="text-blue-500">Operator</span></a>
        </div>

        <!-- Card -->
        <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">

            <!-- Tabs -->
            <div class="flex border border-gray-200 rounded-xl p-1 mb-6">
                <button onclick="showTab('register')" id="tab-register" class="flex-1 py-2 rounded-lg text-sm font-medium bg-gray-900 text-white transition-colors">
                    S'inscrire
                </button>
                <button onclick="showTab('login')" id="tab-login" class="flex-1 py-2 rounded-lg text-sm font-medium text-gray-500 transition-colors">
                    Se connecter
                </button>
            </div>

            <!-- Formulaire inscription -->
            <form id="form-register" action="../src/Controllers/register_process.php" method="POST" class="flex flex-col gap-4">
                <div class="grid grid-cols-2 gap-3">
                    <div class="flex flex-col gap-1">
                        <label class="text-sm font-medium">Nom</label>
                        <input type="text" name="nom" required placeholder="Dupont" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-500">
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-sm font-medium">Prénom</label>
                        <input type="text" name="prenom" required placeholder="Jean" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-500">
                    </div>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="text-sm font-medium">Âge</label>
                    <input type="number" name="age" required min="1" max="120" placeholder="25" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-500">
                </div>
                <div class="flex flex-col gap-1">
                    <label class="text-sm font-medium">Sexe</label>
                    <select name="sexe" required class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-500">
                        <option value="">-- Choisir --</option>
                        <option value="homme">Homme</option>
                        <option value="femme">Femme</option>
                    </select>
                </div>
                
                <button type="submit" class="bg-blue-500 text-white py-2.5 rounded-lg text-sm font-medium hover:bg-blue-600 transition-colors mt-2">
                    Créer mon compte
                </button>
            </form>

            <!-- Formulaire connexion -->
            <form id="form-login" action="../src/Controllers/login_process.php" method="POST" class="flex flex-col gap-4 hidden">
                <div class="flex flex-col gap-1">
                    <label class="text-sm font-medium">Nom</label>
                    <input type="text" name="nom" required placeholder="Dupont" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-500">
                </div>
                <div class="flex flex-col gap-1">
                    <label class="text-sm font-medium">Prénom</label>
                    <input type="text" name="prenom" required placeholder="Jean" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-500">
                </div>
                <button type="submit" class="bg-blue-500 text-white py-2.5 rounded-lg text-sm font-medium hover:bg-blue-600 transition-colors mt-2">
                    Se connecter
                </button>
            </form>

        </div>

        <p class="text-center text-gray-400 text-sm mt-6">
            <a href="../public/main.php" class="hover:text-gray-600">← Retour à l'accueil</a>
        </p>
    </div>

    <script>
        function showTab(tab) {
            const formRegister = document.getElementById('form-register');
            const formLogin = document.getElementById('form-login');
            const tabRegister = document.getElementById('tab-register');
            const tabLogin = document.getElementById('tab-login');

            if (tab === 'register') {
                formRegister.classList.remove('hidden');
                formLogin.classList.add('hidden');
                tabRegister.classList.add('bg-gray-900', 'text-white');
                tabRegister.classList.remove('text-gray-500');
                tabLogin.classList.remove('bg-gray-900', 'text-white');
                tabLogin.classList.add('text-gray-500');
            } else {
                formLogin.classList.remove('hidden');
                formRegister.classList.add('hidden');
                tabLogin.classList.add('bg-gray-900', 'text-white');
                tabLogin.classList.remove('text-gray-500');
                tabRegister.classList.remove('bg-gray-900', 'text-white');
                tabRegister.classList.add('text-gray-500');
            }
        }
    </script>

</body>
</html>