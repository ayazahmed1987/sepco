<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;;
use App\Models\ProductTab;
use App\Models\TabItem;
use App\Models\TabItemContent;
use App\Models\Hotspot;
use App\Http\Requests\Backend\HotspotRequest;
use App\Services\FileService;

class HotspotController extends Controller
{
    public function create(TabItemContent $tab_item_content){
        return view('backend.cms.products.product-tabs.tab-items.tab-item-content.hotspots.create', compact('tab_item_content'));
    }

    public function store(HotspotRequest $request){
        try{
            $data = $request->validated();
            $TabItemContent = TabItemContent::where('id', $request->tab_item_content_id)->first();
            if(!$TabItemContent){
                return redirect()->back()->with('error', 'Invalid Request!');
            }
            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                $data['image'] = FileService::upload($data['image'], 'uploads/hotspots/images');
            }
            Hotspot::create($data);
            return redirect()->route('manager.cms.tab-item-content.edit', [$TabItemContent])->with('success', 'Hotspot has been inserted!');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit(Hotspot $hotspot){
        return view('backend.cms.products.product-tabs.tab-items.tab-item-content.hotspots.edit', compact('hotspot'));
    }

    public function update(HotspotRequest $request, Hotspot $hotspot){
        try{
            $data = $request->validated();
            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                $data['image'] = FileService::upload($data['image'], 'uploads/hotspots/images');
            }
            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                if (isset($hotspot->image)) {
                    FileService::delete($hotspot->image);
                }
                $data['image'] = FileService::upload($data['image'], 'uploads/hotspots/images');
            }
            $hotspot->update($data);
            return redirect()->route('manager.cms.hotspots.edit', [$hotspot])->with('success', 'Hotspot has been updated!');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Hotspot $hotspot){
        try{
            $content = $hotspot->tabItemContent->id;
            FileService::delete($hotspot->image);
            $hotspot->delete();
            return redirect()->route('manager.cms.tab-item-content.edit', [$content])->with('success', 'Hotspot has been deleted!');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function mediaRemove(Hotspot $hotspot, $column){
        try {
            if(isset($hotspot->$column)){
                FileService::delete($hotspot->$column);
            }
            $hotspot->$column = "";
            $hotspot->save();
            return redirect()->back()->with('success', 'Media got removed!');
        } catch (Exception $e) {
            \Log::error('Error deleting media in controller: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Media did not got removed!');
        }
    }
}
