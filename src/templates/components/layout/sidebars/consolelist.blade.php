<ul class="flex flex-col gap-2">
    @component("components.layout.sidebars.consoleitem", [
        "href" => Router->generate("index"),
        "icon" => "components.icons.home",
        "active" => true
    ])
        {{ t("Home") }}
    @endcomponent

        @component("components.layout.sidebars.consoleitem", [
            "href" => Router->generate("index")
        ])
            {{ t("Home") }}
        @endcomponent

        @component("components.layout.sidebars.consoleitem", [
            "href" => Router->generate("index")
        ])
            {{ t("Home") }}
        @endcomponent

        @component("components.layout.sidebars.consoleitem", [
            "href" => Router->generate("index")
        ])
            {{ t("Home") }}
        @endcomponent
</ul>
