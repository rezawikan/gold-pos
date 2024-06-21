<x-layouts.guest>
    <div class="auth-box h-full flex flex-col justify-center">
        <div class="mobile-logo text-center mb-6 lg:hidden flex justify-center">
            <div class="mb-10 inline-flex items-center justify-center">
                <x-application-logo/>
                <span class="ltr:ml-3 rtl:mr-3 text-xl font-Inter font-bold text-slate-900 dark:text-white">DashCode</span>
            </div>
        </div>
        <div class="text-center 2xl:mb-10 mb-4">
            <h4 class="font-medium"> {{ __('Sign in') }}</h4>
            <div class="text-slate-500 text-base">
                {{ __('Sign in to your account to start using Dashcode') }}
            </div>
        </div>

        <!-- START::LOGIN FORM -->
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
            {{-- Email --}}
            <div class="fromGroup">
                <label for="email" class="block capitalize form-label">{{ __('Email') }}</label>
                <div class="relative ">
                    <input type="email" name="email" id="email"
                           class="form-control py-2 @error('email') !border !border-red-500 @enderror"
                           placeholder="{{ __('Type your email') }}" autofocus
                           value="{{ old('email') }}">
                    <x-form.input-error :messages="$errors->get('email')" class="mt-2"/>
                </div>
            </div>

            {{-- Password --}}
            <div class="fromGroup">
                <label for="password" class="block capitalize form-label">{{ __('Password') }}</label>
                <div class="relative ">
                    <input type="password" name="password"
                           class="form-control py-2 @error('password') !border !border-red-500 @enderror"
                           placeholder="{{ __('Password') }}" id="password" autocomplete="current-password">
                    <x-form.input-error :messages="$errors->get('password')" class="mt-2"/>
                </div>
            </div>


            {{-- Remember Me checkbox --}}
            <div class="flex justify-between">
                <div class="checkbox-area">
                    <label class="inline-flex items-center cursor-pointer" for="remember_me">
                        <input type="checkbox" class="hidden" name="remember" id="remember_me">
                        <span class="h-4 w-4 border flex-none border-slate-100 dark:border-slate-800 rounded inline-flex ltr:mr-3 rtl:ml-3 relative transition-all duration-150 bg-slate-100 dark:bg-slate-900">
                    <img src="{{ Vite::asset('resources/assets/images/icon/ck-white.svg') }}" alt=""
                         class="h-[10px] w-[10px] block m-auto opacity-0"></span>
                        <span class="text-slate-500 dark:text-slate-400 text-sm leading-6">{{ __('Keep me signed in') }}</span>
                    </label>
                </div>
                <a href="{{ route('password.request') }}"
                   class="text-sm text-slate-800 dark:text-slate-400 leading-6 font-medium">
                    {{ __('Forgot your password?') }}
                </a>
            </div>

            <button type="submit"
                    class="btn btn-dark block w-full text-center">
                {{ __('Sign In') }}
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

        <div class="md:max-w-[345px] mx-auto font-normal text-slate-500 dark:text-slate-400 mt-12 uppercase text-sm">
            {{ __('Don\'t have an account?') }}
            <a href="{{ route('register') }}" class="text-slate-900 dark:text-white font-medium hover:underline">
                {{ __('Sign Up') }}
            </a>
        </div>
    </div>
</x-layouts.guest>