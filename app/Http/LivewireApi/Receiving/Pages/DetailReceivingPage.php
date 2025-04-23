<?php

namespace App\Http\LivewireApi\Receiving\Pages;

use App\Models\GoodsTransaction;
use App\Services\PrintService;
use Livewire\Component;
use Illuminate\Http\JsonResponse;

class DetailReceivingPage extends Component
{
    public $transactionId;
    public $transaction;

    public function mount($id) {
        $this->transactionId = $id;
        $this->loadTransaction();
    }

    public function loadTransaction() {
        $this->transaction = GoodsTransaction::with(['creator', 'supplier','items'])
        ->receiving()->where('id', $this->transactionId)->first();
    }

    public function printPDF() {
        $pdfContent = PrintService::printReceivingDetail($this->transaction)->output();
        $filename = __('receiving') . '-' . gmdate("Ymd", $this->transaction->transaction_at) . '.pdf';

        $this->dispatchBrowserEvent('toast',[
            'type' => 'success',
            'message' => __('PDF is ready')
        ]);

        return response()->streamDownload(
            fn () => print($pdfContent),
            $filename
        );
    }

    public function getEdit( $id )
    {
        $this->mount($id);
        return new JsonResponse($this->transaction);
    }
    public function render()
    {
        return view('livewire.receiving.pages.detail-receiving-page');
    }
}
