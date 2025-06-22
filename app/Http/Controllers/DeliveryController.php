<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Delivery;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveryController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin')->only([
            'index', 'statistics', 'create', 'store', 'edit', 'update',
        ]);
    }

    public function index(Request $request)
    {
        $isPaid = $request->query('paid', 'no') === 'yes';

        $deliveries = Delivery::where('is_paid', $isPaid)
            ->orderByDesc('created_at')
            ->get();

        return view('deliveries.index', [
            'deliveries' => $deliveries,
            'isPaid' => $isPaid,
        ]);
    }

    public function statistics()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $clientData = DB::table('deliveries')
            ->select('clients.id', 'clients.full_name', DB::raw('SUM(deliveries.glacons_kg) as total_kg'))
            ->join('clients', 'deliveries.client_id', '=', 'clients.id')
            ->whereMonth('deliveries.created_at', $currentMonth)
            ->whereYear('deliveries.created_at', $currentYear)
            ->groupBy('clients.id', 'clients.full_name')
            ->orderByDesc('total_kg')
            ->get();

        $showClientOfMonth = false;
        if ($clientData->count() > 1) {
            $firstKg = $clientData[0]->total_kg;
            $secondKg = $clientData[1]->total_kg;
            if ($firstKg > $secondKg) {
                $showClientOfMonth = true;
            }
        } else {
            $showClientOfMonth = true;
        }

        $displayClients = $clientData->take(3);

        $chartData = $clientData->map(fn($data) => [
            'name' => $data->full_name,
            'kg' => round($data->total_kg, 1),
        ])->values();

        $date = Carbon::now()->isoFormat('MMMM YYYY');

        if(Delivery::count() < 1) {
            return redirect()->back();
        }

        return view('deliveries.statistics', compact(
            'chartData', 'displayClients', 'showClientOfMonth', 'date'
        ));
    }

    public function create()
    {
        $clients = Client::where('status', 'active')->get();
        return view('deliveries.create', compact('clients'));
    }

   public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'client_id' => 'required|integer|exists:clients,id',
            'glacons_kg' => 'required|integer|min:1',
            'is_paid' => 'required|boolean',
        ]);

        Delivery::create([
            'user_id' => $request->user_id,
            'client_id' => $request->client_id,
            'glacons_kg' => $request->glacons_kg,
            'is_paid' => $request->is_paid,
            'payment_date' => $request->is_paid ? now() : null,
        ]);

        $paid = $request->is_paid ? 'yes' : 'no';

        return redirect()->route('deliveries.index', ['paid' => $paid])
            ->with('success', 'Livraison ajoutée avec succès.');
    }

    public function edit($id)
    {
        $delivery = Delivery::findOrFail($id);
        $clients = Client::where('status', 'active')->get();
        return view('deliveries.edit', compact('delivery', 'clients'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'client_id' => 'required|integer|exists:clients,id',
            'glacons_kg' => 'required|integer|min:1',
            'is_paid' => 'required|boolean',
        ]);

        $delivery = Delivery::findOrFail($id);

        $delivery->update([
            'client_id' => $request->client_id,
            'glacons_kg' => $request->glacons_kg,
            'is_paid' => $request->is_paid,
            'payment_date' => $request->is_paid ? now() : null,
        ]);

        $paid = $request->is_paid ? 'yes' : 'no';

        return redirect()->route('deliveries.index', ['paid' => $paid])
            ->with('success', 'Livraison modifiée avec succès.');
    }
}