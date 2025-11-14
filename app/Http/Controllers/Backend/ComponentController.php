<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Component;
use App\Services\ComponentService;
use App\Http\Requests\Backend\ComponentRequest;
use App\Http\Requests\Backend\UpdateComponentRequest;

class ComponentController extends Controller
{
    protected ComponentService $componentService;

    public function __construct(ComponentService $componentService)
    {
        $this->componentService = $componentService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       try {
            $filters = [
                'search' => $request->input('search')
            ];
            $components = $this->componentService->getAllComponentsPaginated($filters,10);
            if($request->ajax()){
                return view('backend.cms.components.rendering-components.paginated-listing', compact('components'));
            }
            return view('backend.cms.components.index', compact('components'));
        } catch (Exception $e) {
            \Log::error('Error fetching components in controller: ' . $e->getMessage());
            return redirect()->route('manager.dashboard')
                             ->with('error', 'An error occurred while fetching components.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.cms.components.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ComponentRequest $request)
    {
        try {
            $this->componentService->createComponent($request->validated());
            return redirect()->route('manager.cms.components.index')->with('success', 'Component created successfully!');
        } catch (Exception $e) {
            \Log::error('Error creating component in controller: ' . $e->getMessage());
            return redirect()->route('manager.cms.components.create')
                             ->with('error', 'An error occurred while creating the component.');
        }
    }

    /**
     * Show the form for editing the specified component.
     */
    public function edit(Component $component)
    {
        return view('backend.cms.components.edit', compact('component'));  // Assuming your edit view is located at 'resources/views/backend/components/edit.blade.php'
    }

    /**
     * Update the specified component in storage.
     */
    public function update(UpdateComponentRequest $request, Component $component)
    {
        try {
            $this->componentService->updateComponent($component, $request->validated());
            return redirect()->route('manager.cms.components.index')->with('success', 'Component updated successfully!');
        } catch (Exception $e) {
            \Log::error('Error updating component in controller: ' . $e->getMessage());
            return redirect()->route('manager.cms.components.edit', $component->id)
                             ->with('error', 'An error occurred while updating the component.');
        }
    }

    /**
     * Remove the specified component from storage.
     */
    public function destroy(Component $component)
    {
        try {
            $this->componentService->deleteComponent($component);
            return redirect()->route('manager.cms.components.index')->with('success', 'Component deleted successfully!');
        } catch (Exception $e) {
            \Log::error('Error deleting component in controller: ' . $e->getMessage());
            return redirect()->route('manager.cms.components.index')
                             ->with('error', 'An error occurred while deleting the component.');
        }
    }

    /**
     * Toggle the status of existing component
     */
    public function toggleStatus(Request $request)
    {
        try {
            $component = $this->componentService->toggleStatus($request);
            return response()->json($component, 200);
        } catch (Exception $e) {
            \Log::error('Error toggling component status: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while toggling the component status.'
            ], 500);
        }
    }

    /**
     * Render Components Related Fields
     */
    public function fieldsRender(Request $request)
    {
        try {
            $html = $this->componentService->fieldsRender($request);
            return response()->json($html, 200);
        } catch (Exception $e) {
            \Log::error('Error rendering component fields: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while rendering component fields.'
            ], 500);
        }
    }
}
