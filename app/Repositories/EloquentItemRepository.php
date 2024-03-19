<?php

namespace App\Repositories;

use App\Models\Item;

class EloquentItemRepository extends BaseRepository implements ItemRepositoryInterface {

    public function __construct(protected Item $item)
    {
        parent::__construct($item);
    }
}