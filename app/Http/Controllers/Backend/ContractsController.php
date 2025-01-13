<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Document;
use App\Models\DocumentTemplate;
use Illuminate\Http\Request;
use PDF;

class ContractsController extends Controller
{
    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_contracts , show_contracts')) {
            return redirect('admin/index');
        }

        $contracts = Contract::all();

        return view('backend.contracts.index', compact('contracts'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_contracts')) {
            return redirect('admin/index');
        }
        return view('backend.contracts.create');
    }


    public function edit($id)
    {
        if (!auth()->user()->ability('admin', 'update_contracts')) {
            return redirect('admin/index');
        }

        $contract = Contract::query()->where('id', $id)->first();

        return view('backend.contracts.edit', compact('contract'));
    }

    public function show($id)
    {
        if (!auth()->user()->ability('admin', 'display_contracts')) {
            return redirect('admin/index');
        }
        $contract = Contract::findOrFail($id);
        return view('backend.contracts.show', compact('contract'));
    }

    public function destroy($id)
    {
        if (!auth()->user()->ability('admin', 'delete_contracts')) {
            return redirect('admin/index');
        }

        $contract = Contract::findOrFail($id);

        $contract->deleted_by = auth()->user()->full_name;
        $contract->save();
        $contract->delete();

        if ($contract) {
            return redirect()->route('admin.contracts.index')->with([
                'message' => __('panel.deleted_successfully'),
                'alert-type' => 'success'
            ]);
        }
        return redirect()->route('admin.contracts.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }


    public function print($id)
    {
        $contract = Contract::findOrFail($id);
        return view('backend.contracts.print', compact('contract'));
    }


    public function pdf($id)
    {
        $contract = Contract::findOrFail($id);

        $data['contract_content']         =  $contract->contract_content;

        // المكان الذي يوجد فيه ملف ال pdf.blade.php  
        // نقوم بارسال البيانات اليه من اجل عرضها في ذلك الملف 
        $pdf = PDF::loadView('backend.contracts.pdf', $data);
        // لطباعة ملف البيدي اف باسم معين وفي المسار المعين 
        return $pdf->stream($contract->id . '.pdf');

        return view('backend.contracts.pdf', compact('contract'));
    }



    public function updateContractStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Contract::where('id', $data['contract_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'contract_id' => $data['contract_id']]);
        }
    }
}
