<?php

namespace App\Http\Livewire\ContractTemplate;

use App\Models\ContractTemplate;
use App\Models\ContractVariable;
use App\Models\DocumentTemplate;
use App\Models\DocumentCategory;
use App\Models\DocumentPage;
use App\Models\DocumentType;
use App\Models\PageGroup;
use App\Models\PageVariable;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class EditContractTemplateComponent extends Component
{
    use LivewireAlert;

    public $currentStep = 1;
    public $totalSteps = 4;

    public $contractTemplate;

    //step1
    public $contract_template_name;
    public $language;
    public $published_on;
    public $status = 1; // Default status value

    //step2
    public $contractTemplateId;
    public $contract_template_text;

    // step3 
    public $variables = [];
    public $count = 1;
    public $currentVariableIndex = 0; // Track the currently active page


    public $stepData = [
        'step1' => '',
        'step2' => '',
        'step3' => '',
        'step4' => '',
    ];

    // public function mount($contractTemplateId = null)
    // {
    //     $this->currentVariableIndex = 0;

    //     if ($this->contractTemplate) {
    //         $this->contract_template_name       =   $this->contractTemplate->contract_template_name;
    //         $this->language                     =   $this->contractTemplate->language;
    //         $this->published_on                 =   $this->contractTemplate->published_on;
    //         $this->status                       =   $this->contractTemplate->status;
    //         $this->contract_template_text       =   $this->contractTemplate->contract_template_text;


    //         $this->variables = $this->contractTemplate->contractVariables->map(function ($variable) {
    //             return [
    //                 'variableId'            =>  $variable->id,
    //                 'cv_name'               =>  $variable->cv_name,
    //                 'cv_question'           =>  $variable->cv_question,
    //                 'cv_type'               =>  $variable->cv_type,
    //                 'cv_required'           =>  $variable->cv_required,
    //                 'cv_details'            =>  $variable->cv_details,
    //                 'saved' => true,
    //             ];
    //         })->toArray();
    //     } else {
    //         $this->variables = [
    //             [
    //                 'variableId'            => 1,
    //                 'cv_name'               =>  __('panel.variable') . (count($this->variables) + 1),
    //                 'cv_question'           =>  '',
    //                 'cv_type'               =>   0,
    //                 'cv_required'           =>   1,
    //                 'cv_details'            =>  '',
    //                 'saved' => false, // Initialize saved as false
    //             ]
    //         ];
    //     }

    //     $this->count = count($this->variables);
    // }
    public function mount($contractTemplateId = null)
    {
        $this->currentVariableIndex = 0;

        if ($this->contractTemplate) {
            $this->contract_template_name       =   $this->contractTemplate->contract_template_name;
            $this->language                     =   $this->contractTemplate->language;
            $this->published_on                 =   $this->contractTemplate->published_on;
            $this->status                       =   $this->contractTemplate->status;
            $this->contract_template_text       =   $this->contractTemplate->contract_template_text;


            $this->variables = $this->contractTemplate->contractVariables->map(function ($variable) {
                return [
                    'variableId'            =>  $variable->id,
                    'cv_name'               =>  $variable->cv_name,
                    'cv_question'           =>  $variable->cv_question,
                    'cv_type'               =>  $variable->cv_type,
                    'cv_required'           =>  $variable->cv_required,
                    'cv_details'            =>  $variable->cv_details,
                    'saved' => true,
                ];
            })->toArray();
        } else {
            $this->variables = [
                [
                    'variableId'            => 1,
                    'cv_name'               =>  __('panel.variable') . (count($this->variables) + 1),
                    'cv_question'           =>  '',
                    'cv_type'               =>   0,
                    'cv_required'           =>   1,
                    'cv_details'            =>  '',
                    'saved' => false, // Initialize saved as false
                ]
            ];
        }

        $this->count = count($this->variables);
    }


    public function render()
    {
        return view('livewire.contract-template.edit-contract-template-component', [
            'contractTemplateId'        => $this->contractTemplate->id,
            'contractTemplate'          => $this->contractTemplate, // Pass the DocumentTemplate instance
            'contract_template_text'    => $this->contract_template_text, // Pass the contract_template_text to the view

        ]);
    }

    public function nextStep()
    {
        $this->validateStep();
        $this->saveStepData();
        $this->currentStep++;
    }

    public function finish()
    {
        $this->validateStep();
        $this->saveStepData();
        return redirect()->route('admin.contract_templates.index');
    }

    public function previousStep()
    {
        $this->currentStep--;
    }

    public function directMoveToStep($choseStep)
    {
        if ($choseStep > $this->currentStep) {
            $this->validateStep();
        }

        $this->currentStep = $choseStep;
    }

    public function validateStep()
    {
        if ($this->currentStep == 1) {
            $this->validate([
                'contract_template_name'    => 'required|string',
                'language'                  => 'required|numeric',
                'published_on'              => 'required',
            ]);
        } elseif ($this->currentStep == 2) {
            $this->validate([
                'contract_template_text' => 'required',
            ]);
        } elseif ($this->currentStep == 3) {
            $this->validateStepThree();
        } elseif ($this->currentStep == 4) {
            $this->validate([
                'contract_template_text' => 'required', // Validation rule for textarea
            ]);
        }
    }

    public function saveStepData()
    {
        if ($this->currentStep == 1) {
            $contractTemplate = ContractTemplate::updateOrCreate(
                ['id'                           =>  $this->contractTemplate->id],
                [
                    'contract_template_name'    => $this->contract_template_name,
                    'language'                  => $this->language,
                    'published_on'              => Carbon::now(),
                    'status'                    => $this->status,
                ]
            );
            $this->alert('success', __('panel.document_template_data_saved'));
        } elseif ($this->currentStep == 2) {
            ContractTemplate::updateOrCreate(
                ['id'                           => $this->contractTemplate->id],
                [
                    'contract_template_text'    => $this->contract_template_text,
                ]
            );
            $this->alert('success', __('panel.contract_template_text_saved'));
            $this->emit('updateDocTemplateText', $this->contract_template_text); // Emit event to update CKEditor
        } elseif ($this->currentStep == 3) {
            $this->saveStepThree();
            $this->alert('success', __('panel.document_template_variables_saved'));
        } elseif ($this->currentStep == 4) {
            ContractTemplate::updateOrCreate(
                ['id'                           => $this->contractTemplate->id],
                [
                    'contract_template_text'    => $this->contract_template_text,
                ]
            );
            $this->alert('success', __('panel.document_and_template_formatting_saved'));
        }
    }


    public function submitForm()
    {
        $this->validateStep();
        $this->saveStepData();
        // Handle final form submission, e.g., redirect or show a success message
    }

    public function toggleStatus()
    {
        $this->status = $this->status == 1 ? 0 : 1;
    }


    // ===================== for step 3 making page  =================//

    // Method to add a new page
    public function addVariable()
    {
        $this->count++;

        $this->variables[] = [
            'cv_name'           =>  __('panel.variable') . $this->count,
            'cv_question'       =>  '',
            'cv_type'           =>  0,
            'cv_required'       =>  1,
            'cv_details'        =>  '',

            'saved' => false, // Initialize saved as false
        ];

        // Set the current page index to the new page
        $this->currentVariableIndex = count($this->variables) - 1;

        $this->setActiveVariable($this->currentVariableIndex);
    }


    public function setActiveVariable($index)
    {
        // Ensure the index is within bounds
        if ($index >= 0 && $index < count($this->variables)) {
            $this->currentVariableIndex = $index;
        }
    }


    // Method to remove a variable
    public function removeVariable($variableIndex)
    {
        if (isset($this->variables[$variableIndex])) {
            array_splice($this->variables, $variableIndex, 1);
            $this->count--;

            // Adjust the currentVariableIndex if necessary
            if ($this->currentVariableIndex >= count($this->variables)) {
                $this->currentVariableIndex = count($this->variables) - 1;
            }

            if ($this->currentVariableIndex < 0) {
                $this->currentVariableIndex = 0;
            }
        }
    }


    public function validateStepThree()
    {
        $this->validate([
            'variables.*.cv_name'                     => 'required|string',
            'variables.*.cv_question'                 => 'required|string',
            'variables.*.cv_type'                     => 'required|numeric',
            'variables.*.cv_required'                 => 'required|boolean',
            'variables.*.cv_details'                  => 'required|string',
        ]);
    }


    public function saveStepThree()
    {
        // Perform validation
        $this->validateStepThree();


        ContractVariable::where('contract_template_id', $this->contractTemplate->id)->delete(); // Delete contract variables

        // Save the new data to the database
        foreach ($this->variables as $variable) {
            // Save the variable
            $variableModel = ContractVariable::updateOrCreate(
                ['id'                       => $variable['variableId'] ?? null],
                [
                    'cv_name'               => $variable['cv_name'],
                    'cv_question'           => $variable['cv_question'],
                    'cv_type'               => $variable['cv_type'],
                    'cv_required'           => $variable['cv_required'],
                    'cv_details'            => $variable['cv_details'],
                    'contract_template_id'  => $this->contractTemplate->id,
                ]
            );
        }

        // Indicate that step three data is saved
        $this->stepData['step3'] = 'saved';

        $this->alert('success', __('panel.document_template_variables_saved'));
    }


    // for saving step3 using btn 
    public function saveStepThreeDataUsingBtn()
    {
        $this->saveStepThree();
        $this->currentStep++;
    }
}
