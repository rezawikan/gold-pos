<div>
    <x-header title="Update Product" subtitle="{{$product?->name}}"></x-header>
    <x-form wire:submit="save">
        <x-input
            label="Name"
            wire:model="form.name"
            wire:keyup="generateSlug" />
        <x-input label="Slug" wire:model="form.slug" readonly disabled />
        <x-select
            label="Type"
            icon="m-cube-transparent"
            :options="$types"
            option-value="name"
            wire:model="form.type_id" />
        <x-select
            label="Brand"
            icon="s-swatch"
            :options="$brands"
            option-value="name"
            wire:model="form.brand_id" />
        <div>
            <label class="label">
                <span class="label-text text-base">Additional Price</span>
            </label>
            <input
                placeholder="Additional Price"
                class="price input input-bordered input-primary w-full"
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
                class="price input input-bordered input-primary w-full"
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
</div>

@script
    <script>
        const prices = document.querySelectorAll('.price');

        for (const price of prices) {
            price.addEventListener('input', (e) => {
                price.value = formatNumeral(e.target.value, {
                    numeralThousandsGroupStyle: 'thousand',
                });
            });
        }
    </script>
@endscript
