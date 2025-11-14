<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\TabItemContentService;
use App\Models\ProductTab;
use App\Models\TabItem;
use App\Models\TabItemContent;
use App\Http\Requests\Backend\TabItemContentRequest;
use App\Services\FileService;

class TabItemContentController extends Controller
{
    public function __construct(
        protected TabItemContentService $service
    ) {}

    public function create(TabItem $tab_item){
        return view('backend.cms.products.product-tabs.tab-items.tab-item-content.create', compact('tab_item'));
    }

    public function store(TabItemContentRequest $request){
        try{
            $TabItem = TabItem::where('id', $request->tab_item_id)->first();
            if(!$TabItem){
                return redirect()->back()->with('error', 'Invalid Request!');
            }
            $this->service->create($request->validated());
            return redirect()->route('manager.cms.tab-items.edit', [$TabItem])->with('success', 'Item content has been inserted!');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit(TabItemContent $tab_item_content){
        return view('backend.cms.products.product-tabs.tab-items.tab-item-content.edit', compact('tab_item_content'));
    }

    public function update(TabItemContentRequest $request, TabItemContent $tab_item_content){
        try{
            $this->service->update($tab_item_content, $request->validated());
            return redirect()->route('manager.cms.tab-item-content.edit', [$tab_item_content])->with('success', 'Item content has been updated!');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy(TabItemContent $tab_item_content){
        try{
            $tab_item_id = $tab_item_content->tabItem->id;
            FileService::delete($tab_item_content->image);
            $tab_item_content->delete();
            return redirect()->route('manager.cms.tab-items.edit', [$tab_item_id])->with('success', 'Item content has been deleted!');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function mediaRemove(TabItemContent $tab_item_content, $column){
        try {
            if(isset($tab_item_content->$column)){
                FileService::delete($tab_item_content->$column);
            }
            $tab_item_content->$column = "";
            $tab_item_content->save();
            return redirect()->back()->with('success', 'Media got removed!');
        } catch (Exception $e) {
            \Log::error('Error deleting media in controller: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Media did not got removed!');
        }
    }
}
