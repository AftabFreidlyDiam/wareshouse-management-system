<?php

namespace App\Http\LivewireApi\GoodsCategory\Pages;

use App\Models\GoodsCategory;
use Livewire\Component;
use Illuminate\Http\JsonResponse;

class AddCategoryPage extends Component
{
    public $name;
    public $description;

    protected $rules = [
        'name' => 'required|max:60',
        'description' => 'max:200',
    ];

    public function render()
    {
        return view('livewire.goods-category.pages.add-category-page');
    }

    public function submit() {

        foreach (request()->all() as $key => $value) {

            $camelKey = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $key))));


            if (property_exists($this, $camelKey)) {
                $this->$camelKey = $value;
            }
        }
        $this->validate();

        $category =  GoodsCategory::create([
                'name' => $this->name,
                'description' => $this->description
            ]);

        return new JsonResponse($category);


    }
}
