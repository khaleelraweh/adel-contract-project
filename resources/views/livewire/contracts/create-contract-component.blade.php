<div>

    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            direction: rtl;
            text-align: right;
        }

        fieldset {
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 20px;
            padding: 15px;
        }

        legend {
            font-size: 1.2em;
            color: #333;
            font-weight: bold;
            width: fit-content;
            padding: 0 0.7rem;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            color: #555;
        }
    </style>

    <div class="mywizard">
        <div class="row">
            <div class="col-sm-4">
                <div class="steps clearfix">
                    <ul role="tablist">
                        <li role="tab" wire:click="directMoveToStep(1)"
                            class="first {{ $currentStep == 1 ? 'current' : '' }}" aria-disabled="false"
                            aria-selected="true">
                            <a id="wizard1-t-0" href="#wizard1-h-0" aria-controls="wizard1-p-0">
                                <span class="number">1</span>
                                <span class="title">{{ __('panel.contract_template_data') }}</span>
                            </a>
                        </li>

                        @isset($contractData)
                            @foreach ($contractData as $key => $contractVariable)
                                <li role="tab" wire:click="directMoveToStep({{ $key + 2 }})"
                                    class="disabled {{ $currentStep == $key + 2 ? 'current' : '' }}" aria-disabled="true">
                                    <a id="wizard1-t-{{ $key + 2 }}" href="#wizard1-h-1"
                                        aria-controls="wizard1-p-{{ $key + 2 }}">
                                        <span class="number">{{ $key + 2 }}</span>
                                        <span class="title">{!! Str::words($contractVariable['cv_name'], 3, ' ...') !!}</span>
                                    </a>
                                </li>
                            @endforeach
                        @endisset

                        @if ($chosen_template)
                            @if (count($chosen_template->contractVariables) > 0)
                                <li role="tab" wire:click="directMoveToStep({{ $totalSteps }})"
                                    class="first {{ $currentStep == $totalSteps ? 'current' : '' }}"
                                    aria-disabled="false" aria-selected="true">
                                    <a id="wizard1-t-0" href="#wizard1-h-0" aria-controls="wizard1-p-0">
                                        <span class="number">{{ $totalSteps }}</span>
                                        <span class="title">{{ __('panel.contract_review') }}</span>
                                    </a>
                                </li>
                            @endif
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-sm-8">
                <!------------- part 2 : Content ------------->
                <div class="mycontent">


                    <h3 id="wizard1-h-0" tabindex="-1" class="title {{ $currentStep == 1 ? 'current' : '' }} ">
                        {{ __('panel.contract_template_data') }}
                    </h3>

                    <section id="wizard1-p-0" role="tabpanel" aria-labelledby="wizard1-h-0"
                        class="body {{ $currentStep == 1 ? 'current' : '' }}  step"
                        aria-hidden="{{ $currentStep == 1 ? 'false' : 'true' }}"
                        style="display: {{ $currentStep == 1 ? 'block' : 'none' }}">

                        <form method="post">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-sm-12 col-md-12">

                                    <div class="row">
                                        <div class="col-sm-12 col-md-2 pt-3">
                                            <label for="contract_template_name">
                                                {{ __('panel.contract_template_name') }}
                                            </label>
                                        </div>
                                        <div class="col-sm-12 col-md-10 pt-3">
                                            <select class="form-control form-control-lg"
                                                wire:model="contract_template_id">
                                                <option value="">---</option>
                                                @forelse ($contract_templates as $contract_template)
                                                    <option value="{{ $contract_template->id }}">
                                                        {{ $contract_template->contract_template_name }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                            @error('contract_template_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-2 pt-3">
                                            <label for="contract_name">
                                                {{ __('panel.contract_name') }}
                                            </label>
                                        </div>
                                        <div class="col-sm-12 col-md-10 pt-3">
                                            <input type="text" id="contract_name" wire:model="contract_name"
                                                name="contract_name" value="{{ old('contract_name') }}"
                                                class="form-control" placeholder="">
                                            @error('contract_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-2 pt-3">
                                            <label for="contract_type_id">
                                                {{ __('panel.contract_type') }}
                                            </label>
                                        </div>
                                        <div class="col-sm-12 col-md-10 pt-3">
                                            <select name="contract_type_id" wire:model.defer="contract_type_id"
                                                class="form-control">
                                                <option value="">---</option>
                                                <option value="0"
                                                    {{ old('contract_type_id') == '0' ? 'selected' : null }}>
                                                    {{ __('panel.contract_type_inner') }}
                                                </option>
                                                <option value="1"
                                                    {{ old('contract_type_id') == '1' ? 'selected' : null }}>
                                                    {{ __('panel.contract_type_outer') }}
                                                </option>
                                            </select>
                                            @error('contract_type_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>


                                </div>


                            </div>
                        </form>
                    </section>

                    <!---- related to step 1 end ----->

                    <!---- related to dynamic steps --->
                    @isset($contractData)
                        @foreach ($contractData as $variableIndex => $contractVariable)
                            <h3 id="wizard1-h-0" tabindex="-1"
                                class="title {{ $currentStep == $variableIndex + 2 ? 'current' : '' }} ">
                                <div class="row align-items-end mb-4 mb-md-0">
                                    <div class="col-md mb-4 mb-md-0">
                                        <h4>{{ $contractVariable['cv_name'] }}</h4>
                                    </div>
                                    <div class="col-md-auto aos-init aos-animate" data-aos="fade-start">
                                    </div>
                                </div>
                            </h3>
                            <section id="wizard1-p-0" role="tabpanel" aria-labelledby="wizard1-h-0"
                                class="body {{ $currentStep == $variableIndex + 2 ? 'current' : '' }}  step"
                                aria-hidden="{{ $currentStep == $variableIndex + 2 ? 'false' : 'true' }}"
                                style="display: {{ $currentStep == $variableIndex + 2 ? 'block' : 'none' }}">
                                <form method="post">
                                    @csrf
                                    <div class="row" wire:ignore.self>
                                        <div class="col-sm-12 col-md-12">
                                            <fieldset>
                                                <div class="row">
                                                    <div class="col-sm-12 {{ $loop->first ? '' : 'pt-3' }} ">
                                                        <label for="{{ 'text_' . $contractVariable['cv_id'] }}">
                                                            {{ $contractVariable['cv_name'] }}:
                                                            (<small>{{ $contractVariable['cv_question'] }}</small>)
                                                        </label>
                                                        @switch($contractVariable['cv_type'])
                                                            @case(0)
                                                                <input type="text" name="{{ $contractVariable['cv_id'] }}"
                                                                    id="{{ 'text_' . $contractVariable['cv_id'] }}"
                                                                    wire:model.defer="contractData.{{ $variableIndex }}.cv_value"
                                                                    value="{{ $contractVariable['cv_value'] }}"
                                                                    class="form-control"
                                                                    {{ $contractVariable['cv_required'] == 0 ? '' : 'required' }}
                                                                    class="form-control">
                                                                <small>{{ $contractVariable['cv_details'] }}</small>
                                                                @error('contractData.' . $variableIndex . '.cv_value')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            @break

                                                            @case(1)
                                                                <input type="number" name="{{ $contractVariable['cv_id'] }}"
                                                                    id="{{ 'text_' . $contractVariable['cv_id'] }}"
                                                                    wire:model.defer="contractData.{{ $variableIndex }}.cv_value"
                                                                    value="{{ $contractVariable['cv_value'] }}"
                                                                    class="form-control"
                                                                    {{ $contractVariable['cv_required'] == 0 ? '' : 'required' }}
                                                                    class="form-control">
                                                                <small>{{ $contractVariable['cv_details'] }}</small>
                                                                @error('contractData.' . $variableIndex . '.cv_value')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            @break

                                                            @case(2)
                                                                <div class="input-group flatpickr" id="flatpickr-datetime"
                                                                    wire:ignore>
                                                                    <input type="text" name="published_on"
                                                                        wire:model.defer="contractData.{{ $variableIndex }}.cv_value"
                                                                        value="{{ $contractVariable['cv_value'] }}"
                                                                        class="form-control" placeholder="Select date" data-input
                                                                        readonly>
                                                                    <span class="input-group-text input-group-addon" data-toggle>
                                                                        <i data-feather="calendar"></i>
                                                                    </span>
                                                                </div>
                                                                @error('contractData.' . $variableIndex . '.cv_value')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            @break

                                                            @default
                                                        @endswitch
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </form>
                            </section>
                        @endforeach
                    @endisset

                    <script>
                        document.addEventListener('livewire:load', function() {
                            initializeFlatpickr();
                        });

                        document.addEventListener('livewire:update', function() {
                            initializeFlatpickr();
                        });

                        function initializeFlatpickr() {
                            const flatpickrElements = document.querySelectorAll('.flatpickr input');
                            flatpickrElements.forEach((el) => {
                                if (!el._flatpickr) {
                                    flatpickr(el, {
                                        enableTime: true,
                                        dateFormat: "Y-m-d H:i",
                                        onChange: function(selectedDates, dateStr) {
                                            el.dispatchEvent(new Event('input'));
                                        },
                                    });
                                }
                            });
                        }
                    </script>

                    <!---- end related to dynamic steps --->

                    <!------ review step ----->
                    @if ($chosen_template)
                        @if (count($chosen_template->contractVariables) > 0)
                            <h3 id="wizard1-h-0" tabindex="-1"
                                class="title {{ $currentStep == $totalSteps ? 'current' : '' }} ">
                                {{ __('panel.contract_review') }}
                            </h3>
                            <section id="wizard1-p-0" role="tabpanel" aria-labelledby="wizard1-h-0"
                                class="body {{ $currentStep == $totalSteps ? 'current' : '' }}  step"
                                aria-hidden="{{ $currentStep == $totalSteps ? 'false' : 'true' }}"
                                style="display: {{ $currentStep == $totalSteps ? 'block' : 'none' }}">

                                @isset($contract)
                                    <div class="row row-sm ">
                                        <div class="col-xl-12">
                                            <div class="card">
                                                <div class="card-header pb-0">
                                                    <div class="d-flex justify-content-between">
                                                        <h4 class="card-title mg-b-0">
                                                            <i class="fa fa-plus-square me-3 "
                                                                style="font-size: 20px;"></i>
                                                            {{ __('panel.show_contracts') }}
                                                        </h4>
                                                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <tr>
                                                                <th>{{ __('panel.contract_name') }}</th>
                                                                <td>{{ $contract->contract_name }}</td>
                                                                <th>{{ __('panel.contract_number') }}</th>
                                                                <td>{{ $contract->contract_no ?? '-' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>{{ __('panel.contract_type') }}</th>
                                                                <td>{{ $contract->contract_type() }}</td>
                                                                <th>{{ __('panel.created_at') }}</th>
                                                                <td>{{ $contract->created_at }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>{{ __('panel.contract_status') }}</th>
                                                                <td>{{ $contract->contract_status() }}</td>
                                                                <th>{{ __('panel.contract_file') }}</th>
                                                                <td>{{ $contract->contract_file ?? '-' }} </td>
                                                            </tr>

                                                        </table>

                                                        <h3>{{ __('panel.contract_text') }}</h3>
                                                        <div class="card">
                                                            <div class="card-body">
                                                                {!! $viewText !!}
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                @endisset

                                {{-- end new part review Document --}}

                            </section>
                        @endif
                    @endif

                    <!------ end review step ----->

                </div>
                <!------------- part 2 : Content end ------------->

            </div>
        </div>




        <div class="actions clearfix">
            <ul role="menu" aria-label="Pagination">
                <li class="{{ $currentStep == 1 ? 'disabled' : '' }}"
                    aria-disabled="{{ $currentStep == 1 ? 'true' : 'false' }}">
                    <a href="#previous" wire:click="previousStep" role="menuitem" class="nav-button prev-button">
                        {{ __('panel.previous') }}
                    </a>
                </li>
                <li aria-hidden="false" aria-disabled="false"
                    style="display: {{ $currentStep == $totalSteps ? 'none' : 'block' }}">
                    <a href="#next" wire:click="nextStep" role="menuitem" class="nav-button next-button">
                        التالي
                    </a>
                </li>
                <li aria-hidden="true" style="display: {{ $currentStep == $totalSteps ? 'block' : 'none' }}">
                    <a href="#finish" wire:click="finish" role="menuitem" class="nav-button finish-button">
                        {{ __('panel.finish') }}
                    </a>
                </li>
            </ul>
        </div>
    </div>

</div>
