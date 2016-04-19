var image_button = 'upload_image_button';
var image_field = 'upload_image_field';
var image = 'section-image-preview';
var choose_image_text = 'Выбрать изображение';

jQuery(document).ready(function () {
    jQuery('.' + image_button).click(function (e) {
        var field = jQuery(this).siblings('.' + image_field);
        var img = jQuery(this).siblings('.' + image);
        uploader(e, field, img);
    })

    jQuery('.' + image).click(function (e) {
        var field = jQuery(this).siblings('.'+image_field);
        var img = jQuery(this);
        uploader(e, field, img);
    });
    jQuery('.' + image_field).click(function (e) {
        var field = jQuery(this);
        var img = jQuery(this).siblings('.'+image);
        uploader(e, field, img);
    });

});

function uploader(e, field, image) {

    var custom_uploader;
    e.preventDefault();

    if (custom_uploader) {
        custom_uploader.open();
        return;
    }
    custom_uploader = wp.media.frames.file_frame = wp.media({
        title: choose_image_text,
        button: {
            text: choose_image_text
        },
        multiple: false
    });
    custom_uploader.on('select', function () {
        attachment = custom_uploader.state().get('selection').first().toJSON();
        field.val(attachment.url);
        image.attr('src', attachment.url)
    });
    custom_uploader.open();
}
