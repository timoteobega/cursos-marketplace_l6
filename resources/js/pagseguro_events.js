let cardNumber = document.querySelector('input[name=card_number]');
let spanBrand = document.querySelector('span.brand');
let submitButton = document.querySelector('button.processCheckout');

cardNumber.addEventListener('keyup', function () {
    if (cardNumber.value.length >= 6) {
        PagSeguroDirectPayment.getBrand({
            cardBin: cardNumber.value.substr(0, 6),
            success: function (res) {
                let imgFlag = `<img src="https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/${res.brand.name}.png">`;
                console.log('bandeira: ', res.brand.name);
                spanBrand.innerHTML = imgFlag;
                document.querySelector('input[name=card_brand]').value = res.brand.name;
                getInstallments(amountTransaction, res.brand.name);
            },
            error: function (err) {
                console.error('Event KeyUp - cardnumber: ', err);
            },
            complete: function (res) {
                console.info('complete: ', res);
            }
        });
    }
});

submitButton.addEventListener('click', function (event) {

    event.preventDefault();
    let buttonTarget = event.target;

    buttonTarget.disabled = true;
    buttonTarget.innerHTML = 'Processando';
    document.querySelector('div.msg').innerHTML = "";

    PagSeguroDirectPayment.createCardToken({
        cardNumber: document.querySelector('input[name=card_number]').value,
        brand: document.querySelector('input[name=card_brand]').value,
        cvv: document.querySelector('input[name=card_cvv]').value,
        expirationMonth: document.querySelector('input[name=card_month]').value,
        expirationYear: document.querySelector('input[name=card_year]').value,

        success: function (res) {
            processPayment(res.card.token, buttonTarget);
        },
        error: function (err) {
            console.log('Event Click - Efetuar pagamento: ', err);
            buttonTarget.disabled = false;
            buttonTarget.innerHTML = 'Efetuar pagamento';

            for (let i in err.errors) {
                document.querySelector('div.msg').innerHTML = showErrorMessages(errorsMapPagSeguro(i));
            }
        },
    });
});
