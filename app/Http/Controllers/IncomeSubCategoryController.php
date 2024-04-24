<?php

namespace App\Http\Controllers;

use App\Models\IncomeCategory;
use App\Models\IncomeSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class IncomeSubCategoryController extends Controller
{

    public function index()
    {
        $subCategories = IncomeSubCategory::all();
        $categories = IncomeCategory::all();


        $categoryList = DB::table('income_categories')
            ->join('income_sub_categories', 'income_sub_categories.category_id', '=', 'income_categories.id')
            ->get();





        return view('backend.category.income.subcategory_index', compact('subCategories', 'categories', 'categoryList'));
    }



    public function store(Request $request)
    {
        $data = new IncomeSubCategory();
        $data->category_id = $request->category_id;
        $data->subcategory = $request->sub_category;
        $data->subc_slug = Str::slug($request->sub_category);
        $data->save();
        return redirect()->back()->with('success', 'Sub Category Created!');
    }

}
