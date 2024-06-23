<!-- BEGIN: Sidebar -->
<div
        x-data="{
        isCollapsed: false,
        toggleSidebar() {
            const appWrapper = document.querySelector('.app-wrapper');
            const menuCheckbox = document.querySelector('#menuCollapse input[type=\'checkbox\']');

            if (appWrapper.classList.contains('collapsed')) {
                appWrapper.classList.remove('collapsed');
                appWrapper.classList.add('extend');
                menuCheckbox.checked = false;
                localStorage.sideBarType = 'extend';
            } else {
                appWrapper.classList.remove('extend');
                appWrapper.classList.add('collapsed');
                menuCheckbox.checked = true;
                localStorage.sideBarType = 'collapsed';
            }
        },
        sidebarCloseIcon() {
            document.querySelector('.sidebar-wrapper').classList.remove('sidebar-open');
            document.querySelector('#bodyOverlay').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        },
        bodyOverlay() {
            document.querySelector('.sidebar-wrapper').classList.remove('sidebar-open');
            document.querySelector('#bodyOverlay').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
     }"
        class="sidebar-wrapper group w-0 hidden xl:w-[248px] xl:block">
    <div @click="bodyOverlay" id="bodyOverlay"
         class="w-screen h-screen fixed top-0 bg-slate-900 bg-opacity-50 backdrop-blur-sm z-10 hidden">
    </div>
    <div class="logo-segment">

        <!-- Application Logo -->
        <x-application-logo/>

        <!-- Sidebar Type Button -->
        <div id="sidebar_type" @click="toggleSidebar" class="cursor-pointer text-slate-900 dark:text-white text-lg">
            <iconify-icon class="sidebarDotIcon extend-icon text-slate-900 dark:text-slate-200"
                          icon="fa-regular:dot-circle"></iconify-icon>
            <iconify-icon class="sidebarDotIcon collapsed-icon text-slate-900 dark:text-slate-200"
                          icon="material-symbols:circle-outline"></iconify-icon>
        </div>
        <button @click="sidebarCloseIcon" class="sidebarCloseIcon text-2xl inline-block md:hidden">
            <iconify-icon class="text-slate-900 dark:text-slate-200" icon="clarity:window-close-line"></iconify-icon>
        </button>
    </div>
    <div id="nav_shadow" class="nav_shadow h-[60px] absolute top-[80px] nav-shadow z-[1] w-full transition-all duration-200 pointer-events-none
      opacity-0"></div>
    <div class="sidebar-menus bg-white dark:bg-slate-800 py-2 px-4 h-[calc(100%-80px)] z-50" id="sidebar_menus">
        <ul class="sidebar-menu">
            <li class="sidebar-menu-title">{{ __('MENU') }}</li>
            <li>
                <a href="#" class="navItem {{ (request()->is('header*')) ? 'active' : '' }}">
                    <span class="flex items-center">
                        <iconify-icon class=" nav-icon" icon="heroicons-outline:home"></iconify-icon>
                        <span>{{ __('Home') }}</span>
                    </span>
                </a>
            </li>
            <!-- Database -->
            <li>
                <a href="#" class="navItem {{ (request()->is('database-backups*')) ? 'active' : '' }}">
                    <span class="flex items-center">
                        <iconify-icon class=" nav-icon" icon="iconoir:commodity"></iconify-icon>
                        <span>{{ __('Gold Stocks') }}</span>
                    </span>
                </a>
            </li>
            <!-- Database -->
            <li>
                <a href="#" class="navItem {{ (request()->is('database-backups*')) ? 'active' : '' }}">
                    <span class="flex items-center">
                        <iconify-icon class=" nav-icon" icon="iconoir:database-backup"></iconify-icon>
                        <span>{{ __('Database Backup') }}</span>
                    </span>
                </a>
            </li>
            <!-- Settings -->
            <li>
                <a href="#"
                   class="navItem {{ (request()->is('general-settings*')) || (request()->is('users*')) || (request()->is('roles*')) || (request()->is('profiles*')) || (request()->is('permissions*')) ? 'active' : '' }}">
                    <span class="flex items-center">
                        <iconify-icon class=" nav-icon" icon="material-symbols:settings-outline"></iconify-icon>
                        <span>{{ __('Settings') }}</span>
                    </span>
                </a>
            </li>
            <li class="{{ (\Request::route()->getName() == 'widget*') ? 'active' : '' }}">
                <a href="javascript:void(0)" class="navItem">
                    <span class="flex items-center">
                        <iconify-icon class=" nav-icon" icon="heroicons-outline:view-grid-add"></iconify-icon>
                        <span>{{ __('Widgets') }}</span>
                    </span>
                    <iconify-icon class="icon-arrow pointer-events-none"
                                  icon="heroicons-outline:chevron-right"></iconify-icon>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="#"
                           class="{{ (\Request::route()->getName() == 'widget.basic') ? 'active' : '' }}">{{ __('Basic') }}</a>
                    </li>
                    <li>
                        <a href="#"
                           class="{{ (\Request::route()->getName() == 'widget.statistic') ? 'active' : '' }}">{{ __('Statistics') }}</a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- Upgrade Your Business Plan Card Start -->
        <div class="bg-slate-900 mb-10 mt-24 p-4 relative text-center rounded-2xl text-white"
             id="sidebar_bottom_wizard">
            <img src="{{ Vite::asset('resources/assets/images/svg/rabit.svg') }}" alt=""
                 class="mx-auto relative -mt-[73px]">
            <div class="max-w-[160px] mx-auto mt-6">
                <div class="widget-title font-Inter mb-1">Unlimited Access</div>
                <div class="text-xs font-light font-Inter">
                    Upgrade your system to business plan
                </div>
            </div>
            <div class="mt-6">
                <button class="bg-white hover:bg-opacity-80 text-slate-900 text-sm font-Inter rounded-md w-full block py-2 font-medium">
                    Upgrade
                </button>
            </div>
        </div>
        <!-- Upgrade Your Business Plan Card Start -->
    </div>
</div>
<!-- End: Sidebar -->