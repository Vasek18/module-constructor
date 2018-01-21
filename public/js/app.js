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
    if (transform.indexOf('onlylatin') !== -1) {
      input.val(val.replace(/[^a-zA-Z]/g, ''));
    }
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

  $(document).ready(function() {
    $("[data-copy_from]").each(function(index, element) {
      var elToChange, elToListenID;
      elToListenID = $(element).attr('data-copy_from');
      elToChange = $(element);
      $(document).on("change", "#" + elToListenID, function() {
        var val;
        val = $(this).val();
        elToChange.val(val);
        elToChange.change();
      });
    });
  });

}).call(this);

//# sourceMappingURL=app.js.map
