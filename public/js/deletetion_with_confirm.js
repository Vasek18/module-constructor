(function() {
  $(document).on("click", ".deletetion-with-confirm", function() {
    var a, href, modal, newLink;
    a = $(this);
    href = a.attr('href');
    modal = $('#delete-confirm-modal');
    newLink = modal.find('.delete');
    modal.modal('show');
    newLink.attr('href', href);
    return false;
  });

}).call(this);

//# sourceMappingURL=deletetion_with_confirm.js.map
