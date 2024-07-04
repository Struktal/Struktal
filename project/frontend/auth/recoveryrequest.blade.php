@component("components.layout.authshell")
    <p class="mb-2">
        Please enter your accounts verified email address below. You will then receive an email with instructions about how to recover your password.
    </p>

    <form method="post" action="{{ Router::generate("auth-recovery-request-action") }}">
        <div class="{{ TailwindUtil::inputGroup() }} mb-2">
            <label class="{{ TailwindUtil::$inputLabel }}"
                   for="email"
                   data-required>
                Email
            </label>
            <input class="{{ TailwindUtil::$input }}"
                   type="email"
                   name="email"
                   id="email"
                   placeholder="Email"
                   required>
        </div>

        <button class="{{ TailwindUtil::button(true) }} w-full mb-2">
            Send instructions
        </button>

        <a class="text-sm text-gray"
           href="{{ Router::generate("auth-login") }}">
            Log in instead?
        </a>
    </form>
@endcomponent
