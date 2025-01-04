<!-- Form section -->
<div class="col-md-3">
    <h2 class="text-center mb-4">How many children to be gifted?</h2>
    <div class="card rounded-3 shadow-lg">
        <form action="" class="py-5">
            <div class="container mt-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="number" class="form-control" id="girl" placeholder="girl" name="girl" value="1"
                                min="0">
                            <label for="girl">Girl</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="number" class="form-control" id="boy" placeholder="boy" name="boy" value="1"
                                min="0">
                            <label for="boy">Boy</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-3">
                <button class="btn btn-primary w-75" id="view-gifts">View gifts</button>
            </div>
        </form>
    </div>

    <div class="container-fluid mt-2">
        <div class="row text-center">
            <div class="col-md-5">
                <button class="btn btn-outline-secondary w-100" id="total-price-button" data-total-price="0">0$</button>
            </div>
            <div class="col-md-7">
                <form action="/main/validate-gifts" method="POST" id="validationForm">
                    <!-- Hidden Inputs -->
                    <input type="hidden" name="total_price" id="totalPriceInput" value="">
                    <input type="hidden" name="remaining_balance" id="remainingBalanceInput" value="">
                    <button type="button" class="btn btn-success w-100" id="validate-btn">Validate</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Gift listing -->
<div class="col-md-8 overflow-auto ml-5" id="gift-list" style="max-height: 500px;">
    <h2 class="text-center mb-4">Gift Suggestions</h2>
    <div class="text-center my-3" id="loading" style="display: none;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div class="row">
        <!-- Placeholder content for the second section (initial view before JS loads actual gifts) -->
        <div class="col-md-12 text-center">
            <div class="placeholder-placeholder">
                <p><strong>Choose the number of children to receive gifts, and click "View gifts" to see
                        suggestions.</strong></p>
                <p>Once the gifts are displayed, you can select and replace gifts accordingly.</p>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirm Gift Purchase</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to finalize your gift purchase?</p>
                <p>Total cost: <strong id="totalCost"></strong></p>
                <p>Remaining balance: <strong id="remainingBalance"></strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirmValidation">Yes, Validate</button>
            </div>
        </div>
    </div>
</div>
