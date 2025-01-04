<div class="container mt-5">
    <h2 class="text-center mb-4">My Account Overview</h2>

    <!-- Gifts Purchased Section -->
    <section class="card rounded-3 shadow-lg mb-4">
        <div class="card-header">
            <h4>Gifts Purchased</h4>
        </div>
        <div class="card-body">
            <ul class="list-group">
                <?php if (count($purchasedGifts) > 0): ?>
                    <?php foreach ($purchasedGifts as $gift): ?>
                        <li class="list-group-item gift-item" data-bs-toggle="modal" data-bs-target="#giftModal"
                            data-gift-name="<?= htmlspecialchars($gift['name']) ?>"
                            data-gift-price="<?= number_format($gift['montant'], 2) ?>"
                            data-gift-description="<?= htmlspecialchars($gift['description']) ?>"
                            data-gift-pic="<?= $gift['pic'] ?>">
                            <?= htmlspecialchars($gift['name']) ?> - <?= "$" . number_format($gift['montant'], 2) ?>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="list-group-item">You have not purchased any gifts yet.</li>
                <?php endif; ?>
            </ul>
        </div>
    </section>


    <!-- Deposits Section -->
    <section class="mt-5 pb-5">
        <?php include 'deposit.php' ?>
    </section>

    <!-- Modal for gift detail -->
    <div class="modal fade" id="giftModal" tabindex="-1" aria-labelledby="giftModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="giftModalLabel">Gift Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="giftDetails">
                        <!-- Gift details will be injected here dynamically -->
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>