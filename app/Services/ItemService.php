<?php 

namespace App\Services;

use App\Jobs\SendMailJob;
use App\Repositories\ItemRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ItemService {

    public function calculTotalPrice(float $price, int $quantity) {
        $totalPrice = $price * $quantity;
        return str_replace(',', '', number_format($totalPrice, 2));
    }

}