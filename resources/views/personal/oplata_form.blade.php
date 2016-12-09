<div class="row">
    <div class="col-md-4">
        <form action="">
            <div class="form-group">
                <label for="sum">{{ trans('oplata_form.sum') }}, {{ trans('oplata_form.rubles') }}</label>
                <select id="sum"
                        name="sum"
                        class="form-control input-lg">
                    <option value="{{ convertCurrency(setting('day_price')*1) }}">{{ trans('oplata_form.one_day') }}
                        - {{ convertCurrency(setting('day_price')*1) }}</option>
                    <option value="{{ setting('day_price')*3 }}">{{ trans('oplata_form.three_days') }}
                        - {{ convertCurrency(setting('day_price')*3) }}</option>
                    <option value="{{ setting('day_price')*7 }}">{{ trans('oplata_form.one_week') }}
                        - {{ convertCurrency(setting('day_price')*7) }}</option>
                    <option value="{{ setting('day_price')*30 }}">{{ trans('oplata_form.one_month') }}
                        - {{ convertCurrency(setting('day_price')*30) }}</option>
                </select>
            </div>
            <div class="form-group">
                <button class="btn btn-success btn-lg">{{ trans('oplata_form.pay') }}</button>
            </div>
        </form>
    </div>
</div>