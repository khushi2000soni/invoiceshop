<?php

namespace App\Http\Controllers;

use App\DataTables\ProductDataTable;
use App\Exports\ProductExport;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProductDataTable $dataTable)
    {
        abort_if(Gate::denies('product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $products = Product::orderBy('id','desc')->get();
        $categories = Category::orderBy('id','desc')->get();
        return $dataTable->render('admin.product.index',compact('products','categories'));
    }

    public function printView($category_id = null, $product_id = null)
    {
        //dd('test');
        abort_if(Gate::denies('product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //$products = Product::orderBy('id','desc')->get();

        $query = Product::query();
        if ($category_id !== null && $category_id != 'null') {
            $query->where('category_id', $category_id);
        }
        if ($product_id !== null) {
            $query->where('id', $product_id);
        }
        $products = $query->orderBy('id','desc')->get();

       return view('admin.product.print-product-list',compact('products'))->render();
    }

    public function export($category_id = null, $product_id = null){
        return Excel::download(new ProductExport($category_id,$product_id), 'items.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('id','DESC')->get();
        $htmlView = view('admin.product.create', compact('categories'))->render();
        return response()->json(['success' => true, 'htmlView' => $htmlView]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $input = $request->all();
        $product=Product::create($input);
        return response()->json(['success' => true,
        'message' => trans('messages.crud.add_record'),
        'alert-type'=> trans('quickadmin.alert-type.success'),
        'title' => trans('quickadmin.product.product')], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::with('category')->findOrFail($id);
        $categories = Category::orderBy('id','desc')->get();;
        $htmlView = view('admin.product.edit', compact('categories','product'))->render();
        return response()->json(['success' => true, 'htmlView' => $htmlView]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Product $product)
    {
        $product->update($request->all());
        return response()->json(['success' => true,
        'message' => trans('messages.crud.update_record'),
        'alert-type'=> trans('quickadmin.alert-type.success')], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('product_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(['success' => true,
         'message' => trans('messages.crud.delete_record'),
         'alert-type'=> trans('quickadmin.alert-type.success'),
         'title' => trans('quickadmin.product.product')
        ], 200);

    }
}
