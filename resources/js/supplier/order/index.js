$(function () {
    var table = $('#order-table').DataTable({
        "language": {
            "zeroRecords": "Không tìm thấy kết quả phù hợp",
            "info": "Hiển thị trang <b>_PAGE_/_PAGES_</b> của <b>_TOTAL_</b> đơn hàng",
            "infoEmpty": "Hiển thị trang <b>1/1</b> của <b>0</b> đơn hàng",
            "infoFiltered": "(Tìm kiếm từ <b>_MAX_</b> đơn hàng)",
            "emptyTable": "Không có dữ liệu đơn hàng",
        },
        "lengthChange": false,
        "autoWidth": false,
        "order": [],
        "dom": '<"table-responsive"t><<"row"<"col-md-6 col-sm-6"i><"col-md-6 col-sm-6"p>>>',
        "drawCallback": function(settings) {
            var api = this.api();
            if (api.page.info().pages <= 1) {
                $('#'+ $(this).attr('id') + '_paginate').hide();
            }
        }
    });
    $('#search-input input').on('keyup', function() {
        table.search(this.value).draw();
    });
});
