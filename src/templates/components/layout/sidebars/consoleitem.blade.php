<li class="w-full">
    <a href="{{ $href }}" class="flex items-center p-2 gap-4 rounded hover:bg-gray-light transition-colors hover:bg-gray-light @if(isset($active) && $active) bg-gray-light font-bold @endif">
        @if(isset($icon))
            @include($icon)
        @endif

        <span class="truncate">
            {!! $slot !!}
        </span>
    </a>
</li>
