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
    $("#product-details").repeatable({
        addTrigger: 'button.add',
        deleteTrigger: 'button.delete',
        max: 15,
        min: 0,
        template: "#product-detail",
        afterAdd:function () {
            $(".product-detail-images").fileinput({
            theme: "explorer-fa",
            required: false,
            showUpload: false,
            showCaption: false,
            showClose: false,
            maxFileCount: 8,
            allowedFileExtensions: ['jpg', 'png', 'gif'],
            initialPreviewAsData: true,
            maxFileSize: 1000,
            overwriteInitial: false,
            removeFromPreviewOnError: true,
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
            $('#product-details .box').boxWidget();
            $('#product-details .field-group:not(:last-child) .box').boxWidget('collapse');
            $('#product-details .field-group:last-child .box').boxWidget('expand');
            $('input.color').on('keyup', function() {
                var val = $(this).val().trim();
                if(val !== '') val = ' - ' + val;
                var name = $('input[name="name"]').val().trim();
                $(this).closest('.box').find('.box-header .box-title span.name').text(name);
                $(this).closest('.box').find('.box-header .box-title span.color').text(val);
            });
        },
        beforeDelete: function(target) {
            $(target).find('.product-detail-images').fileinput('destroy');
        }
    });

    $(".product-detail-images").fileinput({
        theme: "explorer-fa",
        required: false,
        showUpload: false,
        showCaption: false,
        showClose: false,
        maxFileCount: 8,
        allowedFileExtensions: ['jpg', 'png', 'gif'],
        initialPreviewAsData: true,
        maxFileSize: 1000,
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
            childCategory.show();
        });
    });
    childCategory.on('change', function(e) {
        $('#category').val($(this).val());
    });
});
