 <!------------- part 1 : Steps ------------->
 <div class="steps clearfix">
     <ul role="tablist">
         <li role="tab" wire:click="directMoveToStep(1)" class="first {{ $currentStep == 1 ? 'current' : '' }}"
             aria-disabled="false" aria-selected="true">
             <a id="wizard1-t-0" href="#wizard1-h-0" aria-controls="wizard1-p-0">
                 <span class="current-info audible">current step:
                 </span>
                 <span class="number">1</span>
                 <span class="title">
                     {{ __('panel.document_template_data') }}
                 </span>
             </a>
         </li>

         @isset($docData)
             @foreach ($docData as $key => $documentPage)
                 <li role="tab" wire:click="directMoveToStep({{ $key + 2 }})"
                     class="disabled {{ $currentStep == $key + 2 ? 'current' : '' }}" aria-disabled="true">
                     <a id="wizard1-t-{{ $key + 2 }}" href="#wizard1-h-1"
                         aria-controls="wizard1-p-{{ $key + 2 }}">
                         <span class="number">{{ $key + 2 }}</span>
                         <span class="title">
                             {!! Str::words($documentPage['doc_page_name'], 3, ' ...') !!}
                         </span>
                     </a>
                 </li>
             @endforeach
         @endisset

         @if ($chosen_template)
             @if (count($chosen_template->documentPages) > 0)
                 <li role="tab" wire:click="directMoveToStep({{ $totalSteps }})"
                     class="first {{ $currentStep == $totalSteps ? 'current' : '' }}" aria-disabled="false"
                     aria-selected="true">
                     <a id="wizard1-t-0" href="#wizard1-h-0" aria-controls="wizard1-p-0">
                         <span class="current-info audible">current step:
                         </span>
                         <span class="number">{{ $totalSteps }}</span>
                         <span class="title">
                             {{ __('panel.document_review') }}
                         </span>
                     </a>
                 </li>
             @endif
         @endif

     </ul>
 </div>
 <!------------- part 1 : Steps end ------------->
