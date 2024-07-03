@component("components.layout.authshell")
    @foreach($messages as $message)
        <p class="mb-2">
            {{ $message }}
        </p>
    @endforeach

    @if(isset($showLogin) && $showLogin)
        <button class="{{ TailwindUtil::button() }}">
            Log in
        </button>
    @endif
@endcomponent
