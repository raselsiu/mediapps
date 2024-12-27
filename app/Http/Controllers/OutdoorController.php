<?php

namespace App\Http\Controllers;

use App\Models\AllInComingAmount;
use App\Models\Income;
use App\Models\OutdoorModel;
use App\Models\OutdoorService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class OutdoorController extends Controller
{







    public function outdoor_regi_form()
    {
        $data['service'] = OutdoorService::all();

        return view('backend.outdoor.outdoor_registraton_fee', $data);
    }





    public function outdoorServiceView()
    {

        return view('backend.outdoor.service_entry');
    }


    public function outdoorServiceStore(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|unique:outdoor_services,name'
        ]);


        $data = new OutdoorService();

        $data->name = $request->name;
        $data->slug = Str::slug($request->name);
        $data->save();
        return redirect()->back()->with('success', 'Created Successfully!');
    }




    public function all_out_regi_patient()
    {

        $data['patients'] = OutdoorModel::all();

        return view('backend.outdoor.outdoor_registered_patient_list', $data);
    }


    public function outdoor_regi_form_view(string $patient_id)
    {
        $patient = OutdoorModel::where('uuid', $patient_id)->firstOrFail();
        return view('backend.outdoor.outdoor_patients_regi_view', compact('patient'));
    }

    public function printOutDoor(string $patient_id)
    {
        $patient['patient'] = OutdoorModel::where('uuid', $patient_id)->firstOrFail();
        $pdf = Pdf::loadView('backend.pdf.outdoor', $patient);
        return $pdf->stream('outdoor-receipt.pdf');
    }



    public function storeOutdoor_regi_form(Request $request)
    {



        $request->validate([
            'name' => 'required|max:100',
            'address' => 'required',
            'service_category' => 'required',
            'regi_fee' => 'required|numeric',
        ]);

        $data = new OutdoorModel();

        $uuid = uniqid();

        $income = new Income();

        $allIncomingAmountSave = new AllInComingAmount();
        $allIncomeAmount = AllInComingAmount::first();


        if ($request->outdoor_registration_fee) {

            $income->patient_uuid = $uuid;
            $income->type = 'outdoor';
            $income->income_amount = $request->regi_fee;
            $income->income_source = $request->outdoor_registration_fee;
            $income->income_source_name = Str::slug($request->outdoor_registration_fee);


            if ($allIncomeAmount == null) {
                $allIncomingAmountSave->total_amount = $request->regi_fee;
                $allIncomingAmountSave->save();
            } else {
                $allIncomeAmount->total_amount = $allIncomeAmount->total_amount + $request->regi_fee;
                $allIncomeAmount->save();
            }




            $income->save();
        }

        function invoiceNumber()
        {
            $latest = OutdoorModel::latest()->first();

            if (!$latest) {
                return 1;
            }

            $serial = $latest->serial_no + 1;

            return $serial;
        }


        $data->uuid = $uuid;
        $data->name = $request->name;
        if ($request->regi_fee) {
            $data->is_payment_clear = true;
        }
        $data->serial_no = invoiceNumber();
        $data->address = $request->address;
        $data->regi_fee = $request->regi_fee;
        $data->extra_service = $request->extra_service;
        $data->service_category = $request->service_category;
        $data->generated_by = Auth::user()->name;
        $data->save();
        return redirect()->route('outdoor_regi_form_view', $data->uuid)->with('success', 'Registration Success!');
    }





    // type
    // income_source
    // income_source_name
    // income_amount	





















    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
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
