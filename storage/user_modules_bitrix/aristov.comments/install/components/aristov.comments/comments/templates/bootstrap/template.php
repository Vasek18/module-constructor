<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
// print_r($arResult);
// vprint($arParams);
?>
	<div class="av-comments clearfix">
		<div class="comments">
			<? if (!empty($arResult["ITEMS"])){ ?>
				<h2><?=GetMessage("ARISTOV_COMMENTS_KOMMENTARII")?></h2>
				<? foreach ($arResult["ITEMS"] as $c => $arItem){
					$search = Array(
						'#ID#',
						'#AUTHOR_NAME#',
						'#AVA_SRC#',
						'#DATE_CREATE#',
						'#TEXT#',
					);
					$replace = Array(
						$arItem["ID"],
						$arItem["PROPS"][$arParams["AUTHOR_PROP"]]["VALUE"],
						$templateFolder."/img/ava.jpg",
						$arItem["DATE_CREATE"],
						$arItem["DETAIL_TEXT"],
					);
					echo getCommentHTML($_SERVER["DOCUMENT_ROOT"].$templateFolder.'/comment.php', $search, $replace);
				} ?><? } ?>
		</div>
		<div class="comment-form-wrap">
			<h3><?=GetMessage("ARISTOV_COMMENTS_NAPISATQ_KOMMENTARIY")?></h3>
			<form class="bs-example bs-example-form comment-form"
				  role="form">
				<input type="hidden"
					   name="PARENT_ID"
					   value="<?=$arParams["ELEMENT_ID"];?>"
					   required/>
				<div class="form-group">
					<label for="NAME"><?=GetMessage("ARISTOV_COMMENTS_IMA")?></label>
					<input type="text"
						   class="form-control"
						   id="NAME"
						   name="NAME"
						   required/>
				</div>
				<div class="form-group">
					<label for="TEXT"><?=GetMessage("ARISTOV_COMMENTS_TEKST_SOOBSENIA")?></label>
					<textarea id="TEXT"
							  name="TEXT"
							  class="form-control ctrlEnterSubmit"
							  rows="3"
							  required></textarea>
				</div>
				<button type="submit"
						class="btn btn-primary"><?=GetMessage("ARISTOV_COMMENTS_OTPRAVITQ_KOMMENTARI")?></button>
			</form>
		</div>
	</div>
<?php
function getCommentHTML($file, $search = Array(), $replace = Array()){
	$template = file_get_contents($file);
	$commentHTML = str_replace($search, $replace, $template);

	return $commentHTML;
}