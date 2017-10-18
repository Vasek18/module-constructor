<form action="{{ action('Modules\Management\ModulesClientsIssueController@index', $module->id) }}"
      method="post">
    {{ csrf_field() }}
    <h2>Записать проблему</h2>
    <div class="form-group">
        <label for="name">Название</label>
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
                  rows="10"></textarea>
    </div>
    <div class="form-group">
        <button id="create"
                name="create"
                class="btn btn-success">Записать
        </button>
    </div>
</form>