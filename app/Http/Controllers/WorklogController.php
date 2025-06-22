<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Worklog;
use Carbon\Carbon;
use Illuminate\Http\Request;


class WorklogController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin')->only([
            'index',
            'show_admin',
        ]);

        $this->middleware('role:employee')->only([
            'overview',
            'show_employee',
            'create',
            'store',
            'edit',
            'update',
        ]);
    }

    public function index()
    {
        $users = User::where('role', 'employee')->get();

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $workData = Worklog::whereMonth('work_date', $currentMonth)
            ->whereYear('work_date', $currentYear)
            ->with('user')
            ->get()
            ->groupBy('user_id')
            ->map(function ($logs, $userId) {
                return [
                    'user' => $logs->first()->user,
                    'total_hours' => $logs->sum('hours_worked')
                ];
            })
            ->sortByDesc('total_hours')
            ->values();

        $topEmployee = $workData->first();

        $showEmployeeOfMonth = false;
        if ($workData->count() > 1) {
            $firstHours = $workData[0]['total_hours'];
            $secondHours = $workData[1]['total_hours'];
            if ($firstHours > $secondHours) {
                $showEmployeeOfMonth = true;
            }
        } else {
            $showEmployeeOfMonth = true;
        }

        if ($showEmployeeOfMonth) {
            $displayEmployees = $workData->take(3);
        } else {
            $displayEmployees = $workData->take(3);
        }

        $chartData = $workData->map(fn($data) => [
            'name' => $data['user']->name,
            'hours' => round($data['total_hours'], 1)
        ])->values();

        if(Worklog::count() < 1) {
            return redirect()->back();
        }

        return view('worklogs.admin.index', compact('users', 'topEmployee', 'chartData', 'displayEmployees', 'showEmployeeOfMonth'));
    }

    public function show_admin($id)
    {
        $user = User::where('id', $id)->first();
        $worklogs = Worklog::where('user_id', $user->id)
                       ->where('is_paid', false)
                       ->orderBy('created_at', 'desc')
                       ->get();
        return view('worklogs.admin.worklogs', compact('user', 'worklogs'));
    }

    public function update_status(Request $request)
    {
        $request->validate([
            'worklog_ids' => 'required|array',
            'worklog_ids.*' => 'exists:worklogs,id',
        ]);

        Worklog::whereIn('id', $request->worklog_ids)->update([
            'is_paid' => true,
            'payment_date' => now(),
        ]);

        return redirect()->route('worklogs.index')->with('success', 'Heures payées avec succès.');
    }

    public function overview()
    {
        $user = auth()->id();
        return view('worklogs.employee.overview', compact('user'));
    }

    public function show_employee($id)
    {
        $user = auth()->user();
        $worklogs = Worklog::where('user_id', $user->id)
                       ->where('is_paid', false)
                       ->orderBy('created_at', 'desc')
                       ->get();
        return view('worklogs.employee.worklogs', compact('user', 'worklogs'));
    }

    public function create()
    {
        $today = now()->format('Y-m-d');
        return view('worklogs.employee.create', compact('today'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'work_date' => 'required|date',
        ]);

        $start = Carbon::createFromFormat('H:i', $request->start_time);
        $end = Carbon::createFromFormat('H:i', $request->end_time);

        $hoursWorked = $start->diffInMinutes($end) / 60;

        Worklog::create([
            'user_id' => $request->user_id,
            'hours_worked' => $hoursWorked,
            'work_date' => $request->work_date,
        ]);

        return redirect()->route('worklogs.overview', $request->user_id)->with('success', 'Heures ajoutées avec succès.');
    }

     public function edit($id)
    {
        $worklog = Worklog::where('id', $id)->first();
        $user = $worklog->user_id;
        return view('worklogs.employee.edit', compact('worklog', 'user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $start = Carbon::createFromFormat('H:i', $request->start_time);
        $end = Carbon::createFromFormat('H:i', $request->end_time);

        $hoursWorked = $start->diffInMinutes($end) / 60;

        $worklog = Worklog::where('id', $id)->first();

        $worklog->update([
            'hours_worked' => $hoursWorked,
        ]);

        return redirect()->route('worklogs.show-employee', $request->user_id)->with('success', 'Heures modifiées avec succès.');
    }
}