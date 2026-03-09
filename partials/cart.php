<?php if (!isset($_SESSION['cart'])) $_SESSION['cart'] = []; ?>

<!-- PANIER FLOTTANT -->
<div id="cart-panel" class="<?= empty($_SESSION['cart']) ? 'hidden' : '' ?> fixed bottom-6 right-6 bg-white border-2 border-blue-500 rounded-2xl shadow-xl p-5 w-80 z-50">
    <div class="flex justify-between items-center mb-3">
        <p class="font-black text-lg">Mon panier <span id="cart-count" class="text-blue-500"><?= count($_SESSION['cart']) ?></span></p>
        <button onclick="document.getElementById('cart-panel').classList.add('hidden')" class="text-gray-400 hover:text-gray-900">✕</button>
    </div>
    <div id="cart-items" class="flex flex-col gap-1 mb-3">
        <?php foreach ($_SESSION['cart'] as $index => $item): ?>
            <div class="flex justify-between items-center text-sm py-1">
                <span><?= htmlspecialchars($item['destination']) ?> — <?= htmlspecialchars($item['operatorName']) ?></span>
                <div class="flex items-center gap-2">
                    <span class="font-bold"><?= $item['price'] ?>€</span>
                    <button onclick="removeFromCart(<?= $index ?>)" class="text-gray-400 hover:text-red-500 text-xs font-bold transition-colors">✕</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="border-t pt-3 flex justify-between font-black text-lg">
        <span>Total</span>
        <span id="cart-total" class="text-blue-500">
            <?= array_sum(array_column($_SESSION['cart'], 'price')) ?>€
        </span>
    </div>
    <button onclick="alert('Commande passée !')"
        class="mt-3 w-full bg-blue-500 text-white rounded-xl py-2 font-semibold hover:bg-blue-600 transition-colors">
        Confirmer
    </button>
</div>