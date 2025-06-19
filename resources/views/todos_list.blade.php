<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ToDo 一覧</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <h1>ToDo 一覧</h1>

    <a href="{{ route('todos.create') }}">新規作成</a>

    <ul>
        @forelse ($todos as $todo)
            <li>
                {{ $todo->id }}. {{ $todo->title }}
                {{-- 詳細・編集リンクなども追加可能 --}}
            </li>
        @empty
            <li>まだタスクがありません。</li>
        @endforelse
    </ul>
</body>
</html>