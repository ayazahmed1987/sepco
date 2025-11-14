<?php

namespace App\Repositories;
use App\Models\CustomPostData;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Builder;

class CustomPostDataRepository
{
    /**
     * Get all customposts.
     */
    public function all()
    {
        try {
            return CustomPostData::latest()->get();
        } catch (Exception $e) {
            Log::error('Error fetching customposts in repository: ' . $e->getMessage());
            throw new Exception('An error occurred while fetching customposts from the database.');
        }
    }

    /**
     * Get all customposts with pagination.
     */
    public function allPaginated(array $filters = [], int $perCustompost = 10)
    {
        try {
            $query = CustomPostData::with('custompost');
			$query->where('custom_post_id', $filters['custom_post_id']);
            if (!empty($filters['search'])) {
                $searchTerm = $filters['search'];
                $query->where(function (Builder $q) use ($searchTerm) {
                    $q->where('fields_data', 'like', "%{$searchTerm}%");
                });
            }
			

            return $query->paginate($perCustompost);
			
			
			
        } catch (Exception $e) {
            Log::error('Error fetching customposts in repository: ' . $e->getMessage());
            throw new Exception('An error occurred while fetching customposts from the database.');
        }
    }

    /**
     * Create a new custompost.
     */
    public function create(array $data)
    {
        try {
            $custompostdata = CustomPostData::create($data);
			activity()->causedBy(auth()->user())->performedOn($custompostdata)->event('created')->log('Add new custompostdata');
			return $custompostdata;
        } catch (Exception $e) {
            Log::error('Error creating custompost in repository: ' . $e->getMessage());
            throw new Exception('An error occurred while saving the custompost to the database.');
        }
    }

    /**
     * Update the specified custompost.
     */
    public function update(CustomPostData $custompostdata, array $data)
    {
        try {
            $custompostdata->update($data);
			activity()->causedBy(auth()->user())->performedOn($custompostdata)->withProperties($data)->event('updated')->log('Update custompostdata');
			return $custompostdata;
        } catch (Exception $e) {
            Log::error('Error updating custompost in repository: ' . $e->getMessage());
            throw new Exception('An error occurred while updating the custompost in the database.');
        }
    }
	
	
	
	
	

    /**
     * Delete the specified custompost.
     */
    public function delete(CustomPostData $custompostdata)
    {
        try {
            return $custompostdata->delete();
        } catch (Exception $e) {
            Log::error('Error deleting custompostdata in repository: ' . $e->getMessage());
            throw new Exception('An error occurred while deleting the custompostdata from the database.');
        }
    }
}