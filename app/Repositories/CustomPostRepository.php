<?php

namespace App\Repositories;
use App\Models\CustomPost;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Builder;

class CustomPostRepository
{
    /**
     * Get all customposts.
     */
    public function all()
    {
        try {
            return CustomPost::latest()->get();
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
            $query = CustomPost::query();
            if (!empty($filters['search'])) {
                $searchTerm = $filters['search'];
                $query->where(function (Builder $q) use ($searchTerm) {
                    $q->where('table_name', 'like', "%{$searchTerm}%");
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
			
            $custompost = CustomPost::create($data);
			if(!empty($data['page'])){ $custompost->getpages()->sync($data['page'] ?? []); }
			return $custompost;
			
        } catch (Exception $e) {
            Log::error('Error creating custompost in repository: ' . $e->getMessage());
            throw new Exception('An error occurred while saving the custompost to the database.');
        }
    }

    /**
     * Update the specified custompost.
     */
    public function update(CustomPost $custompost, array $data)
    {
        try {
			//dd($data['page']);
			if(!empty($data['page'])){ $custompost->getpages()->sync($data['page'] ?? []); }
            return $custompost->update($data);

			

        } catch (Exception $e) {
            Log::error('Error updating custompost in repository: ' . $e->getMessage());
            throw new Exception('An error occurred while updating the custompost in the database.');
        }
    }

    /**
     * Delete the specified custompost.
     */
    public function delete(CustomPost $custompost)
    {
        try {
            return $custompost->delete();
        } catch (Exception $e) {
            Log::error('Error deleting custompost in repository: ' . $e->getMessage());
            throw new Exception('An error occurred while deleting the custompost from the database.');
        }
    }
}