<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helper;

abstract class BaseRepository {

    public function __construct(protected Model $model)
    {
        $this->model = $model;
    }

    public function all(array $select = ['*'], array $withRelationships = [], bool $paginate = false, int $countPerPage = Helper::COUNT_PER_PAGE)
    {
        $query = $this->model->select($select)->with($withRelationships)->orderBy('id', 'desc');

        if ($paginate) {
            return $query->paginate($countPerPage);
        }
        
        return $query->get();
    }

    public function find(int $id)
    {
        return $this->model->find($id);
    }

    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    public function update(int $id, array $attributes)
    {
        $record = $this->find($id);
        $record->update($attributes);
        return $record;
    }

    public function delete(int $id)
    {
        $record = $this->find($id);
        return $record->delete();
    }

}