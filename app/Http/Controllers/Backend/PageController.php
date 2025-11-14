<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PageService;
use App\Http\Requests\Backend\PageRequest;
use App\Http\Requests\Backend\UpdatePageRequest;
use App\Models\Page;

class PageController extends Controller
{
    protected PageService $pageService;

    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }

    /**
     * Display a listing of the pages.
     */
    public function index(Request $request)
    {
        try {
            $filters = [
                'search' => $request->input('search')
            ];
            $pages = $this->pageService->getAllPagesPaginated($filters,10);
            if($request->ajax()){
                return view('backend.cms.pages.rendering-components.paginated-listing', compact('pages'));
            }
            return view('backend.cms.pages.index', compact('pages'));
        } catch (Exception $e) {
            \Log::error('Error fetching pages in controller: ' . $e->getMessage());
            return redirect()->route('manager.pages.index')
                             ->with('error', 'An error occurred while fetching pages.');
        }
    }

    /**
     * Show the form for creating a new page.
     */
    public function create()
    {
        return view('backend.cms.pages.create');
    }

    /**
     * Store a newly created page in storage.
     */
    public function store(PageRequest $request)
    {
        try {
            $this->pageService->createPage($request->validated());
            return redirect()->route('manager.cms.pages.index')->with('success', 'Page created successfully!');
        } catch (Exception $e) {
            \Log::error('Error creating page in controller: ' . $e->getMessage());
            return redirect()->route('manager.cms.pages.create')
                             ->with('error', 'An error occurred while creating the page.');
        }
    }

    /**
     * Show the form for editing the specified page.
     */
    public function edit(Page $page)
    {
        return view('backend.cms.pages.edit', compact('page'));  // Assuming your edit view is located at 'resources/views/backend/pages/edit.blade.php'
    }

    /**
     * Update the specified page in storage.
     */
    public function update(UpdatePageRequest $request, Page $page)
    {
        try {
            $this->pageService->updatePage($page, $request->validated());
            return redirect()->route('manager.cms.pages.index')->with('success', 'Page updated successfully!');
        } catch (Exception $e) {
            \Log::error('Error updating page in controller: ' . $e->getMessage());
            return redirect()->route('manager.cms.pages.edit', $page->id)
                             ->with('error', 'An error occurred while updating the page.');
        }
    }

    /**
     * Remove the specified page from storage.
     */
    public function destroy(Page $page)
    {
        try {
            $this->pageService->deletePage($page);
            return redirect()->route('manager.cms.pages.index')->with('success', 'Page deleted successfully!');
        } catch (Exception $e) {
            \Log::error('Error deleting page in controller: ' . $e->getMessage());
            return redirect()->route('manager.cms.pages.index')
                             ->with('error', 'An error occurred while deleting the page.');
        }
    }

    /**
     * Toggle the status of existing page
     */
    public function toggleStatus(Request $request)
    {
        try {
            $page = $this->pageService->toggleStatus($request);
            return response()->json($page, 200);
        } catch (Exception $e) {
            \Log::error('Error toggling page status: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while toggling the page status.'
            ], 500);
        }
    }
}
