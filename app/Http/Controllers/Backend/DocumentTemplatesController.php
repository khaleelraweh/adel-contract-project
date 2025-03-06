<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\DocumentCategory;
use App\Models\DocumentTemplate;
use App\Models\DocumentType;
use Illuminate\Http\Request;

class DocumentTemplatesController extends Controller
{
    public function index()
    {
        if (!auth()->user()->ability(['admin','supervisor','users'], 'manage_document_templates , show_document_templates')) {
            return redirect('admin/index');
        }

        $documentTemplates = DocumentTemplate::query()
            ->when(\request()->keyword != null, function ($query) {
                $query->search(\request()->keyword);
            })
            ->when(\request()->status != null, function ($query) {
                $query->where('status', \request()->status);
            })
            ->orderByRaw(request()->sort_by == 'published_on'
                ? 'published_on IS NULL, published_on ' . (request()->order_by ?? 'desc')
                : (request()->sort_by ?? 'created_at') . ' ' . (request()->order_by ?? 'desc'))
            ->paginate(\request()->limit_by ?? 100);

        return view('backend.document_templates.index', compact('documentTemplates'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_document_templates')) {
            return redirect('admin/index');
        }

        $documentCategories = DocumentCategory::whereStatus(1)->get(['id', 'doc_cat_name']);
        $documentTypes = DocumentType::whereStatus(1)->get(['id', 'doc_type_name']);


        return view('backend.document_templates.create', compact('documentCategories', 'documentTypes'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->ability('admin', 'create_document_templates')) {
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
            return redirect()->route('admin.document_templates.index')->with([
                'message' => __('panel.created_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.document_templates.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }


    public function edit($documentTemplate)
    {
        if (!auth()->user()->ability('admin', 'update_document_templates')) {
            return redirect('admin/index');
        }

        $documentTemplate = DocumentTemplate::with('documentPages')->where('id', $documentTemplate)->first();

        return view('backend.document_templates.edit', compact('documentTemplate'));
    }

    public function show($id)
    {
        if (!auth()->user()->ability('admin', 'display_document_templates')) {
            return redirect('admin/index');
        }

        $document_template = DocumentTemplate::with('documentPages')->where('id', $id)->first();

        return view('backend.document_templates.show', compact('document_template'));
    }

    public function update(Request $request,  $documentTemplate) {}

    public function destroy($documentTemplate)
    {
        if (!auth()->user()->ability('admin', 'delete_document_templates')) {
            return redirect('admin/index');
        }

        $documentTemplate = DocumentTemplate::where('id', $documentTemplate)->first();

        $documentTemplate->deleted_by = auth()->user()->full_name;
        $documentTemplate->save();
        $documentTemplate->delete();

        if ($documentTemplate) {
            return redirect()->route('admin.document_templates.index')->with([
                'message' => __('panel.deleted_successfully'),
                'alert-type' => 'success'
            ]);
        }
        return redirect()->route('admin.document_templates.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function updateDocumentTemplateStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            DocumentTemplate::where('id', $data['document_template_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'document_template_id' => $data['document_template_id']]);
        }
    }
}
