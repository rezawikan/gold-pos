<?php

namespace App\Livewire\Forms;

use App\Models\Customer;
use Illuminate\Validation\Rule;
use Livewire\Form;

class CustomerForm extends Form
{
    public ?Customer $customer;

    public $isEditMode = false;

    public $name;

    public $email;

    public $phone_number;

    public $address;

    /**
     * Return the validation rules that apply to the request.
     *
     * @return array|string[]
     */
    public function rules(): array
    {
        if (! $this->isEditMode) {
            return [
                'name' => 'required',
                'email' => 'required|unique:customers',
                'phone_number' => 'required',
                'address' => 'required',
            ];
        } else {
            return [
                'name' => 'required',
                'email' => [
                    'required',
                    Rule::unique('customers')->ignore($this->customer),
                ],
                'phone_number' => 'required',
                'address' => 'required',
            ];
        }

    }

    /**
     * Set the customer.
     *
     * @param  \App\Models\Customer  $customer
     * @return void
     */
    public function setCustomer(Customer $customer): void
    {
        $this->customer = $customer;
        $this->name = $customer->name;
        $this->email = $customer->email;
        $this->phone_number = $customer->phone_number;
        $this->address = $customer->address;
        $this->isEditMode = true;
    }

    /**
     * Store the customer.
     *
     * @return \App\Models\Customer
     */
    public function store(): Customer
    {
        $this->validate();

        $customer = Customer::create(
            $this->pull()
        );

        $this->reset();

        return $customer;
    }

    /**
     * Update the customer.
     *
     * @return void
     */
    public function update(): void
    {
        $this->validate();

        $this->customer->update($this->all());

        $this->reset();
    }
}
