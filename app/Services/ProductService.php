<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use App\Services\FileService;
use App\Models\Product;

class ProductService
{
    public function __construct(
        protected ProductRepository $repo
    ) {}

    public function getAllPaginated($filters, $records){
        return $this->repo->allPaginated($filters, $records);
    }

    public function create(array $data)
    {
        try {
            if (isset($data['thumbnail']) && $data['thumbnail'] instanceof \Illuminate\Http\UploadedFile) {
                $data['thumbnail'] = FileService::upload($data['thumbnail'], 'uploads/products/thumbnails');
            }
            return $this->repo->create($data);
        } catch (Exception $e) {
            Log::error('Error creating product in service: ' . $e->getMessage());
            throw new Exception('An error occurred while creating the product.');
        }
    }

    public function update(Product $product, array $data)
    {
        try {
            if (isset($data['thumbnail']) && $data['thumbnail'] instanceof \Illuminate\Http\UploadedFile) {
                if (isset($product->thumbnail)) {
                    FileService::delete($product->thumbnail);
                }
                $data['thumbnail'] = FileService::upload($data['thumbnail'], 'uploads/products/thumbnails');
            }
            return $this->repo->update($product, $data);
        } catch (Exception $e) {
            Log::error('Error updating product in service: ' . $e->getMessage());
            throw new Exception('An error occurred while updating the product.');
        }
    }

    public function deleteMedia($path){
        return FileService::delete($path);
    }
}