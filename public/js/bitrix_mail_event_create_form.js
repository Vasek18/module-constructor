(function() {
  $(document).on("change", "#MAIL_EVENT_VARS", function() {
    var code, i, input, name, reg, result, val;
    input = $(this);
    val = $(this).val();
    reg = /#(.+)#\s*-\s*([^#]+)/gi;
    i = 0;
    while ((result = reg.exec(val))) {
      code = result[1];
      name = result[2];
      if (code) {
        if (!($("[name*='MAIL_EVENT_VARS_CODES'").eq(i).length)) {
          $('.vals-list').append("<div class='form-group'> <div class='col-md-6'> <input class='form-control' type='text' placeholder='Название' name='MAIL_EVENT_VARS_NAMES[]' id='MAIL_EVENT_VARS_NAME_" + i + "'> </div> <div class='col-md-6'> <input class='form-control' type='text' placeholder='Код' name='MAIL_EVENT_VARS_CODES[]' id='MAIL_EVENT_VARS_CODE_{#i}'> </div> </div>");
        }
        $("[name*='MAIL_EVENT_VARS_CODES'").eq(i).val(code);
      }
      if (name) {
        if (($("[name*='MAIL_EVENT_VARS_NAMES'").eq(i).length)) {
          $("[name*='MAIL_EVENT_VARS_NAMES'").eq(i).val(name);
        }
      }
      i++;
    }
  });

  $(document).on("click", ".add-var-row", function() {
    var count, newRow, varRow;
    count = $('.var-row').length;
    varRow = $('.var-row:last').clone();
    $(this).before(varRow);
    newRow = $('.var-row:last');
    newRow.find('[name*=MAIL_EVENT_VARS_NAMES]').attr('id', "MAIL_EVENT_VARS_NAME_" + count);
    newRow.find('[name*=MAIL_EVENT_VARS_CODES]').attr('id', "MAIL_EVENT_VARS_CODE_" + count);
    newRow.find('[name*=MAIL_EVENT_VARS_CODES]').attr('data-translit_from', "MAIL_EVENT_VARS_NAME_" + count);
    return false;
  });

}).call(this);

//# sourceMappingURL=bitrix_mail_event_create_form.js.map
