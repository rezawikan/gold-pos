<div>
    <x-header title="Dashboard" separator>
        <x-slot:actions>
            <x-dropdown label="Settings" class="btn-outline">
                <x-menu-item title="Archive" icon="o-archive-box" />
                <x-menu-item title="Remove" icon="o-trash" />
                <x-menu-item title="Restore" icon="o-arrow-path" />
            </x-dropdown>
        </x-slot>
    </x-header>

    <div class="grid gap-5 lg:grid-cols-4 lg:gap-8">
        <x-stat title="Messages" value="44" icon="o-envelope" tooltip="Hello" />

        <x-stat
            title="Sales"
            description="This month"
            value="22.124"
            icon="o-arrow-trending-up"
            tooltip-bottom="There" />

        <x-stat
            title="Lost"
            description="This month"
            value="34"
            icon="o-arrow-trending-down"
            tooltip-left="Ops!" />

        <x-stat
            title="Sales"
            description="This month"
            value="22.124"
            icon="o-arrow-trending-down"
            class="text-orange-500"
            color="text-pink-500"
            tooltip-right="Gosh!" />
    </div>
</div>
