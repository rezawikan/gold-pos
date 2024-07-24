<?php

namespace App\Livewire\Forms;

use App\Models\Customer;
use Livewire\Component;

class CustomerForm extends Component
{
    public $name;

    public $email;

    public $phone_number;

    public $address;

    public $isEditMode;

    public $customerId;

    public function mount($isEditMode = false, $customerId = null): void
    {
        $this->isEditMode = $isEditMode;
        $this->customerId = $customerId;
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:customers,email',
            'phone_number' => 'required',
            'address' => 'required',
        ];
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.forms.customer-form');
    }

    public function submit(): void
    {
        $this->validate();
        $customer = Customer::find($this->customerId) ?? new Customer;
        if ($this->isEditMode) {
            $customer = $customer->update([
                'name' => $this->name,
                'email' => $this->email,
                'phone_number' => $this->phone_number,
                'address' => $this->address,
            ]);
            $this->dispatch('refresh-customers', status: 'Successfully updated the customer - '.$customer->name, statusType: 'success');
        } else {
            $customer = $customer->create([
                'name' => $this->name,
                'email' => $this->email,
                'phone_number' => $this->phone_number,
                'address' => $this->address,
            ]);
            $this->dispatch('refresh-customers', status: 'Successfully added a new customer - '.$customer->name, statusType: 'success');
        }
        $this->reset();
    }
}
