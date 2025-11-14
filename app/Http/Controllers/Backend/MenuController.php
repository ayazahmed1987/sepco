<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\MenuService;
use App\Http\Requests\Backend\MenuRequest;
use App\Http\Requests\Backend\UpdateMenuRequest;
use App\Models\Menu;
use App\Models\Page;

class MenuController extends Controller
{
    protected MenuService $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    /**
     * Display a listing of the menus.
     */
    public function index(Request $request)
    {
        try {
            $filters = [
                'search' => $request->input('search')
            ];
            $menus = $this->menuService->getAllMenusPaginated($filters,10);
            if($request->ajax()){
                return view('backend.cms.menus.rendering-components.paginated-listing', compact('menus'));
            }
            return view('backend.cms.menus.index', compact('menus'));
        } catch (Exception $e) {
            \Log::error('Error fetching menus in controller: ' . $e->getMessage());
            return redirect()->route('manager.cms.menus.index')->with('error', 'An error occurred while fetching menus.');
        }
    }

    /**
     * Display a listing of the menus.
     */
    public function create()
    {
        $pages = Page::all();
        $parents = Menu::all();
        return view('backend.cms.menus.create',compact('pages','parents'));
    }

    /**
     * store in db
     */
    public function store(MenuRequest $request)
    {
        try {
            $this->menuService->createMenu($request->validated());
            return redirect()->route('manager.cms.menus.index')->with('success','Menu has been created!');
        } catch (Exception $e) {
            \Log::error('Error fetching menus in controller: ' . $e->getMessage());
            return redirect()->route('manager.cms.menus.index')->with('error', 'An error occurred while fetching menus.');
        }
    }

    /**
     * Show the form for editing the specified Menu.
     */
    public function edit(Menu $menu)
    {
        $pages = Page::all();
        $parents = Menu::all();
        return view('backend.cms.menus.edit', compact('menu','pages','parents'));  // Assuming your edit view is located at 'resources/views/backend/pages/edit.blade.php'
    }

    /**
     * Update the form for editing the specified Menu.
     */
    public function update(UpdateMenuRequest $request, Menu $menu)
    {
        try {
            $this->menuService->updateMenu($menu, $request->validated());
            return redirect()->route('manager.cms.menus.index')->with('success','Menu has been created!');
        } catch (Exception $e) {
            \Log::error('Error fetching menus in controller: ' . $e->getMessage());
            return redirect()->route('manager.cms.menus.index')->with('error', 'An error occurred while fetching menus.');
        }
    }

    /**
     * Remove the specified menu from storage.
     */
    public function destroy(Menu $menu)
    {
        try {
            $this->menuService->deleteMenu($menu);
            return redirect()->route('manager.cms.menus.index')->with('success', 'Menu deleted successfully!');
        } catch (Exception $e) {
            \Log::error('Error deleting menu in controller: ' . $e->getMessage());
            return redirect()->route('manager.cms.menus.index')
                             ->with('error', 'An error occurred while deleting the menu.');
        }
    }

    /**
     * Toggle the status of existing menu
     */
    public function toggleStatus(Request $request)
    {
        try {
            $menu = $this->menuService->toggleStatus($request);
            return response()->json($menu, 200);
        } catch (Exception $e) {
            \Log::error('Error toggling menu status: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while toggling the menu status.'
            ], 500);
        }
    }
}
