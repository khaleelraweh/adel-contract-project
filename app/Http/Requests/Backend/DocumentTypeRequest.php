<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class DocumentTypeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'POST': {
                    return [
                        'doc_type_name.ar'                =>  'required|max:255',
                        'doc_type_note.ar'                =>  'nullable',
                        'document_category_id'           =>  'required',
                        // used always 

                        'status'                        =>  'required',
                        'published_on'                  =>  'required',
                        'created_by'                    =>  'nullable',
                        'updated_by'                    =>  'nullable',
                        'deleted_by'                    =>  'nullable',
                        // end of used always 

                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'doc_type_name.ar'                  =>  'required|max:255',
                        'doc_type_note.ar'                  =>  'nullable',
                        'document_category_id'              =>  'required',
                        // used always 

                        'status'                            =>  'required',
                        'published_on'                      =>  'required',
                        'created_by'                        =>  'nullable',
                        'updated_by'                        =>  'nullable',
                        'deleted_by'                        =>  'nullable',
                        // end of used always 
                    ];
                }

            default:
                break;
        }
    }

    public function attributes(): array
    {
        $attr = [
            'document_category_id'      => '( ' . __('panel.document_category_name') . ' )',
            'doc_type_note'             => '( ' . __('panel.document_type_note') . ' )',
            'published_on'              => '( ' . __('panel.published_on') . ' )',
            'status'                    =>  '( ' . __('panel.status') . ' )',
        ];

        foreach (config('locales.languages') as $key => $val) {
            $attr += ['doc_type_name.' . $key       =>  "( " . __('panel.document_type_name')   . ' ' . __('panel.in') . ' ' . __('panel.' . $val['lang'])   . " )",];
        }


        return $attr;
    }
}
