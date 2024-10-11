@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/user_attendance.css') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="data__content">
    <div class="data__name">{{$user->name}}さん</div>
    <div class="data-table">
        <table class="data-table__inner">
            <tr class="data-table__row">
                <th class="data-table__header">日付</th>
                <th class="data-table__header">勤務開始</th>
                <th class="data-table__header">勤務終了</th>
                <th class="data-table__header">休憩時間</th>
                <th class="data-table__header">勤務時間</th>
            </tr>
            @forelse ($stamps as $stamp)
                <tr class="data-table__row">
                    <td class="data-table__item">{{ $stamp->stamp_date ?? '-' }}</td>
                    <td class="data-table__item">{{ $stamp->start_work ?? '-' }}</td>
                    <td class="data-table__item">{{ $stamp->end_work ?? '-' }}</td>
                    <td class="data-table__item">{{ $stamp->total_rest ?? '-' }}</td>
                    <td class="data-table__item">{{ $stamp->total_work ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="data-table__no-data">指定されたユーザーの勤怠データはありません。</td>
                </tr>
            @endforelse
        </table>
    </div>
    <div class="pagination">{{$stamps->links()}}</div>
</div>

@endsection