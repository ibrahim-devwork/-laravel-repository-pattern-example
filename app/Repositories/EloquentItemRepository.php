<?php

namespace App\Repositories;

use App\Helpers\Helper;
use App\Jobs\SendMailJob;
use App\Models\Item;
use App\Services\ItemService;
use Illuminate\Support\Facades\DB;

class EloquentItemRepository extends BaseRepository implements ItemRepositoryInterface {

    public function __construct(
        protected Item $item,
        protected ItemService $itemService
    ) {
        parent::__construct($item);
        $this->itemService = $itemService;
    }

    public function create(array $attributes)
    {
        $attributes['total_price'] = $this->itemService->calculTotalPrice($attributes['price'], $attributes['quantity']);
        $newItem = $this->item->create($attributes);
        SendMailJob::dispatch()->onQueue('emails');
        DB::commit();

        return $newItem;
    }

    public function update(int $id, array $attributes)
    {
        $attributes['total_price'] = $this->itemService->calculTotalPrice($attributes['price'], $attributes['quantity']);
        $updatedItem = $this->find($id);
        $updatedItem->update($attributes);
        SendMailJob::dispatch()->onQueue('emails');

        return $updatedItem;
    }
   
}