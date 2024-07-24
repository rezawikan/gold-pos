<div>
    <x-form wire:submit.prevent="submit">
        <x-input label="Name" wire:model="name" />
        <x-input label="Email" wire:model="email" />
        <x-input label="Phone Number" wire:model="phone_number" />
        <x-textarea
            label="Address"
            wire:model="address"
            placeholder="Your Address .."
            hint="Max 100 chars"
            rows="2" />

        <x-slot:actions>
            <x-button
                :label="$isEditMode ? 'Update' : 'Save'"
                class="btn-primary"
                type="submit"
                spinner="save" />
            <x-button
                label="Cancel"
                wire:click="$parent.customerModal = false" />
        </x-slot>
    </x-form>
</div>
