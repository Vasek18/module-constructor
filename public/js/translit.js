(function() {
  window.translit = function(str, saveCase) {
    var arr, newStr, replacer;
    arr = {
      'а': 'a',
      'б': 'b',
      'в': 'v',
      'г': 'g',
      'д': 'd',
      'е': 'e',
      'ё': 'yo',
      'ж': 'g',
      'з': 'z',
      'и': 'i',
      'й': 'y',
      'к': 'k',
      'л': 'l',
      'м': 'm',
      'н': 'n',
      'о': 'o',
      'п': 'p',
      'р': 'r',
      'с': 's',
      'т': 't',
      'у': 'u',
      'ф': 'f',
      'х': 'ch',
      'ц': 'c',
      'ч': 'ch',
      'ш': 'sh',
      'щ': 'sch',
      'ъ': '',
      'ь': '',
      'ы': 'y',
      'э': 'e',
      'ю': 'yu',
      'я': 'ya',
      'А': 'A',
      'Б': 'B',
      'В': 'V',
      'Г': 'G',
      'Д': 'D',
      'Е': 'E',
      'Ё': 'YO',
      'Ж': 'G',
      'З': 'Z',
      'И': 'I',
      'Й': 'Y',
      'К': 'K',
      'Л': 'L',
      'М': 'M',
      'Н': 'N',
      'О': 'O',
      'П': 'P',
      'Р': 'R',
      'С': 'S',
      'Т': 'T',
      'У': 'U',
      'Ф': 'F',
      'Х': 'CH',
      'Ц': 'C',
      'Ч': 'CH',
      'Ш': 'SH',
      'Щ': 'SCH',
      'Ъ': '',
      'Ь': '',
      'Ы': 'y',
      'Ю': 'YU',
      'Я': 'YA',
      'Э': 'E',
      '#': '',
      ' ': '_',
      '(': '_',
      ')': '_',
      ',': '_',
      '!': '_',
      '?': '_'
    };
    replacer = function(a) {
      if (arr[a] != null) {
        return arr[a];
      } else {
        return a;
      }
    };
    newStr = str.replace(/./g, replacer);
    newStr = newStr.replace(/__+/g, '_');
    if (!saveCase) {
      newStr = newStr.toLowerCase();
    }
    return newStr;
  };

  $(document).ready(function() {
    $("[data-translit_from]").each(function(index, element) {
      var elToListenID;
      elToListenID = $(element).attr('data-translit_from');
      $("#" + elToListenID).attr('data-translit_to', $(element).attr('id'));
      $(document).on("change", "#" + elToListenID, function() {
        var elToChangeID, val;
        val = $(this).val();
        elToChangeID = $(this).attr('data-translit_to');
        return $("#" + elToChangeID).val(translit(val));
      });
    });
  });

}).call(this);

//# sourceMappingURL=translit.js.map
