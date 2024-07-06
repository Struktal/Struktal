@component("components.layout.authshell")
    <p class="mb-2">
        Don't have an account yet?
        <a class="text-primary hover:text-primary-effect cursor-pointer transition-all"
           href="{{ Router::generate("auth-register") }}">
            Click here to register.
        </a>
    </p>

    <form method="post" action="{{ Router::generate("auth-login-action") }}">
        <div class="{{ TailwindUtil::inputGroup() }} mb-2">
            <label class="{{ TailwindUtil::$inputLabel }}"
                   for="username"
                   data-required>
                Username
            </label>
            <input class="{{ TailwindUtil::$input }}"
                   type="text"
                   name="username"
                   id="username"
                   placeholder="Username"
                   required>
        </div>

        <div class="{{ TailwindUtil::inputGroup() }} mb-2">
            <label class="{{ TailwindUtil::$inputLabel }}"
                   for="password"
                   data-required>
                Password
            </label>
            <input class="{{ TailwindUtil::$input }}"
                   type="password"
                   name="password"
                   id="password"
                   placeholder="Password"
                   required>
        </div>

        <button class="{{ TailwindUtil::button(true) }} w-full mb-2">
            Log in
        </button>

        <a class="text-sm text-gray hover:text-gray-effect cursor-pointer transition-all"
           href="{{ Router::generate("auth-recovery-request") }}">
            Forgot password?
        </a>
    </form>
@endcomponent
