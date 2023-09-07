<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\DB;
use \Carbon\Carbon;
use App\Models\User;

class UserController extends Controller
{
    //initiate
    public function get_user() {
        $user = DB::table('users')
            ->leftJoin('model_has_roles', function($join) {
                $join->on('model_has_roles.model_id', '=', 'users.id');
            })
            ->leftJoin('roles', function($join) {
                $join->on('model_has_roles.role_id', '=', 'roles.id');
            })
            ->where(function($query) {
                $query->where('name', 'user');
            })
            ->get();

        return $user;
    }


    //page
    public function list() {
        $user = $this->get_user();

        return view('admin.user.list', compact('user'));
    }

    public function create_user(Request $request) {
        $validator = Validator::make($request->all(), [
            "first_name" => ['required'],
            "last_name" => ['required'],
            "email" => ['required', 'unique:users'],
        ]);

        if($validator->fails()) {
            toast()->warning($validator->messages()->all()[0]);
            return redirect()->back();
        }

        $create_user = User::create([
            "id" => Uuid::uuid4()->toString(),
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "email" => $request->email,
            "password" => bcrypt('test1234'),
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        $create_user->assignRole('user');

        toast()->success('Pendaftaran anggota berhasil');
        return redirect()->back();
    }
}
