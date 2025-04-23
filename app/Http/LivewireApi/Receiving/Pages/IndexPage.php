<?php

namespace App\Http\LivewireApi\Receiving\Pages;

use Livewire\Component;
use App\Models\Receiving;
use Illuminate\Http\JsonResponse;





class IndexPage extends Component
{

    public function builder(): Builder
    {
        return GoodsTransaction::with(['creator', 'supplier'])
            ->receiving()
            ->withCount('items');
    }
    public function getList()
    {
        $list = $this->builder()->get();
        return new JsonResponse($list, 200);
    }
    public function render()
    {
        return view('livewire.receiving.pages.index-page');
    }
}
