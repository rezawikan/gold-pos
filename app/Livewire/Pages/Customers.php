<?php

namespace App\Livewire\Pages;

use App\Services\CustomerService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

class Customers extends Component
{
    public $titlePage = 'Customers';

    public $subTitlePage = 'Loyal shoppers, vital heartbeat.';

    public $search = '';

    public array $sortBy = ['column' => 'id', 'direction' => 'asc'];

    public $status;

    public $statusType;

    public $headers = [
        ['key' => 'id', 'label' => '#'],
        ['key' => 'name', 'label' => 'Name'],
        ['key' => 'phone_number', 'label' => 'Phone Number'],
        ['key' => 'email', 'label' => 'Email'],
        ['key' => 'address', 'label' => 'Address'],
        ['key' => 'updated_at', 'label' => 'Last Update'],
    ];

    public bool $showDrawerFilter = false;

    // Modal
    public $titleModal = 'Add Customer';

    public $subtitleModal = 'Add new customer';

    public bool $customerModal = false;

    public bool $isEditModeCustomerModal = false;

    protected $customerService;

    public function boot(CustomerService $customerService): void
    {
        $this->customerService = $customerService;
    }

    #[Layout('components.layouts.app')]
    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.pages.customers', [
            'customers' => $this->getCustomers(),
        ]);
    }

    public function getCustomers()
    {
        return $this->customerService->all($this->search, $this->sortBy);
    }

    public function openModal($isEditMode = false): void
    {
        $this->customerModal = true;
        $this->isEditModeCustomerModal = $isEditMode;
    }

    #[On('refresh-customers')]
    public function refresh(string $status, string $statusType): void
    {
        $this->isEditModeCustomerModal = false;
        $this->customerModal = false;
        $this->status = $status;
        $this->statusType = $statusType;
    }
}
