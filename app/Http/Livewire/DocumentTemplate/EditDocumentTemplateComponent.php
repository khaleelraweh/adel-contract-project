<?php

namespace App\Http\Livewire\DocumentTemplate;

use App\Models\DocumentTemplate;
use App\Models\DocumentCategory;
use App\Models\DocumentPage;
use App\Models\DocumentType;
use App\Models\PageGroup;
use App\Models\PageVariable;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class EditDocumentTemplateComponent extends Component
{
    use LivewireAlert;

    public $currentStep = 1;
    public $totalSteps = 4;

    // Document categories and types
    public $document_categories;
    public $document_types = [];

    // Step 1: Document template data
    public $document_category_id;
    public $document_type_id;
    public $doc_template_name;
    public $language;
    public $published_on;
    public $status = 1;

    // Step 2: Document template text
    public $documentTemplateId;
    public $doc_template_text;

    // Step 3: Pages, groups, and variables
    public $pages = [];
    public $count = 1;
    public $currentPageIndex = 0;
    public $activeGroupIndex = 0;
    public $activeVariableIndex = 0;

    public $groupCounters = [];
    public $variableCounters = [];

    public $stepData = [
        'step1' => '',
        'step2' => '',
        'step3' => '',
        'step4' => '',
    ];

    public $documentTemplate;

    // public function mount($documentTemplate)
    // {
    //     $this->documentTemplate = $documentTemplate;
    //     $this->documentTemplateId = $documentTemplate->id;

    //     // Load existing data into the component
    //     $this->document_category_id = $documentTemplate->document_category_id;
    //     $this->document_type_id = $documentTemplate->document_type_id;
    //     $this->doc_template_name = $documentTemplate->doc_template_name;
    //     $this->language = $documentTemplate->language;
    //     $this->published_on = $documentTemplate->published_on;
    //     $this->status = $documentTemplate->status;
    //     $this->doc_template_text = $documentTemplate->doc_template_text;

    //     // Load pages, groups, and variables
    //     foreach ($documentTemplate->documentPages as $page) {
    //         $pageData = [
    //             'pageId' => $page->id,
    //             'doc_page_name' => $page->doc_page_name,
    //             'doc_page_description' => $page->doc_page_description,
    //             'groups' => [],
    //             'saved' => true,
    //         ];

    //         foreach ($page->pageGroups as $group) {
    //             $groupData = [
    //                 'pg_name' => $group->pg_name,
    //                 'variables' => [],
    //             ];

    //             foreach ($group->pageVariables as $variable) {
    //                 $groupData['variables'][] = [
    //                     'pv_name' => $variable->pv_name,
    //                     'pv_question' => $variable->pv_question,
    //                     'pv_type' => $variable->pv_type,
    //                     'pv_required' => $variable->pv_required,
    //                     'pv_details' => $variable->pv_details,
    //                 ];
    //             }

    //             $pageData['groups'][] = $groupData;
    //         }

    //         $this->pages[] = $pageData;
    //     }

    //     // Initialize counters
    //     $this->count = count($this->pages);
    //     $this->groupCounters = array_fill(0, $this->count, 1);
    //     $this->variableCounters = array_fill(0, $this->count, [1]);
    // }

    public function mount($documentTemplate)
    {
        $this->documentTemplate = $documentTemplate;
        $this->documentTemplateId = $documentTemplate->id;

        // Load existing data into the component
        $this->document_category_id = $documentTemplate->document_category_id;
        $this->document_type_id = $documentTemplate->document_type_id;
        $this->doc_template_name = $documentTemplate->doc_template_name;
        $this->language = $documentTemplate->language;
        $this->published_on = $documentTemplate->published_on;
        $this->status = $documentTemplate->status;
        $this->doc_template_text = $documentTemplate->doc_template_text;

        // Load pages, groups, and variables
        foreach ($documentTemplate->documentPages as $page) {
            $pageData = [
                'pageId' => $page->id,
                'doc_page_name' => $page->doc_page_name,
                'doc_page_description' => $page->doc_page_description,
                'groups' => [],
                'saved' => true,
            ];

            foreach ($page->pageGroups as $group) {
                $groupData = [
                    'id' => $group->id, // Add group ID
                    'pg_name' => $group->pg_name,
                    'variables' => [],
                ];

                foreach ($group->pageVariables as $variable) {
                    $groupData['variables'][] = [
                        'id' => $variable->id, // Add variable ID
                        'pv_name' => $variable->pv_name,
                        'pv_question' => $variable->pv_question,
                        'pv_type' => $variable->pv_type,
                        'pv_required' => $variable->pv_required,
                        'pv_details' => $variable->pv_details,
                    ];
                }

                $pageData['groups'][] = $groupData;
            }

            $this->pages[] = $pageData;
        }

        // Initialize counters
        $this->count = count($this->pages);
        $this->groupCounters = array_fill(0, $this->count, 1);
        $this->variableCounters = array_fill(0, $this->count, [1]);
    }



    public function render()
    {
        $this->document_categories = DocumentCategory::whereStatus(true)->get();
        $this->document_types = $this->document_category_id != '' ? DocumentType::whereStatus(true)->whereDocumentCategoryId($this->document_category_id)->get() : [];
        return view('livewire.document-template.edit-document-template-component', [
            'document_categories' => $this->document_categories,
            'document_types' => $this->document_types,
            'documentTemplate' => $this->documentTemplate,

        ]);
    }

    // Reuse methods from CreateDocumentTemplateComponent
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
            ]);
        } elseif ($this->currentStep == 2) {
            $this->validate([
                'doc_template_text' => 'required',
            ]);
        } elseif ($this->currentStep == 3) {
            $this->validateStepThree();
        } elseif ($this->currentStep == 4) {
            $this->validate([
                'doc_template_text' => 'required',
            ]);
        }
    }

    public function saveStepData()
    {
        if ($this->currentStep == 1) {
            DocumentTemplate::updateOrCreate(
                ['id' => $this->documentTemplateId],
                [
                    'document_category_id'  => $this->document_category_id,
                    'document_type_id'      => $this->document_type_id,
                    'doc_template_name'     => $this->doc_template_name,
                    'language'              => $this->language,
                    'published_on'          => $this->published_on,
                    'status'                => $this->status,
                    'updated_by'            => auth()->user()->full_name,
                ]
            );
            $this->alert('success', __('panel.document_template_data_saved'));
        } elseif ($this->currentStep == 2) {
            DocumentTemplate::updateOrCreate(
                ['id' => $this->documentTemplateId],
                [
                    'doc_template_text'     => $this->doc_template_text,
                ]
            );
            $this->alert('success', __('panel.document_template_text_saved'));
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

    // public function saveStepThree()
    // {
    //     $this->validateStepThree();

    //     foreach ($this->pages as $page) {
    //         $pageData = [
    //             'doc_page_name'         => $page['doc_page_name'],
    //             'doc_page_description'  => $page['doc_page_description'],
    //             'document_template_id'  => $this->documentTemplateId,
    //         ];

    //         $pageModel = DocumentPage::updateOrCreate(['id' => $page['pageId']], $pageData);

    //         foreach ($page['groups'] as $group) {
    //             $groupData = [
    //                 'pg_name'           => $group['pg_name'],
    //                 'document_page_id'  => $pageModel->id,
    //             ];

    //             $groupModel = PageGroup::updateOrCreate(['id' => $group['id'] ?? null], $groupData);

    //             foreach ($group['variables'] as $variable) {
    //                 $variableData = [
    //                     'pv_name'       => $variable['pv_name'],
    //                     'pv_question'   => $variable['pv_question'],
    //                     'pv_type'       => $variable['pv_type'],
    //                     'pv_required'   => $variable['pv_required'],
    //                     'pv_details'    => $variable['pv_details'],
    //                     'page_group_id' => $groupModel->id,
    //                 ];

    //                 PageVariable::updateOrCreate(['id' => $variable['id'] ?? null], $variableData);
    //             }
    //         }
    //     }

    //     $this->stepData['step3'] = 'saved';
    // }

    // public function saveStepThree()
    // {
    //     $this->validateStepThree();

    //     foreach ($this->pages as $page) {
    //         // Update or create the page
    //         $pageData = [
    //             'doc_page_name'         => $page['doc_page_name'],
    //             'doc_page_description'  => $page['doc_page_description'],
    //             'document_template_id'  => $this->documentTemplateId,
    //         ];

    //         // Use the page ID to update or create the page
    //         $pageModel = DocumentPage::updateOrCreate(
    //             ['id' => $page['pageId'] ?? null], // Use the page ID to find the existing record
    //             $pageData
    //         );

    //         foreach ($page['groups'] as $group) {
    //             // Update or create the group
    //             $groupData = [
    //                 'pg_name'           => $group['pg_name'],
    //                 'document_page_id'  => $pageModel->id,
    //             ];

    //             // Use the group ID to update or create the group
    //             $groupModel = PageGroup::updateOrCreate(
    //                 ['id' => $group['id'] ?? null], // Use the group ID to find the existing record
    //                 $groupData
    //             );

    //             foreach ($group['variables'] as $variable) {
    //                 // Update or create the variable
    //                 $variableData = [
    //                     'pv_name'       => $variable['pv_name'],
    //                     'pv_question'   => $variable['pv_question'],
    //                     'pv_type'       => $variable['pv_type'],
    //                     'pv_required'   => $variable['pv_required'],
    //                     'pv_details'    => $variable['pv_details'],
    //                     'page_group_id' => $groupModel->id,
    //                 ];

    //                 // Use the variable ID to update or create the variable
    //                 PageVariable::updateOrCreate(
    //                     ['id' => $variable['id'] ?? null], // Use the variable ID to find the existing record
    //                     $variableData
    //                 );
    //             }
    //         }
    //     }

    //     $this->stepData['step3'] = 'saved';
    // }

    public function saveStepThree()
    {
        $this->validateStepThree();

        foreach ($this->pages as $page) {
            // Update or create the page
            $pageData = [
                'doc_page_name'         => $page['doc_page_name'],
                'doc_page_description'  => $page['doc_page_description'],
                'document_template_id'  => $this->documentTemplateId,
            ];

            // Use the page ID to update or create the page
            $pageModel = DocumentPage::updateOrCreate(
                ['id' => $page['pageId'] ?? null], // Use the page ID to find the existing record
                $pageData
            );

            foreach ($page['groups'] as $group) {
                // Update or create the group
                $groupData = [
                    'pg_name'           => $group['pg_name'],
                    'document_page_id'  => $pageModel->id,
                ];

                // Use the group ID to update or create the group
                $groupModel = PageGroup::updateOrCreate(
                    ['id' => $group['id'] ?? null], // Use the group ID to find the existing record
                    $groupData
                );

                foreach ($group['variables'] as $variable) {
                    // Update or create the variable
                    $variableData = [
                        'pv_name'       => $variable['pv_name'],
                        'pv_question'   => $variable['pv_question'],
                        'pv_type'       => $variable['pv_type'],
                        'pv_required'   => $variable['pv_required'],
                        'pv_details'    => $variable['pv_details'],
                        'page_group_id' => $groupModel->id,
                    ];

                    // Use the variable ID to update or create the variable
                    PageVariable::updateOrCreate(
                        ['id' => $variable['id'] ?? null], // Use the variable ID to find the existing record
                        $variableData
                    );
                }
            }
        }

        $this->stepData['step3'] = 'saved';
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
        ]);
    }

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

    public function setActiveVariable($pageIndex, $groupIndex, $variableIndex)
    {
        $this->currentPageIndex = $pageIndex;
        $this->activeGroupIndex = $groupIndex;
        $this->activeVariableIndex = $variableIndex;
    }
}
