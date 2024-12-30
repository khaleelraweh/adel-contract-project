<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ContractTemplate;
use Illuminate\Http\Request;

class ContractTemplateController extends Controller
{
    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_contract_templates , show_contract_templates')) {
            return redirect('admin/index');
        }

        $contract_templates = ContractTemplate::all();

        return view('backend.contract_templates.index', compact('contract_templates'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_contract_templates')) {
            return redirect('admin/index');
        }

        return view('backend.contract_templates.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->ability('admin', 'create_contract_templates')) {
            return redirect('admin/index');
        }

        $input['doc_type_name']             =   $request->doc_type_name;
        $input['doc_type_note']             =   $request->doc_type_note;
        $input['document_category_id']      =   $request->document_category_id;
        $input['created_by']                =   auth()->user()->full_name;
        $input['published_on']              =   $request->published_on;
        $input['status']                    =   $request->status;

        $documentType = DocumentType::create($input);


        if ($documentType) {
            return redirect()->route('admin.contract_templates.index')->with([
                'message' => __('panel.created_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.contract_templates.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }


    public function edit($documentTemplate)
    {
        if (!auth()->user()->ability('admin', 'update_contract_templates')) {
            return redirect('admin/index');
        }

        $documentTemplate = DocumentTemplate::with('documentPages')->where('id', $documentTemplate)->first();

        return view('backend.contract_templates.edit', compact('documentTemplate'));
    }

    public function update(Request $request,  $documentTemplate) {}

    public function destroy($documentTemplate)
    {
        if (!auth()->user()->ability('admin', 'delete_contract_templates')) {
            return redirect('admin/index');
        }

        $documentTemplate = DocumentTemplate::where('id', $documentTemplate)->first();

        $documentTemplate->deleted_by = auth()->user()->full_name;
        $documentTemplate->save();
        $documentTemplate->delete();

        if ($documentTemplate) {
            return redirect()->route('admin.contract_templates.index')->with([
                'message' => __('panel.deleted_successfully'),
                'alert-type' => 'success'
            ]);
        }
        return redirect()->route('admin.contract_templates.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function updateContractTemplateStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            ContractTemplate::where('id', $data['contract_template_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'contract_template_id' => $data['contract_template_id']]);
        }
    }
}
