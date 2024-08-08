<div>
    <x-header title="Update Product" subtitle="{{$product?->name}}"></x-header>

    <div class="grid grid-cols-5 gap-4">
        <x-card
            class="col-span-2"
            title="Selected Product"
            subtitle="Update your detail here"
            shadow
            separator>
            <x-form wire:submit="update">
                <x-input
                    label="Name"
                    wire:model="form.name"
                    wire:keyup="generateSlug" />
                <x-input
                    label="Slug"
                    wire:model="form.slug"
                    readonly
                    disabled />
                <x-select
                    label="Type"
                    icon="m-cube-transparent"
                    :options="$types"
                    option-value="id"
                    placeholder="Select a type"
                    placeholder-value="0"
                    wire:model="form.type_id" />
                <x-select
                    label="Brand"
                    icon="s-swatch"
                    :options="$brands"
                    option-value="id"
                    placeholder="Select a brands"
                    placeholder-value="0"
                    wire:model="form.brand_id" />
                <div>
                    <label class="label">
                        <span class="label-text text-base">
                            Additional Price
                        </span>
                    </label>
                    <input
                        placeholder="Additional Price"
                        class="input input-bordered input-primary w-full"
                        wire:keyup="generateDelimiters('form','additional_sell_price')"
                        wire:model="form.additional_sell_price" />
                    <x-forms.input-error
                        :messages="$errors->get('form.additional_sell_price')"
                        class="mt-2" />
                </div>
                <div>
                    <label class="label">
                        <span class="label-text text-base">
                            Additional Buyback Price per Gram
                        </span>
                    </label>
                    <input
                        placeholder="Buyback Price per Gram"
                        class="input input-bordered input-primary w-full"
                        wire:keyup="generateDelimiters('form','additional_buy_price')"
                        wire:model="form.additional_buy_price" />
                    <x-forms.input-error
                        :messages="$errors->get('form.additional_buy_price')"
                        class="mt-2" />
                </div>
                <x-input label="Grams" wire:model="form.grams" />
                <x-slot:actions>
                    <x-button label="Cancel" link="{{ route('gold-stock') }}" />
                    <x-button
                        label="Update"
                        class="btn-primary"
                        type="submit"
                        spinner="save" />
                </x-slot>
            </x-form>
        </x-card>

        <!-- ... -->
        <x-card
            class="col-span-3"
            title="Current Stock"
            subtitle="Keeping an eye on current stock levels helps businesses manage inventory efficiently."
            shadow
            separator>
            <x-slot:menu>
                <x-button
                    icon="o-plus"
                    class="cursor-pointer"
                    class="btn-sm"
                    wire:click="openAddModal" />
            </x-slot>
            @if ($statusStock && $statusTypeStock)
                <x-alert
                    icon="o-exclamation-triangle"
                    :class="'mb-5 alert-' . $statusTypeStock"
                    dismissible>
                    {{ $statusStock }}
                </x-alert>
            @endif

            <div class="flex flex-wrap gap-2">
                @foreach ($indicators as $key => $indicator)
                    <x-badge
                        :value="$indicator"
                        class="bg-{{ $key }}-500 py-4 text-white" />
                @endforeach
            </div>
            <x-table
                :headers="$productItemHeaders"
                :rows="$form->product_items"
                show-empty-text
                empty-text="Out of Stock!">
                @scope("cell_id", $product_item)
                    {{ $loop->index + 1 }}
                @endscope

                @scope("cell_based_price", $product_item)
                    {{ currencyFormatterIDR($product_item->based_price) }}
                @endscope

                @scope("cell_stock", $product_item)
                    {{ numberFormatter($product_item->stock) }}
                @endscope

                @scope("cell_purchase_date", $product_item)
                    {{ $product_item->purchase_date->format("d-m-Y H:i") }}
                @endscope

                @scope("cell_status_color", $product_item)
                    <div
                        class="bg-{{ $product_item->status_color }}-500 flex h-5 w-5 justify-center rounded-full"></div>
                @endscope

                @scope("cell_actions", $product_item)
                    {{ $product_item->status }}
                    <div class="flex gap-2">
                        <x-button
                            icon="s-pencil-square"
                            wire:click="openEditModal({{ $product_item->id }}, true)"
                            spinner
                            class="btn-sm"
                            inline />
                        <x-button
                            icon="o-trash"
                            spinner
                            class="btn-sm"
                            wire:click="openDeleteModal({{ $product_item->id }})" />
                    </div>
                @endscope
            </x-table>
        </x-card>
    </div>

    {{-- Here is modal`s ID --}}
    <x-modal
        wire:model="deleteStockModal"
        :title="'Are you sure delete '.numberFormatter((string)$selectedItemForDelete?->based_price) .' stock?'">
        <div>You won't be able to revert this!</div>

        <x-slot:actions>
            {{-- Notice `onclick` is HTML --}}
            <x-button label="Cancel" @click="$wire.deleteStockModal = false" />
            <x-button
                label="Confirm"
                class="btn-primary"
                wire:click="deleteProductItem" />
        </x-slot>
    </x-modal>

    <x-modal
        wire:model="editStockModal"
        class="backdrop-blur"
        :title="$isEditModeStock ? 'Edit' : 'Add' . ' Gold Stock'"
        subtitle="Stock for {{ $product?->name }}"
        persistent>
        <x-form wire:submit="updateStock">
            <x-input
                label="Based Price"
                wire:keyup.debounce.500ms="generateDelimiters('stockForm','basedPrice')"
                wire:model="stockForm.basedPrice" />
            <x-input
                label="Stock"
                wire:model="stockForm.stock"
                wire:keyup.debounce.500ms="generateDelimiters('stockForm','stock')" />
            <x-datepicker
                label="Purchase Date"
                wire:model="stockForm.purchaseDate"
                icon="o-calendar"
                :config="$datePickerOptions" />
            <x-slot:actions>
                <x-button label="Cancel" @click="$wire.closeEditModal" />
                <x-button
                    :label="$isEditModeStock ? 'Update' : 'Add'"
                    class="btn-primary"
                    type="submit"
                    spinner="updateStock" />
            </x-slot>
        </x-form>
    </x-modal>
</div>
