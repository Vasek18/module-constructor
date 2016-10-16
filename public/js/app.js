(function() {
  var hash;

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

  $(document).on("shown.bs.tab", 'a[data-toggle="tab"]', function() {
    var hash;
    hash = $(this).attr('data-hash');
    if (hash) {
      window.location.hash = hash;
    } else {
      window.location.hash = '';
    }
  });

  hash = window.location.hash.replace(/#/, '');

  if (hash) {
    if ($(".tab-pane#" + hash).length) {
      $("[data-toggle='tab']").parent('li').removeClass('active');
      $("[data-toggle='tab'][href='#" + hash + "']").parent('li').addClass('active');
      $(".tab-pane").removeClass('active');
      $(".tab-pane#" + hash).addClass('active');
    }
  }

}).call(this);

//# sourceMappingURL=app.js.map
