<ul>
    @component("components.layout.sidebars.landingitem", [
        "href" => Router->generate("index")
    ])
        {{ t("Home") }}
    @endcomponent
</ul>
