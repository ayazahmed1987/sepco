<?php

namespace App\Services;

use App\Repositories\TabItemRepository;
use App\Services\FileService;
use App\Models\TabItem;

class TabItemService
{
     public function __construct(
        protected TabItemRepository $repo
    ) {}

    public function create($data){
        try {
            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                $data['image'] = FileService::upload($data['image'], 'uploads/tab-items/images');
            }
            return $this->repo->create($data);
        } catch (Exception $e) {
            Log::error('Error creating tab item in service: ' . $e->getMessage());
            throw new Exception('An error occurred while creating the tab item.');
        }
    }

    public function update(TabItem $tab_item, $data){
        try {
            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                if (isset($tab_item->image)) {
                    FileService::delete($tab_item->image);
                }
                $data['image'] = FileService::upload($data['image'], 'uploads/tab-items/images');
            }
            return $this->repo->update($tab_item, $data);
        } catch (Exception $e) {
            Log::error('Error creating tab item in service: ' . $e->getMessage());
            throw new Exception('An error occurred while creating the tab item.');
        }
    }
}