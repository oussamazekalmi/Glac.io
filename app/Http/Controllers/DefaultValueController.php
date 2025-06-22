<?php

namespace App\Http\Controllers;

use App\Models\DefaultValue;
use Illuminate\Http\Request;

class DefaultValueController extends Controller
{
    public function index()
    {
        $default = DefaultValue::first();

        $default->kg_price = rtrim(rtrim(number_format($default->kg_price, 2, '.', ''), '0'), '.');
        $default->hourly_rate = rtrim(rtrim(number_format($default->hourly_rate, 2, '.', ''), '0'), '.');
        $default->rent = rtrim(rtrim(number_format($default->rent, 2, '.', ''), '0'), '.');

        return view('defaults.index', compact('default'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'kg_price' => 'required|numeric',
            'hourly_rate' => 'required|numeric',
            'rent' => 'required|numeric'
        ]);

        $default = DefaultValue::firstOrFail();
        $default->update($data);

        return redirect()->route('defaults.index');
    }
}
