$(document).ready(function() {
    $('.payment-methods .list-content label').click(function() {
        $('.payment-methods .list-content>li').removeClass('active');
        $(this).parent('li').addClass('active');
    });
});

function getClass(className, number) {
    return $('.' + className + ':eq(' + number + ')');
}

function getChildClass(childClassName, parentClassName, number = 0) {
    return getClass(parentClassName, number).find(childClassName);
}

function currencyFormat(number) {
    return new Number(number).toLocaleString('en-US');
}

function currencyToNumber(string) {
    let stringNumber = "";
    for (let i = 0; i <= string.length; i++) {
        if (string[i] >= '0' && string[i] <= '9') {
            stringNumber += string[i];
        }
    }

    return parseInt(stringNumber);
}

function getTempPriceAnOrder(number) {
    let tempTotalPrice = getChildClass('.price > span', 'temp-total-price', number).attr('temp-total-price');

    return parseInt(tempTotalPrice);
}

function getShipPriceAnOrder(number, fee) {
    let weight = getClass('ship-price', number).attr('weight');
    let shipPrice = fee * weight;
    getClass('ship-price', number).attr('ship-price', shipPrice);

    return shipPrice;
}

function getTotalPriceAnOrder(number, tempPrice, shipPrice) {
    let totalPrice = tempPrice + shipPrice;
    getClass('total-price', number).attr('total-price', totalPrice);

    return totalPrice;
}

function getCurrentVoucherId(number) {
    let currentVoucherId = getChildClass('.voucher', 'supplier-items', number).attr('current-voucher-id');

    return parseInt(currentVoucherId);
}

function applyVoucherAnOrder(shipPrice, totalPrice, voucherId, number) {
    if (voucherId) {
        $.ajax({
            type: 'get',
            url: $('#checkVoucherRoute').val(),
            data: {
                'voucherId': voucherId,
                'shipPrice': shipPrice,
                'totalPrice': totalPrice,
            },
        }).done(function(result) {
            resetPriceAnOrder(number, result['shipPrice'], result['totalPrice'], voucherId, result['voucherPrice']);
            getChildClass('.voucher', 'supplier-items', number).attr('current-voucher-id', voucherId);
            countFinalPrice();
        });
    } else {
        resetPriceAnOrder(number, shipPrice, totalPrice);
    }
}

function countPriceAnOrder(number, fee) {
    let tempPriceAnOrder = getTempPriceAnOrder(number);
    let shipPriceAnOrder = getShipPriceAnOrder(number, fee);
    let totalPriceAnOrder = getTotalPriceAnOrder(number, tempPriceAnOrder, shipPriceAnOrder);
    let currentVoucherId = getCurrentVoucherId(number);

    applyVoucherAnOrder(shipPriceAnOrder, totalPriceAnOrder, currentVoucherId, number);
}

function resetPriceAnOrder(number, shipPrice, totalPrice, voucherId = 0, voucherPrice = 0) {
    getChildClass('.price > span', 'ship-price', number).text(currencyFormat(shipPrice));
    getChildClass('.price > span', 'total-price', number).text(currencyFormat(totalPrice));
    getChildClass('.voucher', 'supplier-items', number).attr('current-voucher-id', voucherId);
    getChildClass('.price > span', 'voucher-price', number).text('-' + currencyFormat(voucherPrice));

    getChildClass('.transport-fee-input', 'ship-price', number).val(shipPrice);
    getChildClass('.voucher-discount-input', 'voucher-price', number).val(voucherPrice);
    getChildClass('.total-input', 'total-price', number).val(totalPrice);
    getChildClass('.voucher-input', 'supplier-items', number).val(voucherId);
}

function resetFinalPrice(finalTotalPrice) {
    getChildClass('.price > span', 'final-total-price').text(currencyFormat(finalTotalPrice));
}

function countFinalPrice() {
    let finalTotalPrice = 0;

    for (let i = 0; i < $('.supplier-items').length; i++) {
        finalTotalPrice += currencyToNumber(getChildClass('.price > span', 'total-price', i).text());
    }

    resetFinalPrice(finalTotalPrice);
}

function selectTransporter(transporterId) {
    $.ajax({
        type: 'get',
        url: $('input[name = "transporter"]:checked').attr('data-url'),
        data: transporterId,
    }).done(function(fee) {
        for (let i = 0; i < $('.ship-price').length; i++) {
            countPriceAnOrder(i, fee);
        }
        countFinalPrice();
    });
}

function showSelectVoucherPopUp(supplierId, totalPrice, currentVoucherId, url) {
    $.ajax({
        type: 'get',
        url: url,
        data: {
            'supplierId': supplierId,
            'totalPrice': totalPrice,
            'currentVoucherId': currentVoucherId,
        },
    }).done(function(res) {
        $('#showModalBody').html(res);
    });
}

selectTransporter($('input[name = "transporter"]:checked').val());

$('input[name = "transporter"]').on('change', function() {
    selectTransporter($('input[name = "transporter"]:checked').val());
});

$('.select-voucher-btn').click(function() {
    let supplierId = parseInt($(this).attr('data-supplier-id'));
    let totalPrice = parseInt(currencyToNumber($('#supplierItems' + supplierId).find('.total-price > .price > span').text()));
    let currentVoucherId = parseInt($(this).parent().parent().attr('current-voucher-id'));
    let url = $(this).attr('data-url');

    showSelectVoucherPopUp(supplierId, totalPrice, currentVoucherId, url);

    $('#showVouchers').attr('supplier-id', supplierId);
});
