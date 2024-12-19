<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AdmissinForm;
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




    public function release_cabin(string $cabin_no, string $uuid)
    {

        $uuid = $uuid;

        Cabin::where('slug', $cabin_no)->update(['status' => '0']);
        AdmissinForm::where('uuid', $uuid)->update(['status' => 'released']);
        return redirect()->back()->with('success', 'Patient Released Successfully!');
    }



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




    public function show(string $id) {}


    public function edit(string $id) {}




    public function update(Request $request, string $id) {}



    public function destroy(string $id) {}
}
