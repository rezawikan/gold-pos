<div class="z-[9] sticky top-0" id="app_header">
    <div class="app-header z-[999] bg-white dark:bg-slate-800 shadow-sm dark:shadow-slate-700">
        <div
                x-data="{
                    openSideBar() {
                        document.querySelector('.app-wrapper').classList.remove('collapsed');
                        document.querySelector('.app-wrapper').classList.add('extend');
                        // Uncheck the checkbox with type 'checkbox' inside #menuCollapse
                        document.querySelector('#menuCollapse input[type=\'checkbox\']').checked = false;
                        // Set localStorage value for sideBarType
                        localStorage.sideBarType = 'extend';
                    },
                    openSideBarSmall() {
                        document.querySelector('.sidebar-wrapper').classList.add('sidebar-open');
                        document.querySelector('#bodyOverlay').classList.remove('hidden');
                        document.body.classList.add('overflow-hidden');
                    },
                    bodyOverlay() {
                        document.querySelector('.sidebar-wrapper').classList.remove('sidebar-open');
                        document.querySelector('#bodyOverlay').classList.add('hidden');
                        document.body.classList.remove('overflow-hidden');
                    }
                }"
                class="flex justify-between items-center h-full">
            <div class="flex items-center md:space-x-4 space-x-4 rtl:space-x-reverse vertical-box">
                <div class="xl:hidden inline-block">
                    <x-application-logo class="mobile-logo"/>
                </div>
                <button @click="openSideBarSmall" class="open-sidebar-controller hidden xl:hidden md:inline-block">
                    <iconify-icon
                            class="leading-none bg-transparent relative text-xl top-[2px] text-slate-900 dark:text-white"
                            icon="heroicons-outline:menu-alt-3"></iconify-icon>
                </button>
                <button @click="openSideBar" class="sidebarOpenButton text-xl text-slate-900 dark:text-white !ml-0">
                    <iconify-icon icon="ph:arrow-right-bold"></iconify-icon>
                </button>
                <x-header.search/>
            </div>
            <!-- end vertical -->

            <div class="items-center space-x-4 rtl:space-x-reverse horizontal-box">
                <x-application-logo/>
                <button @click="openSideBarSmall" class="open-sidebar-controller hidden xl:hidden md:inline-block">
                    <iconify-icon
                            class="leading-none bg-transparent relative text-xl top-[2px] text-slate-900 dark:text-white"
                            icon="heroicons-outline:menu-alt-3"></iconify-icon>
                </button>
                <x-header.search/>
            </div>
            <!-- end horizontal -->

            <!-- start horizontal nav -->
            <x-bar.top-bar-menu/>
            <!-- end horizontal nav -->

            <div class="nav-tools flex items-center lg:space-x-5 space-x-3 rtl:space-x-reverse leading-0">
                <x-header.theme-switcher/>
                {{--                <x-gray-scale />--}}
                {{--                <x-nav-message-dropdown />--}}
                <x-header.notification/>
                <x-header.user/>
                <button @click="openSideBarSmall" class="md:hidden block leading-0">
                    <iconify-icon class="cursor-pointer text-slate-900 dark:text-white text-2xl"
                                  icon="heroicons-outline:menu-alt-3"></iconify-icon>
                </button>
                <!-- end mobile menu -->
            </div>
            <!-- end nav tools -->
        </div>
    </div>
</div>

<!-- BEGIN: Search Modal -->
<div class="modal fade z-[1055] fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto inset-0 bg-slate-900/40 backdrop-filter backdrop-blur-sm backdrop-brightness-10"
     data-twe-modal-init
     id="searchModal"
     tabindex="-1"
     aria-labelledby="searchModalLabel"
     aria-hidden="true">
    <div class="modal-dialog relative w-auto pointer-events-none top-1/4 translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:max-w-[500px]"
         data-twe-modal-dialog-ref>
        <div data-twe-modal-body-ref
             class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white dark:bg-slate-900 bg-clip-padding rounded-md outline-none text-current">
            <form>
                <div class="relative">
                    <button class="absolute left-0 top-1/2 -translate-y-1/2 w-9 h-full text-xl dark:text-slate-300 flex items-center justify-center">
                        <iconify-icon icon="heroicons-solid:search"></iconify-icon>
                    </button>
                    <input type="text" class="form-control !py-[14px] !pl-10" placeholder="Search" autofocus>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END: Search Modal -->

