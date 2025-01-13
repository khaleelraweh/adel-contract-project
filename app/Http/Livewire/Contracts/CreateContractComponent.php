<?php

namespace App\Http\Livewire\Contracts;

use App\Models\Contract;
use App\Models\ContractData;
use App\Models\ContractTemplate;
use App\Models\Document;
use App\Models\DocumentTemplate;
use App\Models\DocumentCategory;
use App\Models\DocumentData;
use App\Models\DocumentPage;
use App\Models\DocumentType;
use App\Models\PageGroup;
use App\Models\PageVariable;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use niklasravnsborg\LaravelPdf\Facades\PDF;

class CreateContractComponent extends Component
{

    use LivewireAlert;

    //global variables
    public $currentStep = 1;
    public $totalSteps = 4;

    public $contract_templates = [];
    public $contract_template_id;

    public $contract_id;
    public $contract;

    public $chosen_template;
    public $chosen_template_id;

    public $contract_name;
    public $contract_type_id;

    public $contractData = [];

    public $viewText;



    public function mount($contract_id = null)
    {
        $this->contract_id = $contract_id;

        $this->contract_templates       =  ContractTemplate::whereStatus(true)->get();
        $this->contract                 = Contract::find($this->contract_id);

        if ($this->contract) {
            $this->contract_template_id = $this->contract->contractTemplate->id;
            $this->contract_name = $this->contract->contract_name;
            $this->contract_type_id = $this->contract->contract_type;

            $this->chosen_template = ContractTemplate::find($this->contract->contract_template_id);
            $this->chosen_template_id = $this->contract->contract_template_id;

            $this->totalSteps = $this->chosen_template->contractVariables()->count() + 2;
            if ($this->contract->contractData) {

                $this->contractData = $this->chosen_template->contractVariables->map(function ($variable) {
                    return [

                        'cv_id'     =>  $variable->id,
                        'cv_name' => $variable->cv_name,
                        'cv_question' => $variable->cv_question,
                        'cv_type' => $variable->cv_type,
                        'cv_required' => $variable->cv_required,
                        'cv_details' => $variable->cv_details,
                        'cv_value'  =>  ContractData::where('contract_id', $this->contract_id)
                            ->where('contract_variable_id', $variable->id)
                            ->value('value') ?? '',
                        'saved' => true,
                    ];
                })->toArray();
            }
        }
    }

