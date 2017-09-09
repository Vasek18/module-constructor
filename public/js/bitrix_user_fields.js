(function() {
  $(document).on("change", ".js-change-fields-visibility", function() {
    var selectedType;
    selectedType = $(this).val();
    $('[data-for_types]').hide();
    $('[data-for_types ~= "' + selectedType + '"]').show();
  });

}).call(this);

//# sourceMappingURL=bitrix_user_fields.js.map
