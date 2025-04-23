<?php

namespace App\Http\LivewireApi\Goods\Pages;

use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

use App\Models\Goods;

class IndexPage extends Component
{

    public function builder(): Builder
    {
        return Goods::query();
    }

    public function list()
    {
        $list = $this->builder()->get();
        return new JsonResponse($list, 200);
    }

    public function render()
    {
        return view('livewire.goods.pages.index-page');
    }
}
