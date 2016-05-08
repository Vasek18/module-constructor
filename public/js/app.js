(function() {
  $('.draggable').draggable();

  $(document).on("mouseup", ".draggable", function() {
    var i;
    i = 0;
    $('.draggable .sort-val').each(function() {
      $(this).val(i);
      return i++;
    });
  });

}).call(this);

//# sourceMappingURL=app.js.map
