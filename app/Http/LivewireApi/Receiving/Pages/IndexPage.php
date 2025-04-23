<?php

namespace App\Http\LivewireApi\Receiving\Pages;

use Livewire\Component;
use App\Models\Receiving;
use Illuminate\Http\JsonResponse;





class IndexPage extends Component
{


    public function render()
    {
        return view('livewire.receiving.pages.index-page');
    }
}
