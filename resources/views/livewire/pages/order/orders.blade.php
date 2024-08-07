<div>
    <x-header title="Orders" subtitle="It’s where all the magic happens! ">
        <x-slot:middle class="!justify-end">
            <x-input
                icon="m-magnifying-glass"
                placeholder="Order ID..."
                wire:model.live.debounce.500ms="search" />
        </x-slot>
        <x-slot:actions>
            <x-button
                label="Add New Order"
                icon="o-plus"
                class="btn-primary"
                link="{{ route('create-order') }}" />
        </x-slot>
    </x-header>

    <x-table
        :headers="$headers"
        :rows="$orders"
        striped
        with-pagination
        :sort-by="$sortBy">
        @scope("cell_subtotal", $order)
        {{ numberFormatter($order->subtotal) }}
        @endscope
        @scope("cell_base_subtotal", $order)
        {{ numberFormatter($order->base_subtotal) }}
        @endscope
        @scope("cell_total", $order)
        {{ numberFormatter($order->total) }}
        @endscope
        @scope("cell_profit", $order)
        {{ numberFormatter($order->profit) }}
        @endscope
        @scope("cell_created_at", $order)
        {{ $order->created_at->diffForHumans() }}
        @endscope
    </x-table>
</div>
