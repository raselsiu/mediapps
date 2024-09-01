<?php

namespace App\Http\Controllers;

use App\Models\ExpenditureCategory;
use App\Models\ExpenditureSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ExpenditureSubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subCategories = ExpenditureSubCategory::all();
        $categories = ExpenditureCategory::all();


        $categoryList = DB::table('expenditure_categories')
            ->join('expenditure_sub_categories', 'expenditure_sub_categories.category_id', '=', 'expenditure_categories.id')
            ->get();

        return view('backend.category.expenditure.subcategory_index', compact('subCategories', 'categories', 'categoryList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = new ExpenditureSubCategory();
        $data->category_id = $request->category_id;
        $data->subcategory = $request->sub_category;
        $data->subc_slug = Str::slug($request->sub_category);
        $data->save();
        return redirect()->back()->with('success', 'Sub Category Created!');
    }











    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return $id;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExpenditureSubCategory $expenditureSubCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExpenditureSubCategory $expenditureSubCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExpenditureSubCategory $expenditureSubCategory)
    {
        //
    }
}
