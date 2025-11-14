<?php

namespace App\Services;

use App\Models\CustomPost;
use App\Models\CustomPostData;
use App\Repositories\CustomPostDataRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Services\FileService;

class CustomPostDataService
{
    protected CustomPostDataRepository $custompostdataRepository;

    public function __construct(CustomPostDataRepository $custompostdataRepository)
    {
        $this->custompostdataRepository = $custompostdataRepository;
    }

    /**
     * Get all custompostdatas.
     */
    public function getAllCustompostdatas()
    {
        try {
            return $this->custompostdataRepository->all();
        } catch (Exception $e) {
            Log::error('Error fetching custompostdatas in service: ' . $e->getMessage());
            throw new Exception('An error occurred while fetching custompostdatas.');
        }
    }

    /**
     * Get all custompostdatas with pagination.
     */
    public function getAllCustompostsDataPaginated($filters, $perCustompostdata)
    {
        try {
            return $this->custompostdataRepository->allPaginated($filters, $perCustompostdata);
        } catch (Exception $e) {
            Log::error('Error fetching custompostdatas in service: ' . $e->getMessage());
            throw new Exception('An error occurred while fetching custompostdatas.');
        }
    }

    /**
     * Create a new custompostdata.
     */
    public function createCustompostdata(array $data)
    {
        try {
            //if($data['fields']){
            //    $data['fields'] = json_decode($data['fields']);
            //}
			
			//dump($data);
			
			$custompost = CustomPost::findorFail($data['custom_post_id']);
            $data = $this->transformJson($data, $custompost);
			//dump($data);
            return $this->custompostdataRepository->create($data);
			
        } catch (Exception $e) {
            Log::error('Error creating custompostdata in service: ' . $e->getMessage());
            throw new Exception('An error occurred while creating the custompostdata.');
        }
    }
	


    /**
     * Update the custompostdata.
     */
	public function updateCustompostdata($data, $custompostData)
    {
        if ($this->shouldDeleteOldFiles($data, $custompostData)) {
            $this->deleteOldCustompostFiles($custompostData);
        }
        $data = $this->shouldTransformData($data) ? $data = $this->transformJson($data, $custompostData->custompost, $custompostData) : $data['fields_data'] = null;
        return $this->custompostdataRepository->update($custompostData, $data);
    }
	
	public function shouldTransformData($data){
        return $data['custom_post_id'];
    }

    /**
     * Checks should we delete old files or not
     */
    private function shouldDeleteOldFiles(array $data, CustomPostData $custompostData): bool
    {
        return $data['custom_post_id'] != $custompostData->custom_post_id;
    }

    /**
     * Delete existing custompost files
     */
    private function deleteOldCustompostFiles(CustomPostData $custompostData): void
    {
        $fields = $custompostData->custompost->fields['fields'] ?? [];
        foreach ($fields as $field) {
            if ($field['type'] === 'file') {
                $fileName = $field['name'] ?? null;
                if ($fileName && !empty($custompostData->fields_data[$fileName])) {
                    FileService::delete($custompostData->fields_data[$fileName]);
                }
            }
        }
        $custompostData->fields_data = "";
        $custompostData->save();
    }


    /**
     * Delete the custompostdata.
     */
    public function deleteCustompostdata(CustomPostData $custompostdata)
    {
        try {
            //if (isset($custompostdata->image)) {
            //    FileService::delete($custompostdata->image);
            //}
			$this->deleteOldCustompostFiles($custompostdata);
            return $this->custompostdataRepository->delete($custompostdata);
        } catch (Exception $e) {
            Log::error('Error deleting custompostdata in service: ' . $e->getMessage());
            throw new Exception('An error occurred while deleting the custompostdata.');
        }
    }

    /**
     * Toggle the status of existing custompostdata
     */
    public function toggleStatus($request)
    {
        try {
            $custompostdata = CustomPostData::where('id',$request['id'])->first();
            if(!$custompostdata){
                throw new CustompostNotFoundException('CustomPostData not found.');
            }
            $custompostdata->status = $request['status'];
            $custompostdata->save();
            return $custompostdata;
        } catch (Exception $e) {
            Log::error('Error updating custompostdata status in service: ' . $e->getMessage());
            throw new Exception('An error occurred while updating the custompostdata status.');
        }
    }

    
	
	
	public function transformJson($data, $custompost, $custompostData = null)
    {
        $table_name = $custompost->table_name;
		$schema = $custompost->fields['fields'] ?? [];
        $jsonData = [];

        foreach ($schema as $field) {
            if(isset($field['children'])){
                continue;
            }
            $name = $field['name'];
            $isFile = $field['type'] === 'file';
			$isFiles = $field['type'] === 'files';
            $newValue = $data[$name] ?? null;
            $oldValue = ($custompostData && $custompostData->custom_post_id == $data['custom_post_id'])
            ? ($custompostData->fields_data[$name] ?? null)
            : null;

            /*
            if ($isFile) {
                if (!empty($newValue)) {
                    if (!empty($oldValue)) {
                        FileService::delete($oldValue);
                    }
					$jsonData[$name] = FileService::upload($newValue, "uploads/{$table_name}/media");

                } elseif (!empty($oldValue)) {
                    $jsonData[$name] = $oldValue;
                } else {
                    $jsonData[$name] = null;
                }
            } else {
                $jsonData[$name] = $newValue ?? null;
            }
			*/
			// Single file upload
if ($isFile) {
    if (!empty($newValue)) {
        if (!empty($oldValue)) {
            FileService::delete($oldValue);
        }
        $jsonData[$name] = FileService::upload($newValue, "uploads/{$table_name}/media");
    } elseif (!empty($oldValue)) {
        $jsonData[$name] = $oldValue;
    } else {
        $jsonData[$name] = null;
    }
}

// Multi-file upload
elseif ($isFiles) {
    $uploadedFiles = [];

    // If there are new files
    if (!empty($newValue) && is_array($newValue)) {

        // Optional: delete old files if you want to replace them completely
        if (!empty($oldValue) && is_array($oldValue)) {
            foreach ($oldValue as $oldFile) {
                FileService::delete($oldFile);
            }
        }

        // Upload each new file
        foreach ($newValue as $file) {
            $uploadedFiles[] = FileService::upload($file, "uploads/{$table_name}/media");
        }

        $jsonData[$name] = $uploadedFiles;
    }

    // If no new files but old ones exist — keep them
    elseif (!empty($oldValue)) {
        $jsonData[$name] = $oldValue;
    }

    // Nothing old or new
    else {
        $jsonData[$name] = [];
    }
}

// Default (non-file fields)
else {
    $jsonData[$name] = $newValue ?? null;
}

			
			//upload Multifiles
			
			
			
			
        }

        $data['fields_data'] = $jsonData;
        return $data;
    }
	
	
	
	
	
	
	
	
	
	
	
}