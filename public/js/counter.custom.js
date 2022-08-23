/*
 * Functionality for counter view
 */


jQuery(function ($) {

    var elementsArray = {one_euro : '1.00 EUR', smoothie : 'Smoothie', waffel : "Waffel", eis: "Eis", fifty_cent : '0.50 EUR', spritz : 'Spritz', cappuccino : "Cappuccino", espresso : "Espresso", ten_cent : "0.10 EUR", fife_euro : "5.00 EUR", spezi : "Spezi", bier : "Bier"};

    //Get element on calc list
    $('.counter-buttons button').on('click', function(){
        type = $(this).data('type');
        price = $(this).data('price');
        sendToCalc(type, price);
    });

    // Delete calc list
    $('.c-button').on('click', function(){
        $('.inner-calc').empty();
        $('.totalprice').html('0.00');
    });

    // Save all elements in calculator
    $('.send-button').on('click', function(){
        $('.calc-line').each(function(){
            var type = $(this).data('type');
            var amount = $(this).data('amount');
            var price = $(this).data('price');
            setItem($(this), type, amount, price);
        });
        $('.totalprice').html('0.00');
    })

    // Get item Ajax
    function sendToCalc(type, price){
        if($('.calc-line[data-type=' + type +']').length !== 0){
            var amount = $('.calc-line[data-type=' + type +']').data().amount +1;
            $('.calc-line[data-type=' + type +']').replaceWith('<div class="calc-line" data-amount="' + amount + '" data-type="' + type + '" data-price="' + price + '"><div class="initials"><div class="amount">' + amount + ' </div><span>x ' + elementsArray[type] + '</span></div><span>' + price.toFixed(2) + ' EUR</span></div>');
        }
        else
            $('.inner-calc').prepend('<div class="calc-line" data-amount="1" data-type="' + type + '" data-price="' + price + '"><div class="initials"><div class="amount">' + 1 + '</div><span>x ' + elementsArray[type] + '</span></div><span>' + price.toFixed(2) + ' EUR</span></div>');
        // Update total price
        var totalprice = parseFloat(0);
        $('.calc-line').each(function(){
            totalprice += parseFloat(parseInt($(this).data().amount) * parseFloat($(this).data().price));
        });
        $('.totalprice').html(totalprice.toFixed(2));
    };


    // Set and save item ajax
    function setItem(html, type, amount, price){
        var setItemUrl = "/tagesbar/set/" + type + "/" + amount + "/" + price;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'GET',
            url: setItemUrl,
            success: function (data) {
                html.remove();
            },
            error: function() {
                    console.log('ERROR');
            }
        });
    }
});

// Ripple Effect
const buttons = document.getElementsByTagName("button");

for (const button of buttons) {
    button.addEventListener("click", createRipple);
}

function createRipple(event) {
    const button = event.currentTarget;

    const circle = document.createElement("span");
    const diameter = Math.max(button.clientWidth, button.clientHeight);
    const radius = diameter / 2;

    circle.style.width = circle.style.height = `${diameter}px`;
    circle.style.left = `${event.clientX - (button.offsetLeft + radius)}px`;
    circle.style.top = `${event.clientY - (button.offsetTop + radius)}px`;
    circle.classList.add("ripple");

    const ripple = button.getElementsByClassName("ripple")[0];

    if (ripple) {
      ripple.remove();
    }

    button.appendChild(circle);
}

