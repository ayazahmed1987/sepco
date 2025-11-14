<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\PageComponent;
use App\Models\Component;
use App\Http\Requests\Backend\StorePageComponentRequest;
use App\Http\Requests\Backend\UpdatePageComponentRequest;
use App\Services\FileService;
use App\Services\PageComponentService;

class PageComponentController extends Controller
{

    protected PageComponentService $pageComponentService;

    public function __construct(PageComponentService $pageComponentService)
    {
        $this->pageComponentService = $pageComponentService;
    }

    public function index(Page $page){
        $components = $page->components;
        return view('backend.cms.pages.page-components.index',compact('components','page'));
    }

    public function create(Page $page){
        $pageComponents = PageComponent::where('page_id',$page->id)->get();
        $components = Component::active()->get();
        return view('backend.cms.pages.page-components.create',compact('pageComponents','page','components'));
    }

    public function store(StorePageComponentRequest $request, Page $page){
        try {
            $request->merge(['page_id' => $page->id]);
            $this->pageComponentService->createPageComponent($request->all());
            return redirect()->route('manager.cms.pages.edit', $page)->with('success', 'Page component created successfully!');
        } catch (Exception $e) {
            \Log::error('Error creating page component in controller: ' . $e->getMessage());
            return redirect()->route('manager.cms.page-components.create')->with('error', 'An error occurred while creating the component.');
        }
    }

    public function edit(Page $page, PageComponent $component){
        try {
            $pageComponentsList = PageComponent::where('component_id', $component->component_id)->where('page_id', $page->id)->get();
            $componentsList = Component::active()->get();
            $html = '';
            $dataComponent = $component->component;
            if($component->type == 1){
                $fields = $component->component->fields['fields'] ?? [];
                $existingData = $component->fields_data;
                if (isset($component->parent_id, $component->component->fields['children'])) {
                    $fields = $component->component->fields['children'] ?? [];
                }
                $html = view('backend.cms.components.rendering-components.render-fields',compact('fields','existingData','component'));
            }
            return view('backend.cms.pages.page-components.edit',compact('pageComponentsList','componentsList','page','component','html','dataComponent'));
        } catch (Exception $e) {
            \Log::error('Error showing edit form of page component in controller: ' . $e->getMessage());
            return redirect()->route('manager.cms.pages.edit', $page)->with('success', 'Error showing edit form of page component in controller!');
        }
    }

    public function mediaRemove(PageComponent $component, $field){
        try {
			
			$fileName = $field;
			if ($fileName && !empty($component->fields_data[$fileName])) {
				FileService::delete($component->fields_data[$fileName]);
			}
			
            $json = $component->fields_data;
            $json[$field] = null;
            $component->fields_data = $json;
            $component->save();
            return redirect()->back()->with('success', 'Media got removed!');
        } catch (Exception $e) {
            \Log::error('Error deleting media in controller: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Media did not got removed!');
        }
    }

    public function update(UpdatePageComponentRequest $request, Page $page, PageComponent $component){
        try {
			//dump($request->validated());
			
            $request->merge(['page_id' => $page->id]);
            $this->pageComponentService->updatePageComponent($request->validated(), $page, $component);
            return redirect()->route('manager.cms.page-components.edit', [$page, $component])->with('success', 'Page component updated successfully!');
			
        } catch (Exception $e) {
            \Log::error('Error updating page component in controller: ' . $e->getMessage());
            return redirect()->route('manager.cms.page-components.create')->with('error', 'An error occurred while updating the page component.');
        }
    }

    public function destroy(Page $page, PageComponent $component){
        try {
            $this->pageComponentService->destroyPageComponent($component);
            return redirect()->route('manager.cms.pages.edit', [$page])->with('success', 'Page component deleted successfully!');
        } catch (Exception $e) {
            \Log::error('Error deleting page component in controller: ' . $e->getMessage());
            return redirect()->route('manager.cms.pages.edit', [$page])->with('error', 'An error occurred while deleting the page component.');
        }
    }
}
