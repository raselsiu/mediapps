<?php

namespace App\Http\Controllers;

use App\Models\AllInComingAmount;
use App\Models\Income;
use App\Models\IncomeCategory;
use App\Models\IncomeField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class IncomeFieldController extends Controller
{



    public function income_form()
    {
        $data = IncomeCategory::all();
        return view('backend.category.income.income_form', compact('data'));
    }


    public function getIncomeSubCategory($id)

    {
        return json_encode(DB::table('income_sub_categories')->where('category_id', $id)->get());
    }

    /**
     * Display the specified resource.
     */
    public function store(Request $request)
    {
        $category = IncomeCategory::where('id', $request->category)->get(['name'])->first();



        $data = new IncomeField();


        $allIncomingAmountSave = new AllInComingAmount();
        $allIncomeAmount = AllInComingAmount::first();

        $data->category = $category->name;
        $data->cat_slug = Str::slug($category->name);
        $data->sub_category = $request->sub_category;
        $data->sub_slug = Str::slug($request->sub_category);
        $data->amount = $request->amount;
        $data->description = $request->description;


        if ($allIncomeAmount == null) {
            $allIncomingAmountSave->total_amount = $request->amount;
            $allIncomingAmountSave->save();
        } else {
            $allIncomeAmount->total_amount = $allIncomeAmount->total_amount + $request->amount;
            $allIncomeAmount->save();
        }


        $data->save();



        return redirect()->back()->with('success', 'Saved Successfully!');
    }







    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        //
    }
}
