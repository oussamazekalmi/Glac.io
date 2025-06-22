<?php

namespace App\Http\Controllers;

use App\Models\Fisc;
use App\Models\DefaultValue;
use App\Models\Delivery;
use App\Models\Worklog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FiscController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);

        $fiscs = Fisc::where('month', $month)
            ->where('year', $year)
            ->get();

        $defaults = DefaultValue::first();

        $kgPrice = $defaults->kg_price ?? 0;
        $hourlyRate = $defaults->hourly_rate ?? 0;
        $rentExpense = $defaults->rent ?? 0;

        $deliveryIncome = Delivery::where('is_paid', true)
            ->whereMonth('payment_date', $month)
            ->whereYear('payment_date', $year)
            ->sum(DB::raw("glacons_kg * $kgPrice"));

        $worklogExpense = Worklog::where('is_paid', true)
            ->whereMonth('payment_date', $month)
            ->whereYear('payment_date', $year)
            ->sum(DB::raw("hours_worked * $hourlyRate"));

        $worklogsByUser = Worklog::select('user_id', DB::raw("SUM(hours_worked * $hourlyRate) as total"))
            ->where('is_paid', true)
            ->whereMonth('payment_date', $month)
            ->whereYear('payment_date', $year)
            ->groupBy('user_id')
            ->with('user')
            ->get();

        $electricityExpense = $fiscs->where('type', 'electricity')->sum('amount');
        $waterExpense = $fiscs->where('type', 'water')->sum('amount');
        $equipments = $fiscs->where('type', 'equipment');

        $otherExpenses = $fiscs->sum('amount');
        $totalExpense = $rentExpense + $worklogExpense + $otherExpenses;
        $profit = $deliveryIncome - $totalExpense;

        return view('fiscs.index', compact(
            'fiscs', 'month', 'year',
            'deliveryIncome', 'totalExpense', 'profit',
            'rentExpense', 'electricityExpense', 'waterExpense',
            'worklogsByUser', 'equipments'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:rent,water,electricity,equipment,worklogs',
            'equipment_name' => 'nullable|string|max:255',
            'amount' => 'required|numeric',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2000',
        ]);

        if (in_array($validated['type'], ['water', 'electricity'])) {
            $exists = Fisc::where('type', $validated['type'])
                        ->where('month', $validated['month'])
                        ->where('year', $validated['year'])
                        ->exists();

            if ($exists) {
                return back()->withErrors([
                    'type' => ucfirst($validated['type']) . ' already exists for this period.',
                ]);
            }
        }

        Fisc::create($validated);

        return redirect()->route('fiscs.index')->with('success', 'Fisc entry added.');
    }

    public function edit(Fisc $fisc)
    {
        return view('fiscs.edit', compact('fisc'));
    }

    public function update(Request $request, Fisc $fisc)
    {
        $validated = $request->validate([
            'equipment_name' => 'nullable|string|max:255',
            'amount' => 'required|numeric',
        ]);

        $fisc->update($validated);

        return redirect()->route('fiscs.index')->with('success', 'Fisc entry updated.');
    }
}
