<div>
    <div class="space-y-8">
        <div>
            <x-breadcrumb.breadcrumb :page-title="$pageTitle" :breadcrumb-items="$breadcrumbItems"/>
        </div>

        <div class=" space-y-5">
            <div class="card">
                <div class="card-body px-6 pb-6">
                    <div class="overflow-x-auto -mx-6 dashcode-data-table">
                        <span class=" col-span-8  hidden"></span>
                        <span class="  col-span-4 hidden"></span>
                        <div class="inline-block min-w-full align-middle">
                            <div class="overflow-hidden ">
                                <table class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700"
                                       id="data-table">
                                    <thead class=" border-t border-slate-100 dark:border-slate-800">
                                    <tr>
                                        <th scope="col" class=" table-th ">
                                            ID
                                        </th>
                                        <th scope="col" class=" table-th ">
                                            Name
                                        </th>
                                        <th scope="col" class=" table-th ">
                                            Grams
                                        </th>

                                        <th scope="col" class=" table-th ">
                                            Stock
                                        </th>
                                        <th scope="col" class=" table-th ">
                                            Price
                                        </th>
                                        <th scope="col" class=" table-th ">
                                            Last Update
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
                                    @foreach($tableData as $item)
                                        <tr>
                                            <td class="table-td">{{ $item->id }}</td>
                                            <td class="table-td ">#{{ $item->name }}</td>
                                            <td class="table-td ">{{ $item->grams }}</td>
                                            <td class="table-td ">
                                                <div>
                                                    {{ $item->stock ?? "Kosong"}}
                                                </div>
                                            </td>
                                            <td class="table-td ">{{ currencyFormatterIDR($item->price) }}</td>
                                            <td class="table-td ">{{ $item->price_updated_at }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
