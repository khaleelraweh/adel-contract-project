<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\DocumentType;
use Illuminate\Http\Request;
use App\Models\DocumentCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\DocumentTypeRequest;


class DocumentTypesController extends Controller
{

    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_document_types , show_document_types')) {
            return redirect('admin/index');
        }

        $document_types = DocumentType::query()
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

        return view('backend.document_types.index', compact('document_types'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_document_types')) {
            return redirect('admin/index');
        }
        $document_categories = DocumentCategory::whereStatus(1)->get(['id', 'doc_cat_name']);
        return view('backend.document_types.create', compact('document_categories'));
    }

    public function store(DocumentTypeRequest $request)
    {
        if (!auth()->user()->ability('admin', 'create_document_types')) {
            return redirect('admin/index');
        }

        $input['doc_type_name']                 =   $request->doc_type_name;
        $input['doc_type_note']                 =   $request->doc_type_note;
        $input['document_category_id']          =   $request->document_category_id;

        $input['status']                        =   $request->status;
        $input['created_by']                    = auth()->user()->full_name;

        $published_on = str_replace(['ص', 'م'], ['AM', 'PM'], $request->published_on);
        $publishedOn = Carbon::createFromFormat('Y/m/d h:i A', $published_on)->format('Y-m-d H:i:s');
        $input['published_on']            = $publishedOn;


        $document_type = DocumentType::create($input);


        if ($document_type) {
            return redirect()->route('admin.document_types.index')->with([
                'message' => __('panel.created_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.document_types.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }



    public function show($id)
    {
        if (!auth()->user()->ability('admin', 'display_document_types')) {
            return redirect('admin/index');
        }
        return view('backend.document_types.show');
    }

    public function edit($document_type)
    {
        if (!auth()->user()->ability('admin', 'update_document_types')) {
            return redirect('admin/index');
        }

        $document_categories = DocumentCategory::whereStatus(1)->get(['id', 'doc_cat_name']);
        $document_type = DocumentType::where('id', $document_type)->first();

        return view('backend.document_types.edit', compact('document_type', 'document_categories'));
    }

    public function update(DocumentTypeRequest $request, $document_type)
    {
        $document_type = DocumentType::where('id', $document_type)->first();
        $input['doc_type_name'] = $request->doc_type_name;
        $input['doc_type_note'] = $request->note;
        $input['document_category_id']   =   $request->document_category_id;

        $input['status']            =   $request->status;
        $input['created_by'] = auth()->user()->full_name;

        $published_on = str_replace(['ص', 'م'], ['AM', 'PM'], $request->published_on);
        $publishedOn = Carbon::createFromFormat('Y/m/d h:i A', $published_on)->format('Y-m-d H:i:s');
        $input['published_on']            = $publishedOn;


        $document_type->update($input);
        if ($document_type) {
            return redirect()->route('admin.document_types.index')->with([
                'message' => __('panel.updated_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.document_types.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function destroy($document_type)
    {
        if (!auth()->user()->ability('admin', 'delete_document_types')) {
            return redirect('admin/index');
        }
        // Find the document_type category
        $document_type = DocumentType::findOrFail($document_type);
        // Now delete the document_type category record
        $document_type->delete();

        // $document_type = DocumentType::where('id', $document_type)->first()->delete();

        if ($document_type) {
            return redirect()->route('admin.document_types.index')->with([
                'message' => __('panel.deleted_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.document_types.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function updateDocumentTypeStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            DocumentType::where('id', $data['document_type_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'document_type_id' => $data['document_type_id']]);
        }
    }
}
