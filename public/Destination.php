<?php
session_start();

if (!isset($_SESSION['author_id'])) {
    header('Location: ./Register.php');
    exit;
}

ini_set('xdebug.var_display_max_depth', -1);
ini_set('xdebug.var_display_max_children', -1);
ini_set('xdebug.var_display_max_data', -1);

require_once '../src/Managers/Manager.php';
require_once '../src/Entities/TourOperator.php';
require_once '../partials/cart.php';

$id = (int) $_GET['id'];

$manager = new Manager();
$destination = $manager->getDestinationById($id);
$operators = $manager->getOperatorsByDestination($id);
?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Destination - ComparOperator</title>
    <link href="../assets/tailwind/output.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
</head>

<body class="bg-white text-gray-900">



    <!-- NAV -->
    <nav class="flex items-center justify-between px-10 py-5 border-b border-gray-200 sticky top-0 bg-white z-50">
        <span class="text-2xl font-black tracking-tight">Compar<span class="text-blue-500">Operator</span></span>
        <div class="flex items-center gap-6">
            <a href="./main.php" class="text-gray-500 hover:text-gray-900 text-sm font-medium">Accueil</a>
            <a href="./Admin.php" class="text-gray-500 hover:text-gray-900 text-sm font-medium">Admin</a>
            <a href="./Register.php" class="bg-gray-900 text-white text-sm font-medium px-5 py-2 rounded-full hover:bg-blue-500 transition-colors">S'inscrire</a>
        </div>
    </nav>

    <!-- HEADER DESTINATION -->
    <section class="bg-blue-50 border-b border-blue-100 px-10 py-14 text-center">
        <a href="./main.php" class="text-blue-500 text-sm font-medium hover:underline mb-4 inline-block">← Retour aux destinations</a>
        <h1 class="text-5xl font-black tracking-tight mb-3"><?= $destination->getLocation() ?></h1>
        <p class="text-gray-500 text-lg">Comparez les Tour Opérateurs pour cette destination</p>
    </section>

    <!-- LISTE DES TO -->
    <section class="px-10 py-16 max-w-5xl mx-auto">
        <h2 class="text-2xl font-black mb-8">Tour Opérateurs disponibles</h2>

        <div class="flex flex-col gap-6">
            <?php foreach ($operators as $operator): ?>
                <div class="border-2 border-blue-500 rounded-2xl p-6">

                    <!-- Nom + prix -->
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <h3 class="text-xl font-bold"><?= $operator->getName() ?></h3>
                                <?php if ($operator->isPremium()): ?>
                                    <span class="bg-blue-100 text-blue-600 text-xs font-semibold px-3 py-0.5 rounded-full">Premium</span>
                                <?php endif; ?>
                            </div>
                            <p class="text-gray-500 text-sm">
                                <?= $operator->isPremium() ? 'Tour opérateur certifié' : 'Tour opérateur' ?>
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-3xl font-black text-blue-500"><?= $destination->getPrice() ?>€</p>
                            <p class="text-gray-400 text-sm">par personne</p>
                        </div>
                    </div>

                    <!-- Note moyenne affichée -->
                    <div class="flex items-center gap-1 mb-4">
                        <?php
                        $grade = round($operator->getGrade());
                        for ($i = 1; $i <= 5; $i++): ?>
                            <span class="<?= $i <= $grade ? 'text-yellow-400' : 'text-gray-300' ?>">★</span>
                        <?php endfor; ?>
                        <span class="text-gray-500 text-sm">
                            <?= $operator->getGrade() ?> / 5 (<?= count($operator->getReviews()) ?> avis)
                        </span>
                    </div>

                    <!-- Avis récents -->
                    <div class="bg-gray-50 rounded-xl p-4 mb-4">
                        <p class="text-sm font-semibold mb-3 text-gray-700">Avis récents</p>
                        <div class="flex flex-col gap-2">
                            <?php foreach ($operator->getReviews() as $review): ?>
                                <div class="text-sm text-gray-600">
                                    <span class="font-medium text-gray-900">Auteur #<?= $review->getAuthor() ?></span>
                                    — <?= $review->getMessage() ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Formulaire avis (étoiles + message DANS le form) -->
                    <form action="../src/Controllers/create_review.php" method="POST" class="border-t border-gray-200 pt-4">
                        <p class="text-sm font-semibold mb-3">Laisser un avis</p>

                        <!-- Étoiles interactives -->
                        <div class="flex gap-1 mb-3" id="stars-<?= $operator->getId() ?>">
                            <?php for ($s = 1; $s <= 5; $s++): ?>
                                <span
                                    class="text-2xl cursor-pointer text-gray-300 hover:text-yellow-400 transition-colors star"
                                    data-value="<?= $s ?>"
                                    onclick="setStars(<?= $operator->getId() ?>, <?= $s ?>)">★</span>
                            <?php endfor; ?>
                        </div>
                        <input type="hidden" name="grade" id="grade-<?= $operator->getId() ?>" value="0">

                        <input type="hidden" name="tour_operator_id" value="<?= $operator->getId() ?>">
                        <input type="hidden" name="destination_id" value="<?= $id ?>">

                        <div class="flex gap-2 pb-4">
                            <input name="nom" type="text" placeholder="Votre nom"
                                class="border border-gray-200 rounded-lg px-3 py-2 text-sm w-40 focus:outline-none focus:border-blue-500">
                            <input name="message" type="text" placeholder="Votre message..."
                                class="border border-gray-200 rounded-lg px-3 py-2 text-sm flex-1 focus:outline-none focus:border-blue-500">
                            <button type="submit" onclick="return validateStars(<?= $operator->getId() ?>)"
                                class="bg-blue-500 text-white text-sm px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                                Envoyer
                            </button>
                        </div>
                        <button type="button"
                            onclick="addToCart(<?= $operator->getId() ?>, '<?= addslashes($operator->getName()) ?>', <?= $destination->getPrice() ?>, '<?= addslashes($destination->getLocation()) ?>')"
                            class="bg-black text-white text-sm w-full px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                            Acheter
                        </button>

                    </form>

                    <!-- Lien site officiel -->
                    <div class="mt-4">
                        <a href="<?= $operator->getLink() ?>" class="text-blue-500 text-sm font-medium hover:underline">🔗 Visiter le site officiel →</a>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- CARTE DESTINATION -->
    <section class="px-10 py-16 max-w-5xl mx-auto">
        <h2 class="text-2xl font-black mb-4">Localisation</h2>
        <div id="map" style="height: 400px; width: 100%; border-radius: 16px; border: 1px solid #e5e7eb;"></div>
    </section>

    <!-- FOOTER -->
    <footer class="border-t border-gray-200 px-10 py-8 text-center text-gray-400 text-sm">
        © 2026 ComparOperator — Tous droits réservés
    </footer>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // Carte Leaflet
        const destinationName = "<?= addslashes($destination->getLocation()) ?>";

        fetch(`https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(destinationName)}&format=json&limit=1`)
            .then(res => res.json())
            .then(data => {
                if (!data.length) return;
                const lat = parseFloat(data[0].lat);
                const lng = parseFloat(data[0].lon);
                const map = L.map('map').setView([lat, lng], 6);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap'
                }).addTo(map);
                L.marker([lat, lng])
                    .addTo(map)
                    .bindPopup(`<strong>${destinationName}</strong>`)
                    .openPopup();
            });

        // Étoiles interactives
        function setStars(operatorId, value) {
            document.getElementById(`grade-${operatorId}`).value = value;
            const stars = document.querySelectorAll(`#stars-${operatorId} .star`);
            stars.forEach(star => {
                star.classList.toggle('text-yellow-400', parseInt(star.dataset.value) <= value);
                star.classList.toggle('text-gray-300', parseInt(star.dataset.value) > value);
            });
        }

        function validateStars(operatorId) {
            const grade = document.getElementById(`grade-${operatorId}`).value;
            if (parseInt(grade) < 1) {
                alert('Veuillez sélectionner une note avant d\'envoyer votre avis.');
                return false;
            }
            return true;
        }

        function addToCart(operatorId, operatorName, price, destination) {
            fetch('../src/Controllers/add_to_cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        action: 'add',
                        operatorId,
                        operatorName,
                        price,
                        destination
                    })
                })
                .then(res => res.json())
                .then(data => updateCartUI(data.cart));
        }

        function removeFromCart(index) {
            fetch('../src/Controllers/add_to_cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        action: 'remove',
                        index
                    })
                })
                .then(res => res.json())
                .then(data => {
                    updateCartUI(data.cart);
                    if (data.cart.length === 0) {
                        document.getElementById('cart-panel').classList.add('hidden');
                    }
                });
        }

        function updateCartUI(cart) {
            const total = cart.reduce((sum, item) => sum + item.price, 0);
            document.getElementById('cart-count').textContent = cart.length;
            document.getElementById('cart-total').textContent = total + '€';
            document.getElementById('cart-panel').classList.remove('hidden');

            const list = document.getElementById('cart-items');
            list.innerHTML = cart.map((item, index) => `
        <div class="flex justify-between items-center text-sm py-1">
            <span>${item.destination} — ${item.operatorName}</span>
            <div class="flex items-center gap-2">
                <span class="font-bold">${item.price}€</span>
                <button onclick="removeFromCart(${index})" class="text-gray-400 hover:text-red-500 text-xs font-bold transition-colors">✕</button>
            </div>
        </div>
    `).join('');
        }
    </script>

</body>

</html>