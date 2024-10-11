<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Stamp;
use App\Models\Rest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Requests\RegisterRequest;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $stamp = Stamp::where('user_id', $user->id)->orderBy('created_at', 'desc')->first();
        $rest = $stamp ? Rest::where('stamp_id', $stamp->id)->orderBy('created_at', 'desc')->first() : null;

        return view('index', compact('stamp', 'rest'));
    }
    public function date_attendance(Request $request)
    {
        $current_date = $request->input('date', Carbon::today()->format('Y-m-d'));
        $date = Carbon::parse($current_date);


        if ($request->input('action') === 'previous') {
            $date = $date->subDay();
        } elseif ($request->input('action') === 'next') {
            $date = $date->addDay();
        }
        $stamps = Stamp::where('stamp_date', $date->format('Y-m-d'))->orderBy('created_at', 'asc')->paginate(5)->appends(['date' => $date->format('Y-m-d')]);
        

        $next_date = $date->copy()->format('Y-m-d');
        $previous_date = $date->copy()->format('Y-m-d');

        $users = User::whereIn('id', $stamps->pluck('user_id'))->get()->keyBy('id');

        return view('date_attendance', compact('users', 'stamps', 'date', 'next_date', 'previous_date'));
    }

    public function user_attendance(Request $request){
        $user_id = $request->input('select_user', Auth::id());
        $user = User::find($user_id);
        $stamps = Stamp::where('user_id', $user->id)->orderBy('created_at', 'asc')->paginate(5);
        return view('user_attendance', compact('user','stamps'));
    }
    public function all_users(Request $request)
    {
        $users = User::paginate(5);
        return view('all_users', compact('users'));
    }



    public function select_action(Request $request)
    {
        $user = Auth::user();
        $stamp = Stamp::where('user_id', $user->id)->orderBy('created_at', 'desc')->first();
        $rest = $stamp ? Rest::where('stamp_id', $stamp->id)->orderBy('created_at', 'desc')->first() : null;

        $action = $request->input('action');
        switch ($action) {
            case 'start_work':
                return $this->start_work($user, $stamp, $rest);
            case 'end_work':
                return $this->end_work($user, $stamp, $rest);
            case 'start_rest':
                return $this->start_rest($user, $stamp, $rest);
            case 'end_rest':
                return $this->end_rest($user, $stamp, $rest);
            default:
                return redirect('/');
        }
    }
    protected function start_work($user, $stamp, $rest)
    {
        if (!$stamp || $stamp->end_work) {
            $stamp = Stamp::create([
                'user_id' => $user->id,
                'start_work' => Carbon::now()->format('H:i:s'),
                'stamp_date' => Carbon::now()->format('Y-m-d'),
            ]);
            return redirect('/');
        }
        return redirect('/');

    }
    protected function end_work($user, $stamp, $rest)
    {
        if ($stamp && !$stamp->end_work) {
            $end_work = Carbon::now();
            $start_work = Carbon::parse($stamp->start_work);
            $total_work = $start_work->diffInSeconds($end_work);
            $total_rest = $stamp->total_rest ? $this->convertTimeToSeconds($stamp->total_rest) : 0;

            $total_work = $total_work - $total_rest;

            $total_work_formatted = gmdate('H:i:s', $total_work);

            $stamp->update([
                'end_work' => $end_work->format('H:i:s'),
                'total_work' => $total_work_formatted,
            ]);
            return redirect('/');
        }
        return redirect('/');
    }

    protected function start_rest($user, $stamp, $rest)
    {
        if ($stamp && !$stamp->end_work && (!$rest || $rest->end_rest)) {
            $rest = Rest::create([
                'stamp_id' => $stamp->id,
                'start_rest' => Carbon::now()->format('H:i:s'),
            ]);
            return redirect('/');
        }
        return redirect('/');

    }
    protected function end_rest($user, $stamp, $rest)
    {
        if ($stamp && !$stamp->end_work && $rest && !$rest->end_rest) {
            $end_rest = Carbon::now();
            $start_rest = Carbon::parse($rest->start_rest);
            $total_rest = $start_rest->diff($end_rest)->format('%H:%I:%S');
            $rest->update([
                'end_rest' => $end_rest->format('H:i:s'),
                'total_rest' => $total_rest,
            ]);

            $rest_sum = Rest::where('stamp_id', $stamp->id)->get()->reduce(function ($carry, $item) {
                $timeParts = explode(':', $item->total_rest);
                $seconds = $timeParts[0] * 3600 + $timeParts[1] * 60 + $timeParts[2];
                return $carry + $seconds;
            }, 0);
            $rest_sum_formatted = gmdate('H:i:s', $rest_sum);

            $stamp->update([
                'total_rest' => $rest_sum_formatted,
            ]);

            return redirect('/');
        }
        return redirect('/');

    }
    protected function convertTimeToSeconds($time)
    {
        list($hours, $minutes, $seconds) = explode(':', $time);
        return $hours * 3600 + $minutes * 60 + $seconds;
    }
}
