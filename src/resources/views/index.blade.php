@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="stamp__content">
    <div class="stamp__heading">
        <h2>{{ Auth::user()->name }}さんお疲れ様です！</h2>
    </div>
    @php
$start_work = $stamp && !$stamp->end_work;
$start_rest = $stamp && $rest && $rest->start_rest && !$rest->end_rest;
    @endphp

    <div class="form__group">
        <div class="form__group--work">
            <form class="" method="post" action="{{route('button.action')}}">
                @csrf
                <button type="submit" name="action" value="start_work" class="form__button" {{$start_work ? 'disabled' : ''}}>勤務開始</button>
                <button type="submit" name="action" value="end_work" class="form__button" {{!$start_work || $start_rest ? 'disabled' : ''}}>勤務終了</button>
            </form>

        </div>
        <div class="form__group--break">
            <form class="" method="post" action="{{route('button.action')}}">
                @csrf
                <button type="submit" name="action" value="start_rest" class="form__button"
                    {{$start_rest || !$start_work ? 'disabled' : ''}}>休憩開始</button>
                <button type="submit" name="action" value="end_rest" class="form__button"
                    {{!$start_rest ? 'disabled' : ''}}>休憩終了</button>
            </form>
        </div>
    </div>

    </div>
</div>
    @endsection