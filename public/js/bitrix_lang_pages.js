(function() {
  $(document).on("submit", ".langs-form", function() {
    return false;
  });

  $(document).on("click", ".langs-form button", function() {
    var allButtons, button, data, form, method, row, url;
    button = $(this);
    row = button.parents('tr');
    form = button.parents('form');
    url = form.attr('action');
    method = form.attr('method');
    allButtons = form.find('button');
    allButtons.prop('disabled', true);
    data = form.serializeArray();
    data.push({
      name: button.attr('name'),
      value: button.attr('value')
    });
    $.ajax(url, {
      method: method,
      data: data,
      error: function(jqXHR, textStatus, errorThrown) {
        location.reload();
      },
      success: function(data, textStatus, jqXHR) {
        location.reload();
      }
    });
    return false;
  });

}).call(this);

//# sourceMappingURL=bitrix_lang_pages.js.map
