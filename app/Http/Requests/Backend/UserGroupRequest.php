<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class UserGroupRequest extends FormRequest
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
                        // 'display_name' => 'required|unique:roles',
                        'description'  => 'nullable',

                        'created_by' => 'nullable',
                        'updated_by' => 'nullable',
                        'deleted_by' => 'nullable',

                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'display_name'      => 'required|unique:roles,display_name,' . $this->route()->user_group->id,
                        'description'       => 'nullable',

                        'created_by' => 'nullable',
                        'updated_by' => 'nullable',
                        'deleted_by' => 'nullable',

                    ];
                }

            default:
                break;
        }
    }

    public function attributes(): array
    {
        $attr = [
            'display_name'      => '( ' . __('panel.user_group_display_name') . ' )',
            'description'      => '( ' . __('panel.user_group_description') . ' )',

        ];

        return $attr;
    }
}
