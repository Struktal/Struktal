<div class="fixed top-0 w-full h-16 bg-background-header text-font-header">
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
            <div class="w-10 h-10 rounded-full bg-gray">
            </div>
        </div>
    </header>
</div>

@component("components.layout.sidebars.console")
    {{-- Sidebar navigation list --}}
    <nav>
        @include("components.layout.sidebars.consolelist")
    </nav>
@endcomponent
