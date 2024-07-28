<?php

namespace App\Livewire\Pages;

use App\Models\Customer;
use App\Services\CustomerService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;

class CreateOrder extends Component
{
    public ?Customer $customer;

    public ?int $user_searchable_id;

    public $isCustomerModalOpen = false;

    public Collection $usersSearchable;

    // Options list
    protected CustomerService $customerService;

    public function boot(CustomerService $customerService): void
    {
        $this->customerService = $customerService;
    }

    public function mount(): void
    {
        $this->searchCustomers();
    }

    public function searchCustomers(string $searchText = ''): LengthAwarePaginator|Collection
    {
        return $this->usersSearchable = $this->customerService
            ->all($searchText, ['name']);
    }

    public function selectCustomer(): void
    {
        $this->customer = $this->customerService->find($this->user_searchable_id);
        $this->isCustomerModalOpen = false;
    }

    public function deleteCustomer(): void
    {
        $this->customer = null;
        $this->user_searchable_id = null;
    }

    public function cancelCustomer(): void
    {
        $this->isCustomerModalOpen = false;
        $this->customer = null;
        $this->user_searchable_id = null;
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.pages.create-order');
    }
}
