<?php

namespace App\Services;

use App\Models\Component;
use App\Models\PageComponent;
use App\Services\FileService;

class ComponentProcessorService
{
    public function transformJson($data, $component, $pageComponent = null)
    {
        $schema = $component->fields['fields'] ?? [];
        if(isset($data['parent_id'])){
            if (isset($data['parent_id'], $component->fields['children'])) {
                $schema = $component->fields['children'] ?? [];
            }
        }
        $jsonData = [];

        foreach ($schema as $field) {
            if(isset($field['children'])){
                continue;
            }
            $name = $field['name'];
            $isFile = $field['type'] === 'file';
            $newValue = $data[$name] ?? null;
            $oldValue = ($pageComponent && $pageComponent->component_id == $data['component_id'])
            ? ($pageComponent->fields_data[$name] ?? null)
            : null;

            if ($isFile) {
                if (!empty($newValue)) {
                    if (!empty($oldValue)) {
                        FileService::delete($oldValue);
                    }
                    $jsonData[$name] = FileService::upload($newValue, 'uploads/page-components/media');
                } elseif (!empty($oldValue)) {
                    $jsonData[$name] = $oldValue;
                } else {
                    $jsonData[$name] = null;
                }
            } else {
                $jsonData[$name] = $newValue ?? null;
            }
        }

        $data['fields_data'] = $jsonData;
        return $data;
    }

}