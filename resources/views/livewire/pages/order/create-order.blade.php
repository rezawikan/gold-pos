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
    <div class="grid grid-cols-6 gap-8">
        <x-card
            class="col-span-3"
            title="Products"
            subtitle="Our findings about you"
            shadow
            separator>
            @foreach ($products as $product)
                <x-list-item :item="$product" no-separator no-hover>
                    <x-slot:value>
                        <div class="flex justify-normal gap-4">
                            {{ $product->name }}
                            <x-badge
                                :value="$product->stock ? '' : 'Out of Stock'"
                                @class([! $product->stock ? "badge-success" : "hidden", "py-3", "text-xs"]) />
                        </div>
                    </x-slot>
                    <x-slot:sub-value>
                        {{ $product->grams }} grams -
                        {{ $product->product_brand }}
                        - {{ $product->stock }} pcs
                    </x-slot>
                    <x-slot:actions>
                        @if ($selectedUserId)
                            <x-button
                                label="Add"
                                wire:click="addItem({{ $product->id }})"
                                spinner />
                        @endif
                    </x-slot>
                </x-list-item>
            @endforeach
        </x-card>
        <div class="col-span-3 grid grid-cols-subgrid gap-8">
            <x-card
                class="col-span-3 row-span-2"
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
                class="col-span-3 row-span-10"
                title="Cart"
                subtitle="Our findings about you"
                shadow
                separator>
                @if ($carts)
                    <x-table :headers="$headers" :rows="$carts">
                        @scope("cell_quantity", $cart)
                            <div class="relative w-40">
                                <button
                                    class="btn btn-square btn-sm absolute left-0 top-0 rounded-r-none"
                                    wire:click="updateQuantity({{ $cart["id"] }}, {{ $cart["quantity"] }}, false)">
                                    -
                                </button>
                                <input
                                    type="text"
                                    class="input input-sm input-bordered w-full px-12 text-center"
                                    wire:model="carts.{{ $loop->index }}.quantity" />
                                <button
                                    class="btn btn-square btn-sm absolute right-0 top-0 rounded-l-none"
                                    wire:click="updateQuantity({{ $cart["id"] }}, {{ $cart["quantity"] }}, true)">
                                    +
                                </button>
                            </div>
                        @endscope

                        @scope("cell_sellPrice", $cart)
                            {{ numberFormatter($cart["sellPrice"]) }}
                        @endscope

                        @scope("cell_totalValue", $cart)
                            {{ numberFormatter($cart["totalValue"]) }}
                        @endscope
                    </x-table>
                    <div class="mt-4 overflow-x-auto">
                        <table class="table">
                            <!-- head -->
                            <tbody>
                                <tr>
                                    <td rowspan="3" class="w-4/6"></td>
                                    <th>Subtotal</th>
                                    <td class="text-end">
                                        {{ numberFormatter($this->getTotalPrice()) }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Discount</th>
                                    <td class="text-end">
                                        {{ numberFormatter(0) }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td class="text-end">
                                        {{ numberFormatter($this->getTotalPrice()) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end">
                                        <x-button
                                            label="Checkout"
                                            class="btn-primary"
                                            @click="$wire.createOrder"
                                            spinner />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endif
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
                wire:model="selectedUserId"
                :options="$usersSearchable"
                search-function="searchCustomers"
                debounce="1000ms"
                min-chars="3"
                single
                searchable />
            <x-slot:actions>
                <x-button label="Cancel" wire:click="cancelCustomer" />
                <x-button label="Done" type="submit" spinner="selectCustomer" />
            </x-slot>
        </x-form>
    </x-modal>
</div>
