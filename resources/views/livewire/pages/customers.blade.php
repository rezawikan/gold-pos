<div>
    <x-header :title="$titlePage" :subtitle="$subTitlePage">
        <x-slot:middle class="!justify-end">
            <x-input
                icon="m-magnifying-glass"
                placeholder="Customer Name..."
                wire:model.live.debounce.500ms="search" />
        </x-slot>
        <x-slot:actions>
            <x-button
                label="Add New Customer"
                icon="o-plus"
                class="btn-primary"
                wire:click="openModal" />
        </x-slot>
    </x-header>

    @if ($status && $statusType)
        <x-alert
            icon="o-exclamation-triangle"
            :class="'alert-' . $statusType"
            dismissible>
            {{ $status }}
        </x-alert>
    @endif

    <x-table
        :headers="$headers"
        :rows="$customers"
        striped
        with-pagination
        :sort-by="$sortBy">
        @scope("cell_created_at", $customer)
            {{ $customer->created_at->diffForHumans() }}
        @endscope
    </x-table>

    <x-modal
        wire:model="customerModal"
        class="backdrop-blur"
        persistent
        :title="$titleModal"
        :subtitle="$subtitleModal"
        separator>
        <livewire:forms.customer-form
            :is-edit-mode="$isEditModeCustomerModal" />
    </x-modal>
</div>

@script
    <script>
        $wire.on('refresh-customers', () => {
            $wire.$refresh();
        });
    </script>
@endscript
