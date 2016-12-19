(function() {
  $(document).on("click", "a.you-can-change", function() {
    var a, ajax, form, formtype, input, name, pattern, val;
    a = $(this);
    val = a.text();
    name = a.attr('data-name');
    pattern = a.attr('data-pattern');
    if (pattern && typeof result === 'string' && pattern !== 'undefined' && pattern.length) {
      pattern = 'pattern="' + pattern + '"';
    } else {
      pattern = '';
    }
    formtype = a.attr('data-formtype');
    form = a.parents('form');
    ajax = a.hasClass('ajax') ? 'ajax' : '';
    if (!formtype || formtype !== 'textarea') {
      a.replaceWith("<input type='text' class='form-control you-can-change " + ajax + "' name='" + name + "' " + pattern + " value='" + val + "'>");
    }
    if (formtype === 'textarea') {
      a.replaceWith("<textarea class='form-control you-can-change " + ajax + "' name='" + name + "' " + pattern + ">'" + val + "'</textarea>");
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
    if (pattern && typeof result === 'string' && pattern !== 'undefined' && pattern.length) {
      pattern = 'data-pattern="' + pattern + '"';
    } else {
      pattern = '';
    }
    form = input.parents('form');
    ajax = input.hasClass('ajax') ? true : false;
    action = form.attr('action');
    method = form.attr('method');
    if (form.find('[name="_method"]').length) {
      method = form.find('[name="_method"]').val();
    }
    if (ajax) {
      $.ajax({
        url: action,
        data: form.serializeArray(),
        type: method,
        success: function(answer) {
          input.replaceWith("<a class='you-can-change " + (ajax ? "ajax" : void 0) + "' data-name='" + name + "' " + pattern + ">" + val + "</a>");
          return false;
        }
      });
    } else {
      form.submit();
    }
    return false;
  });

}).call(this);

//# sourceMappingURL=a.you-can-change.js.map
