<?php

namespace App\Http\Controllers;

use App\Models\TestModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{

    public function index()
    {
        return view('test_form');
    }


    public function store(Request $request)
    {


        $this->validate($request, [
            'patient_uuid' => 'required',
            'description.*' => 'required',
            'amount.*' => 'required',
        ]);



        $patient_uuid = $request->patient_uuid;
        $description = $request->description;
        $comments = $request->comments;
        $amount = $request->amount;

        for ($i = 0; $i < count($description); $i++) {
            $data = [
                'patient_uuid' => $patient_uuid,
                'description' => $description[$i],
                'comments' => $comments[$i],
                'amount' => $amount[$i],
            ];
            DB::table('test_models')->insert($data);
        }

        return redirect()->back()->with('success', 'Data Inserted Successfully!');
    }
}
