<?php 

namespace App\Services;

use App\Jobs\SendMailJob;
use App\Repositories\ItemRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ItemService {

    public function __construct(protected ItemRepositoryInterface $itemRepositoryInterface)
    {
        $this->itemRepositoryInterface  = $itemRepositoryInterface;
    }

    public function all()
    {
        return $this->itemRepositoryInterface->all(["*"], [], true);
    }

    public function find(int $id)
    {
        return $this->itemRepositoryInterface->find($id);
    }

    public function create(array $attributes)
    {
        try {
            DB::beginTransaction();
            $attributes['total_price'] = $this->calculTotalPrice($attributes['price'], $attributes['quantity']);
            $newItem = $this->itemRepositoryInterface->create($attributes);
            SendMailJob::dispatch()->onQueue('emails');
            DB::commit();

            return $newItem;

        } catch (\Exception $error) {
            DB::rollback();
            throw $error;
        }

        return $newItem;
    }

    public function update(int $id, array $attributes)
    {
        try {
            DB::beginTransaction();
            $attributes['total_price'] = $this->calculTotalPrice($attributes['price'], $attributes['quantity']);
            $updatedItem = $this->itemRepositoryInterface->update($id, $attributes);
            SendMailJob::dispatch()->onQueue('emails');
            DB::commit();

            return $updatedItem;
            
        } catch (\Exception $error) {
            DB::rollback();
            throw $error;
        }
    }

    public function delete(int $id)
    {
        try {
            DB::beginTransaction();
            $deletedItem = $this->itemRepositoryInterface->delete($id);
            DB::commit();

            return $deletedItem;

        } catch (\Exception $error) {
            DB::rollback();
            throw $error;
        }
    }

    public function calculTotalPrice(float $price, int $quantity) {
        $totalPrice = $price * $quantity;
        return str_replace(',', '', number_format($totalPrice, 2));
    }

}