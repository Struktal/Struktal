<ul class="flex flex-col gap-2">
    @component("components.layout.sidebars.consoleitem", [
        "href" => Router->generate("index"),
        "icon" => "components.icons.home",
        "active" => in_array(Router->getCalledRouteName(), [ "console" ])
    ])
        {{ t("Home") }}
    @endcomponent
</ul>
