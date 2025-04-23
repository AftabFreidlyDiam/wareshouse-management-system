<?php

namespace App\Http\LivewireApi\Receiving\Pages;

use Livewire\Component;
use Illuminate\Http\JsonResponse;
use App\Models\GoodsTransaction;
use Illuminate\Database\Eloquent\Builder;




class IndexPage extends Component
{

    public function builder(): Builder
    {
        return GoodsTransaction::with(['creator', 'supplier','items'])
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
