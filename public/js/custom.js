$('form').submit(function() {
    $('.save').hide();
});
$(".show-image").on("click", function() {
    $('#imagepreview').attr('src', $(this).children('img').attr('src'));
    $('#imagemodal').modal('show');
});

$(document).on('click', '.remove_item', function() {
    $(this).parent().closest('.item_added').hide();
    $(this).parent().parent().find('.quantities').val(0);
    $(this).parent().parent().find('.required').removeAttr('required');
});
$(document).on('click', '.add_item', function() {
    $(".item_element").clone().removeAttr('style').removeAttr('class').attr('class', 'col-md-12 item_added').appendTo(".items");
    $(".items:last .new-select").select2();
});
// $(document).ready(function() {
//   $(window).keydown(function(event){
//     if(event.keyCode == 13) {
//       event.preventDefault();
//       return false;
//     }
//   });
// });
$(':input[type="number"]').keyup(function() {
    let oldval = $(this).val();
    $(this).val(Math.abs(oldval));
});

function tinymce_setup_callback(editor) {
    tinymce.init({
        menubar: false,
        selector: 'textarea.richTextBox',
        skin_url: $('meta[name="assets-path"]').attr('content') + '?path=js/skins/voyager',
        resize: 'vertical',
        plugins: 'link, image, code, table, textcolor, lists',
        extended_valid_elements: 'input[id|name|value|type|class|style|required|placeholder|autocomplete|onclick]',
        file_browser_callback: function(field_name, url, type, win) {
            if (type == 'image') {
                $('#upload_file').trigger('click');
            }
        },
        toolbar: 'styleselect bold italic underline | forecolor backcolor | alignleft aligncenter alignright | bullist numlist outdent indent | link image table | code',
        convert_urls: false,
        image_caption: true,
        image_title: true,
        height: 300,
        max_height: 600
    });
}
$('.readonly_edit').find(':input').attr('readonly', 'readonly');
$('.readonly_edit').find('select').select2({
    disabled: true
});
// $('.readonly_edit').find(':select').select2().enable(false);
$('#office').find('select').on('select2:select', function(e) {
    var data = e.params.data;
    console.log(data.id);
    $.ajax({
        url: "/updateCookies/" + data.id,
        type: "GET",
        success: function(response) {
            console.log(response);
            // if(response) {
            //   $('.success').text(response.success);
            // }
        },
    });
});;