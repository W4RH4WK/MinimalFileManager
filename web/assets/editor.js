// -------------------------------------------------- EDITOR INIT
$('div#editor textarea').ckeditor(function (textarea) {
  var e = $(textarea).ckeditorGet();

  e.getCommand('save').exec = function (editor) {
    $.ajax({
      url: 'data/ajax/' + $('div#editor input#editor-target').val(),
      cache: false,
      dataType: 'json',
      data: {
        content: $('div#editor textarea').val(),
        type: 'edit'
      },
      type: 'POST',
      success: function (result) {
        add_msg(result.msg, 'PHP', result.status ? 'alert-success' : 'alert-danger');
      },
      error: function (jqXHR, status) {
        add_msg(status, 'AJAX', 'alert-danger');
      }
    });
  };

  e.getCommand('save').enable()
});

// -------------------------------------------------- TOOLBOX BUTTONS
$('a#editor-close-button').click(function (e) {
  $('div#editor').hide();
});
