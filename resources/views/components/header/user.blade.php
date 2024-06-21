<!-- Dropdown -->
<div class="md:block hidden w-full leading-0 relative" data-twe-dropdown-ref>
    <button
            id="dropdownMenuUser"
            data-twe-dropdown-toggle-ref
            aria-expanded="false"
            data-twe-ripple-init
            class="text-slate-800 dark:text-white focus:ring-0 focus:outline-none font-medium rounded-lg text-sm text-center
        inline-flex items-center"
            type="button">
        <div class="lg:h-8 lg:w-8 h-7 w-7 rounded-full flex-1 ltr:mr-[10px] rtl:ml-[10px]">
            <img class="block w-full h-full object-cover rounded-full" src="#" alt="user"/>
        </div>
        <div class="ltr:text-left rtl:text-right">
            <span
                    class="flex-none text-slate-600 dark:text-white text-sm font-normal items-center lg:flex hidden overflow-hidden text-ellipsis whitespace-nowrap">
                asdasd
{{--                {{ Str::limit(Auth::user()->name, 20) }}--}}
            </span>
            <!-- <small class="text-[9px] block"></small> -->
        </div>
        <svg class="w-[16px] h-[16px] dark:text-white lg:inline-block text-base inline-block ml-[10px] rtl:mr-[10px]"
             aria-hidden="true" fill="none" stroke="currentColor" viewbox="0 0 24 24"
             xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>
    <!-- Dropdown menu -->
    <div class="dropdown-menu hidden z-10 bg-white divide-y divide-slate-100 shadow w-44 dark:bg-slate-800 border dark:border-slate-700 !top-[23px] rounded-md overflow-hidden data-[twe-dropdown-show]:block"
         aria-labelledby="dropdownMenuUser"
         data-twe-dropdown-menu-ref>
        <ul class="py-1 text-sm text-slate-800 dark:text-slate-200">
            <li>
                <a href="#" class="flex items-center px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-600 dark:hover:text-wh`ite font-inter text-sm text-slate-600
                              dark:text-white font-normal"
                   @class(['country-list', 'active']) data-twe-dropdown-item-ref>
                    <iconify-icon class="text-lg text-textColor dark:text-white mr-2" icon="carbon:user-avatar">
                    </iconify-icon>
                    <span class="dropdown-option">@lang('Profile') </span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-600 dark:hover:text-white font-inter text-sm text-slate-600
                              dark:text-white font-normal" @class(['country-list', 'active'=>
                            request()->routeIs('general-settings.edit')]) data-twe-dropdown-item-ref>
                    <iconify-icon class="text-lg text-textColor dark:text-white mr-2"
                                  icon="material-symbols:settings-outline">
                    </iconify-icon>
                    <span class="dropdown-option">
                                @lang('Settings')
                            </span>
                </a>
            </li>
            <li>
                <form method="POST" action="{{ route('logout') }}" class="flex items-center px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-600 dark:hover:text-white font-inter text-sm text-slate-600
                              dark:text-white font-normal">
                    @csrf
                    <button type="submit" class="country-list flex items-start">
                        <iconify-icon class="text-lg text-textColor dark:text-white mr-2" icon="carbon:logout">
                        </iconify-icon>
                        <span class="dropdown-option">
                                    @lang('Log Out')
                                </span>
                    </button>
                </form>
            </li>
        </ul>
    </div>
</div>
