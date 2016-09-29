(function() {
  $(document).on("change", ".wizard input", function() {
    var form, url;
    form = $('.wizard');
    url = form.attr('action');
    $.get(url, form.serializeArray(), function(answer) {
      if (answer.component_php != null) {
        $("#component_php").val(answer.component_php);
        window.editor_component.getSession().setValue(answer.component_php);
      }
      if (answer.class_php != null) {
        $("#class_php").val(answer.class_php);
        window.editor_class.getSession().setValue(answer.class_php);
        $('#class_php_wrap').collapse('show');
      }
    });
    return false;
  });

}).call(this);

//# sourceMappingURL=bitrix_component_logic_wizard.js.map
