<?php

namespace App\Http\LivewireApi\Shipper\Pages;

use App\Models\Shipper;
use Livewire\Component;
use Illuminate\Http\JsonResponse;

class AddShipperPage extends Component
{
    public string $name;
    public $cp_phone;

    protected $rules = [
        'name' => 'required|max:60',
        // 'cp_phone' => 'string|min:9|max:15',
    ];

    public function submit() {


        foreach (request()->all() as $key => $value) {
            $camelKey = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $key))));

            if (property_exists($this, $camelKey)) {
                $this->$camelKey = $value;
            }
        }
        $this->validate();


        $shipper = Shipper::create([
            'name' => $this->name,
            'cp_phone' => $this->cp_phone
        ]);

        return new JsonResponse($shipper);
    }

    public function render()
    {
        return view('livewire.shipper.pages.add-shipper-page');
    }
}
