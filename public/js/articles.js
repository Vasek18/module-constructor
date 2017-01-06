(function() {
  $(document).ready(function() {
    $(".article-detail img").each(function(index, element) {
      var img, title, wrap;
      img = $(element);
      title = img.attr('title');
      img.wrap('<div class="img-wrap"></div>');
      wrap = img.parent('.img-wrap');
      if (title.length) {
        wrap.append('<div class="description">' + title + '</div>');
      }
    });
  });

}).call(this);

//# sourceMappingURL=articles.js.map
