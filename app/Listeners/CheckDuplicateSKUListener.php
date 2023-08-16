<?php
namespace App\Listeners;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Events\ProductCreated;
use App\Notifications\DuplicateSKUNotification;


class CheckDuplicateSKUListener implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ProductCreated  $event
     * @return void
     */
    public function handle(ProductCreated $event)
    {
  
        
        $sku = $event->sku;

        $existingProduct = DB::table('products')
            ->where('sku', $sku)
            ->first();
    
        if ($existingProduct) {
              dd($existingProduct);
            // Send email notification about the duplicate SKU
            $user = 'asim7349@gmail.com';
            $user->notify(new DuplicateSKUNotification($sku));
        }
    }
}

