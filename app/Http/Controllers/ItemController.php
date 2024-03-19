<?php

namespace App\Http\Controllers;

use App\Http\Requests\Items\DeleteItemRequest;
use App\Http\Requests\Items\ShowItemRequest;
use App\Http\Requests\Items\StoreItemRequest;
use App\Http\Requests\Items\UpdateItemRequest;
use App\Http\Resources\ItemResource;
use App\Services\ItemService;
use Illuminate\Support\Facades\Log;

class ItemController extends Controller
{
    public function __construct(protected ItemService $itemService)
    {
        $this->itemService = $itemService;
    }

    public function index() {
        try {

            $items = $this->itemService->all();
            return ItemResource::collection($items);

        } catch(\Exception $error) {
            Log::error('ItemController - (index) : ' . $error->getMessage() . "\n Trace : " . json_encode($error->getTrace()));
            return response()->json(['errors' => 'Something wrong !'], 500);
        }
    }

    public function show(int $id, ShowItemRequest $request) {
        try {

            $items = $this->itemService->find($id);
            return new ItemResource($items);

        } catch(\Exception $error) {
            Log::error('ItemController - (show) : ' . $error->getMessage() . "\n Trace : " . json_encode($error->getTrace()));
            return response()->json(['errors' => 'Something wrong !'], 500);
        }
    }

    public function store(StoreItemRequest $request) {
        try {

            $validated_data = $request->validated();
            $this->itemService->create($validated_data);   
            return response()->json(['message' => 'This item has been stored successfully.'], 201);

        } catch(\Exception $error) {
            Log::error('ItemController - (store) : ' . $error->getMessage() . "\n Trace : " . json_encode($error->getTrace()));
            return response()->json(['errors' => 'Something wrong !'], 500);
        }
    }

    public function update(int $id, UpdateItemRequest $request) {
        try {

            $validated_data = $request->validated();
            $this->itemService->update($id, $validated_data);
            return response()->json(['message' => 'This item has been updated successfully.'], 200);

        } catch(\Exception $error) {
            Log::error('ItemController - (update) : ' . $error->getMessage() . "\n Trace : " . json_encode($error->getTrace()));
            return response()->json(['errors' => 'Something wrong !'], 500);
        }
    }

    public function destroy(int $id, DeleteItemRequest $request) {
        try {

            $this->itemService->delete($id);
            return response()->json(['message' => 'This item has been deleted successfully.'], 200);

        } catch(\Exception $error) {
            Log::error('ItemController - (destroy) : ' . $error->getMessage() . "\n Trace : " . json_encode($error->getTrace()));
            return response()->json(['errors' => 'Something wrong !'], 500);
        }
    }

}
