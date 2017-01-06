$(document).ready(->
	$(".article-detail img").each((index, element) ->
		img = $(element)
		title = img.attr('title')

		img.wrap('<div class="img-wrap"></div>')
		wrap = img.parent('.img-wrap')

		if title.length
			wrap.append('<div class="description">' + title + '</div>')


		return
	)
	return
)