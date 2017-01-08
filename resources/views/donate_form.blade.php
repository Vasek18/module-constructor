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
            <input name="customerNumber"
                   value="{{ $user->id }}"
                   type="hidden">
            <div class="form-group">
                <label for="sum">{{ trans('donate_form.sum') }}, {{ trans('donate_form.rubles') }}</label>
                <select id="sum"
                        name="sum"
                        class="form-control input-lg">
                    <option value="{{ convertCurrency(100) }}">{{ convertCurrency(100) }}</option>
                    <option value="{{ convertCurrency(500) }}"
                            selected>{{ convertCurrency(500) }}</option>
                    <option value="{{ convertCurrency(1000) }}">{{ convertCurrency(1000) }}</option>
                    <option value="{{ convertCurrency(3000) }}">{{ convertCurrency(3000) }}</option>
                </select>
            </div>
            <div class="form-group">
                <button class="btn btn-success btn-lg">{{ trans('donate_form.pay') }}</button>
            </div>
        </form>
    </div>
</div>