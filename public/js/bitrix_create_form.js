(function() {
  $(document).on("change", '[name="PARTNER_URI"]', function() {
    var httpServicePartOfString, httpsServicePartOfString, input, servicePartHttp, servicePartHttps, url;
    input = $(this);
    url = input.val();
    httpServicePartOfString = url.substr(0, 7);
    httpsServicePartOfString = url.substr(0, 8);
    servicePartHttp = 'http://';
    servicePartHttps = 'https://';
    if (httpServicePartOfString !== servicePartHttp) {
      if (httpsServicePartOfString !== servicePartHttps) {
        url = servicePartHttp + url;
        return input.val(url);
      }
    }
  });

}).call(this);

//# sourceMappingURL=bitrix_create_form.js.map
