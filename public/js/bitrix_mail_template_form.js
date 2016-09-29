(function() {
  $(document).on("click", ".available-vals a", function() {
    var text, textarea, variable;
    textarea = $('[name=body]');
    text = textarea.val();
    variable = $(this).attr('data-var');
    textarea.val(text + "#" + variable + "#");
    return false;
  });

}).call(this);

//# sourceMappingURL=bitrix_mail_template_form.js.map
