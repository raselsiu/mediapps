<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Cabin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CabinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function cabinForm()
    {
        $cabin = Cabin::all();
        return view('cabin.cabin_form', compact('cabin'));
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
    public function storeCabin(Request $request)
    {

        $this->validate($request, [
            'cabin_no' => 'required|unique:cabins,cabin_no'
        ]);

        $cabin = new Cabin();
        $cabin->cabin_no = $request->cabin_no;
        $cabin->slug = Str::slug($request->cabin_no);
        $cabin->details = $request->details;
        $cabin->save();

        return redirect()->back()->with('success', 'Created Successfully!');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
