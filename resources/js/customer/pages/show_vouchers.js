function getSupplierItemsClassClassNumber(className, classId) {
    for (let i = 0; i < $('.' + className).length; i++) {
        if (getClass(className, i).attr('id') == classId) {
            return i;
        }
    }

    return null;
}

$('.apply-btn').click(function() {
    let voucherId = $('input[name = "voucher"]:checked').val();

    if (!voucherId) {
        return null;
    }

    let supplierId = parseInt($('#showVouchers').attr('supplier-id'));
    let number = getSupplierItemsClassClassNumber('supplier-items', 'supplierItems' + supplierId);

    if (voucherId == getCurrentVoucherId(number)) {
        return null;
    }

    let supplierItemsClass = $('#supplierItems' + supplierId);
    let shipPrice = supplierItemsClass.find('.ship-price').attr('ship-price');
    let totalPrice = supplierItemsClass.find('.total-price').attr('total-price');

    applyVoucherAnOrder(shipPrice, totalPrice, voucherId, number);
});
