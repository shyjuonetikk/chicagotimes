var custom_uploader;

function image_button_click(dialog_title, button_text, library_type, preview_id, control_id) {

  event.preventDefault();

  custom_uploader = wp.media.frames.file_frame = wp.media({
    title: dialog_title,
    button: {
      text: button_text
    },
    library : { type : library_type },
    multiple: false
  });

  custom_uploader.on('select', function() {

    attachment = custom_uploader.state().get('selection').first().toJSON();
    jQuery('#' + control_id).val(attachment.url);

    var html = '';

    if (library_type=='image') {
      var image = jQuery('<img>');
      image.attr('href', attachment.url);
    }

    jQuery('#' + preview_id).empty().append(image);
  });

  //Open the uploader dialog
  custom_uploader.open();

}