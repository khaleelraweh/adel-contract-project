<?php

namespace App\Http\Livewire\DocumentTemplate;


use App\Models\DocumentTemplate;
use App\Models\DocumentCategory;
use App\Models\DocumentType;
use App\Models\DocumentPage;
use App\Models\PageGroup;
use App\Models\PageVariable;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CreateDocumentTemplateComponent extends Component
{
    use LivewireAlert;

    public $currentStep = 1;
    public $totalSteps = 4;

    // -------- for document categories and types ---------//
    public $document_categories;
    public $document_types = [];

    // this is for sending data to document template table 
    //step1
    public $document_category_id;
    public $document_type_id;
    public $doc_template_name;
    public $language;
    public $published_on;
    public $status = 1; // Default status value

    //step2
    public $documentTemplateId;
    public $doc_template_text;

    // step3 
    public $pages = [];
    public $count = 1;
    public $currentPageIndex = 0; // Track the currently active page
    public $activeGroupIndex = 0; // Track the currently active group within a page

    public $activeVariableIndex = 0; // Initialize to 0 or any default value

    // Add a property to track the group counter for each page
    public $groupCounters = [];

    // Add a property to track the variable counter for each group in each page
    public $variableCounters = [];




    public $stepData = [
        'step1' => '',
        'step2' => '',
        'step3' => '',
        'step4' => '',
    ];

    public function mount($documentTemplateId = null)
    {
        $this->currentPageIndex = 0;
        $this->activeGroupIndex = 0;
        $this->activeVariableIndex = 0;

        // Initialize the pages array with a default page if it's empty
        if (empty($this->pages)) {
            $this->pages = [
                [
                    'pageId' => 1,
                    'doc_page_name' => __('panel.page') . ' 1',
                    'doc_page_description' => 'Page Description 1',
                    'groups' => [
                        [
                            'pg_name' =>  __('panel.group_name') . ' 1',
                            'variables' => [
                                [
                                    'pv_name' => __('panel.pv_name_holder') . ' 1',
                                    'pv_question'           =>  '',
                                    'pv_type'               =>   0,
                                    'pv_required'           =>   1,
                                    'pv_details'            =>  '',
                                ],
                            ],

                        ],

                    ],
                    'saved' => false, // Initialize saved as false
                ]
            ];
            // Initialize the group counter for the first page
            $this->groupCounters[0] = 1; // Start counting from 1
            $this->variableCounters[0][0] = 1; // Start counting variables from 1 for the first group

        }

        $this->documentTemplateId = $documentTemplateId;

        if ($documentTemplateId) {
            $documentTemplate = DocumentTemplate::find($documentTemplateId);

            if ($documentTemplate) {
                $this->document_category_id =   $documentTemplate->document_category_id;
                $this->document_type_id     =   $documentTemplate->document_type_id;
                $this->doc_template_name    =   $documentTemplate->doc_template_name;
                $this->language             =   $documentTemplate->language;
                $this->published_on         =   $documentTemplate->published_on;
                $this->status               =   $documentTemplate->status;
                $this->doc_template_text    =   $documentTemplate->doc_template_text;
                // Initialize other fields as needed
            }

            // Initialize count based on existing pages
            $this->count = count($this->pages);
        }
    }


    public function render()
    {
        // -------- for document categories and types ---------//
        $this->document_categories  = DocumentCategory::whereStatus(true)->get();
        $this->document_types       = $this->document_category_id != '' ? DocumentType::whereStatus(true)->whereDocumentCategoryId($this->document_category_id)->get() : [];


        // Fetch the DocumentTemplate instance
        $documentTemplate = $this->documentTemplateId ? DocumentTemplate::find($this->documentTemplateId) : null;


        return view(
            'livewire.document-template.create-document-template-component',
            [
                'document_categories'   => $this->document_categories,
                'document_types'        => $this->document_types,
                'documentTemplateId'    => $this->documentTemplateId,
                'documentTemplate'      => $documentTemplate, // Pass the DocumentTemplate instance
                'doc_template_text'     => $this->doc_template_text, // Pass the doc_template_text to the view


            ]
        );
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
                'document_category_id'  => 'required|numeric',
                'document_type_id'      => 'required|numeric',
                'doc_template_name'     => 'required|string',
                'language'              => 'required|numeric',
                'published_on'          => 'required',
            ], [], [
                'document_category_id'  => __('panel.attributes.document_category_id'),
                'document_type_id'      => __('panel.attributes.document_type_id'),
                'doc_template_name'     => __('panel.attributes.doc_template_name'),
                'language'              => __('panel.attributes.language'),
                'published_on'          => __('panel.attributes.published_on'),
            ]);
        } elseif ($this->currentStep == 2) {
            $this->validate([
                'doc_template_text' => 'required',
            ], [], [
                'doc_template_text' => __('panel.attributes.doc_template_text'),
            ]);
        } elseif ($this->currentStep == 3) {
            // Perform validation
            $this->validateStepThree();
        } elseif ($this->currentStep == 4) {
            $this->validate([
                'doc_template_text' => 'required', // Validation rule for textarea
            ], [], [
                'doc_template_text' => __('panel.attributes.doc_template_text'),
            ]);
        }
    }

    public function saveStepData()
    {
        if ($this->currentStep == 1) {
            if ($this->documentTemplateId) {
                $documentTemplate = DocumentTemplate::updateOrCreate(
                    ['id' => $this->documentTemplateId],
                    [
                        'document_category_id'  => $this->document_category_id,
                        'document_type_id'      => $this->document_type_id,
                        'doc_template_name'     => $this->doc_template_name,
                        'language'              => $this->language,
                        // 'published_on'          => $this->published_on,
                        // 'published_on'          => Carbon::now(),
                        'published_on'          => $this->published_on,
                        'status'                => $this->status,
                        'created_by'            => auth()->user()->full_name,

                    ]
                );
            } else {
                $documentTemplate = DocumentTemplate::updateOrCreate(
                    [
                        'document_category_id'  => $this->document_category_id,
                        'document_type_id'      => $this->document_type_id,
                        'doc_template_name'     => $this->doc_template_name,
                        'language'              => $this->language,
                        // 'published_on'          => $this->published_on,
                        // 'published_on'          => Carbon::now(),
                        'published_on'          => $this->published_on,
                        'status'                => $this->status,
                        'created_by'            => auth()->user()->full_name,
                    ]
                );
            }



            $this->documentTemplateId = $documentTemplate->id;
            $this->alert('success', __('panel.document_template_data_saved'));
        } elseif ($this->currentStep == 2) {
            DocumentTemplate::updateOrCreate(
                ['id' => $this->documentTemplateId],
                [
                    'doc_template_text'     => $this->doc_template_text,
                ]
            );
            $this->alert('success', __('panel.document_template_text_saved'));
            $this->emit('updateDocTemplateText', $this->doc_template_text); // Emit event to update CKEditor
        } elseif ($this->currentStep == 3) {
            $this->saveStepThree();
            $this->alert('success', __('panel.document_template_variables_saved'));
        } elseif ($this->currentStep == 4) {
            DocumentTemplate::updateOrCreate(
                ['id' => $this->documentTemplateId],
                [
                    'doc_template_text' => $this->doc_template_text,
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
    public function addPage()
    {
        $this->count++;

        $this->pages[] = [
            'pageId'                => $this->count,
            'doc_page_name'         => __('panel.page') . ' ' . $this->count,
            'doc_page_description'  => 'Page description ' . $this->count,
            'groups' => [
                [
                    'pg_name' => __('panel.group_name') . ' 1',
                    'variables' => [
                        [
                            'pv_name'       =>  __('panel.pv_name_holder') . ' 1',
                            'pv_question'   =>  '',
                            'pv_type'       =>   0,
                            'pv_required'   =>   1,
                            'pv_details'    =>  '',
                        ],
                    ],
                ],
            ],
            'saved' => false, // Initialize saved as false
        ];

        // Initialize the group counter for the new page
        $this->groupCounters[count($this->pages) - 1] = 1;

        // Initialize the variable counter for the first group in the new page
        $this->variableCounters[count($this->pages) - 1][0] = 1;

        // Set the current page index to the new page
        $this->currentPageIndex = count($this->pages) - 1;

        $this->setActivePage($this->currentPageIndex);
    }

    public function setActivePage($index)
    {
        // Ensure the index is within bounds
        if ($index >= 0 && $index < count($this->pages)) {
            $this->currentPageIndex = $index;
            $this->activeGroupIndex = 0; // Reset the active group index
            $this->activeVariableIndex = 0; // Reset the active group index

        }
    }

    // Method to remove a page
    public function removePage($pageIndex)
    {
        if (isset($this->pages[$pageIndex])) {
            array_splice($this->pages, $pageIndex, 1);
            $this->count--;

            // Adjust the currentPageIndex if necessary
            if ($this->currentPageIndex >= count($this->pages)) {
                $this->currentPageIndex = count($this->pages) - 1;
            }

            if ($this->currentPageIndex < 0) {
                $this->currentPageIndex = 0;
            }
        }
    }

    public function addGroup($pageIndex)
    {

        // Initialize the group counter for the page if it doesn't exist
        if (!isset($this->groupCounters[$pageIndex])) {
            $this->groupCounters[$pageIndex] = 0;
        }

        // Increment the group counter for the page
        $this->groupCounters[$pageIndex]++;

        // Add a new group with at least one variable
        $this->pages[$pageIndex]['groups'][] = [
            'pg_name' => __('panel.group_name') . ' ' . $this->groupCounters[$pageIndex],

            'variables' => [
                [
                    'pv_name' => __('panel.pv_name_holder') . ' 1',
                    'pv_question'   => '',
                    'pv_type'       => 0,
                    'pv_required'   => 1,
                    'pv_details'    => '',
                ],
            ],
        ];

        // Initialize the variable counter for the new group
        $this->variableCounters[$pageIndex][count($this->pages[$pageIndex]['groups']) - 1] = 1;

        // To point to this page 
        $this->setActivePage($pageIndex);

        // Set the new group as the active group
        $this->activeGroupIndex = count($this->pages[$pageIndex]['groups']) - 1;
        $this->activeVariableIndex = 0; // Set the first variable as active


    }

    public function setActiveGroup($pageIndex, $groupIndex)
    {
        // Ensure the group has at least one variable
        if (empty($this->pages[$pageIndex]['groups'][$groupIndex]['variables'])) {
            $this->pages[$pageIndex]['groups'][$groupIndex]['variables'][] = [
                'pv_name'       => __('panel.pv_name_holder'),
                'pv_question'   => '',
                'pv_type'       => 0,
                'pv_required'   => 1,
                'pv_details'    => '',
            ];
        }

        // Set the active group and variable
        $this->currentPageIndex = $pageIndex;
        $this->activeGroupIndex = $groupIndex;
        $this->activeVariableIndex = 0; // Set the first variable as active
    }

    // Method to remove a group
    public function removeGroup($pageIndex, $groupIndex)
    {
        if (isset($this->pages[$pageIndex]['groups'][$groupIndex])) {
            array_splice($this->pages[$pageIndex]['groups'], $groupIndex, 1);

            // Decrement the group counter for the page
            if (isset($this->groupCounters[$pageIndex])) {
                $this->groupCounters[$pageIndex]--;
            }


            // Adjust the activeGroupIndex if necessary
            if ($this->activeGroupIndex >= count($this->pages[$pageIndex]['groups'])) {
                $this->activeGroupIndex = count($this->pages[$pageIndex]['groups']) - 1;
            }

            if ($this->activeGroupIndex < 0) {
                $this->activeGroupIndex = 0;
            }
        }
    }

    public function addVariable($pageIndex, $groupIndex)
    {
        // Initialize the variable counter for the group if it doesn't exist
        if (!isset($this->variableCounters[$pageIndex][$groupIndex])) {
            $this->variableCounters[$pageIndex][$groupIndex] = 0;
        }

        // Increment the variable counter for the group
        $this->variableCounters[$pageIndex][$groupIndex]++;


        $this->pages[$pageIndex]['groups'][$groupIndex]['variables'][] = [
            'pv_name' => __('panel.pv_name_holder') . ' ' . $this->variableCounters[$pageIndex][$groupIndex],
            'pv_question'       =>  '',
            'pv_type'           =>  0,
            'pv_required'       =>  1,
            'pv_details'        =>  '',
        ];

        $this->setActiveGroup($pageIndex, $groupIndex);
        // Set the new variable as the active variable
        $this->activeVariableIndex = count($this->pages[$pageIndex]['groups'][$groupIndex]['variables']) - 1;

        // Emit an event to initialize TinyMCE for the new variable
        $variableIndex = count($this->pages[$pageIndex]['groups'][$groupIndex]['variables']) - 1;
        $this->emit('initTinyMCE', $variableIndex);
    }


    // Method to remove a variable
    // public function removeVariable($pageIndex, $groupIndex, $variableIndex)
    // {
    //     if (isset($this->pages[$pageIndex]['groups'][$groupIndex]['variables'][$variableIndex])) {
    //         array_splice($this->pages[$pageIndex]['groups'][$groupIndex]['variables'], $variableIndex, 1);
    //     }

    // }

    // public function removeVariable($pageIndex, $groupIndex, $variableIndex)
    // {
    //     if (isset($this->pages[$pageIndex]['groups'][$groupIndex]['variables'][$variableIndex])) {
    //         // Remove the variable
    //         array_splice($this->pages[$pageIndex]['groups'][$groupIndex]['variables'], $variableIndex, 1);

    //         // Decrement the variable counter for the group
    //         if (isset($this->variableCounters[$pageIndex][$groupIndex])) {
    //             $this->variableCounters[$pageIndex][$groupIndex]--;
    //         }

    //         $this->setActiveGroup($pageIndex, $groupIndex);
    //         // Adjust the activeVariableIndex if necessary
    //         if ($this->activeVariableIndex >= count($this->pages[$pageIndex]['groups'][$groupIndex]['variables'])) {
    //             $this->activeVariableIndex = count($this->pages[$pageIndex]['groups'][$groupIndex]['variables']) - 1;
    //         }

    //         if ($this->activeVariableIndex < 0) {
    //             $this->activeVariableIndex = 0;
    //         }
    //     }
    // }

    // public function removeVariable($pageIndex, $groupIndex, $variableIndex)
    // {
    //     if (isset($this->pages[$pageIndex]['groups'][$groupIndex]['variables'][$variableIndex])) {
    //         // Remove the variable
    //         array_splice($this->pages[$pageIndex]['groups'][$groupIndex]['variables'], $variableIndex, 1);

    //         // Decrement the variable counter for the group
    //         if (isset($this->variableCounters[$pageIndex][$groupIndex])) {
    //             $this->variableCounters[$pageIndex][$groupIndex]--;
    //         }


    //         $this->activeGroupIndex = $groupIndex;

    //         // Adjust the activeVariableIndex if necessary
    //         if ($this->activeVariableIndex == $variableIndex) {
    //             // If the removed variable was the active one, set the active variable to the previous one
    //             if ($variableIndex > 0) {
    //                 $this->activeVariableIndex = $variableIndex - 1;
    //             } else {
    //                 // If there are no variables left, set it to 0
    //                 $this->activeVariableIndex = 0;
    //             }
    //         } elseif ($this->activeVariableIndex > $variableIndex) {
    //             // If the active variable was after the removed one, decrement its index
    //             $this->activeVariableIndex--;
    //         }

    //         // Ensure the activeVariableIndex is within bounds
    //         if ($this->activeVariableIndex >= count($this->pages[$pageIndex]['groups'][$groupIndex]['variables'])) {
    //             $this->activeVariableIndex = count($this->pages[$pageIndex]['groups'][$groupIndex]['variables']) - 1;
    //         }

    //         if ($this->activeVariableIndex < 0) {
    //             $this->activeVariableIndex = 0;
    //         }
    //     }
    // }

    public function removeVariable($pageIndex, $groupIndex, $variableIndex)
    {
        if (isset($this->pages[$pageIndex]['groups'][$groupIndex]['variables'][$variableIndex])) {
            // Remove the variable
            array_splice($this->pages[$pageIndex]['groups'][$groupIndex]['variables'], $variableIndex, 1);

            // Decrement the variable counter for the group
            if (isset($this->variableCounters[$pageIndex][$groupIndex])) {
                $this->variableCounters[$pageIndex][$groupIndex]--;
            }

            // Check if the removed variable is in the active group
            if ($this->currentPageIndex == $pageIndex && $this->activeGroupIndex == $groupIndex) {
                // Adjust the activeVariableIndex only if the removed variable is in the active group
                if ($this->activeVariableIndex == $variableIndex) {
                    // If the removed variable was the active one, set the active variable to the previous one
                    if ($variableIndex > 0) {
                        $this->activeVariableIndex = $variableIndex - 1;
                    } else {
                        // If there are no variables left, set it to 0
                        $this->activeVariableIndex = 0;
                    }
                } elseif ($this->activeVariableIndex > $variableIndex) {
                    // If the active variable was after the removed one, decrement its index
                    $this->activeVariableIndex--;
                }

                // Ensure the activeVariableIndex is within bounds
                $variableCount = count($this->pages[$pageIndex]['groups'][$groupIndex]['variables']);
                if ($this->activeVariableIndex >= $variableCount) {
                    $this->activeVariableIndex = $variableCount - 1;
                }

                if ($this->activeVariableIndex < 0) {
                    $this->activeVariableIndex = 0;
                }
            }
        }
    }






    public function validateStepThree()
    {
        $this->validate([
            'pages.*.doc_page_name'                     => 'required|string',
            'pages.*.doc_page_description'              => 'required|string',
            'pages.*.groups.*.pg_name'                  => 'required|string',
            'pages.*.groups.*.variables.*.pv_name'      => 'required|string',
            'pages.*.groups.*.variables.*.pv_question'  => 'required|string',
            'pages.*.groups.*.variables.*.pv_type'      => 'required|numeric',
            'pages.*.groups.*.variables.*.pv_required'  => 'required|boolean',
            'pages.*.groups.*.variables.*.pv_details'   => 'required|string',
        ], [], [
            'pages.*.doc_page_name'                     => __('panel.pages.*.doc_page_name'),
            'pages.*.doc_page_description'              => __('panel.pages.*.doc_page_description'),
            'pages.*.groups.*.pg_name'                  => __('panel.pages.*.groups.*.pg_name'),
            'pages.*.groups.*.variables.*.pv_name'      => __('panel.pages.*.groups.*.variables.*.pv_name'),
            'pages.*.groups.*.variables.*.pv_question'  => __('panel.pages.*.groups.*.variables.*.pv_question'),
            'pages.*.groups.*.variables.*.pv_type'      => __('panel.pages.*.groups.*.variables.*.pv_type'),
            'pages.*.groups.*.variables.*.pv_required'  => __('panel.pages.*.groups.*.variables.*.pv_required'),
            'pages.*.groups.*.variables.*.pv_details'   => __('panel.pages.*.groups.*.variables.*.pv_details'),
        ]);
    }



    public function saveStepThree()
    {
        // // Perform validation
        $this->validateStepThree();

        // Save the data to the database
        foreach ($this->pages as $page) {
            $pageData = [
                'doc_page_name'         => $page['doc_page_name'],
                'doc_page_description'  => $page['doc_page_description'],
                'document_template_id'  => $this->documentTemplateId,
            ];

            $pageModel = DocumentPage::updateOrCreate($pageData);

            foreach ($page['groups'] as $group) {
                $groupData = [
                    'pg_name'           => $group['pg_name'],
                    'document_page_id'  => $pageModel->id,
                ];

                $groupModel = PageGroup::updateOrCreate($groupData);

                foreach ($group['variables'] as $variable) {

                    $variableData = [
                        'pv_name'       => $variable['pv_name'],
                        'pv_question'   => $variable['pv_question'],
                        'pv_type'       => $variable['pv_type'],
                        'pv_required'   => $variable['pv_required'],
                        'pv_details'    => $variable['pv_details'],
                        'page_group_id' => $groupModel->id,
                    ];

                    PageVariable::updateOrCreate($variableData);
                }
            }
        }

        // Indicate that step three data is saved
        $this->stepData['step3'] = 'saved';
    }

    // for saving step3 using btn 
    public function saveStepThreeDataUsingBtn()
    {
        $this->saveStepThree();
        $this->currentStep++;
    }

    public function updateDocTemplateText() {}

    public function syncAndNextStep()
    {
        $this->emit('syncTinyMCE');
        $this->nextStep();
    }



    public function setActiveVariable($pageIndex, $groupIndex, $variableIndex)
    {
        $this->currentPageIndex = $pageIndex;
        $this->activeGroupIndex = $groupIndex;
        $this->activeVariableIndex = $variableIndex;
    }
}
