<?php

namespace App\Services;

use App\Models\Component;
use App\Models\PageComponent;
use App\Repositories\PageComponentRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Services\FileService;
use App\Services\ComponentProcessorService;

class PageComponentService
{
    protected PageComponentRepository $pageComponentRepository;
    protected ComponentProcessorService $componentProcessor;

    public function __construct(PageComponentRepository $pageComponentRepository, ComponentProcessorService $componentProcessor)
    {
        $this->pageComponentRepository = $pageComponentRepository;
        $this->componentProcessor = $componentProcessor;
    }

    /**
     * Create a new page component.
     */
    public function createPageComponent($data)
    {
        try {
            $component = Component::findorFail($data['component_id']);
            if($this->shouldTransformData($data)){
                $data = $this->componentProcessor->transformJson($data, $component);
            }
            return $this->pageComponentRepository->create($data);
        } catch (Exception $e) {
            Log::error('Error creating page component in service: ' . $e->getMessage());
            throw new Exception('An error occurred while creating the page component.');
        }
    }

    /**
     * update a component.
     */
    public function updatePageComponent($data, $page, $pageComponent)
    {
        if ($this->shouldDeleteOldFiles($data, $pageComponent)) {
            $this->deleteOldComponentFiles($pageComponent);
        }
        $data = $this->shouldTransformData($data) ? $data = $this->componentProcessor->transformJson($data, $pageComponent->component, $pageComponent) : $data['fields_data'] = null;
        return $this->pageComponentRepository->update($pageComponent, $data);
    }

    public function shouldTransformData($data){
        return $data['type'] == 1 && $data['component_id'];
    }

    /**
     * Checks should we delete old files or not
     */
    private function shouldDeleteOldFiles(array $data, PageComponent $pageComponent): bool
    {
        return $pageComponent->type == 1 && (
            $data['type'] != $pageComponent->type ||
            $data['component_id'] != $pageComponent->component_id
        );
    }

    /**
     * Delete existing component files
     */
    private function deleteOldComponentFiles(PageComponent $pageComponent): void
    {
        $fields = $pageComponent->component->fields['fields'] ?? [];
        if($pageComponent->type == 1){
            if (isset($pageComponent->parent_id, $pageComponent->component->field['children'])) {
                $fields = $pageComponent->component->fields['children'] ?? [];
            }
            $fields = $pageComponent->component->fields['fields'] ?? [];
        }
        foreach ($fields as $field) {
            if ($field['type'] === 'file') {
                $fileName = $field['name'] ?? null;
                if ($fileName && !empty($pageComponent->fields_data[$fileName])) {
                    FileService::delete($pageComponent->fields_data[$fileName]);
                }
            }
        }
        $pageComponent->fields_data = "";
        $pageComponent->save();
    }

    /**
     * destroy a component.
     */
    public function destroyPageComponent($pageComponent)
    {
        $this->deleteOldComponentFiles($pageComponent);
        return $pageComponent->delete();
    }
}