$(function () {
    const MIN_RECORD = 0;
    const START_PAGE = 1;
    const MIN_TOTAL_PAGE = 1;
    const NO_RECORD_WORD = $('#noRecord').val();
    const DISPLAY_PAGE_WORD = $('#displayPage').val();
    const OF_WORD = $('#of').val();
    const PRODUCTS_WORD = $('#productsWord').val();
    const SEARCHED_FROM_WORD = $('#searchedFrom').val();
    const NEXT_WORD = $('#next').val();
    const PREVIOUS_WORD = $('#previous').val();

    var table = $('#product-table').DataTable({
        "language": {
            "zeroRecords": NO_RECORD_WORD,
            "info": DISPLAY_PAGE_WORD + " <b>_PAGE_/_PAGES_</b> " + OF_WORD + " <b>_TOTAL_</b> " + PRODUCTS_WORD,
            "infoEmpty": DISPLAY_PAGE_WORD + " <b>" + START_PAGE + "/" + MIN_TOTAL_PAGE + "</b> " + OF_WORD + " <b>" + MIN_RECORD + "</b> " + PRODUCTS_WORD,
            "infoFiltered": "(" + SEARCHED_FROM_WORD + " <b>_MAX_</b> " + PRODUCTS_WORD + ")",
            "emptyTable": NO_RECORD_WORD,
            "paginate": {
                next: NEXT_WORD,
                previous: PREVIOUS_WORD
            }
        },
        "lengthChange": false,
        "autoWidth": false,
        "order": [],
        "dom": '<"table-responsive"t><<"row"<"col-md-6 col-sm-6"i><"col-md-6 col-sm-6"p>>>',
        "drawCallback": function(settings) {
            var api = this.api();
            if (api.page.info().pages <= MIN_TOTAL_PAGE) {
                $('#'+ $(this).attr('id') + '_paginate').hide();
            }
        }
    });

    $('#search-input input').on('keyup', function() {
        table.search(this.value).draw();
    });
});

$(".btn-show").click(function() {
    let url = this.getAttribute('data-url');
    $.ajax({
        url : url,
        type : "get",
        success : function (data) {
            $('#showModalBody').html(data);
        }
    })
});
