<div class="fixed top-0 w-full h-16 bg-surface-100">
    <header class="flex justify-between items-center h-full px-4 shadow">
        <div class="flex items-center">
            {{-- Open sidebar button --}}
            <button class="cursor-pointer sidebar-toggle">
                @include("components.icons.menu", [ "class" => "w-6 h-6" ])
            </button>

            {{-- Logo --}}
            <a href="{{ Router->generate(Config::$APP_SETTINGS["APP_URL"]) }}" class="ml-2 font-bold">
                {{ Config::$APP_SETTINGS["APP_NAME"] }}
            </a>
        </div>

        <div class="">
            <div class="w-10 h-10 rounded-full bg-surface-500">
            </div>
        </div>
    </header>
</div>

@component("components.layout.sidebars.console")
    {{-- Sidebar navigation list --}}
    <nav>
        @include("components.layout.sidebars.consolelist")
    </nav>

    <div class="absolute bottom-0 left-0 w-full bg-surface-200">
        asdf
    </div>
@endcomponent
