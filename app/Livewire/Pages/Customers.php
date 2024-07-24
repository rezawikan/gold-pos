<?php

namespace App\Livewire\Pages;

use App\Livewire\Forms\CustomerForm;
use App\Services\CustomerService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

class Customers extends Component
{
    public $titlePage = 'Customers';

    public $subTitlePage = 'Loyal shoppers, vital heartbeat.';

    public CustomerForm $form;

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

    public bool $isEditMode = false;

    // Modal
    public $titleModal = 'Add Customer';

    public $subtitleModal = 'Add new customer';

    public bool $customerModal = false;

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

    public function save(): void
    {
        $this->validate();

        if ($this->isEditMode) {
            $this->form->update();
            $this->dispatch('refresh-customers', status: 'Successfully updated the customer', statusType: 'success');
        } else {
            $customer = $this->form->store();
            $this->dispatch('refresh-customers', status: 'Successfully added a new customer - '.$customer->name, statusType: 'success');
        }
    }

    public function updateCustomer($id): void
    {
        $customer = $this->customerService->find($id);
        $this->titleModal = 'Update Customer';
        $this->subtitleModal = 'Update customer '.$customer->name;
        $this->form->setCustomer($customer);
        $this->openModal(true);
    }

    public function openModal($isEditMode = false): void
    {
        $this->customerModal = true;
        $this->isEditMode = $isEditMode;
    }

    #[On('refresh-customers')]
    public function refresh(string $status, string $statusType): void
    {
        $this->isEditMode = false;
        $this->customerModal = false;
        $this->status = $status;
        $this->statusType = $statusType;
    }
}
