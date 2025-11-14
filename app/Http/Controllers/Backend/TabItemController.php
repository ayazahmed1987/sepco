<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\TabItemService;
use App\Models\ProductTab;
use App\Models\TabItem;
use App\Http\Requests\Backend\TabItemRequest;
use App\Services\FileService;

class TabItemController extends Controller
{
    public function __construct(
        protected TabItemService $service
    ) {}

    public function create(ProductTab $product_tab){
        return view('backend.cms.products.product-tabs.tab-items.create', compact('product_tab'));
    }

    public function store(TabItemRequest $request){
        try{
            $product_tab = ProductTab::where('id', $request->tab_id)->first();
            if(!$product_tab){
                return redirect()->back()->with('error', 'Invalid Request!');
            }
            $this->service->create($request->validated());
            return redirect()->route('manager.cms.product-tabs.edit', [$product_tab->product, $product_tab])->with('success', 'Tab item has been inserted!');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit(TabItem $tab_item){
        return view('backend.cms.products.product-tabs.tab-items.edit', compact('tab_item'));
    }

    public function mediaRemove(TabItem $tab_item, $column){
        try {
            if(isset($tab_item->$column)){
                FileService::delete($tab_item->$column);
            }
            $tab_item->$column = "";
            $tab_item->save();
            return redirect()->back()->with('success', 'Media got removed!');
        } catch (Exception $e) {
            \Log::error('Error deleting media in controller: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Media did not got removed!');
        }
    }

    public function update(TabItemRequest $request, TabItem $tab_item){
        try{
            $this->service->update($tab_item, $request->validated());
            return redirect()->route('manager.cms.tab-items.edit', [$tab_item])->with('success', 'Tab item has been updated!');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy(TabItem $tab_item){
        try{
            $product_tab = ProductTab::where('id', $tab_item->tab_id)->first();
            if(!$product_tab){
                return redirect()->back()->with('error', 'Invalid request');
            }
            FileService::delete($tab_item->image);
            $tab_item->delete();
            return redirect()->route('manager.cms.product-tabs.edit', [$product_tab->product, $product_tab])->with('success', 'Tab item has been deleted!');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
