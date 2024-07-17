<x-layouts.auth>
    <div class="relative flex h-screen flex-col justify-center overflow-hidden">
        <div
            class="m-auto w-full rounded-md bg-white p-6 shadow-md lg:max-w-lg">
            <h1 class="text-center text-3xl font-semibold text-primary">
                DaisyUI
            </h1>
            <form
                class="space-y-4"
                method="POST"
                action="{{ route("login") }}">
                @csrf
                <div>
                    <label class="label">
                        <span class="label-text text-base">
                            {{ __("Email") }}
                        </span>
                    </label>
                    <input
                        id="email"
                        type="text"
                        class="@error("email") @enderror input input-primary w-full !border !border-red-500 !outline-0"
                        placeholder="{{ __("Type your email") }}"
                        value="{{ old("email") }}"
                        name="email"
                        autofocus />
                    <x-forms.input-error
                        :messages="$errors->get('email')"
                        class="mt-2" />
                </div>
                <div>
                    <label class="label">
                        <span class="label-text text-base">Password</span>
                    </label>
                    <input
                        id="password"
                        type="password"
                        placeholder="Enter Password"
                        class="input input-bordered input-primary w-full"
                        name="password"
                        autocomplete="current-password" />
                    <x-forms.input-error
                        :messages="$errors->get('password')"
                        class="mt-2" />
                </div>
                <a
                    href="{{ route("password.request") }}"
                    class="text-xs text-gray-600 hover:text-blue-600 hover:underline">
                    {{ __("Forgot your password?") }}
                </a>
                <div>
                    <button class="btn btn-primary">
                        {{ __("Sign In") }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.auth>
