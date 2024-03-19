<?php

namespace App\Repositories;

use App\Helpers\Helper;

interface ItemRepositoryInterface {

    public function all(array $select = ['*'], array $withRelationships = [], bool $paginate = false, int $countPerPage = Helper::COUNT_PER_PAGE);

    public function find(int $id);

    public function create(array $attributes);

    public function update(int $id, array $attributes);

    public function delete(int $id);
    
}