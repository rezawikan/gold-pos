<div>
    <x-header title="Create Order" subtitle="Check this on mobile">
        <x-slot:middle class="!justify-end">
            <x-input icon="o-bolt" placeholder="Search..." />
        </x-slot:middle>
        <x-slot:actions>
            <x-button icon="o-funnel" />
            <x-button icon="o-plus" class="btn-primary" />
        </x-slot:actions>
    </x-header>
    <div class="grid grid-cols-3 gap-8">
        <x-card title="Customer" shadow separator menu="dark">
            @if($customer)
                <x-list-item :item="$customer" no-separator no-hover>
                    <x-slot:value>
                        {{ $customer->name }}
                    </x-slot:value>
                    <x-slot:sub-value>
                        <div class="text-wrap">{{ $customer->email }}</div>
                        <div class="text-wrap">{{ $customer->phone_number }}</div>
                        <div class="text-wrap">{{ $customer->address }}</div>
                    </x-slot:sub-value>
                    <x-slot:actions>
                        <x-button icon="o-trash" class="text-red-500" @click="$wire.deleteCustomer" spinner />
                    </x-slot:actions>
                </x-list-item>
            @else
                <div>No selected customer</div>
            @endif

            <x-slot:menu>
                <x-button
                    icon="s-pencil-square"
                    spinner
                    class="btn-sm"
                    inline @click="$wire.isCustomerModalOpen = true" />
            </x-slot:menu>
        </x-card>
        <x-card class="col-span-2" title="Your stats" subtitle="Our findings about you" shadow separator>
            I have title, subtitle, separator and shadow.
        </x-card>
    </div>

    <x-modal wire:model="isCustomerModalOpen" box-class="overflow-visible" class="backdrop-blur" title="Find Customer"
             persistent>
        <x-form wire:submit.prevent="selectCustomer">
            <x-choices
                label="Start typing to search and select a customer from the list."
                wire:model="user_searchable_id"
                :options="$usersSearchable"
                search-function="searchCustomers"
                debounce="1000ms"
                min-chars="3"
                single
                searchable />
            <x-slot:actions>
                <x-button label="Cancel" @click="$wire.cancelCustomer" />
                <x-button label="Done" type="submit" spinner="selectCustomer" />
            </x-slot:actions>
        </x-form>
    </x-modal>
</div>
