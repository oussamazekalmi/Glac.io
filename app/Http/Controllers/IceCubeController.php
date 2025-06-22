<?php

namespace App\Http\Controllers;

use App\Models\IceCube;
use Illuminate\Http\Request;

class IceCubeController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $iceCubes = IceCube::where('status', 'full')->latest()->get();
        return view('icecubes.admin.index', compact('iceCubes'));
    }

    public function logs($id)
    {
        if (auth()->user()->role !== 'employee' || auth()->id() != $id) {
            abort(403, 'Unauthorized');
        }

        $today = now()->toDateString();
        $iceCubes = IceCube::where('user_id', $id)
            ->where('status', 'partiel')
            ->where('date', $today)
            ->get();

        return view('icecubes.employee.logs', compact('iceCubes'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'employee') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'kg' => 'required|integer|min:1',
        ]);

        IceCube::create([
            'user_id' => auth()->id(),
            'date' => now()->toDateString(),
            'kg' => $request->kg,
            'status' => 'partiel',
        ]);

        return redirect()->back()->with('success', 'Enregistrement réussi.');
    }

    public function destroy($id)
    {
        $iceCube = IceCube::findOrFail($id);

        if (auth()->user()->role !== 'employee' || $iceCube->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $iceCube->delete();

        return redirect()->back()->with('success', 'Suppression réussie.');
    }

    public function consolidate()
    {
        if (auth()->user()->role !== 'employee') {
            abort(403, 'Unauthorized');
        }

        $userId = auth()->id();
        $today = now()->toDateString();

        $partiels = IceCube::where('user_id', $userId)
            ->where('status', 'partiel')
            ->where('date', $today)
            ->get();

        if ($partiels->isEmpty()) {
            return redirect()->back()->with('error', 'Aucun enregistrement partiel à consolider.');
        }

        $totalKg = $partiels->sum('kg');

        IceCube::create([
            'user_id' => $userId,
            'date' => $today,
            'kg' => $totalKg,
            'status' => 'full',
        ]);

        foreach ($partiels as $entry) {
            $entry->forceDelete();
        }

        return redirect()->back()->with('success', 'Consolidation réussie.');
    }
}
