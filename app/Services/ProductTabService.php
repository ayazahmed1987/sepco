<?php

namespace App\Services;

use App\Repositories\ProductTabRepository;
use App\Models\ProductTab;

class ProductTabService
{
    public function __construct(
        protected ProductTabRepository $repo
    ) {}

    public function create($data){
        return $this->repo->create($data);
    }

    public function update(ProductTab $product_tab, $data){
        return $this->repo->update($product_tab, $data);
    }
}