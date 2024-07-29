<div>
    <x-header
        title="Create Order"
        subtitle="Provide clear and concise descriptions of the products or services being offered.">
        <x-slot:middle class="!justify-end">
            <x-input icon="o-bolt" placeholder="Search..." />
        </x-slot>
        <x-slot:actions>
            <x-button icon="o-funnel" />
            <x-button icon="o-plus" class="btn-primary" />
        </x-slot>
    </x-header>
    <div class="grid grid-cols-5 gap-8">
        <x-card
            class="col-span-3"
            title="Products"
            subtitle="Our findings about you"
            shadow
            separator>
            I have title, subtitle, separator and shadow.
        </x-card>
        <div class="col-span-2 grid grid-cols-subgrid gap-8">
            <x-card
                class="col-span-2"
                title="Customer"
                shadow
                separator
                menu="dark">
                @if ($customer)
                    <x-list-item :item="$customer" no-separator no-hover>
                        <x-slot:value>
                            {{ $customer->name }}
                        </x-slot>
                        <x-slot:sub-value>
                            <div class="text-wrap">{{ $customer->email }}</div>
                            <div class="text-wrap">
                                {{ $customer->phone_number }}
                            </div>
                            <div class="text-wrap">
                                {{ $customer->address }}
                            </div>
                        </x-slot>
                        <x-slot:actions>
                            <x-button
                                icon="o-trash"
                                class="text-red-500"
                                @click="$wire.deleteCustomer"
                                spinner />
                        </x-slot>
                    </x-list-item>
                @else
                    <div>No selected customer</div>
                @endif

                <x-slot:menu>
                    <x-button
                        icon="s-pencil-square"
                        spinner
                        class="btn-sm"
                        inline
                        @click="$wire.isCustomerModalOpen = true" />
                </x-slot>
            </x-card>
            <x-card
                class="col-span-2"
                title="Cart"
                subtitle="Our findings about you"
                shadow
                separator>
                {{-- @foreach() --}}
                {{-- <x-list-item :item="$user2" no-separator no-hover> --}}
                {{-- <x-slot:avatar> --}}
                {{-- <x-badge value="top user" class="badge-primary" /> --}}
                {{-- </x-slot:avatar> --}}
                {{-- <x-slot:value> --}}
                {{-- Custom value --}}
                {{-- </x-slot:value> --}}
                {{-- <x-slot:sub-value> --}}
                {{-- Custom sub-value --}}
                {{-- </x-slot:sub-value> --}}
                {{-- <x-slot:actions> --}}
                {{-- <x-button icon="o-trash" class="text-red-500" wire:click="delete(1)" spinner /> --}}
                {{-- </x-slot:actions> --}}
                {{-- </x-list-item> --}}
                {{-- @endforeach --}}
            </x-card>
        </div>
    </div>

    <x-modal
        wire:model="isCustomerModalOpen"
        box-class="overflow-visible"
        class="backdrop-blur"
        title="Find Customer"
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
            </x-slot>
        </x-form>
    </x-modal>
</div>
