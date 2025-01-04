<div class="container" id="deposit-form">
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center mb-4">Make a Deposit</h2>
            <div class="card rounded-3 shadow-lg p-4">
                <form action="/deposit" method="POST">
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="amount" name="amount" placeholder="Deposit Amount" required>
                        <label for="amount">Deposit Amount ($)</label>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success w-50" id="deposit-btn">Submit Deposit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
