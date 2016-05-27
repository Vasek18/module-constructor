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

}).call(this);

//# sourceMappingURL=app.js.map
