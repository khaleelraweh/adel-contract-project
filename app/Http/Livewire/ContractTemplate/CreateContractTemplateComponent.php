<?php

namespace App\Http\Livewire\ContractTemplate;

use App\Models\ContractTemplate;
use App\Models\ContractVariable;
use App\Models\DocumentTemplate;
use App\Models\DocumentCategory;
use App\Models\DocumentType;
use App\Models\DocumentPage;
use App\Models\PageGroup;
use App\Models\PageVariable;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CreateContractTemplateComponent extends Component
{
    use LivewireAlert;

    public $currentStep = 1;
    public $totalSteps = 4;

    public $stepData = [
        'step1' => '',
        'step2' => '',
        'step3' => '',
        'step4' => '',
    ];

    // Step 1
    public $name;
    public $language;
    public $published_on;
    public $status = 1; // Default status value

    // Step 2
    public $contractTemplateId;
    public $text;

    // Step 3
    public $variables = []; // Directly store variables here

    public function mount($contractTemplateId = null)
    {
        $this->contractTemplateId = $contractTemplateId;

        if ($contractTemplateId) {
            $documentTemplate = DocumentTemplate::find($contractTemplateId);

            if ($documentTemplate) {
                $this->name = $documentTemplate->name;
                $this->language = $documentTemplate->language;
                $this->published_on = $documentTemplate->published_on;
                $this->status = $documentTemplate->status;
                $this->text = $documentTemplate->text;

                // Load existing variables if editing
                $this->variables = PageVariable::whereHas('pageGroup.documentPage', function ($query) use ($documentTemplate) {
                    $query->where('document_template_id', $documentTemplate->id);
                })->get()->toArray();
            }
        } else {
            // Initialize with one empty variable
            $this->variables = [
                [
                    'cv_name' => '',
                    'cv_question' => '',
                    'cv_type' => 0,
                    'cv_required' => 1,
                    'cv_details' => '',
                ],
            ];
        }
    }

    public function render()
    {
        $documentTemplate = $this->contractTemplateId ? DocumentTemplate::find($this->contractTemplateId) : null;

        return view('livewire.contract-template.create-contract-template-component', [
            'contractTemplateId' => $this->contractTemplateId,
            'documentTemplate' => $documentTemplate,
            'text' => $this->text,
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
        return redirect()->route('admin.document_templates.index');
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
                'name' => 'required|string',
                'language' => 'required|numeric',
                'published_on' => 'required',
            ]);
        } elseif ($this->currentStep == 2) {
            $this->validate([
                'text' => 'required',
            ]);
        } elseif ($this->currentStep == 3) {
            $this->validateStepThree();
        } elseif ($this->currentStep == 4) {
            $this->validate([
                'text' => 'required',
            ]);
        }
    }

    public function saveStepData()
    {
        if ($this->currentStep == 1) {
            $contractTemplate = ContractTemplate::updateOrCreate(
                ['id' => $this->contractTemplateId],
                [
                    'name' => $this->name,
                    'language' => $this->language,
                    'published_on' => Carbon::now(),
                    'status' => $this->status,
                ]
            );

            $this->contractTemplateId = $contractTemplate->id;
            $this->alert('success', __('panel.contract_template_data_saved'));
        } elseif ($this->currentStep == 2) {
            ContractTemplate::updateOrCreate(
                ['id' => $this->contractTemplateId],
                [
                    'text' => $this->text,
                ]
            );
            $this->alert('success', __('panel.contract_template_text_saved'));
            $this->emit('updateContractTemplateText', $this->text);
        } elseif ($this->currentStep == 3) {
            $this->saveStepThree();
            $this->alert('success', __('panel.document_template_variables_saved'));
        } elseif ($this->currentStep == 4) {
            ContractTemplate::updateOrCreate(
                ['id' => $this->contractTemplateId],
                [
                    'text' => $this->text,
                ]
            );
            $this->alert('success', __('panel.document_and_template_formatting_saved'));
        }
    }

    public function submitForm()
    {
        $this->validateStep();
        $this->saveStepData();
    }

    public function toggleStatus()
    {
        $this->status = $this->status == 1 ? 0 : 1;
    }

    // Step 3: Add a new variable
    public function addVariable()
    {
        $this->variables[] = [
            'cv_name' => '',
            'cv_question' => '',
            'cv_type' => 0,
            'cv_required' => 1,
            'cv_details' => '',
        ];
    }

    // Step 3: Remove a variable
    public function removeVariable($index)
    {
        unset($this->variables[$index]);
        $this->variables = array_values($this->variables); // Re-index the array
    }

    public function validateStepThree()
    {
        $this->validate([
            'variables.*.cv_name' => 'required|string',
            'variables.*.cv_question' => 'required|string',
            'variables.*.cv_type' => 'required|numeric',
            'variables.*.cv_required' => 'required|boolean',
            'variables.*.cv_details' => 'required|string',
        ]);
    }

    public function saveStepThree()
    {
        $this->validateStepThree();

        // Save variables directly
        foreach ($this->variables as $variable) {
            ContractVariable::updateOrCreate(
                [
                    'cv_name' => $variable['cv_name'],
                    'cv_question' => $variable['cv_question'],
                ],
                [
                    'cv_type' => $variable['cv_type'],
                    'cv_required' => $variable['cv_required'],
                    'cv_details' => $variable['cv_details'],
                ]
            );
        }

        $this->stepData['step3'] = 'saved';
    }

    public function saveStepThreeDataUsingBtn()
    {
        $this->saveStepThree();
        $this->currentStep++;
    }

    public function updateDocTemplateText() {}
}
