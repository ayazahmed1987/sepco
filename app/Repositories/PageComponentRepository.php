<?php

namespace App\Repositories;

use App\Models\PageComponent;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Builder;

class PageComponentRepository
{
    /**
     * Create a new page component.
     */
    public function create(array $data)
    {
        try {
            return PageComponent::create($data);
        } catch (Exception $e) {
            Log::error('Error creating page component in repository: ' . $e->getMessage());
            throw new Exception('An error occurred while saving the page component to the database.');
        }
    }

    /**
     * Update a new page component.
     */
    public function update(PageComponent $component, array $data)
    {
        try {
            return $component->update($data);
        } catch (Exception $e) {
            Log::error('Error updating page component in repository: ' . $e->getMessage());
            throw new Exception('An error occurred while updating the page component to the database.');
        }
    }
}