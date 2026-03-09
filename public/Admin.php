<?php
session_start();

require_once '../src/Managers/Manager.php';
require_once '../src/Entities/TourOperator.php';

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: ./login_admin.php');
    exit;
}

$manager = new Manager();
$operators = $manager->getAllOperators();




?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - ComparOperator</title>
    <link href="../assets/tailwind/output.css" rel="stylesheet">
</head>

<body class="bg-gray-50 text-gray-900 select-none">

    <!-- NAV -->
    <nav class="flex items-center justify-between px-10 py-5 border-b border-gray-200 bg-white sticky top-0 z-50">
        <span class="text-2xl font-black tracking-tight">Compar<span class="text-blue-500">Operator</span> <span class="text-sm font-medium text-gray-400">/ Admin</span></span>
        <a href="../public/main.php" class="text-gray-500 hover:text-gray-900 text-sm font-medium">← Retour au site</a>
    </nav>

    <div class="max-w-5xl mx-auto px-10 py-12">

        <h1 class="text-4xl font-black tracking-tight mb-2">Panel Admin</h1>
        <p class="text-gray-500 mb-10">Gérez les tour opérateurs et les destinations.</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <!-- Ajouter un TO -->
            <div class="bg-white border border-gray-200 rounded-2xl p-6">
                <h2 class="text-xl font-bold mb-1">Ajouter un Tour Opérateur</h2>
                <p class="text-gray-500 text-sm mb-5">Créez un nouveau TO dans la base de données.</p>

                <form action="../src/Controllers/add_operator.php" method="POST" class="flex flex-col gap-4">
                    <div class="flex flex-col gap-1">
                        <label class="text-sm font-medium">Nom du TO</label>
                        <input type="text" name="name" required placeholder="Ex: Club Med" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-500">
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-sm font-medium">Lien site officiel <span class="text-gray-400">(optionnel)</span></label>
                        <input type="url" name="link" placeholder="https://..." class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-500">
                    </div>
                    <button type="submit" class="bg-gray-900 text-white py-2 rounded-lg text-sm font-medium hover:bg-blue-500 transition-colors">
                        Ajouter le TO
                    </button>
                </form>
            </div>

            <!-- Ajouter une destination -->
            <div class="bg-white border border-gray-200 rounded-2xl p-6">
                <h2 class="text-xl font-bold mb-1">Ajouter une Destination</h2>
                <p class="text-gray-500 text-sm mb-5">Associez une destination à un TO.</p>

                <form action="../src/Controllers/add_destination.php" method="POST" class="flex flex-col gap-4">
                    <div class="flex flex-col gap-1">
                        <label class="text-sm font-medium">Destination</label>
                        <select name="location" required class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-500">
                            <option value="">-- Choisir --</option>
                            <option value="Maroc">Maroc</option>
                            <option value="Thaïlande">Thaïlande</option>
                            <option value="Espagne">Espagne</option>
                            <option value="Grèce">Grèce</option>
                            <option value="Maldives">Maldives</option>
                            <option value="Cuba">Cuba</option>
                            <option value="Mexique">Mexique</option>
                            <option value="Portugal">Portugal</option>
                            <option value="Bali">Bali</option>
                            <option value="Turquie">Turquie</option>
                        </select>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-sm font-medium">Prix (€)</label>
                        <input type="number" name="price" required placeholder="Ex: 999" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-500">
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-sm font-medium">Tour Opérateur</label>
                        <select name="tour_operator_id" required class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-500">
                            <?php foreach ($operators as $operator): ?>
                                <option value="<?= $operator->getId() ?>"><?= $operator->getName() ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="bg-gray-900 text-white py-2 rounded-lg text-sm font-medium hover:bg-blue-500 transition-colors">
                        Ajouter la destination
                    </button>
                </form>
            </div>

            <!-- Passer en premium -->
            <div class="bg-white border border-blue-200 rounded-2xl p-6 md:col-span-2">
                <h2 class="text-xl font-bold mb-1">Passer un TO en Premium </h2>
                <p class="text-gray-500 text-sm mb-5">Le TO aura accès à un lien vers son site et un badge premium.</p>

                <form action="../src/Controllers/set_premium.php" method="POST" class="flex gap-4 items-end">
                    <div class="flex flex-col gap-1 flex-1">
                        <label class="text-sm font-medium">Tour Opérateur</label>
                        <select name="tour_operator_id" required class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-500">
                            <option value="">-- Choisir --</option>
                            <option value="1">TUI</option>
                            <option value="2">Jet Tours</option>
                            <option value="3">Club Med</option>
                        </select>
                    </div>
                    <div class="flex flex-col gap-1 flex-1">
                        <label class="text-sm font-medium">Signataire</label>
                        <input type="text" name="signatory" required placeholder="Votre nom" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-500">
                    </div>
                    <button type="submit" class="bg-blue-500 text-white py-2 px-6 rounded-lg text-sm font-medium hover:bg-blue-600 transition-colors">
                        Activer Premium
                    </button>
                </form>
            </div>

        </div>
    </div>

    <!-- FOOTER -->
    <footer class="border-t border-gray-200 px-10 py-8 text-center text-gray-400 text-sm mt-10">
        © 2024 ComparOperator — Panel Administrateur
    </footer>

</body>

</html>