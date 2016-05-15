@extends("app")

@section("content")
    <div class="container">
        <div class="row">
            <div class="banner-on-main clearfix">
                <div class="col-md-8">
                    <strong>Делаешь сайты, а зарабатываешь меньше 100 000р в месяц?</strong>
                </div>
            </div>
            <div class="banner-on-main clearfix">
                <div class="col-md-8 col-md-offset-4">
                    <strong>Не можешь создать модуль под Битрикс, потому что это слишком сложно?</strong>
                </div>
            </div>
            <div class="banner-on-main clearfix">
                <div class="col-md-8">
                    <strong>Часто повторяешь свой код?</strong>
                </div>
            </div>
            <div class="banner-on-main clearfix">
                <div class="col-md-8 col-md-offset-4">
                    <strong>Хватит это терпеть!</strong>
                    <p>Не, серьёзно, это же совсем не сложно теперь. Просто заполняй простые формочки в сервисе,
                        читай
                        подсказки и на выходе получишь готовый для публикации в Marketplace архив с модулем.
                        <br>
                    И просто качай бабло.
                    </p>
                </div>
            </div>
            <div class="col-md-8 col-md-offset-2 modules-created">
                <p>С нами создано уже</p>
                <strong>{{$countModules}}</strong>
                <p>модул{{$modulesEnding}}</p>
            </div>
        </div>
    </div>
@stop