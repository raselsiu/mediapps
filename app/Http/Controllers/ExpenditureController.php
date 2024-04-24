<?php

namespace App\Http\Controllers;

use App\Models\Expenditure;
use App\Models\ExpenditureCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ExpenditureController extends Controller
{





    /**
     * Store a newly created resource in storage.
     */




    public function expenditure_form()
    {
        $data = ExpenditureCategory::all();
        return view('backend.category.expenditure.expenditure_form', compact('data'));
    }


    public function getSubCategory($id)

    {
        return json_encode(DB::table('expenditure_sub_categories')->where('category_id', $id)->get());
    }

    /**
     * Display the specified resource.
     */
    public function store(Request $request)
    {
        $category = ExpenditureCategory::where('id', $request->category)->get(['name'])->first();

        $data = new Expenditure();

        $data->category = $category->name;
        $data->cat_slug = Str::slug($category->name);
        $data->sub_category = $request->sub_category;
        $data->sub_slug = Str::slug($request->sub_category);
        $data->amount = $request->amount;
        $data->description = $request->description;

        $data->save();

        return redirect()->back()->with('success', 'Saved Successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expenditure $expenditure)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expenditure $expenditure)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expenditure $expenditure)
    {
        //
    }
}
