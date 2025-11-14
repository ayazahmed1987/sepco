<?php

namespace App\Repositories;

use App\Models\TabItemContent;

class TabItemContentRepository
{
    public function __construct(
        protected TabItemContent $model
    ) {}

    public function create($data){
        return $this->model->create($data);
    }

    public function update(TabItemContent $tab_item_content, $data){
        return $tab_item_content->update($data);
    }
}