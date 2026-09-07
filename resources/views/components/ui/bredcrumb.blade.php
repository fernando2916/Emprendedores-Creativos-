{{-- <div> --}}
    <nav class="flex my-5" aria-label="Breadcrumb">
     <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
 
         @foreach($items as $index => $item)
             @php
                 $isLast = $index === count($items) - 1;
             @endphp
 
             @if($index === 0)
                 <li class="inline-flex items-center">
                     @if(!$isLast)
                         <a @if(!empty($item['navigate'])) wire:navigate @endif 
                            href="{{ $item['url'] }}" 
                            class="inline-flex items-center font-medium hover:text-link-100">
                             @if(!empty($item['icon']))
                                 <i class="{{ $item['icon'] }} text-lg p-1"></i>
                             @endif
                             {{ $item['label'] }}
                         </a>
                     @else
                         <span class="inline-flex items-center text-sm font-medium text-gray-400">
                             @if(!empty($item['icon']))
                                 <i class="{{ $item['icon'] }} text-lg p-1"></i>
                             @endif
                             {{ $item['label'] }}
                         </span>
                     @endif
                 </li>
             @else
                 <li>
                     <div class="flex items-center">
                         <svg class="w-3 h-3 text-gray-400 mx-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                             <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                         </svg>
 
                         @if(!$isLast)
                             <a @if(!empty($item['navigate'])) wire:navigate @endif 
                                href="{{ $item['url'] }}" 
                                class="ms-1 font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">
                                 {{ $item['label'] }}
                             </a>
                         @else
                             <span class="ms-1 text-sm font-medium text-gray-400 md:ms-2 dark:text-gray-400">
                                 {{ $item['label'] }}
                             </span>
                         @endif
                     </div>
                 </li>
             @endif
 
         @endforeach
 
     </ol>
 </nav>
 
 {{-- </div> --}}