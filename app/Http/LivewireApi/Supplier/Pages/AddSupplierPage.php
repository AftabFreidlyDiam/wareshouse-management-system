<?php

namespace App\Http\LivewireApi\Supplier\Pages;

use App\Models\Supplier;
use Livewire\Component;
use Illuminate\Http\JsonResponse;


class AddSupplierPage extends Component
{
    public string $name;
    public string|null $address = null;
    public string|null $cp_phone = null;
    public string|null $cp_name = null;

    protected $rules = [
        'name' => 'required|max:60',
        'address' => 'max:200',
        'cp_phone' => 'sometimes|nullable|max:15|min:9',
        'cp_name' => 'max:60'
    ];

    public function submit() {

        foreach (request()->all() as $key => $value) {

            $camelKey = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $key))));


            if (property_exists($this, $camelKey)) {
                $this->$camelKey = $value;
            }
        }
        $this->validate();

        $supplier= Supplier::create([
            'name' => $this->name,
            'address' => $this->address,
            'cp_phone' => $this->cp_phone,
            'cp_name' => $this->cp_name,
        ]);

        return new JsonResponse($supplier);
    }

    public function render()
    {
        return view('livewire.supplier.pages.add-supplier-page');
    }
}
