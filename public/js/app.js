(function() {
  $('.draggable').draggable();

  $(document).on("mouseup", ".draggable", function() {
    $('.draggable .sort-val').each(function(i, el) {
      $(this).val(i);
    });
  });

  $(document).on("change", "[data-transform]", function() {
    var input, transform, val;
    input = $(this);
    val = $(this).val();
    transform = input.attr('data-transform').split(',');
    if (transform.indexOf('uppercase') !== -1) {
      input.val(val.toUpperCase());
    }
  });

  $(document).on("click", ".human_ajax_deletion", function() {
    var button, item, method, url;
    button = $(this);
    item = $(this).parents('.deletion_wrapper');
    method = button.attr('data-method');
    url = button.attr('href');
    $.ajax({
      url: url,
      data: "",
      type: method,
      success: function(answer) {}
    });
    item.remove();
    return false;
  });

  $('[data-toggle="popover"]').popover();

}).call(this);

//# sourceMappingURL=app.js.map
