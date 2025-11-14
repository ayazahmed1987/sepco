<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Models\Product;
use App\Http\Requests\Backend\ProductRequest;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $service
    ) {}

    public function index(Request $request){
        try{
            $filters = [
                'search' => $request->input('search')
            ];
            $products = $this->service->getAllPaginated($filters,10);
            if($request->ajax()){
                return view('backend.cms.products.rendering-components.paginated-listing', compact('products'));
            }
            return view('backend.cms.products.index',compact('products'));
        } catch (\Exception $e) {
            \Log::error('Error fetching products in controller: ' . $e->getMessage());
            return redirect()->route('manager.dashboard')->with('error', 'An error occurred while fetching products.');
        }
    }

    public function create(){
        return view('backend.cms.products.create');
    }

    public function store(ProductRequest $request){
        try {
            $this->service->create($request->validated());
            return redirect()->route('manager.cms.products.index')->with('success', 'Product created successfully!');
        } catch (Exception $e) {
            \Log::error('Error creating product in controller: ' . $e->getMessage());
            return redirect()->route('manager.cms.products.create')
                             ->with('error', 'An error occurred while creating the product.');
        }
    }

    public function edit(Product $product){
        $tabs = $product->productTabs;
        return view('backend.cms.products.edit', compact('product','tabs'));
    }

    public function update(ProductRequest $request, Product $product){
        try {
            $this->service->update($product, $request->validated());
            return redirect()->route('manager.cms.products.edit', $product)->with('success', 'Product updated successfully!');
        } catch (Exception $e) {
            \Log::error('Error updating product in controller: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating the product.');
        }
    }

    public function mediaRemove(Product $product, $column){
        try {
            $this->service->deleteMedia($product->$column);
            $product->$column = "";
            $product->save();
            return redirect()->back()->with('success', 'Media got removed!');
        } catch (Exception $e) {
            \Log::error('Error deleting media in controller: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Media did not got removed!');
        }
    }

    public function destroy(Product $product){
        try {
            $this->service->deleteMedia($product->thumbnail);
            $product->delete();
            return redirect()->route('manager.cms.products.index')->with('success', 'Product got deleted!');
        } catch (Exception $e) {
            \Log::error('Error deleting product in controller: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Product did not got deleted!');
        }
    }
}
