<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Models\DocumentCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\DocumentCategoryRequest;

use Carbon\Carbon;

class DocumentCategoriesController extends Controller
{
    public function index()
    {
        if (!auth()->user()->ability(['admin','supervisor','users'], 'manage_document_categories , show_document_categories')) {
            return redirect('admin/index');
        }

        $document_categories = DocumentCategory::query()
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

        return view('backend.document_categories.index', compact('document_categories'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_document_categories')) {
            return redirect('admin/index');
        }

        return view('backend.document_categories.create');
    }

    public function store(DocumentCategoryRequest $request)
    {
        if (!auth()->user()->ability('admin', 'create_document_categories')) {
            return redirect('admin/index');
        }

        $input['doc_cat_name'] = $request->doc_cat_name;
        $input['doc_cat_note'] = $request->doc_cat_note;

        $input['status']            =   $request->status;
        $input['created_by'] = auth()->user()->full_name;

        $published_on = str_replace(['ص', 'م'], ['AM', 'PM'], $request->published_on);
        $publishedOn = Carbon::createFromFormat('Y/m/d h:i A', $published_on)->format('Y-m-d H:i:s');
        $input['published_on']            = $publishedOn;


        $document_category = DocumentCategory::create($input);

        if ($document_category) {
            return redirect()->route('admin.document_categories.index')->with([
                'message' => __('panel.created_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.document_categories.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }



    public function show($id)
    {
        if (!auth()->user()->ability('admin', 'display_document_categories')) {
            return redirect('admin/index');
        }

        $document_category = DocumentCategory::where('id', $id)->first();

        return view('backend.document_categories.show', compact('document_category'));
    }

    public function edit($document_category)
    {
        if (!auth()->user()->ability('admin', 'update_document_categories')) {
            return redirect('admin/index');
        }

        $document_category = DocumentCategory::where('id', $document_category)->first();

        return view('backend.document_categories.edit', compact('document_category'));
    }

    public function update(DocumentCategoryRequest $request, $document_category)
    {
        if (!auth()->user()->ability('admin', 'update_document_categories')) {
            return redirect('admin/index');
        }

        $document_category = DocumentCategory::where('id', $document_category)->first();

        $input['doc_cat_name'] = $request->doc_cat_name;
        $input['doc_cat_note'] = $request->doc_cat_note;
        $input['status']            =   $request->status;
        $input['updated_by'] = auth()->user()->full_name;

        $published_on = str_replace(['ص', 'م'], ['AM', 'PM'], $request->published_on);
        $publishedOn = Carbon::createFromFormat('Y/m/d h:i A', $published_on)->format('Y-m-d H:i:s');
        $input['published_on']            = $publishedOn;

        $document_category->update($input);


        if ($document_category) {
            return redirect()->route('admin.document_categories.index')->with([
                'message' => __('panel.updated_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.document_categories.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function destroy($document_category)
    {
        if (!auth()->user()->ability('admin', 'delete_document_categories')) {
            return redirect('admin/index');
        }
        // Find the document category
        $document_category = DocumentCategory::findOrFail($document_category);
        // Now delete the document category record
        $document_category->delete();
        if ($document_category) {
            return redirect()->route('admin.document_categories.index')->with([
                'message' => __('panel.deleted_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.document_categories.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function updateDocumentCategoryStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            DocumentCategory::where('id', $data['document_category_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'document_category_id' => $data['document_category_id']]);
        }
    }
}
