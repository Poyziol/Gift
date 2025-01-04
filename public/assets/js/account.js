$(document).ready(function () {
    // When a gift is clicked
    $('.gift-item').on('click', function () {
        // Extract gift details from data attributes
        var giftName = $(this).data('gift-name');
        var giftPrice = $(this).data('gift-price');
        var giftDescription = $(this).data('gift-description');
        var giftPic = $(this).data('gift-pic');

        // Set modal title
        $('#giftModalLabel').text(giftName);

        // Set modal content (image, price, description)
        $('#giftDetails').html(`
            <div class="row g-4 align-items-center">
                <!-- Gift Image -->
                <div class="col-md-6 text-center">
                    <img src="/assets/img/gifts/${giftPic}" alt="${giftName}" class="img-fluid rounded border" />
                </div>
                <!-- Gift Information -->
                <div class="col-md-6">
                    <h3 class="text-primary fw-bold mb-3">${giftName}</h3>
                    <p class="mb-2"><strong>Price:</strong> $${giftPrice}</p>
                    <p><strong>Description:</strong> ${giftDescription}</p>
                </div>
            </div>
        `);
    });
});
