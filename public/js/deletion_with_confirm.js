(function() {
  $(document).on("click", ".deletion-with-confirm", function() {
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

//# sourceMappingURL=deletion_with_confirm.js.map
