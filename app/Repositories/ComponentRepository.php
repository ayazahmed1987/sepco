<?php

namespace App\Repositories;
use App\Models\Component;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Builder;

class ComponentRepository
{
    /**
     * Get all components.
     */
    public function all()
    {
        try {
            return Component::latest()->get();
        } catch (Exception $e) {
            Log::error('Error fetching components in repository: ' . $e->getMessage());
            throw new Exception('An error occurred while fetching components from the database.');
        }
    }

    /**
     * Get all components with pagination.
     */
    public function allPaginated(array $filters = [], int $perComponent = 10)
    {
        try {
            $query = Component::query();
            if (!empty($filters['search'])) {
                $searchTerm = $filters['search'];
                $query->where(function (Builder $q) use ($searchTerm) {
                    $q->where('component_name', 'like', "%{$searchTerm}%");
                });
            }
            return $query->paginate($perComponent);
        } catch (Exception $e) {
            Log::error('Error fetching components in repository: ' . $e->getMessage());
            throw new Exception('An error occurred while fetching components from the database.');
        }
    }

    /**
     * Create a new component.
     */
    public function create(array $data)
    {
        try {
            return Component::create($data);
        } catch (Exception $e) {
            Log::error('Error creating component in repository: ' . $e->getMessage());
            throw new Exception('An error occurred while saving the component to the database.');
        }
    }

    /**
     * Update the specified component.
     */
    public function update(Component $component, array $data)
    {
        try {
            return $component->update($data);
        } catch (Exception $e) {
            Log::error('Error updating component in repository: ' . $e->getMessage());
            throw new Exception('An error occurred while updating the component in the database.');
        }
    }

    /**
     * Delete the specified component.
     */
    public function delete(Component $component)
    {
        try {
            return $component->delete();
        } catch (Exception $e) {
            Log::error('Error deleting component in repository: ' . $e->getMessage());
            throw new Exception('An error occurred while deleting the component from the database.');
        }
    }
}