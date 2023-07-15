<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestBudgetRequest;
use App\Models\User\RequestBudgetModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RequestBudgetController extends Controller
{
    //
    public function index()
    {
        $datas = RequestBudgetModel::with(['user'])->where('user_id', Auth::user()->id)->get();

        return view('verified.request.budget.index', compact('datas'));
    }

    public function create(RequestBudgetRequest $request)
    {
        DB::beginTransaction();
        try {
            //code...

            RequestBudgetModel::create([
                'user_id' => Auth::user()->id,
                'balance' => (int) str_replace(['.', ','], '', $request->balance),
                'status_id' => 1
            ]);

            DB::commit();
            session()->flash('success', 'Budget Request Added Successfully. Please wait for an approval');
            return redirect()->back();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();

            $msg = 'There is a problem when saving your request for balance. Please contact the developers';

            if(env('APP_DEBUG')) {
                $msg = $th->getMessage();
            }

            session()->flash('error', $msg);

            return redirect()->back();
        }
    }
}
