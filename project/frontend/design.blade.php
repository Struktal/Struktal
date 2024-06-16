@component("components.layout.appshell")
    <h1>
        Design
    </h1>

    <section>
        <h2>Buttons</h2>
        <div class="mb-2">
            <button class="{{ TailwindUtil::button() }}">Button primary</button>
            <button class="{{ TailwindUtil::button(true) }}">Button primary flat</button>
            <button class="{{ TailwindUtil::button() }}">
                @include("components.icons.more", ["class" => "w-4 h-4 fill-current"])
                Button primary with icon
            </button>
            <button class="{{ TailwindUtil::button() }}" disabled>Button primary disabled</button>
        </div>

        <div class="mb-2">
            <button class="{{ TailwindUtil::button(false, "secondary") }}">Button secondary</button>
            <button class="{{ TailwindUtil::button(true, "secondary") }}">Button secondary flat</button>
        </div>

        <div class="mb-2">
            <button class="{{ TailwindUtil::button(false, "gray") }}">Button gray</button>
            <button class="{{ TailwindUtil::button(true, "gray") }}">Button gray flat</button>
        </div>

        <div class="mb-2">
            <button class="{{ TailwindUtil::button(false, "danger") }}">Button danger</button>
            <button class="{{ TailwindUtil::button(true, "danger") }}">Button danger flat</button>
        </div>

        <div class="mb-2">
            <button class="{{ TailwindUtil::button(false, "warning") }}">Button warning</button>
            <button class="{{ TailwindUtil::button(true, "warning") }}">Button warning flat</button>
        </div>

        <div class="mb-2">
            <button class="{{ TailwindUtil::button(false, "safe") }}">Button success</button>
            <button class="{{ TailwindUtil::button(true, "safe") }}">Button success flat</button>
        </div>
    </section>
@endcomponent
