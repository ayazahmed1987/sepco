<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class ProductRepository
{
    public function __construct(
        protected Product $model
    ) {}

    public function allPaginated($filters, $perComponent){
        $query = $this->model->query();
        if (!empty($filters['search'])) {
            $searchTerm = $filters['search'];
            $query->where(function (Builder $q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%");
            });
        }
        return $query->paginate($perComponent);
    }

    public function create(array $data)
    {
        try {
            return $this->model->create($data);
        } catch (\Exception $e) {
            \Log::error('Error creating product in repository: ' . $e->getMessage());
            throw new \Exception('An error occurred while saving the product to the database.');
        }
    }

    public function update(Product $product, array $data)
    {
        try {
            return $product->update($data);
        } catch (\Exception $e) {
            \Log::error('Error updating product in repository: ' . $e->getMessage());
            throw new \Exception('An error occurred while updating the product in the database.');
        }
    }
}