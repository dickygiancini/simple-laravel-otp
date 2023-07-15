<?php

namespace App\Http\Controllers;

use App\Models\User\RequestBudgetModel;
use App\Models\User\UsersBalanceInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApprovalRequestBudgetController extends Controller
{
    //
    public function index()
    {
        $datas = RequestBudgetModel::with(['user', 'status'])->where('status_id', 1)->get();

        return view('verified.request.approval-budget.index', compact('datas'));
    }

    public function approve(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            //code...

            RequestBudgetModel::query()
            ->where('id', $request->id)->update([
                'status_id' => $request->status_id
            ]);

            $msg = 'Successfully ';

            if($request->status_id == 2) {
                UsersBalanceInfo::query()
                ->where('user_id', RequestBudgetModel::where('id', $request->id)->value('user_id'))
                ->increment('balance',
                    (int) str_replace(['Rp','.', ','], '', RequestBudgetModel::where('id', $request->id)->value('balance'))
                );

                $msg .= 'Approve ';
            } else {
                $msg .= 'Reject ';
            }

            $msg .= 'The Requested Budget';

            DB::commit();



            session()->flash('success', $msg);

            return redirect()->back();

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();

            $msg = 'Failed when approving the requested budget. Please contact developers';

            if(env('APP_DEBUG')) {
                $msg = $th->getMessage();
            }

            session()->flash('error', $msg);

            return redirect()->back();
        }
    }
}
