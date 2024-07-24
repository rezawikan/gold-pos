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
            :class="'mb-5 alert-' . $statusType"
            dismissible>
            {{ $status }}
        </x-alert>
    @endif

    <x-table
        :headers="$headers"
        :rows="$customers"
        striped
        with-pagination
        @row-click="$wire.updateCustomer($event.detail.id)"
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
        <x-form wire:submit.prevent="save">
            <x-input label="Name" wire:model="form.name" />
            <x-input label="Email" wire:model="form.email" />
            <x-input label="Phone Number" wire:model="form.phone_number" />
            <x-textarea
                label="Address"
                wire:model="form.address"
                placeholder="Your Address .."
                hint="Max 100 chars"
                rows="2" />

            <x-slot:actions>
                <x-button
                    :label="$isEditMode ? 'Update' : 'Save'"
                    class="btn-primary"
                    type="submit"
                    spinner="save" />
                <x-button label="Cancel" @click="$wire.customerModal = false" />
            </x-slot>
        </x-form>
    </x-modal>
</div>

@script
    <script>
        $wire.on('refresh-customers', () => {
            $wire.$refresh();
        });
    </script>
@endscript
