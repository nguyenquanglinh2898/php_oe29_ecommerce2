// khởi tạo bộ soạn thảo cho thuộc tính detail_info
tinymce.init({
    selector: '#product-information>textarea',
    plugins: 'media image code table link lists preview fullscreen',
    toolbar: 'undo redo | formatselect | fontsizeselect | bold italic underline forecolor | alignleft aligncenter alignright alignjustify | numlist bullist | outdent indent | link image media table | code preview fullscreen',
    toolbar_drawer: 'sliding',
    entity_encoding : "raw",
    branding: false,
    /* enable title field in the Image dialog*/
    image_title: true,
    height: 400,
    min_height: 300,
    /* Link Custom */
    link_assume_external_targets: 'http',
    /* disable media advanced tab */
    media_alt_source: false,
    media_poster: false,
    /* enable automatic uploads of images represented by blob or data URIs*/
    automatic_uploads: true,
    file_picker_types: 'image',
    /* and here's our custom image picker*/
    file_picker_callback: function (cb, value, meta) {
        var input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');

        input.onchange = function () {
            var file = this.files[0];

            var reader = new FileReader();
                reader.onload = function () {
                var id = 'blobid' + (new Date()).getTime();
                var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                var base64 = reader.result.split(',')[1];
                var blobInfo = blobCache.create(id, file, base64);
                blobCache.add(blobInfo);

                /* call the callback and populate the Title field with the file name */
                cb(blobInfo.blobUri(), { title: file.name });
            };
            reader.readAsDataURL(file);
        };

        input.click();
    }
});

// // khởi tạo bộ soạn thảo cho thuộc tính description
tinymce.init({
    selector: '#product-introduction>textarea',
    plugins: 'media image code table link lists preview fullscreen',
    toolbar: 'undo redo | formatselect | fontsizeselect | bold italic underline forecolor | alignleft aligncenter alignright alignjustify | numlist bullist | outdent indent | link image media table | code preview fullscreen',
    toolbar_drawer: 'sliding',
    entity_encoding : "raw",
    branding: false,
    /* enable title field in the Image dialog*/
    image_title: true,
    height: 400,
    min_height: 300,
    /* Link Custom */
    link_assume_external_targets: 'http',
    /* disable media advanced tab */
    media_alt_source: false,
    media_poster: false,
    /* enable automatic uploads of images represented by blob or data URIs*/
    automatic_uploads: true,
    file_picker_types: 'image',
    /* and here's our custom image picker*/
    file_picker_callback: function (cb, value, meta) {
        var input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');

        input.onchange = function () {
            var file = this.files[0];

            var reader = new FileReader();
            reader.onload = function () {
                var id = 'blobid' + (new Date()).getTime();
                var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                var base64 = reader.result.split(',')[1];
                var blobInfo = blobCache.create(id, file, base64);
                blobCache.add(blobInfo);

                /* call the callback and populate the Title field with the file name */
                cb(blobInfo.blobUri(), { title: file.name });
            };
            reader.readAsDataURL(file);
        };

        input.click();
    }
});

// hiển thị thumbnail preview khi user upload
$(document).ready(function(){
    $("#upload").change(function(event) {
        var target = event.target || event.srcElement;
        $('#imagePreview').attr('src', getImageURL(this));
    });
});

// lấy đường dẫn ảnh vừa upload
function getImageURL(input) {
    return URL.createObjectURL(input.files[0]);
};

// thao tác với thuộc tính phân loại
$(function() {
    $(".product-detail-images").fileinput({
        theme: "explorer-fa",
        required: false,
        showUpload: false,
        showCaption: false,
        showClose: false,
        maxFileCount: 8,
        allowedFileExtensions: ['jpg', 'png', 'gif'],
        initialPreviewAsData: true,
        maxFileSize: 10000,
        overwriteInitial: false,
        removeFromPreviewOnError: true,
    });

    $('input[name="name"]').on('keyup', function() {
        var val = $(this).val().trim();
        $('#product-details .field-group .box .box-header .box-title span.name').text(val);
    });

    $('input.color').on('keyup', function() {
        var val = $(this).val().trim();
        if(val !== '') val = ' - ' + val;
        var name = $('input[name="name"]').val().trim();
        $(this).closest('.box').find('.box-header .box-title span.name').text(name);
        $(this).closest('.box').find('.box-header .box-title span.color').text(val);
    });

    $('.reservation').daterangepicker({
        autoApply: true,
        autoUpdateInput: false,
        minDate: moment(),
        "locale": {
            "format": "DD/MM/YYYY",
        }
    });
    $('.reservation').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
    });
    $('.reservation').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
    $('input.currency').autoNumeric('init', {
        aSep: '.',
        aDec: ',',
        aPad: false,
        lZero: 'deny',
        vMin: '0'
    });
    $("#productForm").validate({
        normalizer: function( value ) {
            return $.trim( value );
        },
        errorElement: "span",
        ignore: "",
        highlight: function(element, errorClass, validClass) {
            $(element).addClass(errorClass).removeClass(validClass);
            if($(element).parents('div#product-details').length || $(element).parents('div#product-promotions').length) {
                $(element).parents('.box').boxWidget('expand');
            }
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass(errorClass).addClass(validClass);
        }
    });
});

