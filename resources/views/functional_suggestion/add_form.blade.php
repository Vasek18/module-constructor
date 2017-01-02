<h2>Добавить своё предложение</h2>
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>{{trans('validation.error')}}</strong> {{trans('validation.there_occur_errors')}}
        <br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{ action('FunctionalSuggestionController@store') }}"
      method="post"
      class="">
    {{ csrf_field() }}
    <div class="form-group">
        <label for="name">Заголовок</label>
        <input type="text"
               id="name"
               name="name"
               class="form-control"
               required>
    </div>
    <div class="form-group">
        <label for="description">Описание</label>
        <textarea id="description"
                  name="description"
                  class="form-control"
                  rows="10"
                  required></textarea>
    </div>
    <div class="form-group">
        <button id="create"
                name="create"
                class="btn btn-success btn-block">Отправить
        </button>
    </div>
</form>