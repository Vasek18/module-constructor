(function() {
  $('.option .modal').on('show.bs.modal', function(event) {
    var button, modal_form, row, type;
    button = $(event.relatedTarget);
    row = button.parents(".row.option");
    type = row.find("[name *= _type]").val();
    modal_form = row.find('.modal');
    modal_form.find('.form-group').hide();
    modal_form.find('[data-for_types ~= "' + type + '"]').show();
    modal_form.find('[data-for_types = ""]').show();
    modal_form.find(".only-one input:not([type=radio])").prop("disabled", true);
    if (!modal_form.find(".only-one input[type=radio]:checked")) {
      modal_form.find(".only-one input[type=radio]:first").change();
    } else {
      modal_form.find(".only-one input[type=radio]:checked").parents(".item").find("input:not([type=radio])").prop("disabled", false);
    }
  });

  $(document).on("change", ".option .modal .only-one [type=radio]", function() {
    var item, items;
    item = $(this).parents(".item");
    items = $(".only-one .item");
    items.each(function() {
      return $(this).find("input:not([type=radio])").prop("disabled", true);
    });
    item.find("input:not([type=radio])").prop("disabled", false);
  });

}).call(this);

//# sourceMappingURL=bitrix_module_components_params.js.map
