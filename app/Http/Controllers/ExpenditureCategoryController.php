<?php

namespace App\Http\Controllers;

use App\Models\ExpenditureCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ExpenditureCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function add_expenditure_index()
    {
        $categories = ExpenditureCategory::all();
        return view('backend.category.expenditure.category_index', compact('categories'));
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
    public function store_exp_category(Request $request)
    {


        $request->validate([
            'name' => 'required|unique:expenditure_categories,name'
        ]);


        $data = new ExpenditureCategory();
        $data->name = $request->name;
        $data->slug = Str::slug($request->name);
        $data->save();
        return redirect()->back()->with('success', 'Category Created Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ExpenditureCategory $expenditureCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExpenditureCategory $expenditureCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExpenditureCategory $expenditureCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $user = ExpenditureCategory::find($id);
        $user->delete();
        return redirect()->back()->with('success', 'Data Deleted Successfully!');
    }
}
