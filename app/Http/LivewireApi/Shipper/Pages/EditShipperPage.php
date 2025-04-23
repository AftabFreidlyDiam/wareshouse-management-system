<?php

namespace App\Http\LivewireApi\Shipper\Pages;

use App\Models\Shipper;
use Livewire\Component;
use Illuminate\Http\JsonResponse;

class EditShipperPage extends Component
{
    public string $name;
    public string $cp_phone;

    public $shipper;
    public $shipperId;

    protected $rules = [
        'name' => 'required|max:60',
        'cp_phone' => 'max:15|min:9',
        'shipperId' => 'required|exists:wms_shipper,id',
    ];

    public function mount($id) {
        $this->shipperId = $id;
        $this->loadShipper();
    }

    public function loadShipper() {
        $this->shipper = Shipper::where('id', $this->shipperId)->first();
        if ($this->shipper) {
            $this->name = $this->shipper->name;
            $this->cp_phone = $this->shipper->cp_phone;

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


        $this->shipper = Shipper::where('id', $this->shipperId)->first();

        dd($this->shipper);
        $this->validate();
        $this->shipper->update([
            'name' => $this->name,
            'cp_phone' => $this->cp_phone,
        ]);

        return new JsonResponse($this->shipper);
    }

    public function getEdit( $id )
    {
        $this->mount($id);
        return new JsonResponse($this->shipper);
    }
    public function render()
    {
        return view('livewire.shipper.pages.edit-shipper-page');
    }
}
