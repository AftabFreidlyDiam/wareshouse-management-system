<?php

namespace App\Http\LivewireApi\Supplier\Pages;

use App\Models\Supplier;
use Livewire\Component;
use Illuminate\Http\JsonResponse;
class EditSupplierPage extends Component
{
    public string $name;
    public string|null $address = null;
    public string|null $cp_phone = null;
    public string|null $cp_name = null;

    public $supplier;
    public $supplierId;

    protected $rules = [
        'name' => 'required|max:60',
        'address' => 'max:200',
        'cp_phone' => 'sometimes|nullable|max:15|min:9',
        'cp_name' => 'max:60'
    ];

    public function mount($id) {
        $this->supplierId = $id;
        $this->loadSupplier();
    }

    public function loadSupplier() {
        $this->supplier = Supplier::where('id', $this->supplierId)->first();
        if ($this->supplier) {
            $this->name = $this->supplier->name;
            $this->address = $this->supplier->address;
            $this->cp_name = $this->supplier->cp_name;
            $this->cp_phone = $this->supplier->cp_phone;

            return;
        }
        return redirect()->to(route('shipper.index'));
    }

    public function submit() {
        foreach (request()->all() as $key => $value) {

            $camelKey = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $key))));

            if (property_exists($this, $camelKey)) {
                $this->$camelKey = $value;
            }
        }
        $this->validate();
        $this->supplier = Supplier::where('id', $this->supplierId)->first();

        $this->supplier->update([
            'name' => $this->name,
            'address' => $this->address,
            'cp_phone' => $this->cp_phone,
            'cp_name' => $this->cp_name,
        ]);

        return new JsonResponse($this->supplier);
    }
    public function getEdit( $id )
    {
        $this->mount($id);
        return new JsonResponse($this->supplier);
    }
    public function render()
    {
        return view('livewire.supplier.pages.edit-supplier-page');
    }
}
