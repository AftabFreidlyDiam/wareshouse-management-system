<?php

namespace App\Http\LivewireApi\Shipper\Pages;

use Livewire\Component;
use App\Models\Shipper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;

class IndexPage extends Component
{
    public function builder(): Builder
    {
        return Shipper::select('*');

    }
    public function shipperList()
    {
        $list = $this->builder()->get();
        return new JsonResponse($list, 200);
    }
    public function render()
    {
        return view('livewire.shipper.pages.index-page');
    }
}