// ajax trả về các list danh mục con sau khi user click chọn danh mục cha
$(function () {
    let childCategory = $('#childCategory');
    childCategory.hide();
    $('#rootCategory').on('change', function(e) {
        let rootCategoryId = $(this).val();
        $.ajax({
            type: 'get',
            url: $('#getChildCategoriesUrl').val() + rootCategoryId,
            data: rootCategoryId,
        }).done(function(res) {
            childCategory.html(null);
            for (let i in res) {
                childCategory.append("<option value='" +  res[i].id + "' class='category-item'>" +  res[i].name + "</option>");
            }
            childCategory.val(res[0].id);
            $('#category').val(res[0].id);
            childCategory.show();
        });
    });
    childCategory.on('change', function(e) {
        $('#category').val($(this).val());
    });
});

// lấy ra thẻ thứ order có class = "className"
function getClass(className, order) {
    return $('.' + className + ':eq(' + order + ')');
}

function addNewAttrInput(){
    $('#attributes').append(
        '<div class="col-md-3">' +
            '<div class="form-group attr-div">' +
                '<label for="attr">' + $("#attrName").val() + '<span class="text-red">*</span></label>' +
                '<input type="text" class="form-control attr" name="attr[]" placeholder="' + $("#attrName").val() + '">' +
                '<button type="button" class="remove-attr-btn">&times;</button>' +
            '</div>' +
        '</div>'
    );
}

function addTableHeader(){
    let attributes = $('.attr');

    for (let i = 0; i < attributes.length; i++) {
        let attrName = getClass('attr', i).val();

        $('#attrTableHeader').append(
            '<th>' + attrName + '</th>'
        );
    }

    $('#attrTableHeader').append(
        '<th>' + $("#remainingCol").val() + '</th>' +
        '<th>' + $("#priceCol").val() + '</th>' +
        '<th>' + $("#actionCol").val() + '</th>'
    );
}

function addRowToTableBody(){
    //thêm dòng
    let rowNumber = $('#attrTableBody').find('tr').length + 1;
    $('#attrTableBody').append(
        '<tr class="table-row" id="row' + rowNumber + '"></tr>'
    );
    $('#numOfRow').val(rowNumber);

    // thêm input các cột thuộc tính phân loại
    let attributes = $('.attr');
    for (let i = 0; i < attributes.length; i++) {
        let attrName = getClass('attr', i).val();
        $('#row' + rowNumber).append(
            '<td><input type="text" class="form-control" name="' + attrName + '[]"></td>'
        );
    }

    // thêm 3 cột số lượng, giá bán và thao tác
    $('#row' + rowNumber).append(
        '<td><input type="number" min="1" name="remaining[]" class="form-control remaining" placeholder="' + $('#remainingCol').val() + '"></td>' +
        '<td><input type="number" min="0" name="price[]" class="form-control price" placeholder="' + $('#priceCol').val() + '"></td>' +
        '<td><button type="button" class="remove-row-btn btn btn-danger"><i class="fa fa-trash"></i></button></td>'
    );
}

$('#updateBtn').hide();

$('#addAttrBtn').on('click', function () {
    $('#priceArea').remove();
    $('#remainingArea').remove();
    $('#updateBtn').show();
    addNewAttrInput();
});

function clearTable(){
    $('#attrTableHeader').html(null);
    $('#attrTableBody').html(null);
}

$('#updateBtn').on('click', function () {
    clearTable();
    addTableHeader();
    $('#addRowBtn').show();
    addRowToTableBody();
});

$('#addRowBtn').on('click', function () {
    addRowToTableBody();
});

$("#attributes").on( "click", ".remove-attr-btn", function() {
    $(this).parent().parent().remove();
});

$("#attrTableBody").on( "click", ".remove-row-btn", function() {
    $(this).parent().parent().remove();
});

addTableHeader();
addRowToTableBody();
