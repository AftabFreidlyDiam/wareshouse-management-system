<?php

namespace App\Http\LivewireApi\GoodsCategory\Pages;

use App\Models\GoodsCategory;
use Livewire\Component;
use Illuminate\Http\JsonResponse;

class EditCategoryPage extends Component
{
    public $categoryId;
    public $category;
    public $name;
    public $description;

    protected $rules = [
        'name' => 'required|max:60',
        'description' => 'max:200',
        'categoryId' => 'required|exists:wms_goods_categories,id',
    ];

    public function mount($id) {
        $this->categoryId = $id;
        $this->loadCategory();
    }

    public function loadCategory() {

        $this->category = GoodsCategory::where('id', $this->categoryId)->first();


        if (!$this->category) {
            return new JsonResponse(['code'=>404,'message'=> 'Category Not Exits'], 404);
            // return redirect()->to('goods-category.index');
        }

        $this->name = $this->category->name;
        $this->description = $this->category->description;
    }

    public function submit() {
        foreach (request()->all() as $key => $value) {

            $camelKey = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $key))));

            if (property_exists($this, $camelKey)) {
                $this->$camelKey = $value;
            }
        }
        $this->validate();
        $this->category = GoodsCategory::where('id', request()->categoryId)->first();
        $this->category->update([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        return new JsonResponse($this->category);
    }
    public function getEdit( $id )
    {
        $this->mount($id);
        return new JsonResponse($this->category);
    }


    public function render()
    {
        return view('livewire.goods-category.pages.edit-category-page');
    }
}
