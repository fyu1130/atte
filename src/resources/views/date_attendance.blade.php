@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/date_attendance.css') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="data__content">
    <div class="data__date">
        <form method="post" class="form" action="/date_attendance">
            @csrf
            <input type="hidden" name="date" value="{{ $previous_date }}">
            <button type="submit" name="action" value="previous" class="form__button">＜</button>
        </form>
        <span class="form__date">{{$date->format('Y-m-d')}}</span>
        <form method="post" class="form" action="/date_attendance">
            @csrf
            <input type="hidden" name="date" value="{{ $next_date }}">
            <button type="submit" name="action" value="next" class="form__button">＞</button>
        </form>
    </div>
    <div class="data-table">
        <table class="data-table__inner">
            <tr class="data-table__row">
                <th class="data-table__header">名前</th>
                <th class="data-table__header">勤務開始</th>
                <th class="data-table__header">勤務終了</th>
                <th class="data-table__header">休憩時間</th>
                <th class="data-table__header">勤務時間</th>
            </tr>
            @forelse ($stamps as $stamp)
                <tr class="data-table__row">
                    <td class="data-table__item">{{ $users[$stamp->user_id]->name ?? '-' }}</td>
                    <td class="data-table__item">{{ $stamp->start_work ?? '-' }}</td>
                    <td class="data-table__item">{{ $stamp->end_work ?? '-' }}</td>
                    <td class="data-table__item">{{ $stamp->total_rest ?? '-' }}</td>
                    <td class="data-table__item">{{ $stamp->total_work ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="data-table__no-data">指定された日付の勤怠データはありません。</td>
                </tr>
            @endforelse
        </table>
    </div>
    <div class="pagination">{{$stamps->appends(['date' => $date->format('Y-m-d')])->links()}}</div>
    </div>

@endsection


