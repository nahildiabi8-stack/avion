<?php
session_start();



if (!isset($_SESSION['author_id'])) {
    header('Location: ./Register.php');
    exit;
}
// truc

require_once '../src/Managers/Manager.php';
require_once '../src/Entities/Destination.php';
require_once '../partials/cart.php';
$manager = new Manager();
$destinations = $manager->getAllDestinations();

?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="merde">
    <title>ComparOperator</title>
    <link href="../assets/tailwind/output.css" rel="stylesheet">
</head>

<body class="bg-white text-gray-900 select-none">





    <!-- NAV -->
    <nav class="flex items-center justify-between px-10 py-5 border-b border-gray-200 sticky top-0 bg-white z-50">
        <span class="text-2xl font-black tracking-tight">Compar<span class="text-blue-500">Operator</span></span>
        <div class="flex items-center gap-6">
            <a href="./main.php" class="text-gray-500 hover:text-gray-900 text-sm font-medium">Accueil</a>
            <a href="./Admin.php" class="text-gray-500 hover:text-gray-900 text-sm font-medium">Admin</a>
            <a href="./Register.php" class="bg-gray-900 text-white text-sm font-medium px-5 py-2 rounded-full hover:bg-blue-500 transition-colors">S'inscrire</a>
        </div>
    </nav>

    <!-- HERO -->
    <section class="px-10 py-20 max-w-4xl mx-auto text-center">
        <span class="inline-block bg-blue-100 text-blue-500 text-xs font-semibold tracking-widest uppercase px-4 py-1 rounded-full mb-6">Comparateur de voyages</span>
        <h1 class="text-6xl font-black tracking-tight leading-tight mb-6">
            Trouvez le meilleur<br>
            <span class="text-blue-500 italic">Tour Opérateur</span>
        </h1>
        <p class="text-gray-500 text-lg max-w-xl mx-auto mb-10">
            Comparez les offres, lisez les avis et partez l'esprit tranquille.
        </p>
        <a href="#destinations" class="bg-gray-900 text-white px-8 py-4 rounded-full font-medium hover:bg-blue-500 transition-colors">
            Voir les destinations
        </a>
    </section>

    <!-- STATS -->
    <section class="border-y border-gray-200 py-10 px-10">
        <div class="max-w-3xl mx-auto flex justify-around text-center">
            <div>
                <p class="text-4xl font-black">10+</p>
                <p class="text-gray-500 text-sm mt-1">Destinations</p>
            </div>
            <div>
                <p class="text-4xl font-black">50+</p>
                <p class="text-gray-500 text-sm mt-1">Tour Opérateurs</p>
            </div>
            <div>
                <p class="text-4xl font-black">200+</p>
                <p class="text-gray-500 text-sm mt-1">Avis vérifiés</p>
            </div>
        </div>
    </section>

    <!-- DESTINATIONS -->
    <section id="destinations" class="px-10 py-20 max-w-6xl mx-auto">
        <h2 class="text-3xl font-black tracking-tight mb-2">Destinations populaires</h2>
        <p class="text-gray-500 mb-10">Sélectionnez une destination pour comparer les offres.</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- Card destination — à dupliquer en PHP avec foreach -->
            <?php foreach ($destinations as $destination): ?>
                <a href="./Destination.php?id=<?= $destination->getId() ?>" class="group block border border-gray-200 rounded-2xl overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="bg-blue-50 h-40 flex items-center justify-center text-6xl">🌍</div>
                    <div class="p-5">
                        <h3 class="text-lg font-bold mb-1"><?= $destination->getLocation() ?></h3>
                        <div class="flex items-center justify-between">
                            <span class="text-blue-500 font-bold">À partir de <?= $destination->getPrice() ?>€</span>
                            <span class="text-gray-400 text-sm group-hover:text-gray-900 transition-colors">Voir →</span>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>

        </div>
    </section>

    <!-- FOOTER -->
    <footer class="border-t border-gray-200 px-10 py-8 text-center text-gray-400 text-sm">
        © 2026 ComparOperator — Tous droits réservés
    </footer>

</body>

<script>
    function updateCartUI(cart) {
        const total = cart.reduce((sum, item) => sum + item.price, 0);
        document.getElementById('cart-count').textContent = cart.length;
        document.getElementById('cart-total').textContent = total + '€';
        document.getElementById('cart-panel').classList.remove('hidden');

        const list = document.getElementById('cart-items');
        list.innerHTML = cart.map(item => `
        <div class="flex justify-between text-sm py-1">
            <span>${item.destination} — ${item.operatorName}</span>
            <span class="font-bold">${item.price}€</span>
        </div>
    `).join('');
    }
</script>

</html>