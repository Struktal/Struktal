<div class="p-4 bg-background-header text-font-header">
    <header class="flex justify-between items-center max-w-screen-xl m-auto">
        {{-- Logo --}}
        <div class="whitespace-nowrap">
            <a href="{{ Router->generate(Config::$APP_SETTINGS["APP_URL"]) }}"
               class="flex justify-start items-center"
            >
                <img src="{{ Router->staticFilePath("img/logo.svg") }}"
                     alt="Logo"
                     class="h-12 w-auto rounded"
                >
                <span class="ml-2 font-bold">
                    {{ Config::$APP_SETTINGS["APP_NAME"] }}
                </span>
            </a>
        </div>

        {{-- Open sidebar button --}}
        <button id="header-sidebar-open" class="cursor-pointer">
            <svg class="w-6 h-6 stroke-current"
                 viewBox="0 0 24 24"
                 xmlns="http://www.w3.org/2000/svg"
            >
                <path d="M3 12h18M3 6h18M3 18h18"></path>
            </svg>
        </button>

        @component("components.layout.sidebar")
            {{-- Account information --}}
            @include("components.layout.accountinfo")

            {{-- Sidebar navigation list --}}
            <nav>
                @include("components.layout.sidebarlist")
            </nav>
        @endcomponent
    </header>
</div>
