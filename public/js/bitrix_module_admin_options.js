(function() {
  $('.options .modal').on('show.bs.modal', function(event) {
    var button, modal_form, row, type_id;
    button = $(event.relatedTarget);
    row = button.parents(".row.option");
    type_id = row.find("[name *= _type]").val();
    modal_form = row.next(button.attr('data-target'));
    modal_form.find('.form-group').hide();
    modal_form.find('[data-for_type_ids ~= "' + type_id + '"]').show();
    modal_form.find(".only-one input:not([type=radio])").prop("disabled", true);
    if (!modal_form.find(".only-one input[type=radio]:checked").length) {
      modal_form.find(".only-one input[type=radio]:first").click();
    } else {
      modal_form.find(".only-one input[type=radio]:checked").parents(".item").find("input:not([type=radio])").prop("disabled", false);
    }
  });

  $(document).on("change", ".options .modal .only-one [type=radio]", function() {
    var item, items;
    item = $(this).parents(".item");
    items = $(".only-one .item");
    items.each(function() {
      return $(this).find("input:not([type=radio])").prop("disabled", true);
    });
    item.find("input:not([type=radio])").prop("disabled", false);
  });

  $(document).on("click", ".add-dop-row", function() {
    var newRow, number, row, rowTemplate;
    row = $(this).parents('.row.overlast-row');
    number = $('.row.option:visible').length;
    rowTemplate = $('.template-for-js').html();
    newRow = rowTemplate.replace(/__change_me_i_am_number__/g, number);
    row.before(newRow);
    return false;
  });

}).call(this);

//# sourceMappingURL=bitrix_module_admin_options.js.map
