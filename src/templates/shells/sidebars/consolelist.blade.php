<ul class="flex flex-col gap-2 p-4">
    @component("shells.sidebars.sidebaritem", [
        "href" => Router->generate("index"),
        "icon" => "icons.home",
        "active" => in_array(Router->getCalledRouteName(), [ "console" ])
    ])
        {{ t("Home") }}
    @endcomponent
</ul>
