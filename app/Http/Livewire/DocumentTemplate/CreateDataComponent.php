<?php

namespace App\Http\Livewire\DocumentTemplate;

use App\Models\DocumentCategory;
use App\Models\DocumentType;
use Livewire\Component;

class CreateDataComponent extends Component
{
    public $document_categories;
    public $document_types = [];

    public $document_category_id;
    public $document_type_id;

    public function render()
    {
        $this->document_categories  = DocumentCategory::whereStatus(true)->get();
        $this->document_types       = $this->document_category_id != '' ? DocumentType::whereStatus(true)->whereDocumentCategoryId($this->document_category_id)->get() : [];


        return view('livewire.document-template.create-data-component', [
            'document_categories'   => $this->document_categories,
            'document_types'        => $this->document_types,
        ]);
    }
}
