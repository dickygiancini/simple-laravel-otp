<?php

namespace App\Http\Controllers\Privileged;

use App\Http\Controllers\Controller;
use App\Models\Master\MstRolesModel;
use App\Models\Users\UserPrivileges;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

class UserPriviledgeController extends Controller
{
    //
    public function index()
    {
        $roles = MstRolesModel::with(['access'])->whereNotIn('level', [1,2,3])->get();
        $middlewareGroup = 'verified';

        $routings = collect(Route::getRoutes())->reject(function ($route) use ($middlewareGroup) {
            // Exclude routes with the 'privilege' middleware
            if (in_array('privilege', $route->gatherMiddleware())) {
                return true;
            }

            // Exclude routes not belonging to the specified middleware group
            if (!in_array($middlewareGroup, $route->gatherMiddleware())) {
                return true;
            }

            // Exclude routes that don't have the 'getRouteTitle' macro defined
            $action = $route->getAction();
            if (!isset($action['title'])) {
                return true;
            }

            return false;
        });

        return view('verified.privileged.index', compact('roles', 'routings'));
    }

    public function checkRoles(Request $request)
    {
        $data = UserPrivileges::where('role_id', $request->role_id)->get();

        return response()->json($data);
    }

    public function update(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            foreach ($request->route_name as $key => $value) {
                # code...
                $access = false;
                $create = false;
                $update = false;
                $delete = false;

                if(isset($request->can_access) && array_key_exists($key, $request->can_access)) {
                    $access = true;
                }
                if(isset($request->can_create) && array_key_exists($key, $request->can_create)) {
                    $create = true;
                }
                if(isset($request->can_update) && array_key_exists($key, $request->can_update)) {
                    $update = true;
                }
                if(isset($request->can_delete) && array_key_exists($key, $request->can_delete)) {
                    $delete = true;
                }

                $check_role = UserPrivileges::where('role_id', $request->role_id);

                if($check_role->doesntExist()) {
                    UserPrivileges::create([
                        'role_id' => $request->role_id,
                        'route_name' => $request->route_name[$key],
                        'route_alias' => $request->route_alias[$key],
                        'can_access' => $access,
                        'can_create' => $create,
                        'can_update' => $update,
                        'can_delete' => $delete,
                    ]);
                }

                $check_alias = $check_role->where('route_alias', $request->route_alias[$key]);

                if($check_alias->doesntExist()) {
                    UserPrivileges::create([
                        'role_id' => $request->role_id,
                        'route_name' => $request->route_name[$key],
                        'route_alias' => $request->route_alias[$key],
                        'can_access' => $access,
                        'can_create' => $create,
                        'can_update' => $update,
                        'can_delete' => $delete,
                    ]);
                }

                $update = $check_alias->update([
                    'can_access' => $access,
                    'can_create' => $create,
                    'can_update' => $update,
                    'can_delete' => $delete,
                ]);
            }

            DB::commit();
            // Flash a success message
            session()->flash('success', 'Successfully Update The Access Pages to User!');

            // Redirect back or to a specific route
            return back();
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();

            $msg = 'Error when saving access pages from the data provided. Please contact the developers';

            if(env('APP_DEBUG')) {
                $msg = $th->getMessage();
            }

            session()->flash('error', $msg);
            return back();
        }
    }
}
