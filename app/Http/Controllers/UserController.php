<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\IceCube;
use App\Models\User;
use App\Models\Worklog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin')->only([
            'index', 'create', 'store', 'destroy',
        ]);

        $this->middleware('role:admin,employee')->only([
            'profile', 'resetPasswordForm', 'resetPassword',
        ]);
    }

    public function index()
    {
        $users = User::where('role', '!=', 'admin')->where('status', 'in_work')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => [
                'nullable',
                'regex:/^(05|06|07)[0-9]{8}$/'
            ],
        ]);

        $name = $request->name;
        $nameTrimmed = str_replace(' ', '', $name);

        $today = now()->format('d');
        $password = $nameTrimmed . $today;

        User::create([
            'name' => $name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'phone' => $request->phone,
            'role' => 'employee',
            'status' => 'in_work',
        ]);

        return redirect()->route('users.index')->with('success', 'Utilisateur ajouté avec succès.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        if (auth()->user()->role !== 'admin' && auth()->id() !== $user->id) {
            abort(403);
        }
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if (auth()->user()->role !== 'admin' && auth()->id() !== $user->id) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => [
                'nullable',
                'regex:/^(05|06|07)[0-9]{8}$/'
            ],
            'status' => 'in:in_work,on_vacation,stopped',
        ]);

        $status = '';

        if($user->id === auth()->id()) {
            $status = 'in_work';
        }
        else {
            $status = $request->status;
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => $status,
        ]);

        if($user->role === 'admin') {
            return redirect()->route('users.index')->with('success', 'Utilisateur modifié avec succès.');
        }

        return redirect()->route('users.profile', $id)->with('success', 'Utilisateur modifié avec succès.');
    }

    public function profile($id)
    {
        $user = User::findOrFail($id);
        return view('users.profile', compact('user'));
    }

    public function resetPasswordForm($id)
    {
        $user = User::findOrFail($id);
        return view('users.reset-password', compact('user'));
    }

    public function resetPassword(Request $request, $id)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:8|max:50',
            'confirm_password' => 'required|same:password',
        ]);

        $user = User::where('id', auth()->id())->first();
        if (!Hash::check($request->input('old_password'), $user->password)) {
            return redirect()->back()->withErrors(['old_password' => 'L\'ancien mot de passe est incorrect.']);
        }

        $user->update([
            'password' => bcrypt($request->input('password'))
        ]);

        return redirect()->route('users.profile', $id)->with('success', 'Mot de passe réinitialisé avec succès.');
    }

    public function destroy()
    {
        $cutoffDate = Carbon::now()->subDays(60);
        Delivery::where('is_paid', true)
            ->whereDate('created_at', '<', $cutoffDate)
            ->forceDelete();

        Worklog::where('is_paid', true)
            ->whereDate('created_at', '<', $cutoffDate)
            ->forceDelete();

        IceCube::whereDate('created_at', '<', $cutoffDate)->delete();

        return redirect()->back()->with('success', 'Les anciennes données ont été supprimées avec succès.');
    }
}