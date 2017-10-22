<table class="table table-bordered">
    <tr>
        <td>Модуль</td>
        <td>Дата</td>
        <td>Версия</td>
        <td>Описание</td>
    </tr>
    @foreach($competitors_updates as $update)
        <tr>
            <td>{{ $update->module_name }}</td>
            <td>{{ $update->date }}</td>
            <td>{{ $update->version }}</td>
            <td>{{ $update->description }}</td>
        </tr>
    @endforeach
</table>