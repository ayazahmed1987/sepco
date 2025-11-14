<?php

namespace App\Services;

use App\Models\CustomPost;
use App\Repositories\CustomPostRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Services\FileService;

class CustomPostService
{
    protected CustomPostRepository $custompostRepository;

    public function __construct(CustomPostRepository $custompostRepository)
    {
        $this->custompostRepository = $custompostRepository;
    }

    /**
     * Get all customposts.
     */
    public function getAllCustomposts()
    {
        try {
            return $this->custompostRepository->all();
        } catch (Exception $e) {
            Log::error('Error fetching customposts in service: ' . $e->getMessage());
            throw new Exception('An error occurred while fetching customposts.');
        }
    }

    /**
     * Get all customposts with pagination.
     */
    public function getAllCustompostsPaginated($filters, $perCustompost)
    {
        try {
            return $this->custompostRepository->allPaginated($filters, $perCustompost);
        } catch (Exception $e) {
            Log::error('Error fetching customposts in service: ' . $e->getMessage());
            throw new Exception('An error occurred while fetching customposts.');
        }
    }

    /**
     * Create a new custompost.
     */
    public function createCustompost(array $data)
    {
        try {
            if($data['fields']){
                $data['fields'] = json_decode($data['fields']);
            }
            return $this->custompostRepository->create($data);
        } catch (Exception $e) {
            Log::error('Error creating custompost in service: ' . $e->getMessage());
            throw new Exception('An error occurred while creating the custompost.');
        }
    }

    /**
     * Update the custompost.
     */
    public function updateCustompost(CustomPost $custompost, array $data)
    {
        try {
            if (!$custompost) {
                throw new CustompostNotFoundException('CustomPost not found.');
            }
            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                $data['image'] = FileService::upload($data['image'], 'uploads/customposts/images');
            }
            if($data['fields']){
                $data['fields'] = json_decode($data['fields']);
            }
            return $this->custompostRepository->update($custompost, $data);
        } catch (Exception $e) {
            Log::error('Error updating custompost in service: ' . $e->getMessage());
            throw new Exception('An error occurred while updating the custompost.');
        }
    }

    /**
     * Delete the custompost.
     */
    public function deleteCustompost(CustomPost $custompost)
    {
        try {
            if (isset($custompost->image)) {
                FileService::delete($custompost->image);
            }
            return $this->custompostRepository->delete($custompost);
        } catch (Exception $e) {
            Log::error('Error deleting custompost in service: ' . $e->getMessage());
            throw new Exception('An error occurred while deleting the custompost.');
        }
    }

    /**
     * Toggle the status of existing custompost
     */
    public function toggleStatus($request)
    {
        try {
            $custompost = CustomPost::where('id',$request['id'])->first();
            if(!$custompost){
                throw new CustompostNotFoundException('CustomPost not found.');
            }
            $custompost->status = $request['status'];
            $custompost->save();
            return $custompost;
        } catch (Exception $e) {
            Log::error('Error updating custompost status in service: ' . $e->getMessage());
            throw new Exception('An error occurred while updating the custompost status.');
        }
    }

    /**
     * Toggle the status of existing custompost
     */
	 /*
    public function fieldsRender($request)
    {
        try {    
            $custompost = CustomPost::where('id',$request->custompost_id)->first();
            if(!$custompost){
                throw new Exception('CustomPost not found.');
            }
            $fields = $custompost->fields['fields'] ?? [];
            $dataCustompost = $custompost;
            return view('backend.cms.customposts.rendering-customposts.render-fields',compact('fields','dataCustompost'))->render();
        } catch (Exception $e) {
            Log::error('Error rendering custompost fields in service: ' . $e->getMessage());
            throw new Exception($e->getMessage());
        }
    }
	*/
}