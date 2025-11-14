<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductTab;
use App\Models\Product;
use App\Services\ProductTabService;
use App\Http\Requests\Backend\ProductTabRequest;

class ProductTabController extends Controller
{
    public function __construct(
        protected ProductTabService $service
    ) {}

    public function create(Product $product){
        $productsOptions = Product::all();
        return view('backend.cms.products.product-tabs.create', compact('product','productsOptions'));
    }

    public function store(ProductTabRequest $request){
        $this->service->create($request->validated());
        return redirect()->route('manager.cms.products.edit',$request->product_id)->with('success', 'Product tab has been inserted!');
    }

    public function edit(Product $product, ProductTab $product_tab){
        $productsOptions = Product::all();
        return view('backend.cms.products.product-tabs.edit', compact('product','productsOptions','product_tab'));
    }

    public function update(ProductTabRequest $request, ProductTab $product_tab){
        $this->service->update($product_tab, $request->validated());
        return redirect()->route('manager.cms.product-tabs.edit',[$request->product_id, $product_tab])->with('success', 'Product tab has been updated!');
    }

    public function destroy(ProductTab $product_tab){
        $product_id = $product_tab->product_id;
        $product_tab->delete();
        return redirect()->route('manager.cms.products.edit', $product_id)->with('success', 'Product tab has been deleted!');
    }
}
