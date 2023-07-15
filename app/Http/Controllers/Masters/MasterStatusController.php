<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\MasterStatusRequest;
use App\Models\Master\MasterStatus;
use Illuminate\Http\Request;

class MasterStatusController extends Controller
{
    //
    public function index()
    {
        $datas = MasterStatus::get();

        return view('verified.privileged.master.mst-status.index', compact('datas'));
    }

    public function create(MasterStatusRequest $request)
    {
        MasterStatus::create($request->validated());

        session()->flash('Success', 'Successfully Make New Status');

        return back();
    }
}
