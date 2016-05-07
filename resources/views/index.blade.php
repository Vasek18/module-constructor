@extends("app")

@section("content")
    <div class="container">
        <div class="row">
            <div class="banner-on-main col-md-8 col-md-offset-2">
                <h2>Делаешь сайты, а зарабатываешь меньше 100 000р в месяц?</h2>
                <hr>
            </div>
            <div class="banner-on-main col-md-8 col-md-offset-2">
                <h2>Не можешь создать модуль под Битрикс, потому что это слишком сложно?</h2>
                <hr>
            </div>
            <div class="banner-on-main col-md-8 col-md-offset-2">
                <h2>Часто повторяешь свой код?</h2>
                <hr>
            </div>
            <div class="banner-on-main col-md-8 col-md-offset-2">
                <h2>Хватит это терпеть!</h2>
                <p>Не, серьёзно, это же совсем не сложно теперь. Просто заполняй простые формочки в сервисе, читай
                    подсказки и на выходе получишь готовый для публикации в Marketplace архив с модулем.</p>
            </div>
            <div class="col-md-8 col-md-offset-2 modules-created">
                <p>С нами создано уже</p>
                <strong>{{$countModules}}</strong>
                <p>модул{{$modulesEnding}}</p>
            </div>
        </div>
    </div>
@stop