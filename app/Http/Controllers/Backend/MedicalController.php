<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AdmissinForm;
use App\Models\CashMemoForm;
use App\Models\CashMemoInfo;
use App\Models\Income;
use App\Models\RegistratonForm;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class MedicalController extends Controller
{

    public function registration_form()
    {
        return view('backend.medical_pages.registraton_fee');
    }

    public function admission_form()
    {
        return view('backend.medical_pages.admission_form');
    }



    public function cash_memo_form(string $id)
    {

        $uuid = $id;


        $patient = AdmissinForm::where('uuid', $id)->first();


        $service_list = Service::all();


        return view('backend.medical_pages.cash_memo', compact('uuid', 'patient', 'service_list'));
    }





    public function edit_cash_memo(String $id)
    {
        $uuid = $id;

        $patient = AdmissinForm::where('uuid', $id)->first();

        $cash_memo_info = CashMemoInfo::where('patient_uuid', $id)->first();

        $cash_memo_form = CashMemoForm::where('patient_uuid', $id)->first();

        $service_list = Service::all();


        return view('backend.medical_pages.update_data.edit_cash_memo', compact('uuid', 'patient', 'cash_memo_info'));
    }






    public function cash_memo_form_save(Request $request)
    {


        $data = new CashMemoInfo();
        $data->patient_uuid = $request->patient_uuid;
        $data->admission_date = $request->admission_date;
        $data->leave_date = $request->leave_date;
        $data->address = $request->address;
        $data->mobile = $request->mobile;
        $data->cabin_no = $request->cabin_no;
        $data->regi_no = $request->regi_no;
        $data->total_bill = $request->total_bill;
        $data->discount = $request->discount;
        $data->total_paid = $request->total_paid;
        $data->paid = $request->paid;


        $totalPaid = $request->total_paid;
        $paid = $request->paid;
        $outstanding = $totalPaid - $paid;

        $data->outstanding_total = $outstanding;
        $data->generated_by = Auth::user()->name;




        $admissionFormData = AdmissinForm::where('uuid', $request->patient_uuid)->first();
        $admissionFormData->total_bill = $request->total_bill;
        $admissionFormData->discount = $request->discount;
        $admissionFormData->total_paid = $request->total_paid;
        $admissionFormData->paid = $request->paid;
        if ($totalPaid == $paid) {
            $admissionFormData->is_payment_clear = true;
        } else {
            $admissionFormData->is_payment_clear = false;
        }

        $admissionFormData->is_cash_memo_generated = true;


        $data->save();

        $admissionFormData->save();



        //Cash-Memo Form 

        $this->validate($request, [
            'patient_uuid' => 'required',
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
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
            DB::table('cash_memo_forms')->insert($data);
        }




        $rcpt_info = CashMemoInfo::where('patient_uuid', $request->patient_uuid)->first();

        $patient_info = AdmissinForm::where('uuid', $request->patient_uuid)->first();


        $get_bill = CashMemoForm::where('patient_uuid', $request->patient_uuid)->get()->toArray();


        return view('backend.medical_pages.cash_memo_receipt', compact('rcpt_info', 'get_bill', 'patient_info'));
    }






    public function updateDueAmount(Request $request, string $id)
    {


        $patient_cash = CashMemoInfo::where('patient_uuid', $id)->first();



        $outstanding_value = $patient_cash->outstanding_total;



        $this->validate($request, [
            'due_amount' => 'required',
        ]);

        if ($request->due_amount > $outstanding_value) {
            return redirect()->back()->with('msg', 'Amount should not be greater then the Due Amount');
        }
        if ($request->due_amount < $outstanding_value) {
            return redirect()->back()->with('msg', 'Amount should not be less then the Due Amount');
        }




        $amount = $patient_cash->paid + $request->due_amount;

        $UpdateOutstanding_Total = $patient_cash->total_paid - $amount;

        $user = CashMemoInfo::where('patient_uuid', $id)->first();
        $user->paid = $amount;
        $user->outstanding_total = $UpdateOutstanding_Total;
        $user->save();
        return redirect()->route('all_regi_patient')->with('success', 'Updated Successfully!');
    }








    public function view_cash_memo(String $id)
    {
        $rcpt_info = CashMemoInfo::where('patient_uuid', $id)->first();

        $patient_info = AdmissinForm::where('uuid', $id)->first();

        $get_bill = CashMemoForm::where('patient_uuid', $id)->get()->toArray();

        return view('backend.medical_pages.cash_memo_receipt', compact('rcpt_info', 'get_bill', 'patient_info'));
    }









    public function receipt_generate()
    {

        $id = '6630cece79b9e';

        $rcpt_info = CashMemoInfo::where('patient_uuid', $id)->first();
        $get_bill = CashMemoForm::where('patient_uuid', $id)->get()->toArray();

        $patient_info = AdmissinForm::where('uuid', $id)->first();


        return view('backend.medical_pages.cash_memo_receipt', compact('rcpt_info', 'get_bill', 'patient_info'));
    }











    public function all_regi_patient()
    {


        $data['patients'] = AdmissinForm::all();

        return view('backend.medical_pages.registered_patient_list', $data);
    }




    public function store(Request $request)
    {
        //
    }



    public function storeRegistration(Request $request)
    {
        $data = new RegistratonForm();

        $uuid = uniqid();

        $income = new Income();

        if ($request->indoor_registration_fee) {

            $income->patient_uuid = $uuid;
            $income->type = 'indoor';
            $income->income_amount = $request->regi_fee;
            $income->income_source = $request->indoor_registration_fee;
            $income->income_source_name = Str::slug($request->indoor_registration_fee);
            $income->save();
        }

        function invoiceNumber()
        {
            $latest = RegistratonForm::latest()->first();

            if (!$latest) {
                return 1;
            }

            $serial = $latest->serial_no + 1;

            return $serial;
        }


        $data->uuid = $uuid;
        $data->name = $request->name;
        $data->serial_no = invoiceNumber();
        $data->address = $request->address;
        $data->cabin_no = $request->cabin_no;
        $data->regi_no = $request->regi_no;
        $data->regi_fee = $request->regi_fee;
        $data->generated_by = Auth::user()->name;
        $data->save();
        return redirect()->route('regi_form_view', $data->uuid)->with('success', 'Registration Success!');
    }


    public function regi_form_view(string $patient_id)
    {

        $patient = AdmissinForm::where('uuid', $patient_id)->firstOrFail();


        return view('backend.medical_pages.patients_regi_view', compact('patient'));
    }


    // Admission Part Started

    public function admission_form_view()
    {
        // $uuid = $id;
        return view('backend.medical_pages.admission_form');
    }

    public function admission_form_save(Request $request)
    {

        $patient_info = new AdmissinForm();

        $uuid = uniqid();

        $patient_info->uuid = $uuid;
        $patient_info->regular_date = $request->regular_date;
        $patient_info->regi_no = $request->regi_no;
        $patient_info->name = $request->name;
        $patient_info->age = $request->age;
        $patient_info->father_or_husb_name = $request->father_or_husb_name;
        $patient_info->present_address = $request->present_address;
        $patient_info->pre_village = $request->pre_village;
        $patient_info->pre_post_code = $request->pre_post_code;
        $patient_info->pre_thana = $request->pre_thana;
        $patient_info->pre_district = $request->pre_district;
        $patient_info->mobile = $request->mobile;
        $patient_info->admission_date = $request->admission_date;
        $patient_info->admission_time = $request->admission_time;
        $patient_info->disease_name = $request->disease_name;
        $patient_info->doctor_name = $request->doctor_name;
        $patient_info->cabin_no = $request->cabin_no;
        $patient_info->date_of_leave = $request->date_of_leave;
        $patient_info->leave_time = $request->leave_time;
        $patient_info->is_admitted = true;
        $patient_info->status = 'admitted';


        $patient_info->save();

        return redirect()->route('all_regi_patient')->with('success', 'Patient Admitted Successfully!');
    }

    // Admission Part Started End




    public function service_index()
    {
        return view('backend.medical_service.service');
    }
    public function service_store(Request $request)
    {


        $this->validate($request, [
            'name' => 'required'
        ]);


        $data = new Service();

        $data->name = $request->name;
        $data->name = $request->name;
        $data->name = $request->name;
        $data->save();
        return redirect()->back()->with('success', 'Created Successfully!');
    }
    public function delete_service()
    {
    }
}
