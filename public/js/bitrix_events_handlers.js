(function() {
  $(document).on("change", "[name^=event]", function() {
    var datalist, datalistOption, el, event, params, paramsField, row;
    el = $(this);
    event = el.val();
    datalist = $("#" + el.attr("list"));
    datalistOption = datalist.find("[value=" + event + "]");
    params = datalistOption.attr("data-params");
    row = el.parents(".option");
    paramsField = row.find("[name^=params]");
    if (params) {
      paramsField.val(params);
    }
  });

}).call(this);

//# sourceMappingURL=bitrix_events_handlers.js.map
