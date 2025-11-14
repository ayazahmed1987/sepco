<?php

namespace App\Services;

use App\Models\Page;
use App\Repositories\PageRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\PageNotFoundException;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Services\FileService;

class PageService
{
    protected PageRepository $pageRepository;

    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    /**
     * Get all pages.
     */
    public function getAllPages()
    {
        try {
            return $this->pageRepository->all();
        } catch (Exception $e) {
            Log::error('Error fetching pages in service: ' . $e->getMessage());
            throw new Exception('An error occurred while fetching pages.');
        }
    }

    /**
     * Get all pages with pagination.
     */
    public function getAllPagesPaginated($filters, $perPage)
    {
        try {
            return $this->pageRepository->allPaginated($filters, $perPage);
        } catch (Exception $e) {
            Log::error('Error fetching pages in service: ' . $e->getMessage());
            throw new Exception('An error occurred while fetching pages.');
        }
    }

    /**
     * Create a new page.
     */
    public function createPage(array $data)
    {
        try {
            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                $data['image'] = FileService::upload($data['image'], 'uploads/pages/images');
            }
            return $this->pageRepository->create($data);
        } catch (Exception $e) {
            Log::error('Error creating page in service: ' . $e->getMessage());
            throw new Exception('An error occurred while creating the page.');
        }
    }

    /**
     * Update the page.
     */
    public function updatePage(Page $page, array $data)
    {
        try {
            if (!$page) {
                throw new PageNotFoundException('Page not found.');
            }
            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                if (isset($page->image)) {
                    FileService::delete($page->image);
                }
                $data['image'] = FileService::upload($data['image'], 'uploads/pages/images');
            }
            return $this->pageRepository->update($page, $data);
        } catch (PageNotFoundException $e) {
            throw $e;
        } catch (Exception $e) {
            Log::error('Error updating page in service: ' . $e->getMessage());
            throw new Exception('An error occurred while updating the page.');
        }
    }

    /**
     * Delete the page.
     */
    public function deletePage(Page $page)
    {
        try {
            if (isset($page->image)) {
                FileService::delete($page->image);
            }
            return $this->pageRepository->delete($page);
        } catch (Exception $e) {
            Log::error('Error deleting page in service: ' . $e->getMessage());
            throw new Exception('An error occurred while deleting the page.');
        }
    }

    /**
     * Toggle the status of existing page
     */
    public function toggleStatus($request)
    {
        try {
            $page = Page::where('id',$request['id'])->first();
            if(!$page){
                throw new PageNotFoundException('Page not found.');
            }
            $page->status = $request['status'];
            $page->save();
            return $page;
        } catch (PageNotFoundException $e) {
            throw $e;
        } catch (Exception $e) {
            Log::error('Error updating page status in service: ' . $e->getMessage());
            throw new Exception('An error occurred while updating the page status.');
        }
    }
}