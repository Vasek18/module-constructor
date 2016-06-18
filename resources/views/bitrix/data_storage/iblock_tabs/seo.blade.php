<table class="table">
    <tr>
        <th colspan="2"><h3>{{ trans('bitrix_iblocks_form.sections_seo_params_group_title') }}</h3></th>
    </tr>
    <tr>
        <th>{{ trans('bitrix_iblocks_form.param_meta_title_template') }}</th>
        <td>
            <input type="text" class="form-control"
                   name="IPROPERTY_TEMPLATES[SECTION_META_TITLE][TEMPLATE]"
                   id="IPROPERTY_TEMPLATES_SECTION_META_TITLE">
        </td>
    </tr>
    <tr>
        <th>{{ trans('bitrix_iblocks_form.param_meta_keywords_template') }}</th>
        <td>
            <input type="text" class="form-control"
                   name="IPROPERTY_TEMPLATES[SECTION_META_KEYWORDS][TEMPLATE]"
                   id="IPROPERTY_TEMPLATES_SECTION_META_KEYWORDS">
        </td>
    </tr>
    <tr>
        <th>{{ trans('bitrix_iblocks_form.param_meta_description_template') }}</th>
        <td>
            <input type="text" class="form-control"
                   name="IPROPERTY_TEMPLATES[SECTION_META_DESCRIPTION][TEMPLATE]"
                   id="IPROPERTY_TEMPLATES_SECTION_META_DESCRIPTION">
        </td>
    </tr>
    <tr>
        <th>{{ trans('bitrix_iblocks_form.param_section_page_title') }}</th>
        <td>
            <input type="text" class="form-control"
                   name="IPROPERTY_TEMPLATES[SECTION_PAGE_TITLE][TEMPLATE]"
                   id="IPROPERTY_TEMPLATES_SECTION_PAGE_TITLE">
        </td>
    </tr>
    <tr>
        <th colspan="2"><h3>{{ trans('bitrix_iblocks_form.elements_seo_params_group_title') }}</h3></th>
    </tr>
    <tr>
        <th>{{ trans('bitrix_iblocks_form.param_meta_title_template') }}</th>
        <td>
            <input type="text" class="form-control"
                   name="IPROPERTY_TEMPLATES[ELEMENT_META_TITLE][TEMPLATE]"
                   id="IPROPERTY_TEMPLATES_ELEMENT_META_TITLE">
        </td>
    </tr>
    <tr>
        <th>{{ trans('bitrix_iblocks_form.param_meta_keywords_template') }}</th>
        <td>
            <input type="text" class="form-control"
                   name="IPROPERTY_TEMPLATES[ELEMENT_META_KEYWORDS][TEMPLATE]"
                   id="IPROPERTY_TEMPLATES_ELEMENT_META_KEYWORDS">
        </td>
    </tr>
    <tr>
        <th>{{ trans('bitrix_iblocks_form.param_meta_description_template') }}</th>
        <td>
            <input type="text" class="form-control"
                   name="IPROPERTY_TEMPLATES[ELEMENT_META_DESCRIPTION][TEMPLATE]"
                   id="IPROPERTY_TEMPLATES_ELEMENT_META_DESCRIPTION">
        </td>
    </tr>
    <tr>
        <th>{{ trans('bitrix_iblocks_form.param_element_page_title') }}</th>
        <td>
            <input type="text" class="form-control"
                   name="IPROPERTY_TEMPLATES[ELEMENT_PAGE_TITLE][TEMPLATE]"
                   id="IPROPERTY_TEMPLATES_ELEMENT_PAGE_TITLE">
        </td>
    </tr>
    <tr>
        <th colspan="2"><h3>{{ trans('bitrix_iblocks_form.sections_announce_pictures_seo_params_group_title') }}</h3></th>
    </tr>
    <tr>
        <th>{{ trans('bitrix_iblocks_form.param_picture_alt_template') }}</th>
        <td>
            <input type="text" class="form-control"
                   name="IPROPERTY_TEMPLATES[SECTION_PICTURE_FILE_ALT][TEMPLATE]"
                   id="IPROPERTY_TEMPLATES_SECTION_PICTURE_FILE_ALT">
        </td>
    </tr>
    <tr>
        <th>{{ trans('bitrix_iblocks_form.param_picture_title_template') }}</th>
        <td>
            <input type="text" class="form-control"
                   name="IPROPERTY_TEMPLATES[SECTION_PICTURE_FILE_TITLE][TEMPLATE]"
                   id="IPROPERTY_TEMPLATES_SECTION_PICTURE_FILE_TITLE">
        </td>
    </tr>
    <tr>
        <th>{{ trans('bitrix_iblocks_form.param_picture_file_name_template') }}</th>
        <td>
            <input type="text" class="form-control"
                   name="IPROPERTY_TEMPLATES[SECTION_PICTURE_FILE_NAME][TEMPLATE]"
                   id="IPROPERTY_TEMPLATES_SECTION_PICTURE_FILE_NAME">
            <input type="checkbox" name="IPROPERTY_TEMPLATES[SECTION_PICTURE_FILE_NAME][LOWER]"
                   id="lower_SECTION_PICTURE_FILE_NAME" value="Y"
            >
            <label for="lower_SECTION_PICTURE_FILE_NAME" title=""></label>
            <label for="lower_SECTION_PICTURE_FILE_NAME">{{ trans('bitrix_iblocks_form.param_transform_to_lower_case') }}</label>
            <br>
            <input type="checkbox" name="IPROPERTY_TEMPLATES[SECTION_PICTURE_FILE_NAME][TRANSLIT]"
                   id="translit_SECTION_PICTURE_FILE_NAME" value="Y"
            >
            <label for="translit_SECTION_PICTURE_FILE_NAME" title=""></label>
            <label for="translit_SECTION_PICTURE_FILE_NAME">{{ trans('bitrix_iblocks_form.param_transliterate') }}</label>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label for="space_SECTION_PICTURE_FILE_NAME">
                        {{ trans('bitrix_iblocks_form.param_transliterate_whitespace_replacement') }}:
                    </label>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control"
                           name="IPROPERTY_TEMPLATES[SECTION_PICTURE_FILE_NAME][SPACE]"
                           id="space_SECTION_PICTURE_FILE_NAME" value=""
                    >
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <th colspan="2"><h3>{{ trans('bitrix_iblocks_form.sections_detail_pictures_seo_params_group_title') }}</h3></th>
    </tr>
    <tr>
        <th>{{ trans('bitrix_iblocks_form.param_picture_alt_template') }}</th>
        <td>
            <input type="text" class="form-control"
                   name="IPROPERTY_TEMPLATES[SECTION_DETAIL_PICTURE_FILE_ALT][TEMPLATE]"
                   id="IPROPERTY_TEMPLATES_SECTION_DETAIL_PICTURE_FILE_ALT"
            >
        </td>
    </tr>
    <tr>
        <th>{{ trans('bitrix_iblocks_form.param_picture_title_template') }}</th>
        <td>
            <input type="text" class="form-control"
                   name="IPROPERTY_TEMPLATES[SECTION_DETAIL_PICTURE_FILE_TITLE][TEMPLATE]"
                   id="IPROPERTY_TEMPLATES_SECTION_DETAIL_PICTURE_FILE_TITLE"
            >
        </td>
    </tr>
    <tr>
        <th>{{ trans('bitrix_iblocks_form.param_picture_file_name_template') }}</th>
        <td>
            <input type="text" class="form-control"
                   name="IPROPERTY_TEMPLATES[SECTION_DETAIL_PICTURE_FILE_NAME][TEMPLATE]"
                   id="IPROPERTY_TEMPLATES_SECTION_DETAIL_PICTURE_FILE_NAME"
            >
            <input type="checkbox" name="IPROPERTY_TEMPLATES[SECTION_DETAIL_PICTURE_FILE_NAME][LOWER]"
                   id="lower_SECTION_DETAIL_PICTURE_FILE_NAME" value="Y"
            >
            <label for="lower_SECTION_DETAIL_PICTURE_FILE_NAME" title=""></label>
            <label for="lower_SECTION_DETAIL_PICTURE_FILE_NAME">{{ trans('bitrix_iblocks_form.param_transform_to_lower_case') }}</label>
            <br>
            <input type="checkbox" name="IPROPERTY_TEMPLATES[SECTION_DETAIL_PICTURE_FILE_NAME][TRANSLIT]"
                   id="translit_SECTION_DETAIL_PICTURE_FILE_NAME" value="Y"
            >
            <label for="translit_SECTION_DETAIL_PICTURE_FILE_NAME" title=""></label>
            <label for="translit_SECTION_DETAIL_PICTURE_FILE_NAME">{{ trans('bitrix_iblocks_form.param_transliterate') }}</label>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label for="space_SECTION_DETAIL_PICTURE_FILE_NAME">
                        {{ trans('bitrix_iblocks_form.param_transliterate_whitespace_replacement') }}:
                    </label>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control"
                           name="IPROPERTY_TEMPLATES[SECTION_DETAIL_PICTURE_FILE_NAME][SPACE]"
                           id="space_SECTION_DETAIL_PICTURE_FILE_NAME" value=""
                    >
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <th colspan="2"><h3>{{ trans('bitrix_iblocks_form.elements_announce_pictures_seo_params_group_title') }}</h3></th>
    </tr>
    <tr>
        <th></th>
        <td>
            <input type="text" class="form-control"
                   name="IPROPERTY_TEMPLATES[ELEMENT_PREVIEW_PICTURE_FILE_ALT][TEMPLATE]"
                   id="IPROPERTY_TEMPLATES_ELEMENT_PREVIEW_PICTURE_FILE_ALT"
            >
        </td>
    </tr>
    <tr>
        <th>{{ trans('bitrix_iblocks_form.param_picture_title_template') }}</th>
        <td>
            <input type="text" class="form-control"
                   name="IPROPERTY_TEMPLATES[ELEMENT_PREVIEW_PICTURE_FILE_TITLE][TEMPLATE]"
                   id="IPROPERTY_TEMPLATES_ELEMENT_PREVIEW_PICTURE_FILE_TITLE"
            >
        </td>
    </tr>
    <tr>
        <th>{{ trans('bitrix_iblocks_form.param_picture_file_name_template') }}</th>
        <td>
            <input type="text" class="form-control"
                   name="IPROPERTY_TEMPLATES[ELEMENT_PREVIEW_PICTURE_FILE_NAME][TEMPLATE]"
                   id="IPROPERTY_TEMPLATES_ELEMENT_PREVIEW_PICTURE_FILE_NAME"
            >
            <input type="checkbox" name="IPROPERTY_TEMPLATES[ELEMENT_PREVIEW_PICTURE_FILE_NAME][LOWER]"
                   id="lower_ELEMENT_PREVIEW_PICTURE_FILE_NAME" value="Y"
            >
            <label for="lower_ELEMENT_PREVIEW_PICTURE_FILE_NAME" title=""></label>
            <label for="lower_ELEMENT_PREVIEW_PICTURE_FILE_NAME">{{ trans('bitrix_iblocks_form.param_transform_to_lower_case') }}</label>
            <br>
            <input type="checkbox" name="IPROPERTY_TEMPLATES[ELEMENT_PREVIEW_PICTURE_FILE_NAME][TRANSLIT]"
                   id="translit_ELEMENT_PREVIEW_PICTURE_FILE_NAME" value="Y"
            >
            <label for="translit_ELEMENT_PREVIEW_PICTURE_FILE_NAME"
                   title=""></label>
            <label for="translit_ELEMENT_PREVIEW_PICTURE_FILE_NAME">{{ trans('bitrix_iblocks_form.param_transliterate') }}</label>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label for="space_ELEMENT_PREVIEW_PICTURE_FILE_NAME">
                        {{ trans('bitrix_iblocks_form.param_transliterate_whitespace_replacement') }}:
                    </label>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control"
                           name="IPROPERTY_TEMPLATES[ELEMENT_PREVIEW_PICTURE_FILE_NAME][SPACE]"
                           id="space_ELEMENT_PREVIEW_PICTURE_FILE_NAME" value=""
                    >
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <th colspan="2"><h3>{{ trans('bitrix_iblocks_form.elements_detail_pictures_seo_params_group_title') }}</h3></th>
    </tr>
    <tr>
        <th>{{ trans('bitrix_iblocks_form.param_picture_alt_template') }}</th>
        <td>
            <input type="text" class="form-control"
                   name="IPROPERTY_TEMPLATES[ELEMENT_DETAIL_PICTURE_FILE_ALT][TEMPLATE]"
                   id="IPROPERTY_TEMPLATES_ELEMENT_DETAIL_PICTURE_FILE_ALT"
            >
        </td>
    </tr>
    <tr>
        <th>{{ trans('bitrix_iblocks_form.param_picture_title_template') }}</th>
        <td>
            <input type="text" class="form-control"
                   name="IPROPERTY_TEMPLATES[ELEMENT_DETAIL_PICTURE_FILE_TITLE][TEMPLATE]"
                   id="IPROPERTY_TEMPLATES_ELEMENT_DETAIL_PICTURE_FILE_TITLE"
            >
        </td>
    </tr>
    <tr>
        <th>{{ trans('bitrix_iblocks_form.param_picture_file_name_template') }}</th>
        <td>
            <input type="text" class="form-control"
                   name="IPROPERTY_TEMPLATES[ELEMENT_DETAIL_PICTURE_FILE_NAME][TEMPLATE]"
                   id="IPROPERTY_TEMPLATES_ELEMENT_DETAIL_PICTURE_FILE_NAME"
            >
            <input type="checkbox" name="IPROPERTY_TEMPLATES[ELEMENT_DETAIL_PICTURE_FILE_NAME][LOWER]"
                   id="lower_ELEMENT_DETAIL_PICTURE_FILE_NAME" value="Y"
            >
            <label for="lower_ELEMENT_DETAIL_PICTURE_FILE_NAME" title=""></label>
            <label for="lower_ELEMENT_DETAIL_PICTURE_FILE_NAME">{{ trans('bitrix_iblocks_form.param_transform_to_lower_case') }}</label>
            <br>
            <input type="checkbox" name="IPROPERTY_TEMPLATES[ELEMENT_DETAIL_PICTURE_FILE_NAME][TRANSLIT]"
                   id="translit_ELEMENT_DETAIL_PICTURE_FILE_NAME" value="Y"
            >
            <label for="translit_ELEMENT_DETAIL_PICTURE_FILE_NAME" title=""></label>
            <label for="translit_ELEMENT_DETAIL_PICTURE_FILE_NAME">{{ trans('bitrix_iblocks_form.param_transliterate') }}</label>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label for="space_ELEMENT_DETAIL_PICTURE_FILE_NAME">
                        {{ trans('bitrix_iblocks_form.param_transliterate_whitespace_replacement') }}:
                    </label>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control"
                           name="IPROPERTY_TEMPLATES[ELEMENT_DETAIL_PICTURE_FILE_NAME][SPACE]"
                           id="space_ELEMENT_DETAIL_PICTURE_FILE_NAME" value=""
                    >
                </div>
            </div>
        </td>
    </tr>
</table>