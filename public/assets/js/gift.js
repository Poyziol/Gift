$(document).ready(function () {
    // Show gifts after filling the form 
    let totalPrice = 0;

    $("#view-gifts").click(function (e) {
        e.preventDefault();

        const girlCount = $("#girl").val();
        const boyCount = $("#boy").val();

        if (girlCount <= 0 && boyCount <= 0) {
            showModalMessage("Please enter the number of boys or girls to suggest gifts for"); // Method in main.js
            return;
        }

        fetchGifts(girlCount, boyCount);
    });

    // Replace gifts
    $('#gift-list').on('click', '.btn-primary', function (e) {
        e.preventDefault();
        const card = $(this).closest('.col-md-4');
        const giftIndex = card.data('index');

        replaceGift(card, giftIndex);
    });

    // Ajax 
    function fetchGifts(girls, boys) {
        $.ajax({
            url: '/api/gifts',
            type: 'GET',
            data: { girls, boys },
            success: function (response) {
                const gifts = response.gifts || [];
                totalPrice = response.total_price || 0;

                const giftList = $('#gift-list .row');
                giftList.empty();

                if (gifts.length === 0) {
                    giftList.append('<p class="text-center">No gifts available for the selected input.</p>');
                    $("#total-price-button").attr('data-value', 0).text('$0');
                    return;
                }

                gifts.forEach(gift => {
                    giftList.append(createGiftCard(gift));
                });

                $("#total-price-button").attr('data-value', totalPrice).text(`$${totalPrice}`);
            },
            error: function (xhr) {
                let response = JSON.parse(xhr.responseText);
                showModalMessage(response.message);
            }
        });
    }

    function replaceGift(card, giftIndex) {
        // Loading: so we put a sleep in the controller 
        const btn = card.find('.btn-primary');
        btn.text('Loading...').prop('disabled', true);

        $.ajax({
            url: '/api/replace-gift',
            method: 'GET', // TODO: make it POST method (too lazy)
            data: { index: giftIndex },
            success: function (response) {
                const newGift = response.new_gift;
                totalPrice = response.total_price;
                console.log('New Gift:', newGift);
                console.log('Price:', newGift['montant']);

                const newGiftCard = createGiftCard(newGift);
                card.replaceWith(newGiftCard);

                btn.text('Replace Gift').prop('disabled', false); // Reset the button 
                $('#total-price-button').text(`$${totalPrice}`); // Update the total price 
            },
            error: function (xhr) {
                let response = JSON.parse(xhr.responseText);
                showModalMessage(response.message);
                btn.text('Replace Gift').prop('disabled', false);
            }
        });
    }

    // Helper methods
    function getCategoryIcon(categoryId) {
        switch (categoryId) {
            case 1:
                return 'fa-venus';
            case 2:
                return 'fa-mars';
            case 3:
                return 'fa-question-circle';
            default:
                return '';
        }
    }

    function createGiftCard(gift) {
        const categoryIcon = getCategoryIcon(gift['id_category']);
        return `
            <div class="col-md-4 mb-4" data-index=${gift['index']}>
                <div class="card shadow-sm d-flex flex-column" style="height: 100%;">
                    <div class="position-relative" style="height: 200px;">
                        <img src="/assets/img/gifts/${gift['pic']}" class="card-img-top" alt="${gift['name']}" style="height: 200px; object-fit: cover;">
                        <div class="position-absolute bottom-0 start-0 p-2 text-white gender-div">
                            <p class="m-0" style="font-size: 1.1em; font-weight: bold;">
                                <i class="fas ${categoryIcon}"></i>
                            </p>
                        </div>
                        <div class="position-absolute bottom-0 end-0 p-2 text-white price-div">
                            <p class="m-0" style="font-size: 1.1em;">
                                <i class="fas fa-tag"></i> $${gift['montant']}
                            </p>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column flex-grow-1">
                        <h5 class="card-title">${gift['name']}</h5>
                        <p class="card-text">${gift['description']}</p>
                        <div class="mt-auto">
                            <a href="#" class="btn btn-primary w-100">Replace Gift</a>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    // Final validation
    let balance = parseFloat($('#balance').attr('value'));
    $("#validate-btn").click(function () {
        const remainingBalance = balance - totalPrice;

        if (remainingBalance < 0) {
            showModalMessage("You do not have enough balance to finalize the purchase");
            return;
        }

        $("#totalCost").text(`$${totalPrice}`);
        $("#remainingBalance").text(`$${remainingBalance}`);
        $("#confirmationModal").modal("show");
    });

    // Submit form when modal confirmation is accepted
    $("#confirmValidation").click(function () {
        $("#totalPriceInput").val(totalPrice);
        const remainingBalance = balance - totalPrice;
        $("#remainingBalanceInput").val(remainingBalance);
        $("#validationForm").submit();
    });
});
