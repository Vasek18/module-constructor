(function() {
  $('.prop .modal').on('show.bs.modal', function(event) {
    var button, modal_form, row, type_id;
    button = $(event.relatedTarget);
    row = button.parents("tr");
    type_id = row.find("[name *= TYPE]").val();
    modal_form = $(button.attr('data-target'));
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

}).call(this);

//# sourceMappingURL=bitrix_iblock.js.map
