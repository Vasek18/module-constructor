(function() {
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

}).call(this);

//# sourceMappingURL=human_ajax_deletion.js.map
