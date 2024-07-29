<div>
    <x-header :title="$pageTitle" subtitle="Elzan Gold">
        <x-slot:middle class="!justify-end">
            <x-input
                icon="m-magnifying-glass"
                placeholder="Search..."
                wire:model.live.debounce.500ms="search" />
        </x-slot>
        <x-slot:actions>
            <x-button
                icon="o-funnel"
                label="Filters"
                @click="$wire.showDrawerFilter = true"
                :badge="$filterCount" />
            <x-button
                label="Add Stock"
                icon="o-plus"
                wire:click="openModal"
                class="btn-primary" />
            <x-button
                label="Refresh"
                class="btn-primary"
                wire:click="updatePrice()"
                spinner />
        </x-slot>
    </x-header>

    @if ($status && $statusType)
        <x-alert
            icon="o-exclamation-triangle"
            :class="'mb-5 alert-' . $statusType"
            dismissible>
            {{ $status }}
        </x-alert>
    @endif

    @if (session("status"))
        <x-alert
            icon="o-exclamation-triangle"
            class="alert-success mb-5"
            dismissible>
            {{ session("status") }}
        </x-alert>
    @endif

    <x-table
        :headers="$headers"
        :rows="$products"
        with-pagination
        :sort-by="$sortBy">
        @scope("cell_sell_price", $product)
            {{ currencyFormatterIDR($product->sell_price) }}
        @endscope

        @scope("cell_buy_price", $product)
            {{ currencyFormatterIDR($product->buy_price) }}
        @endscope

        @scope("cell_stock", $product)
            {{ numberFormatter($product->stock) }}
        @endscope

        @scope("cell_price_updated_at", $product)
            <div class="flex items-center">
                {{ $product->price_updated_at ? $product->price_updated_at->format("d M Y H:i:s") : "No Data" }}
                <div
                    class="{{ now()->format("Y-m-d") == $product->price_updated_at?->format("Y-m-d") ? "text-green-500" : "text-red-500" }} pl-2">
                    @if (now()->format("Y-m-d") == $product->price_updated_at?->format("Y-m-d"))
                        <x-icon name="m-check-circle" />
                    @else
                        <x-icon name="s-x-circle" />
                    @endif
                </div>
            </div>
        @endscope
    </x-table>

    <x-modal
        wire:model="goldStockModal"
        class="backdrop-blur"
        persistent
        title="Add Stock Gold"
        subtitle="asd"
        separator>
        <x-form wire:submit.prevent="save">
            <x-input label="Name" wire:model="form.name" />
            {{-- <x-input label="Email" wire:model="form.email" /> --}}
            {{-- <x-input label="Phone Number" wire:model="form.phone_number" /> --}}
            {{-- <x-textarea --}}
            {{-- label="Address" --}}
            {{-- wire:model="form.address" --}}
            {{-- placeholder="Your Address .." --}}
            {{-- hint="Max 100 chars" --}}
            {{-- rows="2" /> --}}

            <x-slot:actions>
                <x-button
                    label="Save"
                    class="btn-primary"
                    type="submit"
                    spinner="save" />
                <x-button label="Cancel" @click="$wire.customerModal = false" />
            </x-slot>
        </x-form>
    </x-modal>

    <x-drawer
        wire:model="showDrawerFilter"
        title="Filters"
        separator
        with-close-button
        close-on-escape
        class="w-11/12 lg:w-1/3"
        right>
        <x-form wire:submit="applyFilters">
            <x-checkbox
                label="Hide Stock Column"
                wire:model="filters.hide_stock"
                hint="You can hide this column" />

            <x-slot:actions>
                <x-button label="Cancel" />
                <x-button
                    label="Done"
                    class="btn-primary"
                    type="submit"
                    spinner="applyFilters" />
            </x-slot>
        </x-form>
    </x-drawer>
</div>

@script
    <script>
        $wire.on('refresh-products', () => {
            $wire.$refresh();
        });
    </script>
@endscript
