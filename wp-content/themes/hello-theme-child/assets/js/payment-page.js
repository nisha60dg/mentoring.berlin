console.log('kjslkfjlkdsjflkdsjflk');
Stripe.setPublishableKey('pk_test_51LX5UuKyiv2cxXNOmVFgOaEUzFrmWMdgDzKoVRinA11m4bC69RUPxK7FcD8K7z7flJ4u8NlBUNgj5VXyeqL3Brno00nyKCCK2l');
function stripePay(event) {
    event.preventDefault();
    if (validateForm() == true) {
        $('#payNow').attr('disabled', 'disabled');
        // $('#payNow').val('Payment Processing....');
        Stripe.createToken({
            number: $('#cardNumber').val(),
            cvc: $('#cardCVC').val(),
            exp_month: $('#cardExpMonth').val(),
            exp_year: $('#cardExpYear').val()
        }, stripeResponseHandler);
        return false;
    }
}
function stripeResponseHandler(status, response) {
    if (response.error) {
        $('#payNow').attr('disabled', false);
        $('#message').html(response.error.message).show();
    } else {
        var stripeToken = response['id'];
        $('#paymentForm').append("<input type='hidden' name='stripeToken' value='" + stripeToken + "' />");

        $('#paymentForm').submit();
    }
}

function validateForm() {
    var validCard = 0;
    var valid = false;
    var cardCVC = $('#cardCVC').val();
    var cardExpMonth = $('#cardExpMonth').val();
    var cardExpYear = $('#cardExpYear').val();
    var cardNumber = $('#cardNumber').val();
    // var validateName = /^[a-z ,.'-]+$/i;
    // var validateEmail = /^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/;
    var validateMonth = /^01|02|03|04|05|06|07|08|09|10|11|12$/;
    var validateYear = /^23|24|25|26|27|28|29|30|31$/;
    var cvv_expression = /^[0-9]{3,3}$/;

    $('#cardNumber').validateCreditCard(function (result) {
        if (result.valid) {
            $('#cardNumber').removeClass('require');
            $('#errorCardNumber').text('');
            validCard = 1;
        } else {
            $('#cardNumber').addClass('require');
            $('#errorCardNumber').text('Invalid Card Number');
            validCard = 0;
        }
    });

    if (validCard == 1) {
        if (!validateMonth.test(cardExpMonth)) {
            $('#cardExpMonth').addClass('require');
            $('#errorCardExpMonth').text('Invalid Data');
            valid = false;
        } else {
            $('#cardExpMonth').removeClass('require');
            $('#errorCardExpMonth').text('');
            valid = true;
        }

        if (!validateYear.test(cardExpYear) || cardExpYear<22) {
            $('#cardExpYear').addClass('require');
            $('#errorCardExpYear').text('Invalid Data');
            valid = false;
        } else {
            $('#cardExpYear').removeClass('require');
            $('#errorCardExpYear').text('');
            valid = true;
        }

        if (!cvv_expression.test(cardCVC)) {
            $('#cardCVC').addClass('require');
            $('#errorCardCvc').text('Invalid Data');
            valid = false;
        } else {
            $('#cardCVC').removeClass('require');
            $('#errorCardCvc').text('');
            valid = true;
        }
    }
    return valid;
}

// function validateNumber(event) {
//     var charCode = (event.which) ? event.which : event.keyCode;
//     if (charCode != 32 && charCode > 31 && (charCode < 48 || charCode > 57)) {
//         return false;
//     }
//     return true;
// }
