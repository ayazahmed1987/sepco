<?php

namespace App\Services;

use App\Models\Component;
use App\Repositories\ComponentRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Services\FileService;

class ComponentService
{
    protected ComponentRepository $componentRepository;

    public function __construct(ComponentRepository $componentRepository)
    {
        $this->componentRepository = $componentRepository;
    }

    /**
     * Get all components.
     */
    public function getAllComponents()
    {
        try {
            return $this->componentRepository->all();
        } catch (Exception $e) {
            Log::error('Error fetching components in service: ' . $e->getMessage());
            throw new Exception('An error occurred while fetching components.');
        }
    }

    /**
     * Get all components with pagination.
     */
    public function getAllComponentsPaginated($filters, $perComponent)
    {
        try {
            return $this->componentRepository->allPaginated($filters, $perComponent);
        } catch (Exception $e) {
            Log::error('Error fetching components in service: ' . $e->getMessage());
            throw new Exception('An error occurred while fetching components.');
        }
    }

    /**
     * Create a new component.
     */
    public function createComponent(array $data)
    {
        try {
            if($data['type'] == 1 && $data['fields']){
                $data['fields'] = json_decode($data['fields']);
            }
            return $this->componentRepository->create($data);
        } catch (Exception $e) {
            Log::error('Error creating component in service: ' . $e->getMessage());
            throw new Exception('An error occurred while creating the component.');
        }
    }

    /**
     * Update the component.
     */
    public function updateComponent(Component $component, array $data)
    {
        try {
            if (!$component) {
                throw new ComponentNotFoundException('Component not found.');
            }
            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                $data['image'] = FileService::upload($data['image'], 'uploads/components/images');
            }
            if($data['type'] == 1 && $data['fields']){
                $data['fields'] = json_decode($data['fields']);
            }
            return $this->componentRepository->update($component, $data);
        } catch (Exception $e) {
            Log::error('Error updating component in service: ' . $e->getMessage());
            throw new Exception('An error occurred while updating the component.');
        }
    }

    /**
     * Delete the component.
     */
    public function deleteComponent(Component $component)
    {
        try {
            if (isset($component->image)) {
                FileService::delete($component->image);
            }
            return $this->componentRepository->delete($component);
        } catch (Exception $e) {
            Log::error('Error deleting component in service: ' . $e->getMessage());
            throw new Exception('An error occurred while deleting the component.');
        }
    }

    /**
     * Toggle the status of existing component
     */
    public function toggleStatus($request)
    {
        try {
            $component = Component::where('id',$request['id'])->first();
            if(!$component){
                throw new ComponentNotFoundException('Component not found.');
            }
            $component->status = $request['status'];
            $component->save();
            return $component;
        } catch (Exception $e) {
            Log::error('Error updating component status in service: ' . $e->getMessage());
            throw new Exception('An error occurred while updating the component status.');
        }
    }

    /**
     * Toggle the status of existing component
     */
    public function fieldsRender($request)
    {
        try {    
            $component = Component::where('id',$request->component_id)->first();
            if(!$component){
                throw new Exception('Component not found.');
            }
            $is_children = $request->is_children;
            if($is_children){
                if(!isset($component->fields['children'])){
                    throw new Exception('The selected component does not support children components.');
                }
                $fields = $component->fields['children'] ?? [];
                $dataComponent = $component;
                return view('backend.cms.components.rendering-components.render-fields',compact('fields','dataComponent'))->render();
            }
            $fields = $component->fields['fields'] ?? [];
            $dataComponent = $component;
            return view('backend.cms.components.rendering-components.render-fields',compact('fields','dataComponent'))->render();
        } catch (Exception $e) {
            Log::error('Error rendering component fields in service: ' . $e->getMessage());
            throw new Exception($e->getMessage());
        }
    }
}