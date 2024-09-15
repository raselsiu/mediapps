<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AdmissinForm;
use App\Models\AllInComingAmount;
use App\Models\Cabin;
use App\Models\CashMemoForm;
use App\Models\CashMemoInfo;
use App\Models\Due;
use App\Models\DueCollection;
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


    public function addMoreServicesForm(Request $request, string $id)
    {

        $uuid = $id;
        $patient = AdmissinForm::where('uuid', $id)->first();
        $service_list = Service::all();

        return view('backend.medical_pages.add_more_services', compact('uuid', 'patient', 'service_list'));
    }


    public function addMoreServicesUpdate(Request $request, string $id)
    {

        $uuid = $id;

        $admissionForm = AdmissinForm::where('uuid', $uuid)->first();
        $cashMemoInfo =  CashMemoInfo::where('patient_uuid', $uuid)->first();
        $allIncomeAmount = AllInComingAmount::first();



        // =====================================================================
        $previousTotalBill = $cashMemoInfo->total_bill;
        $previousDiscount = $cashMemoInfo->discount;
        $previousTotalPaid = $cashMemoInfo->total_paid;
        $previousPaid = $cashMemoInfo->paid;
        $previousOutstandingTotal = $cashMemoInfo->outstanding_total;

        $addServiceBill = $allIncomeAmount->total_amount;

        // ======================================================================

        $admissionForm->total_bill = $request->total_bill + $previousTotalBill;
        $admissionForm->discount = $request->discount + $previousDiscount;
        $admissionForm->total_paid = $request->total_paid + $previousTotalPaid;
        $admissionForm->paid = $request->paid + $previousPaid;

        // =====================================================================
        $cashMemoInfo->total_bill = $request->total_bill + $previousTotalBill;
        $cashMemoInfo->discount = $request->discount + $previousDiscount;
        $cashMemoInfo->total_paid = $request->total_paid + $previousTotalPaid;
        $cashMemoInfo->paid = $request->paid + $previousPaid;
        // =====================================================================

        // =====================================================================
        $allIncomeAmount->total_amount = $addServiceBill + $request->paid;

        // =====================================================================

        $totalPaid = $request->total_paid;
        $paid = $request->paid;
        $outstanding = $totalPaid - $paid;
        // =====================================================================
        $cashMemoInfo->outstanding_total = $outstanding + $previousOutstandingTotal;




        $dueAmount = Due::where('refs_id', $uuid)->first();
        $due = Due::where('refs_id', $uuid)->first();
        $due->due_amount = $dueAmount->due_amount  + $outstanding;


        $cashMemoInfo->save();
        $admissionForm->save();
        $allIncomeAmount->save();
        $due->save();

        //Cash-Memo Form 

        $this->validate($request, [
            'patient_uuid' => 'required',
        ]);

        $patient_uuid = $uuid;
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

        return redirect()->route('all_regi_patient')->with('success', 'Service Added Successfully!');
    }







    public function cash_memo_form_save(Request $request)
    {

        $data = new CashMemoInfo();
        $admissionFormData = AdmissinForm::where('uuid', $request->patient_uuid)->first();
        $due = new Due();
        $allIncomingAmountSave = new AllInComingAmount();


        $data->patient_uuid = $request->patient_uuid;
        $data->patient_name = $admissionFormData->name;
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



        // Save the amount to Master Amount
        $allIncomeAmount = AllInComingAmount::first();



        if ($allIncomeAmount == null) {
            $allIncomingAmountSave->total_amount = $request->paid;
            $allIncomingAmountSave->save();
        } else {
            $allIncomeAmount->total_amount = $request->paid + $allIncomeAmount->total_amount;
            $allIncomeAmount->save();
        }

        // Due Collect
        $due->refs_id = $request->patient_uuid;
        $due->due_amount = $outstanding;
        $due->source = $admissionFormData->name;


        //  Saving Data

        $due->save();
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




        // $rcpt_info = CashMemoInfo::where('patient_uuid', $request->patient_uuid)->first();
        // $patient_info = AdmissinForm::where('uuid', $request->patient_uuid)->first();
        // $get_bill = CashMemoForm::where('patient_uuid', $request->patient_uuid)->get()->toArray();
        // return view('backend.medical_pages.cash_memo_receipt', compact('rcpt_info', 'get_bill', 'patient_info'));

        return redirect()->route('view_cash_memo', $request->patient_uuid);
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
        if ($request->due_amount <= 0) {
            return redirect()->back()->with('msg', 'Amount should not be less then or equal to 0');
        }





        $amount = $patient_cash->paid + $request->due_amount;

        $UpdateOutstanding_Total = $patient_cash->total_paid - $amount;

        $user = CashMemoInfo::where('patient_uuid', $id)->first();
        $user->paid = $amount;
        $user->outstanding_total = $UpdateOutstanding_Total;


        // Update Due

        $due = Due::where('refs_id', $id)->first();
        $due_amount = $due->due_amount;
        $updateDue = Due::where('refs_id', $id)->first();
        $updateDue->due_amount = $due_amount - $request->due_amount;



        // Due Amount Collection 

        $saveDue = new  DueCollection();
        $saveDue->refs_id  = $id;
        $saveDue->details  = 'Due Collected';
        $saveDue->amount  = $request->due_amount;

        // Updating Master Amount with Due Amount

        $UpdateMasterAmount = AllInComingAmount::first();

        $UpdateMasterAmount->total_amount = $UpdateMasterAmount->total_amount + $request->due_amount;



        $user->save();
        $updateDue->save();
        $saveDue->save();
        $UpdateMasterAmount->save();


        return redirect()->route('all_regi_patient')->with('success', 'Due Collected Successfully!');
    }








    public function view_cash_memo(String $id)
    {
        $rcpt_info = CashMemoInfo::where('patient_uuid', $id)->first();

        $patient_info = AdmissinForm::where('uuid', $id)->first();

        $get_bill = CashMemoForm::where('patient_uuid', $id)->get()->toArray();

        return view('backend.medical_pages.cash_memo_receipt', compact('rcpt_info', 'get_bill', 'patient_info'));
    }







    public function all_regi_patient()
    {

        $data['patients'] = AdmissinForm::all();

        return view('backend.medical_pages.registered_patient_list', $data);
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

        $cabin_info = Cabin::where('status', '0')->get();
        return view('backend.medical_pages.admission_form', compact('cabin_info'));
    }

    public function admission_form_save(Request $request)
    {

        // $request->validate([
        //     'regi_no' => "required|unique:admissin_forms,regi_no"
        // ]);

        $patient_info = new AdmissinForm();

        $uuid = uniqid();

        $patient_info->uuid = $uuid;
        $patient_info->regi_no = '0';
        $patient_info->name = $request->name;
        $patient_info->age = $request->age;
        $patient_info->father_or_husb_name = $request->father_or_husb_name;
        $patient_info->present_address = $request->present_address;
        $patient_info->pre_village = $request->pre_village;
        $patient_info->pre_post_code = $request->pre_post_code;
        $patient_info->pre_thana = $request->pre_thana;
        $patient_info->pre_district = $request->pre_district;
        $patient_info->mobile = $request->mobile;
        $patient_info->disease_name = $request->disease_name;
        $patient_info->doctor_name = $request->doctor_name;
        $patient_info->cabin_no = Str::slug($request->cabin_no);
        $patient_info->care_of = $request->care_of;
        $patient_info->regi_fee = $request->regi_fee;
        $patient_info->is_admitted = true;
        $patient_info->status = 'not_released';

        // Cabin Block

        $findCabin = Cabin::where('slug', Str::slug($request->cabin_no))->first();
        $findCabin->status = '1';


        $patient_info->save();

        $findRegiField = AdmissinForm::where('id', $patient_info->id)->first();

        $regi_num = '#' . str_pad($patient_info->id, 8, "0", STR_PAD_LEFT);

        $findRegiField->regi_no = $regi_num;

        $findRegiField->save();

        $findCabin->save();


        $totalAmount = AllInComingAmount::pluck('total_amount')->sum();

        $amount = AllInComingAmount::first();
        $saveFirst = new AllInComingAmount();

        if ($amount == null) {
            $saveFirst->total_amount = $request->regi_fee;
            $saveFirst->save();
        } else {
            $amount->total_amount =  $request->regi_fee + $totalAmount;
            $amount->save();
        }



        return redirect()->route('regi_form_view', $patient_info->uuid)->with('success', 'Admit Success!');
    }

    // Admission Part Started End




    public function service_index()
    {
        return view('backend.medical_service.service');
    }
    public function service_store(Request $request)
    {


        $this->validate($request, [
            'name' => 'required|unique:services,name'
        ]);


        $data = new Service();

        $data->name = $request->name;
        $data->description = $request->description;
        $data->save();
        return redirect()->back()->with('success', 'Created Successfully!');
    }
}
