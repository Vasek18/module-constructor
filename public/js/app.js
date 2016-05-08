(function() {
  $(document).on("click", "a.you-can-change", function() {
    var a, ajax, form, formtype, input, name, pattern, val;
    a = $(this);
    val = a.text();
    name = a.attr('data-name');
    pattern = a.attr('data-pattern');
    formtype = a.attr('data-formtype');
    form = a.parents('form');
    ajax = a.hasClass('ajax') ? 'ajax' : '';
    if (!formtype || formtype !== 'textarea') {
      a.replaceWith("<input type='text' class='form-control you-can-change " + ajax + "' name='" + name + "'' pattern='" + pattern + "' value='" + val + "'>");
    }
    if (formtype === 'textarea') {
      a.replaceWith("<textarea class='form-control you-can-change " + ajax + "' name='" + name + "'' pattern='" + pattern + "'>'" + val + "'</textarea>");
    }
    input = form.find("[name='" + name + "']");
    input.focus();
    input.val(val);
    return false;
  });

  $(document).on("blur", "input.you-can-change, textarea.you-can-change", function() {
    var action, ajax, form, input, method, name, pattern, val;
    input = $(this);
    val = input.val();
    name = input.attr('name');
    pattern = input.attr('pattern');
    form = input.parents('form');
    ajax = input.hasClass('ajax') ? true : false;
    action = form.attr('action');
    method = form.attr('method');
    if (ajax) {
      $.ajax({
        url: action,
        data: form.serializeArray(),
        type: method,
        success: function() {
          input.replaceWith("<a class='you-can-change " + (ajax ? "ajax" : void 0) + "' data-name='" + name + "'' data-pattern='" + pattern + "'>" + val + "</a>");
          return false;
        }
      });
    } else {
      form.submit();
    }
    return false;
  });

}).call(this);

//# sourceMappingURL=app.js.map
