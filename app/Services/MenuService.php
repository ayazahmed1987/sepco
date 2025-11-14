<?php

namespace App\Services;

use App\Models\Menu;
use App\Repositories\MenuRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\MenuNotFoundException;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Services\FileService;

class MenuService
{
    protected MenuRepository $menuRepository;

    public function __construct(MenuRepository $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    /**
     * Get all menus.
     */
    public function getAllMenusPaginated($filters, $perPage)
    {
        try {
            return $this->menuRepository->allPaginated($filters, $perPage);
        } catch (Exception $e) {
            Log::error('Error fetching menus in service: ' . $e->getMessage());
            throw new Exception('An error occurred while fetching menus.');
        }
    }

    /**
     * Create a new Menu.
     */
    public function createMenu(array $data)
    {
        try {
            return $this->menuRepository->create($data);
        } catch (Exception $e) {
            Log::error('Error creating Menu in service: ' . $e->getMessage());
            throw new Exception('An error occurred while creating the Menu.');
        }
    }

    /**
     * Update the menu.
     */
    public function updateMenu(Menu $menu, array $data)
    {
        try {
            if (!$menu) {
                throw new Exception('An error occurred while updating the menu.');
            }
            return $this->menuRepository->update($menu, $data);
        } catch (Exception $e) {
            Log::error('Error updating menu in service: ' . $e->getMessage());
            throw new Exception('An error occurred while updating the menu.');
        }
    }

    /**
     * Delete the menu.
     */
    public function deleteMenu(Menu $menu)
    {
        try {
            return $this->menuRepository->delete($menu);
        } catch (Exception $e) {
            Log::error('Error deleting menu in service: ' . $e->getMessage());
            throw new Exception('An error occurred while deleting the menu.');
        }
    }

    /**
     * Toggle the status of existing menu
     */
    public function toggleStatus($request)
    {
        try {
            $menu = Menu::where('id',$request['id'])->first();
            if(!$menu){
                throw new MenuNotFoundException('Menu not found.');
            }
            $menu->status = $request['status'];
            $menu->save();
            return $menu;
        } catch (MenuNotFoundException $e) {
            throw $e;
        } catch (Exception $e) {
            Log::error('Error updating menu status in service: ' . $e->getMessage());
            throw new Exception('An error occurred while updating the menu status.');
        }
    }
}