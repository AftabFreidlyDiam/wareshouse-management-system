<?php

namespace App\Http\LivewireApi\Supplier\Pages;

use Livewire\Component;
use App\Models\Supplier;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Builder;

class IndexPage extends Component
{

    public function builder(): Builder
    {
        return Supplier::query();
    }

    public function supplierList()
    {
        $list = $this->builder()->get();
        return new JsonResponse($list, 200);
    }
    public function render()
    {
        return view('livewire.supplier.pages.index-page');
    }
}
