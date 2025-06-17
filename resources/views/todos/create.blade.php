{{-- resources/views/todos/create.blade.php --}}
<h1>ToDo 作成</h1>

<form action="{{ route('todos.store') }}" method="POST">
    @csrf
    <input type="text" name="title" placeholder="タイトル">
    <textarea name="description" placeholder="説明"></textarea>
    <input type="date" name="due_date">
    <button type="submit">作成</button>
</form>
