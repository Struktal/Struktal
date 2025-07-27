{{-- Sidebar popup --}}
<div class="header-sidebar-popup hidden absolute z-200 top-0 right-0 h-full
            w-screen sm:max-w-screen-sm
            p-6 bg-background-header border-l border-gray translate-x-full transition-all">
    <div class="flex">
        {{-- Close sidebar button --}}
        <button class="ml-auto mr-0 cursor-pointer" id="header-sidebar-close">
            <svg class="w-6 h-6 stroke-current"
                 viewBox="0 0 24 24"
                 xmlns="http://www.w3.org/2000/svg"
            >
                <path d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    {{-- Content --}}
    {!! $slot !!}
</div>

{{-- Sidebar background layer --}}
<div class="header-sidebar-background hidden absolute left-0 top-0 w-full h-full z-100 backdrop-blur"></div>

<script type="module">
    import * as Sidebar from "{{ Router->staticFilePath("js/Sidebar.js") }}";
    Sidebar.init();
</script>
