<?php

namespace App\Repositories;

use App\Models\ProductTab;

class ProductTabRepository
{
    public function __construct(
        protected ProductTab $model
    ) {}

    public function create($data){
        return $this->model->create($data);
    }

    public function update(ProductTab $product_tab, $data){
        return $product_tab->update($data);
    }
}