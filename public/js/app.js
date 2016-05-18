(function() {
  $('.draggable').draggable();

  $(document).on("mouseup", ".draggable", function() {
    $('.draggable .sort-val').each(function(i, el) {
      $(this).val(i);
    });
  });

}).call(this);

//# sourceMappingURL=app.js.map
