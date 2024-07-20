<div>
    <x-header :title="$pageTitle" subtitle="Check this on mobile">
        <x-slot:middle class="!justify-end">
            <x-input icon="o-bolt" placeholder="Search..." />
        </x-slot>
        <x-slot:actions>
            <x-button icon="o-funnel" />
            <x-button icon="o-plus" class="btn-primary" />
        </x-slot>
    </x-header>
    <x-table
        :headers="$headers"
        :rows="$products"
        striped
        with-pagination
        :sort-by="$sortBy">
        @scope("cell_price", $product)
            {{ currencyFormatterIDR($product->price) }}
        @endscope

        @scope("cell_stock", $product)
            {{ numberFormatter($product->stock) }}
        @endscope

        @scope("cell_price_updated_at", $product)
            <div class="flex items-center">
                {{ $product->price_updated_at?->format("d M Y H:i:s") }}
                <div
                    class="{{ $not = now()->format("Y-m-d") == $product->price_updated_at?->format("Y-m-d") ? "text-green-500" : "text-red-500" }} pl-2">
                    @if (! $not)
                        <x-icon name="m-check-circle" />
                    @else
                        <x-icon name="s-x-circle" />
                    @endif
                </div>
            </div>
        @endscope
    </x-table>
</div>
