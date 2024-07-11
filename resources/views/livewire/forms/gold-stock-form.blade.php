<div wire:ignore.self
     data-twe-modal-init
     class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
     id="addStockModal"
     tabindex="-1"
     aria-labelledby="addStockModalLabel"
     aria-hidden="true">
    <div
            data-twe-modal-dialog-ref
            class="pointer-events-none relative w-auto transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:max-w-[500px]">
        <div
                class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-4 outline-none dark:bg-slate-800">
            <div
                    class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 p-4 dark:border-white/10">
                <h5
                        class="text-xl font-medium leading-normal text-surface dark:text-white"
                        id="addStockModalLabel">
                    {{ $formTitle }}
                </h5>
                <button
                        type="button"
                        class="box-content rounded-none border-none text-neutral-500 hover:text-neutral-800 hover:no-underline focus:text-neutral-800 focus:opacity-100 focus:shadow-none focus:outline-none dark:text-neutral-400 dark:hover:text-neutral-300 dark:focus:text-neutral-300"
                        data-twe-modal-dismiss
                        aria-label="Close">
          <span class="[&>svg]:h-6 [&>svg]:w-6">
            <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor">
              <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="relative flex-auto p-4" data-twe-modal-body-ref>
                <div class="card">
                    <div class="card-body flex flex-col">
                        <div class="card-text h-full space-y-4">
                            <div class="input-area">
                                <label for="readonly" class="form-label">Product Name</label>
                                <input value="{{ $product?->name }}" id="readonly" type="text" class="form-control"
                                       placeholder="You can't change me.(Readonly)" readonly="readonly"></div>
                            <div class="input-area">
                                <label for="basedPrice" class="form-label">Based Price *</label>
                                <div class="relative">
                                    <input wire:model="basedPrice" id="basedPrice" type="text" class="form-control"
                                           placeholder="Based Price">
                                    @error('basedPrice')
                                    <iconify-icon
                                            class="absolute top-1/2 right-3 -translate-y-1/2 text-danger-500 text-xl"
                                            icon="mdi:warning-octagon-outline"></iconify-icon>
                                    @enderror
                                </div>
                                @error('basedPrice')
                                <span
                                        class="font-Inter text-sm text-danger-500 pt-2 inline-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="input-area">
                                <label for="stock" class="form-label">Stock *</label>
                                <div class="relative">
                                    <input wire:model="stock" id="stock" type="text" class="form-control"
                                           placeholder="Stock">
                                    @error('stock')
                                    <iconify-icon
                                            class="absolute top-1/2 right-3 -translate-y-1/2 text-danger-500 text-xl"
                                            icon="mdi:warning-octagon-outline"></iconify-icon>
                                    @enderror

                                </div>
                                @error('stock')
                                <span
                                        class="font-Inter text-sm text-danger-500 pt-2 inline-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div
                    class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 p-4 dark:border-white/10">
                <button
                        wire:click="close"
                        type="button"
                        class="btn inline-block rounded justify-center btn-sm btn-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-primary-3 transition duration-150 ease-in-out hover:shadow-primary-2 focus:shadow-primary-2 focus:outline-none focus:ring-0 active:shadow-primary-2 dark:shadow-black/30 dark:hover:shadow-dark-strong dark:focus:shadow-dark-strong dark:active:shadow-dark-strong"
                        data-twe-modal-dismiss
                        data-twe-ripple-init
                        data-twe-ripple-color="light">
                    Close
                </button>
                <button
                        wire:click="addStock"
                        type="button"
                        class="btn ms-1 inline-block rounded  justify-center btn-sm btn-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-primary-3 transition duration-150 ease-in-out hover:shadow-primary-2 focus:shadow-primary-2 focus:outline-none focus:ring-0 active:shadow-primary-2 dark:shadow-black/30 dark:hover:shadow-dark-strong dark:focus:shadow-dark-strong dark:active:shadow-dark-strong"
                        data-twe-ripple-init
                        data-twe-ripple-color="light">
                    Add Stock
                </button>
            </div>
        </div>
    </div>
</div>

@script
<script>
    const basePrice = document.getElementById("basedPrice");
    const stock = document.getElementById("stock");
    basePrice.addEventListener('input', (e) => {
        basePrice.value = formatNumeral(e.target.value, {
            numeralThousandsGroupStyle: 'thousand',
        })
    })

    stock.addEventListener('input', (e) => {
        stock.value = formatNumeral(e.target.value, {
            numeralThousandsGroupStyle: 'thousand',
        })
    })
</script>
@endscript
