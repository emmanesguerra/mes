<?php

namespace App\Observers;

use App\Model\Quotation;
use Illuminate\Support\Facades\Auth;

class QuotationObserver
{
    /**
     * Handle the slider "creating" event.
     *
     * @param  \App\Model\Slider  $slider
     * @return void
     */
    public function creating(Quotation $quotation)
    {
        $quotation->created_by = Auth::id();
    }

    /**
     * Handle the slider "updating" event.
     *
     * @param  \App\Model\Slider  $slider
     * @return void
     */
    public function updating(Quotation $quotation)
    {
        $quotation->updated_by = Auth::id();
    }
    
    /**
     * Handle the quotation "created" event.
     *
     * @param  \App\Model\Quotation  $quotation
     * @return void
     */
    public function created(Quotation $quotation)
    {
        //
    }

    /**
     * Handle the quotation "updated" event.
     *
     * @param  \App\Model\Quotation  $quotation
     * @return void
     */
    public function updated(Quotation $quotation)
    {
        //
    }

    /**
     * Handle the quotation "deleted" event.
     *
     * @param  \App\Model\Quotation  $quotation
     * @return void
     */
    public function deleted(Quotation $quotation)
    {
        //
    }

    /**
     * Handle the quotation "restored" event.
     *
     * @param  \App\Model\Quotation  $quotation
     * @return void
     */
    public function restored(Quotation $quotation)
    {
        //
    }

    /**
     * Handle the quotation "force deleted" event.
     *
     * @param  \App\Model\Quotation  $quotation
     * @return void
     */
    public function forceDeleted(Quotation $quotation)
    {
        //
    }
}
