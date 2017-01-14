(function() {
  var changeForm, downloadAsInput, downloadAsInputForTestVal, downloadAsInputFreshVal, downloadAsInputName, downloadAsInputUpdateVal, filesEncodingInput, filesEncodingInputUtfVal, filesEncodingInputWindows1251Val, filesInput, updateDescriptionInput, updatePhpInput;

  downloadAsInputName = "download_as";

  downloadAsInput = $("[name=" + downloadAsInputName + "]");

  downloadAsInputUpdateVal = "update";

  downloadAsInputFreshVal = "fresh";

  downloadAsInputForTestVal = "for_test";

  updateDescriptionInput = $("[name=description]");

  updatePhpInput = $("[name=updater]");

  filesEncodingInput = $("[name=files_encoding]");

  filesEncodingInputUtfVal = "utf-8";

  filesEncodingInputWindows1251Val = "windows-1251";

  filesInput = $("[name^=files]");

  $(document).on("change", "[name^=" + downloadAsInputName + "]", function() {
    var downloadAs;
    downloadAsInput = $(this);
    downloadAs = downloadAsInput.val();
    changeForm(downloadAs);
  });

  $(document).ready(function() {
    changeForm(downloadAsInput.val());
  });

  $(document).on("click", ".check-all", function() {
    filesInput.prop('checked', true);
    return false;
  });

  changeForm = function(downloadAs) {
    if (downloadAs === downloadAsInputFreshVal) {
      updateDescriptionInput.parents('.form-group').hide();
      updatePhpInput.parents('.form-group').hide();
      filesEncodingInput.val(filesEncodingInputWindows1251Val);
      filesInput.prop('checked', true);
    }
    if (downloadAs === downloadAsInputUpdateVal) {
      updateDescriptionInput.parents('.form-group').show();
      updatePhpInput.parents('.form-group').show();
      filesEncodingInput.val(filesEncodingInputWindows1251Val);
      filesInput.prop('checked', false);
      filesInput.filter('[data-changed="true"]').prop('checked', true);
    }
    if (downloadAs === downloadAsInputForTestVal) {
      updateDescriptionInput.parents('.form-group').hide();
      updatePhpInput.parents('.form-group').hide();
      filesEncodingInput.val(filesEncodingInputUtfVal);
      return filesInput.prop('checked', true);
    }
  };

}).call(this);

//# sourceMappingURL=bitrix_download_form.js.map
