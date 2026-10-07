<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use App\Services\ComplaintAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ComplaintOfficerController extends Controller
{
    public function __construct()
    {
        app()->setLocale('ar');
    }

    protected function validateAccount(Request $request, array $rules)
    {
        return $request->validate($rules, __('complaint_portal.validation'), [
            'name' => __('complaint_portal.name'), 'email' => __('complaint_portal.email'),
            'password' => __('complaint_portal.password'), 'active' => __('complaint_portal.active'),
        ]);
    }

    public function index()
    {
        app()->setLocale('ar');
        return view('admin.complaint_officers.index', ['officers' => User::where('type', ComplaintAccess::OFFICER_TYPE)->orderBy('name')->paginate(20)]);
    }

    public function store(Request $request)
    {
        $data = $this->validateAccount($request, ['name' => 'required|string|max:190', 'email' => 'required|email|max:255|unique:users,email', 'password' => 'required|string|min:10|max:128|confirmed']);
        DB::transaction(function () use ($data) {
            $role = Role::firstOrCreate(['name' => 'Complaint Officers'], ['permissions' => json_encode(ComplaintAccess::PERMISSIONS)]);
            $user = new User();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = Hash::make($data['password']);
            $user->type = ComplaintAccess::OFFICER_TYPE;
            $user->role_id = $role->id;
            $user->complaint_officer_active = true;
            $user->complaint_auth_version = 1;
            $user->save();
        });
        return back()->with('success', __('complaint_portal.account_saved'));
    }

    public function update(Request $request, $id)
    {
        $user = User::where('type', ComplaintAccess::OFFICER_TYPE)->findOrFail($id);
        $data = $this->validateAccount($request, ['name' => 'required|string|max:190', 'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)]]);
        $user->update($data);
        return back()->with('success', __('complaint_portal.account_saved'));
    }

    public function state(Request $request, $id)
    {
        $data = $this->validateAccount($request, ['active' => 'required|boolean']);
        DB::transaction(function () use ($id, $data) {
            $user = User::where('type', ComplaintAccess::OFFICER_TYPE)->whereKey($id)->lockForUpdate()->firstOrFail();
            $user->complaint_officer_active = (bool) $data['active'];
            $user->complaint_auth_version++;
            $user->remember_token = Str::random(60);
            $user->save();
        });
        return back()->with('success', __('complaint_portal.account_saved'));
    }

    public function password(Request $request, $id)
    {
        $data = $this->validateAccount($request, ['password' => 'required|string|min:10|max:128|confirmed']);
        DB::transaction(function () use ($id, $data) {
            $user = User::where('type', ComplaintAccess::OFFICER_TYPE)->whereKey($id)->lockForUpdate()->firstOrFail();
            $user->password = Hash::make($data['password']);
            $user->view_password = null;
            $user->complaint_auth_version++;
            $user->remember_token = Str::random(60);
            $user->save();
        });
        return back()->with('success', __('complaint_portal.account_saved'));
    }
}
