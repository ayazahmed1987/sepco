<?php

namespace App\Repositories;

use App\Models\TabItem;

class TabItemRepository
{
    public function __construct(
        protected TabItem $model
    ) {}

    public function create($data){
        return $this->model->create($data);
    }

    public function update(TabItem $tab_item, $data){
        return $tab_item->update($data);
    }
}