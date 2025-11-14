<?php

namespace App\Repositories;

use App\Models\Page;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Builder;

class PageRepository
{
    /**
     * Get all pages.
     */
    public function all()
    {
        try {
            return Page::latest()->get();
        } catch (Exception $e) {
            Log::error('Error fetching pages in repository: ' . $e->getMessage());
            throw new Exception('An error occurred while fetching pages from the database.');
        }
    }

    /**
     * Get all pages with pagination.
     */
    public function allPaginated(array $filters = [], int $perPage = 10)
    {
        try {
            $query = Page::query();
            if (!empty($filters['search'])) {
                $searchTerm = $filters['search'];
                $query->where(function (Builder $q) use ($searchTerm) {
                    $q->where('title', 'like', "%{$searchTerm}%");
                });
            }
            return $query->paginate($perPage);
        } catch (Exception $e) {
            Log::error('Error fetching pages in repository: ' . $e->getMessage());
            throw new Exception('An error occurred while fetching pages from the database.');
        }
    }

    /**
     * Create a new page.
     */
    public function create(array $data)
    {
        try {
            return Page::create($data);
        } catch (Exception $e) {
            Log::error('Error creating page in repository: ' . $e->getMessage());
            throw new Exception('An error occurred while saving the page to the database.');
        }
    }

    /**
     * Update the specified page.
     */
    public function update(Page $page, array $data)
    {
        try {
            return $page->update($data);
        } catch (Exception $e) {
            Log::error('Error updating page in repository: ' . $e->getMessage());
            throw new Exception('An error occurred while updating the page in the database.');
        }
    }

    /**
     * Delete the specified page.
     */
    public function delete(Page $page)
    {
        try {
            return $page->delete();
        } catch (Exception $e) {
            Log::error('Error deleting page in repository: ' . $e->getMessage());
            throw new Exception('An error occurred while deleting the page from the database.');
        }
    }
}