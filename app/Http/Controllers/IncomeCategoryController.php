<?php

namespace App\Http\Controllers;

use App\Models\IncomeCategory;
use App\Models\IncomeSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class IncomeCategoryController extends Controller
{

    public function add_income_index()
    {
        $categories = IncomeCategory::all();
        return view('backend.category.income.category_index', compact('categories'));
    }




    public function store_income_category(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:income_categories,name'
        ]);


        $data = new IncomeCategory();
        $data->name = $request->name;
        $data->slug = Str::slug($request->name);
        $data->save();
        return redirect()->back()->with('success', 'Category Created Successfully!');
    }

    public function delete(string $id)
    {
        $incomeCat = IncomeCategory::find($id);
        $incomeSubCat = IncomeSubCategory::where('category_id', $id);
        $incomeCat->delete();
        $incomeSubCat->delete();
        return redirect()->back()->with('success', 'Data Deleted Successfully!');
    }
}
