<div>
    <x-header :title="$pageTitle" subtitle="Check this on mobile">
        <x-slot:middle class="!justify-end">
            <x-input icon="o-bolt" placeholder="Search..."/>
        </x-slot:middle>
        <x-slot:actions>
            <x-button icon="o-funnel"/>
            <x-button icon="o-plus" class="btn-primary"/>
        </x-slot:actions>
    </x-header>
    <x-table :headers="$headers" :rows="$products" striped @row-click="alert($event.detail.name)" with-pagination
             :sort-by="$sortBy"/>
</div>