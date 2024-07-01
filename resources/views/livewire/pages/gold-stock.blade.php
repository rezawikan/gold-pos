<div>
    <div class="space-y-8">
        <div>
            <x-breadcrumb.breadcrumb :page-title="$pageTitle" :breadcrumb-items="$breadcrumbItems"/>
        </div>

        <div class=" space-y-5">
            <div class="card">
                <div class="card-body px-6 pb-6">
                    <div class="overflow-x-auto -mx-6 dashcode-data-table">
                        <span class=" col-span-8  hidden"></span>
                        <span class="  col-span-4 hidden"></span>
                        <div class="inline-block min-w-full align-middle">
                            <div class="overflow-hidden ">
                                <table class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700"
                                       id="data-table">
                                    <thead class=" border-t border-slate-100 dark:border-slate-800">
                                    <tr>
                                        <th scope="col" class="table-th">
                                            ID
                                        </th>
                                        <th scope="col" class="table-th">
                                            Name
                                        </th>
                                        <th scope="col" class="table-th">
                                            Grams
                                        </th>

                                        <th scope="col" class="table-th">
                                            Stock
                                        </th>
                                        <th scope="col" class="table-th">
                                            Price
                                        </th>
                                        <th scope="col" class="table-th">
                                            Last Update
                                        </th>
                                        <th scope="col" class="table-th">
                                            Action
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
                                    @foreach($tableData as $item)
                                        <tr>
                                            <td class="table-td">{{ $item->id }}</td>
                                            <td class="table-td ">#{{ $item->name }}</td>
                                            <td class="table-td ">{{ $item->grams }}</td>
                                            <td class="table-td ">
                                                <div>
                                                    {{ $item->stock ?? "0"}}
                                                </div>
                                            </td>
                                            <td class="table-td ">{{ currencyFormatterIDR($item->price) }}</td>
                                            <td class="table-td ">
                                                <div class="{{ $today == $item->price_updated_at?->format('Y-m-d') ? 'text-amber-500' : '' }}">
                                                    {{  $item->price_updated_at ? $item->price_updated_at : '-' }}
                                                </div>
                                            </td>
                                            <td class="table-td ">
                                                <div class="relative" data-twe-dropdown-ref>
                                                    <a class="flex items-center rounded w-14 h-14 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white transition duration-150 ease-in-out motion-reduce:transition-none dark:shadow-black/30"
                                                       href="#"
                                                       type="button"
                                                       id="dropdownMenuButton2"
                                                       data-twe-dropdown-toggle-ref
                                                       aria-expanded="false"
                                                       data-twe-ripple-init
                                                    >
                                                        <iconify-icon
                                                                class="m-auto text-slate-800 dark:text-white text-xl dark:hidden block"
                                                                icon="heroicons-outline:dots-vertical"></iconify-icon>
                                                    </a>
                                                    <ul class="absolute z-[1000] float-left m-0 hidden min-w-max list-none overflow-hidden rounded-lg border-none bg-white bg-clip-padding text-base shadow-lg data-[twe-dropdown-show]:block dark:bg-surface-dark"
                                                        aria-labelledby="dropdownMenuButton2"
                                                        data-twe-dropdown-menu-ref>
                                                        <li>
                                                            <a class="block w-full whitespace-nowrap bg-white px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-zinc-200/60 focus:bg-zinc-200/60 focus:outline-none active:bg-zinc-200/60 active:no-underline dark:bg-surface-dark dark:text-white dark:hover:bg-neutral-800/25 dark:focus:bg-neutral-800/25 dark:active:bg-neutral-800/25"
                                                               href="#"
                                                               data-twe-dropdown-item-ref>
                                                                Add Stock
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="block w-full whitespace-nowrap bg-white px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-zinc-200/60 focus:bg-zinc-200/60 focus:outline-none active:bg-zinc-200/60 active:no-underline dark:bg-surface-dark dark:text-white dark:hover:bg-neutral-800/25 dark:focus:bg-neutral-800/25 dark:active:bg-neutral-800/25"
                                                               href="#"
                                                               data-twe-dropdown-item-ref>
                                                                Price Update
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
