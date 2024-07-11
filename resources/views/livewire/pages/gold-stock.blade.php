<div>
    <div class="space-y-8">
        <div>
            <x-breadcrumb.breadcrumb :page-title="$pageTitle" :breadcrumb-items="$breadcrumbItems"/>
        </div>

        <div class=" space-y-5">
            <div class="card">
                <header class="card-header">
                    <div class="w-full flex justify-between">
                        <button wire:click="addGoldStock" class="btn btn-sm rounded btn-primary">Add Gold Stock</button>
                        {{ $search }}
                        <div class="w-[200px]">
                            <livewire:forms.search-form wire:model.live="search"/>
                        </div>
                    </div>
                </header>
                @if($status)
                    <div class="alert alert-success light-mode">
                        <div class="flex items-center space-x-3 rtl:space-x-reverse">
                            <iconify-icon class="text-2xl flex-0" icon="system-uicons:target"></iconify-icon>
                            <p class="flex-1 font-Inter"> {{$status}} </p>
                            <div class="flex-0 text-xl cursor-pointer">
                                <iconify-icon wire:click="closeStatus" icon="line-md:close"
                                              class="relative top-[4px]"></iconify-icon>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="card-body px-6 pb-6">
                    <div class="overflow-x-auto -mx-6">
                        <div class="inline-block min-w-full align-middle">
                            <div class="overflow-hidden ">
                                <table class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700">
                                    <thead class="bg-slate-200 dark:bg-slate-700">
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
                                    @foreach($products as $item)
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
                                                <div
                                                        class="{{ $today == $item->price_updated_at?->format('Y-m-d') ? 'text-amber-500' : '' }}">
                                                    {{  $item->price_updated_at ?? '-' }}
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
                                                                class="m-auto text-slate-800 dark:text-white text-xl block"
                                                                icon="heroicons-outline:dots-vertical"></iconify-icon>
                                                    </a>
                                                    <ul class="absolute z-[1000] float-left m-0 hidden min-w-max list-none overflow-hidden rounded-lg border-none bg-white bg-clip-padding text-base shadow-lg data-[twe-dropdown-show]:block dark:bg-slate-700"
                                                        aria-labelledby="dropdownMenuButton2"
                                                        data-twe-dropdown-menu-ref>
                                                        <li>
                                                            <a @click="$dispatch('add-stock',{id:{{$item->id}}})"
                                                               class="block w-full whitespace-nowrap bg-white px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-zinc-200/60 focus:bg-zinc-200/60 focus:outline-none active:bg-zinc-200/60 active:no-underline dark:bg-slate-700 dark:text-white dark:hover:bg-slate-600 dark:focus:bg-slate-600 dark:active:bg-slate-600"
                                                               href="#"
                                                               data-twe-toggle="modal"
                                                               data-twe-target="#addStockModal"
                                                               data-twe-ripple-init
                                                               data-twe-ripple-color="light"
                                                               data-twe-dropdown-item-ref>
                                                                Add Stock
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a @click="$dispatch('update-price',{id:{{$item->id}}})"
                                                               class="block w-full whitespace-nowrap bg-white px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-zinc-200/60 focus:bg-zinc-200/60 focus:outline-none active:bg-zinc-200/60 active:no-underline dark:bg-slate-700 dark:text-white dark:hover:bg-slate-600 dark:focus:bg-slate-600 dark:active:bg-slate-600"
                                                               href="#"
                                                               data-twe-toggle="modal"
                                                               data-twe-target="#addPriceModal"
                                                               data-twe-ripple-init
                                                               data-twe-ripple-color="light"
                                                               data-twe-dropdown-item-ref>
                                                                Add Today's Price
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
    <livewire:forms.gold-stock-form/>
    <livewire:forms.gold-price-form/>
</div>

@script
<script>
    const addStockModalEl = document.getElementById("addStockModal");
    const addStockModal = Modal.getOrCreateInstance(addStockModalEl);
    $wire.on('refresh-products', () => {
        $wire.$refresh();
        addStockModal.hide();
    });

    addStockModalEl.addEventListener("hidden.twe.modal", () => {
        $wire.dispatch('add-stock-close');
    });

    const addPriceModalEl = document.getElementById("addPriceModal");
    const addPriceModal = Modal.getOrCreateInstance(addPriceModalEl);
    $wire.on('refresh-products', () => {
        addPriceModal.hide();
    });

    addPriceModalEl.addEventListener("hidden.twe.modal", () => {
        $wire.dispatch('add-price-close');
    });

</script>
@endscript
