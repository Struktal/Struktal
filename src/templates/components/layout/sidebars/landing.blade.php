{{-- Sidebar popup --}}
<aside class="absolute fixed z-200 top-0 right-0
              h-full w-screen sm:max-w-96
              p-6 bg-surface-100 border-l border-surface-500 transition-all translate-x-full"
       data-sidebar-active="false"
       data-sidebar-inactive-classes="translate-x-full">
    <div class="flex">
        {{-- Close sidebar button --}}
        <button class="ml-auto mr-0 cursor-pointer sidebar-toggle">
            @include("components.icons.close", [ "class" => "w-6 h-6" ])
        </button>
    </div>

    {{-- Content --}}
    {!! $slot !!}
</aside>

{{-- Sidebar background layer --}}
<div class="sidebar-toggle hidden absolute left-0 top-0 w-full h-full z-100 backdrop-blur"
     data-sidebar-inactive-classes="hidden"
></div>

<script type="module">
    import * as Sidebar from "{{ Router->staticFilePath("js/Sidebar.js") }}";
    Sidebar.init();
</script>
