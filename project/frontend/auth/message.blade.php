@component("components.layout.authshell")
    @foreach($messages as $message)
        <p class="mb-2">
            {{ $message }}
        </p>
    @endforeach

    @if(isset($showLogin) && $showLogin)
        <a class="{{ TailwindUtil::button() }}"
           href="{{ Router::generate("auth-login") }}">
            Log in
        </a>
    @endif
@endcomponent
