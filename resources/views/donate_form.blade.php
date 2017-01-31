<div class="row">
    <div class="col-md-4">
        <form action="{{ env('YANDEX_KASSA_FORM_ACTION') }}"
              method="post">
            <input type="hidden"
                   name="shopId"
                   value="{{ env('YANDEX_KASSA_SHOP_ID') }}">
            <input type="hidden"
                   name="scid"
                   value="{{ env('YANDEX_KASSA_SCID') }}">
            @if (isset($user))
                <input name="customerNumber"
                       value="{{ $user->id }}"
                       type="hidden">
            @endif
            <div class="form-group">
                <label for="sum">{{ trans('donate_form.sum') }}, {{ trans('donate_form.rubles') }}</label>
                <select id="sum"
                        name="sum"
                        class="form-control input-lg">
                    {{--Сумма должна быть указана в рублях--}}
                    <option value="100">{{ convertCurrency(100, true) }}</option>
                    <option value="500" selected>{{ convertCurrency(500, true) }}</option>
                    <option value="1000">{{ convertCurrency(1000, true) }}</option>
                    <option value="3000">{{ convertCurrency(3000, true) }}</option>
                </select>
            </div>
            <div class="form-group">
                <button class="btn btn-success btn-lg">{{ trans('donate_form.pay') }}</button>
            </div>
        </form>
    </div>
</div>