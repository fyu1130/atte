@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/all_users.css') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="data__content">
    <div class="data__name">全ユーザ一覧</div>
    <div class="data-table">
        <table class="data-table__inner">
            <tr class="data-table__row">
                <th class="data-table__header">名前</th>
                <th class="data-table__header">メールアドレス</th>
                <th class="data-table__header">指定ユーザの勤怠一覧へ</th>
            </tr>
            @forelse ($users as $user)
                <tr class="data-table__row">
                    <td class="data-table__item">{{ $user->name ?? '-' }}</td>
                    <td class="data-table__item">{{ $user->email ?? '-' }}</td>
                    <td class="data-table__item">
                        <form action="/user_attendance" method="post">
                            @csrf
                            <button class="form-item" name='select_user' value="{{$user->id}}">{{$user->name ?? '-'}}さん</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" class="data-table__no-data">まだユーザーの勤怠データはありません。</td>
                </tr>
            @endforelse
        </table>
    </div>
    <div class="pagination">{{$users->links()}}</div>
</div>

@endsection