    public function render()
    {
        $this->contract_templates       =  ContractTemplate::whereStatus(true)->get();
        $this->contract                 =  Contract::find($this->contract_id);

        if ($this->contract != null) {
            $this->chosen_template = ContractTemplate::find($this->contract->contract_template_id);
            $this->chosen_template_id = $this->contract->contract_template_id;
            $this->totalSteps = $this->chosen_template->contractVariables()->count() + 2;
            if ($this->contract->contractData) {

                $this->contractData = $this->chosen_template->contractVariables->map(function ($variable) {
                    return [
                        'cv_id'     =>  $variable->id,
                        'cv_name' => $variable->cv_name,
                        'cv_question' => $variable->cv_question,
                        'cv_type' => $variable->cv_type,
                        'cv_required' => $variable->cv_required,
                        'cv_details' => $variable->cv_details,
                        'cv_value'  =>  ContractData::where('contract_id', $this->contract_id)
                            ->where('contract_variable_id', $variable->id)
                            ->value('value') ?? '',
                        'saved' => true,
                    ];
                })->toArray();
            }
        }
        // end to update chosen template status in the frontend 
        return view('livewire.contracts.create-contract-component', [
            'contract_templates'    => $this->contract_templates,
            'contract'              => $this->contract,
            'viewText'              => $this->viewText,
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
        $this->saveStepData();
        return redirect()->route('admin.contracts.show', $this->contract_id);
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
                'contract_template_id'  => 'required|integer',
                'contract_name'         => 'required|string|max:255',
                'contract_type_id'      => 'required|integer',
            ];
            $validationAttributes = [
                'contract_template_id'  => __('panel.contract_template_name'),
                'contract_name'         => __('panel.contract_name'),
                'contract_type_id'      => __('panel.contract_type'),
            ];
        }
        // Validation for steps between 2 and (totalSteps - 1)
        elseif ($this->currentStep > 1 && $this->currentStep < $this->totalSteps) {
            // Determine the index of the documentPage we're on
            $variableIndex = $this->currentStep - 2; // Since steps start at 1 and pages at 0

            // Loop through the groups and variables to build dynamic validation rules
            foreach ($this->contractData[$variableIndex] as $contractVariable) {
                $fieldName = 'contractData.'  . $variableIndex . '.cv_value';
                // $rules[$fieldName] = $contractVariable['cv_required'] ? 'required' : 'nullable';

                if (is_array($contractVariable) && isset($contractVariable['cv_required'])) {
                    $rules[$fieldName] = $contractVariable['cv_required'] ? 'required' : 'nullable';
                } else {
                    // Handle the case where $contractVariable is not an array or missing the 'cv_required' key.
                    $rules[$fieldName] = 'nullable'; // Default rule or log an error
                }


                // Create a user-friendly name for this field using the cv_name
                // $validationAttributes[$fieldName] = $contractVariable['cv_name'];
                if (is_array($contractVariable) && isset($contractVariable['cv_name'])) {
                    $validationAttributes[$fieldName] = $contractVariable['cv_name'];
                } else {
                    // Handle the case where $contractVariable is not valid
                    $validationAttributes[$fieldName] = 'Unknown Field'; // Default fallback
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
            $contract = Contract::updateOrCreate(
                ['id' => $this->contract_id],
                [
                    'contract_name' => $this->contract_name,
                    'contract_type' => $this->contract_type_id,
                    'contract_status' => 0,
                    'contract_template_id' => $this->contract_template_id,
                ]
            );

            $this->contract = $contract;
            $this->contract_id = $contract->id;

            $this->alert('success', __('panel.contract_data_saved'));
        }
        // Save data for dynamic steps (between 2 and totalSteps - 1)
        elseif ($this->currentStep > 1 && $this->currentStep < $this->totalSteps) {
            // Determine the index of the documentPage we're on
            $variableIndex = $this->currentStep - 2;

            foreach ($this->contractData as $variableIndex => $contractVariable) {
                ContractData::updateOrCreate(
                    [
                        'contract_id'       => $this->contract_id,
                        'contract_variable_id'  => $contractVariable['cv_id'],
                    ],
                    ['value' => $contractVariable['cv_value']]
                );
            }
            if ($this->chosen_template->contract_template_text) {
                $this->replacePlaceholders();
            }
            $this->alert('success', __('panel.contract_data_saved'));
        }

        // Proceed to the next step if validation passes
        if ($this->currentStep < $this->totalSteps) {
            // $this->currentStep++;
        } else {

            $contract = Contract::find($this->contract_id);
            $contract->contract_content = $this->viewText;
            $contract->contract_status = 1; // Mark as finished
            $contract->save();
            $this->alert('success', __('panel.contract_data_saved'));
        }
    }

    public function replacePlaceholders()
    {
        $viewText = $this->chosen_template->contract_template_text;

        // Initialize an empty array for replacements
        $forReplacement = [];

        // Match all placeholders in the format {!-number-Description!}
        preg_match_all('/{\!-([0-9]+)-[^\!]+\!}/', $viewText, $matches);

        if (isset($matches[1]) && isset($matches[0])) {
            foreach ($matches[1] as $index => $contractVariableId) {
                // Iterate over all steps in contractData to find the value
                foreach ($this->contractData as $stepData) {
                    if ($stepData['cv_id'] == $contractVariableId) {
                        // Map the placeholder to the value in contractData
                        $forReplacement[$matches[0][$index]] = $stepData['cv_value'];
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
