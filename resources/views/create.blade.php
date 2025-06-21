{{-- resources/views/todos/create.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>新規ToDo作成</title>
</head>
<body>
    <h1>ToDo 新規作成</h1>

    <form action="{{ route('todos.store') }}" method="POST">
        @csrf
        <label>タイトル: <input type="text" name="title"></label><br>
        <label>説明: <textarea name="description"></textarea></label><br>
        <label>期限: <input type="date" name="due_date"></label><br>
        <button type="submit">登録</button>
    </form>
</body>
</html>
