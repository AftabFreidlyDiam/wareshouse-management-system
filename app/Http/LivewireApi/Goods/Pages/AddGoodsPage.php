<?php

namespace App\Http\LivewireApi\Goods\Pages;

use App\Models\Goods;
use App\Models\GoodsCategory;
use App\Models\Unit;
use Livewire\Component;
class AddGoodsPage extends Component
{
    public $name;
    public $code;
    public $categoryIds;
    public $stockLimit;
    public $unitId;
    public $description;
    public $price;

    public $categoryOptions;
    public $unitOptions;

    protected $rules = [
        'name' => 'required|max:80',
        'code' => 'required|max:25',
        'description' => 'max:200',
        'stockLimit' => 'numeric|min:0',
        'unitId' => 'required',
        'price' => 'numeric|min:0',
        'categoryIds' => 'required|array',
        'categoryIds.*' => 'exists:wms_goods_categories,id',
    ];


    public function mount() {
        $this->loadUnitOptions();
        $this->loadCategoryOptions();
    }

    public function loadUnitOptions() {
        $this->unitOptions = Unit::all(['id', 'name', 'symbol']);
    }

    public function loadCategoryOptions() {
        $this->categoryOptions = GoodsCategory::all()->pluck('name', 'id');
    }

    public function submit() {


        // Hydrate Livewire properties manually
        foreach (request()->all() as $key => $value) {

            $camelKey = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $key))));

            if ($key === 'minimum_stock') {
                $this->stockLimit = $value;
                continue;
            }
            if ($key === 'unit_id') {
                $this->unitId = $value;
                continue;
            }

            if (property_exists($this, $camelKey)) {
                $this->$camelKey = $value;
            }
        }


        $this->validate();

        $goods = Goods::create([
            'name' => $this->name,
            'code' => $this->code,
            'minimum_stock' => $this->stockLimit,
            'price' => $this->price,
            'unit_id' => $this->unitId,
            'description' => $this->description,
        ]);

        if ($goods) {
            $goods->categories()->attach($this->categoryIds);
        }
        return $goods;
    }
}
