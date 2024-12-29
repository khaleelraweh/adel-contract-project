<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentTemplate;
use Illuminate\Http\Request;
use PDF;


class DocumentsController extends Controller
{
    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_documents , show_documents')) {
            return redirect('admin/index');
        }

        $documents = Document::all();

        return view('backend.documents.index', compact('documents'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_documents')) {
            return redirect('admin/index');
        }
        return view('backend.documents.create');
    }


    public function edit($id)
    {
        if (!auth()->user()->ability('admin', 'update_document_templates')) {
            return redirect('admin/index');
        }

        $document = Document::query()->where('id', $id)->first();

        return view('backend.documents.edit', compact('document'));
    }

    public function show($id)
    {
        if (!auth()->user()->ability('admin', 'display_documents')) {
            return redirect('admin/index');
        }
        $document = Document::findOrFail($id);
        return view('backend.documents.show', compact('document'));
    }

    public function destroy($id)
    {
        if (!auth()->user()->ability('admin', 'delete_documents')) {
            return redirect('admin/index');
        }

        $document = Document::findOrFail($id);

        $document->deleted_by = auth()->user()->full_name;
        $document->save();
        $document->delete();

        if ($document) {
            return redirect()->route('admin.documents.index')->with([
                'message' => __('panel.deleted_successfully'),
                'alert-type' => 'success'
            ]);
        }
        return redirect()->route('admin.documents.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }


    public function print($id)
    {
        $document = Document::findOrFail($id);
        return view('backend.documents.print', compact('document'));
    }


    public function pdf($id)
    {
        $document = Document::findOrFail($id);

        $data['doc_content']         =  $document->doc_content;

        // المكان الذي يوجد فيه ملف ال pdf.blade.php  
        // نقوم بارسال البيانات اليه من اجل عرضها في ذلك الملف 
        $pdf = PDF::loadView('backend.documents.pdf', $data);
        // لطباعة ملف البيدي اف باسم معين وفي المسار المعين 
        return $pdf->stream($document->id . '.pdf');

        return view('backend.documents.pdf', compact('document'));
    }



    public function updateDocumentStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Document::where('id', $data['document_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'document_id' => $data['document_id']]);
        }
    }
}