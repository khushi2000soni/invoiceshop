<?php

namespace App\Http\Controllers;

use App\DataTables\CategoryDataTable;
use App\Exports\CategoryExport;
use App\Models\Category;
use App\Rules\TitleValidationRule;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CategoryDataTable $dataTable)
    {
        abort_if(Gate::denies('category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $categories = Category::orderBy('id','desc')->get();
        return $dataTable->render('admin.category.index',compact('categories'));
    }

    public function printView($category_id = null)
    {
        //dd('test');
        abort_if(Gate::denies('category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');        
        
        $query = Category::query();
        if ($category_id !== null) {
            $query->where('id', $category_id);
        }
        $categories = $query->orderBy('id','desc')->get();        
        
       // $categories = Category::orderBy('id','desc')->get();
       return view('admin.category.print-category-list',compact('categories'))->render();
    }

    public function export($category_id = null){
        return Excel::download(new CategoryExport($category_id), 'categories.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $htmlView = view('admin.category.create')->render();
        return response()->json(['success' => true, 'htmlView' => $htmlView]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        //dd($request->all());
        $validatedData =$request->validate([
            'name' => ['required','string','unique:categories,name', new TitleValidationRule],
        ]);

        $address=Category::create($validatedData);
        return response()->json(['success' => true,
         'message' => trans('messages.crud.add_record'),
         'alert-type'=> trans('quickadmin.alert-type.success')], 200);
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
        $category = Category::findOrFail($id);
        $htmlView = view('admin.category.edit', compact('category'))->render();
        return response()->json(['success' => true, 'htmlView' => $htmlView]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $category = Category::find($id);
        $validatedData =$request->validate([
            'name' => ['required','string','unique:categories,name,'.$category->id, new TitleValidationRule],
        ]);

        $category->update($validatedData);
        return response()->json([
            'success' => true,
            'message' => trans('messages.crud.update_record'),
            'alert-type'=> trans('quickadmin.alert-type.success'),
            'title' => trans('quickadmin.category.category')], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $address = Category::findOrFail($id);
        $address->delete();

        return response()->json(['success' => true,
         'message' => trans('messages.crud.delete_record'),
         'alert-type'=> trans('quickadmin.alert-type.success'),
         'title' => trans('quickadmin.category.category')
        ], 200);
    }
}
