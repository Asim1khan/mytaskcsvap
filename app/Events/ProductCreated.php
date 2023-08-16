<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class ProductCreated
{
    use SerializesModels;

    public $sku;

    /**
     * Create a new event instance.
     *
     * @param string $sku
     */
    public function __construct($sku)
    {
        $this->sku = $sku;
    }
}
