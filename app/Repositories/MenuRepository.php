<?php

namespace App\Repositories;

use App\Models\Menu;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Builder;

class MenuRepository
{
   /**
     * Get all menus with pagination.
     */
    public function allPaginated(array $filters = [], int $perPage = 10)
    {
        try {
            $query = Menu::query();
            if (!empty($filters['search'])) {
                $searchTerm = $filters['search'];
                $query->where(function (Builder $q) use ($searchTerm) {
                    $q->where('title', 'like', "%{$searchTerm}%");
                });
            }
            return $query->paginate($perPage);
        } catch (Exception $e) {
            Log::error('Error fetching menus in repository: ' . $e->getMessage());
            throw new Exception('An error occurred while fetching menus from the database.');
        }
    }

    /**
     * Create a new Menu.
     */
    public function create(array $data)
    {
        try {
            return Menu::create($data);
        } catch (Exception $e) {
            Log::error('Error creating Menu in repository: ' . $e->getMessage());
            throw new Exception('An error occurred while saving the Menu to the database.');
        }
    }

    /**
     * Update the specified menu.
     */
    public function update(Menu $menu, array $data)
    {
        try {
            return $menu->update($data);
        } catch (Exception $e) {
            Log::error('Error updating menu in repository: ' . $e->getMessage());
            throw new Exception('An error occurred while updating the menu in the database.');
        }
    }

    /**
     * Delete the specified menu.
     */
    public function delete(Menu $menu)
    {
        try {
            return $menu->delete();
        } catch (Exception $e) {
            Log::error('Error deleting menu in repository: ' . $e->getMessage());
            throw new Exception('An error occurred while deleting the menu from the database.');
        }
    }
}