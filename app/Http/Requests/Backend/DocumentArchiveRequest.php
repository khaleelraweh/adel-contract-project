<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class DocumentArchiveRequest extends FormRequest
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
                        'doc_archive_name.ar'           =>  'required|max:255',
                        'doc_archive_attached_file'  =>  'required|file|mimes:pdf,doc,docx',

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
                        'doc_archive_name.ar'           =>  'required|max:255',
                        'doc_archive_attached_file'     =>  'nullable|file|mimes:pdf,doc,docx',

                        // used always 
                        'status'                        =>  'required',
                        'published_on'                  =>  'required',
                        'created_by'                    =>  'nullable',
                        'updated_by'                    =>  'nullable',
                        'deleted_by'                    =>  'nullable',
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
            'doc_archive_attached_file'      => '( ' . __('panel.attach_the_document') . ' )',
            'published_on'                  =>  '( ' . __('panel.published_on') . ' )',
            'status'                        =>  '( ' . __('panel.status') . ' )',
        ];

        foreach (config('locales.languages') as $key => $val) {
            $attr += ['doc_archive_name.' . $key       =>  "( " . __('panel.document_archive_name')   . ' ' . __('panel.in') . ' ' . __('panel.' . $val['lang'])   . " )",];
        }


        return $attr;
    }
}
