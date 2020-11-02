function setIdToTableRow() {
    let rowNumber = $('#attrTableBody').find('tr').length;
    for (let i = 0; i < rowNumber; i++) {
        $('#attrTableBody').find('tr:eq(' + i + ')').attr('id', 'row' + (i + 1));
    }
    $('#numOfRow').val(rowNumber);
}

function removeLastTableRow() {
    let rowNumber = $('#attrTableBody').find('tr').length;
    $('#row' + rowNumber).remove();
    $('#numOfRow').val(rowNumber - 1);
}

$(function() {
    if ($('input[name = "attr[]"]').length) {
        $('#addRowBtn').show();
    }
    setIdToTableRow();
    removeLastTableRow();
    $('#childCategory').show();

    $('.remove-pic-btn').click(function() {
        let imageId = $(this).attr('image-id');
        $('#detailPictures').append(
            '<input type="hidden" name="old_image[]" value="' + imageId + '">'
        );
        $(this).parent().remove();
    });
});
