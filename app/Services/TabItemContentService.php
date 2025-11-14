<?php

namespace App\Services;

use App\Repositories\TabItemContentRepository;
use App\Services\FileService;
use App\Models\TabItemContent;

class TabItemContentService
{
    public function __construct(
        protected TabItemContentRepository $repo
    ) {}

    public function create($data){
        try {
            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                $data['image'] = FileService::upload($data['image'], 'uploads/tab-item-content/images');
            }
            return $this->repo->create($data);
        } catch (Exception $e) {
            Log::error('Error creating tab item content in service: ' . $e->getMessage());
            throw new Exception('An error occurred while creating the tab item content.');
        }
    }

    public function update(TabItemContent $tab_item_content, $data){
        try {
            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                if (isset($tab_item_content->image)) {
                    FileService::delete($tab_item_content->image);
                }
                $data['image'] = FileService::upload($data['image'], 'uploads/tab-item-content/images');
            }
            return $this->repo->update($tab_item_content, $data);
        } catch (Exception $e) {
            Log::error('Error creating tab item content in service: ' . $e->getMessage());
            throw new Exception('An error occurred while creating the tab item content.');
        }
    }
}