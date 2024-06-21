<x-layouts.guest>
    <div class="auth-box h-full flex flex-col justify-center">
        <div class="mobile-logo text-center mb-6 lg:hidden flex justify-center">
            <div class="mb-10 inline-flex items-center justify-center">
                <x-application-logo/>
                <span class="ltr:ml-3 rtl:mr-3 text-xl font-Inter font-bold text-slate-900 dark:text-white">DashCode</span>
            </div>
        </div>
        <div class="text-center 2xl:mb-10 mb-4">
            <h4 class="font-medium">{{ __('Sign Up') }}</h4>
            <div class="text-slate-500 text-base">
                {{ __('Create account to start using Dashcode') }}
            </div>
        </div>

        <!-- START::LOGIN FORM -->
        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            {{-- Name --}}
            <div class="fromGroup">
                <label for="name" class="block capitalize form-label">
                    {{ __('Name') }}
                </label>
                <input type="text" name="name" id="name"
                       class="form-control py-2 @error('name') !border !border-red-500 @enderror"
                       placeholder="{{ __('Type your full name') }}" required autofocus value="{{ old('name') }}">
                <x-form.input-error :messages="$errors->get('name')" class="mt-2"/>
            </div>

            {{-- Email --}}
            <div class="fromGroup">
                <label for="email" class="block capitalize form-label">
                    {{ __('Email') }}
                </label>
                <input type="email" name="email" id="email"
                       class="form-control py-2 @error('email') !border !border-red-500 @enderror"
                       placeholder="{{ __('Type your email') }}" required value="{{ old('email') }}">
                <x-form.input-error :messages="$errors->get('email')" class="mt-2"/>
            </div>

            {{-- Password --}}
            <div class="fromGroup">
                <label for="password" class="block capitalize form-label">
                    {{ __('Password') }}
                </label>
                <input type="password" name="password" id="password"
                       class="form-control py-2 @error('password') !border !border-red-500 @enderror"
                       placeholder="{{ __('Password') }}" required autocomplete="new-password">
                <x-form.input-error :messages="$errors->get('password')" class="mt-2"/>
            </div>

            {{-- Confirm Password --}}
            <div class="fromGroup">
                <label for="password_confirmation" class="block capitalize form-label">
                    {{ __('Confirm Password') }}
                </label>
                <input type="password" name="password_confirmation"
                       id="password_confirmation"
                       class="form-control py-2 @error('password_confirmation') !border !border-red-500 @enderror"
                       placeholder="{{ __('Confirm Password') }}" required autocomplete="password_confirmation">
                <x-form.input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
            </div>

            {{-- Terms & Condition Checkbox --}}
            <div class="flex justify-between">
                <div class="checkbox-area">
                    <label class="inline-flex items-center cursor-pointer" for="checkbox">
                        <input type="checkbox" class="hidden" name="terms" id="checkbox" required>
                        <span class="h-4 w-4 border flex-none border-slate-100 dark:border-slate-800 rounded inline-flex ltr:mr-3 rtl:ml-3 relative transition-all duration-150 bg-slate-100 dark:bg-slate-900">
                    <img src="/images/icon/ck-white.svg" alt="" class="h-[10px] w-[10px] block m-auto opacity-0"></span>
                        <span class="text-slate-500 dark:text-slate-400 text-sm leading-6">{{ __('You accept our Terms and Conditions and Privacy Policy') }}</span>
                    </label>
                </div>
                <x-form.input-error :messages="$errors->get('terms')" class="mt-2"/>
            </div>

            <button type="submit" class="btn btn-dark block w-full text-center">
                {{ __('Create an account') }}
            </button>
        </form>

        <!-- END::LOGIN FORM -->

        <div class="relative border-b-[#9AA2AF] border-opacity-[16%] border-b pt-6">
            <div class="absolute inline-block bg-white dark:bg-slate-800 dark:text-slate-400 left-1/2 top-1/2 transform -translate-x-1/2
                    px-4 min-w-max text-sm text-slate-500 font-normal">
                {{ __('Or continue with') }}
            </div>
        </div>
        <div class="max-w-[242px] mx-auto mt-8 w-full">
            <x-social-login></x-social-login>
        </div>
        <div class="md:max-w-[345px] mx-auto font-normal text-slate-500 dark:text-slate-400 mt-8 uppercase text-sm">
            <span> {{ __('ALREADY REGISTERED?') }}</span>
            <a href="{{ route('login') }}" class="text-slate-900 dark:text-white font-medium hover:underline">
                {{ __('Sign In') }}
            </a>
        </div>
    </div>
</x-layouts.guest>