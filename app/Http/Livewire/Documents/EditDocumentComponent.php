<?php

namespace App\Http\Livewire\Documents;

use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\DocumentData;
use App\Models\DocumentTemplate;
use App\Models\DocumentType;
use App\Models\PageVariable;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class EditDocumentComponent extends Component
{
    use LivewireAlert;

    //global variables
    public $currentStep = 1;
    public $totalSteps = 4;

    public $document_id;
    public $document;

    public $document_categories;
    public $document_category_id;

    public $document_types = [];
    public $document_type_id;

    public $document_templates = [];
    public $document_template_id;

    public $chosen_template;
    public $chosen_template_id;

    public $doc_name;
    public $doc_type_id;

    public $docData = [];

    public $viewText;


    public function mount($document_id = null)
    {
        $this->document_id = $document_id;

        $this->document_categories  = DocumentCategory::whereStatus(true)->get();
        $this->document_types       = $this->document_category_id != '' ? DocumentType::whereStatus(true)->whereDocumentCategoryId($this->document_category_id)->get() : [];
        $this->document_templates       = $this->document_type_id != '' ? DocumentTemplate::whereStatus(true)->whereDocumentTypeId($this->document_type_id)->get() : [];
        $this->document = Document::find($this->document_id);


        if ($this->document) {
            $this->document_type_id = $this->document->documentTemplate->documentType->id;
            $this->document_template_id = $this->document->documentTemplate->id;
            $this->document_category_id = $this->document->documentTemplate->documentType->documentCategory->id;
            $this->doc_name = $this->document->doc_name;
            $this->doc_type_id = $this->document->doc_type;

            $this->chosen_template = DocumentTemplate::find($this->document->document_template_id);
            $this->chosen_template_id = $this->document->document_template_id;

            $this->totalSteps = $this->chosen_template->documentPages()->count() + 2;

            if ($this->document->documentData) {

                $this->docData = $this->chosen_template->documentPages->map(function ($page) {
                    return [
                        'pageId' => $page->id,
                        'doc_page_name' => $page->doc_page_name,
                        'doc_page_description' => $page->doc_page_description,
                        'groups' => $page->pageGroups->map(function ($group) {
                            return [
                                'pg_id'     =>  $group->id,
                                'pg_name' => $group->pg_name,
                                'variables' => $group->pageVariables->map(function ($variable) {
                                    return [
                                        'pv_id'     =>  $variable->id,
                                        'pv_name' => $variable->pv_name,
                                        'pv_question' => $variable->pv_question,
                                        'pv_type' => $variable->pv_type,
                                        'pv_required' => $variable->pv_required,
                                        'pv_details' => $variable->pv_details,
                                        'pv_value'  =>  DocumentData::where('document_id', $this->document_id)
                                            ->where('page_variable_id', $variable->id)
                                            ->value('value') ?? '',
                                    ];
                                })->toArray(),
                            ];
                        })->toArray(),
                        'saved' => true,
                    ];
                })->toArray();
            }
        }
    }

    public function render()
    {
        $this->document_categories  = DocumentCategory::whereStatus(true)->get();
        $this->document_types       = $this->document_category_id != '' ? DocumentType::whereStatus(true)->whereDocumentCategoryId($this->document_category_id)->get() : [];
        $this->document_templates       = $this->document_type_id != '' ? DocumentTemplate::whereStatus(true)->whereDocumentTypeId($this->document_type_id)->get() : [];
        $this->document = Document::find($this->document_id);

        if ($this->document != null) {
            $this->chosen_template = DocumentTemplate::find($this->document->document_template_id);
            $this->chosen_template_id = $this->document->document_template_id;
            $this->totalSteps = $this->chosen_template->documentPages()->count() + 2;

            if ($this->document->documentData) {

                $this->docData = $this->chosen_template->documentPages->map(function ($page) {
                    return [
                        'pageId' => $page->id,
                        'doc_page_name' => $page->doc_page_name,
                        'doc_page_description' => $page->doc_page_description,
                        'groups' => $page->pageGroups->map(function ($group) {
                            return [
                                'pg_id'     =>  $group->id,
                                'pg_name' => $group->pg_name,
                                'variables' => $group->pageVariables->map(function ($variable) {
                                    return [
                                        'pv_id'     =>  $variable->id,
                                        'pv_name' => $variable->pv_name,
                                        'pv_question' => $variable->pv_question,
                                        'pv_type' => $variable->pv_type,
                                        'pv_required' => $variable->pv_required,
                                        'pv_details' => $variable->pv_details,
                                        'pv_value'  =>  DocumentData::where('document_id', $this->document_id)
                                            ->where('page_variable_id', $variable->id)
                                            ->value('value') ?? '',
                                    ];
                                })->toArray(),
                            ];
                        })->toArray(),
                        'saved' => true,
                    ];
                })->toArray();
            }
        }




        return view('livewire.documents.edit-document-component', [
            'document_categories'   => $this->document_categories,
            'document_types'        => $this->document_types,
            'document_templates'    => $this->document_templates,
            'document'              => $this->document,
            'viewText'     => $this->viewText,
        ]);
    }

    public function previousStep()
    {
        $this->currentStep--;
    }

    public function nextStep()
    {
        $this->validateStep();
        $this->saveStepData();
        $this->currentStep++;
    }

    public function finish()
    {
        // $this->validateStep();
        $this->saveStepData();
        return redirect()->route('admin.documents.show', $this->document_id);
    }

    public function directMoveToStep($choseStep)
    {
        if ($choseStep > $this->currentStep && $choseStep == ($this->currentStep + 1)) {
            $this->validateStep();
            $this->saveStepData();
            $this->currentStep = $choseStep;
        } elseif ($choseStep < $this->currentStep) {
            $this->currentStep = $choseStep;
        }
    }


    public function validateStep()
    {
        // Base validation rules
        $rules = [];
        $validationAttributes = [];

        // Step 1 validation (this is static, since it's always step 1)
        if ($this->currentStep == 1) {
            $rules = [
                'document_category_id' => 'required|integer',
                'document_type_id' => 'required|integer',
                'document_template_id' => 'required|integer',
                'doc_name' => 'required|string|max:255',
                'doc_type_id' => 'required|integer',
            ];
            $validationAttributes = [
                'document_category_id' => __('panel.document_category_name'),
                'document_type_id' => __('panel.document_type_name'),
                'document_template_id' => __('panel.document_template_name'),
                'doc_name' => __('panel.document_name'),
                'doc_type_id' => __('panel.document_type'),
            ];
        }
        // Validation for steps between 2 and (totalSteps - 1)
        elseif ($this->currentStep > 1 && $this->currentStep < $this->totalSteps) {
            // Determine the index of the documentPage we're on
            $pageIndex = $this->currentStep - 2; // Since steps start at 1 and pages at 0

            // Loop through the groups and variables to build dynamic validation rules
            foreach ($this->docData[$pageIndex]['groups'] as $groupIndex => $pageGroup) {
                foreach ($pageGroup['variables'] as $variableIndex => $pageVariable) {
                    $fieldName = 'docData.' . $pageIndex . '.groups.' . $groupIndex . '.variables.' . $variableIndex . '.pv_value';
                    $rules[$fieldName] = $pageVariable['pv_required'] ? 'required' : 'nullable';

                    // Create a user-friendly name for this field using the pv_name
                    $validationAttributes[$fieldName] = $pageVariable['pv_name'];
                }
            }
        }

        // Set custom attribute names
        $this->withValidator(function ($validator) use ($validationAttributes) {
            $validator->setAttributeNames($validationAttributes);
        });

        // Validate data based on the rules
        $this->validate($rules);
    }

    public function saveStepData()
    {
        if ($this->currentStep == 1) {
            // Save or update the document information
            $document = Document::updateOrCreate(
                ['id' => $this->document_id],
                [
                    'doc_name' => $this->doc_name,
                    'doc_type' => $this->doc_type_id,
                    'doc_status' => 0,
                    'document_template_id' => $this->document_template_id,
                    'updated_by'            => auth()->user()->full_name,

                ]
            );

            $this->document = $document;
            $this->document_id = $document->id;

            $this->alert('success', __('panel.document_data_saved'));
        }
        // Save data for dynamic steps (between 2 and totalSteps - 1)
        elseif ($this->currentStep > 1 && $this->currentStep < $this->totalSteps) {
            // Determine the index of the documentPage we're on
            $pageIndex = $this->currentStep - 2;

            foreach ($this->docData[$pageIndex]['groups'] as $groupIndex => $pageGroup) {
                foreach ($pageGroup['variables'] as $variableIndex => $pageVariable) {
                    DocumentData::updateOrCreate(
                        [
                            'document_id' => $this->document_id,
                            'page_variable_id' => $pageVariable['pv_id'],
                        ],
                        ['value' => $pageVariable['pv_value']]
                    );
                }
            }
            if ($this->chosen_template->doc_template_text) {
                $this->replacePlaceholders();
            }
            $this->alert('success', __('panel.document_data_saved'));
        }

        // Proceed to the next step if validation passes
        if ($this->currentStep < $this->totalSteps) {
            // $this->currentStep++;
        } else {

            $document = Document::find($this->document_id);
            $document->doc_content = $this->viewText;
            $document->doc_status = 1; // Mark as finished
            $document->save();
            $this->alert('success', __('panel.document_data_saved'));
        }
    }

    public function replacePlaceholders()
    {
        $viewText = $this->chosen_template->doc_template_text;

        // Initialize an empty array for replacements
        $forReplacement = [];

        // Match all placeholders in the format {!-number-Description!}
        preg_match_all('/{\!-([0-9]+)-[^\!]+\!}/', $viewText, $matches);

        if (isset($matches[1]) && isset($matches[0])) {
            foreach ($matches[1] as $index => $pageVariableId) {
                // Iterate over all steps in docData to find the value
                foreach ($this->docData as $stepData) {
                    foreach ($stepData['groups'] as $groupData) {
                        foreach ($groupData['variables'] as $variableData) {
                            if ($variableData['pv_id'] == $pageVariableId) {
                                // Map the placeholder to the value in docData
                                $forReplacement[$matches[0][$index]] = $variableData['pv_value'];
                                break 3; // Exit all three loops once the value is found
                            }
                        }
                    }
                }
            }
        }

        // Replace all placeholders in viewText with their corresponding values
        $viewText = strtr($viewText, $forReplacement);

        // Update the viewText property with the replaced content
        $this->viewText = $viewText;

        // Optionally, return or display the replaced text
        return $viewText;
    }
}
