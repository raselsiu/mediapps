<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AdmissinForm;
use App\Models\AllInComingAmount;
use App\Models\AllOutGoingAmount;
use App\Models\CashMemoInfo;
use App\Models\Expenditure;
use App\Models\Income;
use App\Models\IncomeField;
use App\Models\OutdoorModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{

    public function outdoor_income()
    {

        $outdoor['data'] = OutdoorModel::all();
        $outdoor['total_amount'] = OutdoorModel::pluck('regi_fee')->sum();

        return view('backend.outdoor_income.outdoor_income', $outdoor);
    }


    public function indoor_income()
    {



        $data1 = CashMemoInfo::select('patient_uuid as uuid', 'patient_name as income_source', 'paid as income_amount')->orderBy('created_at', 'desc')->get();
        $data2 = AdmissinForm::select('uuid', 'name as income_source', 'regi_fee as income_amount')->orderBy('created_at', 'desc')->get();

        $indoor_info['data'] = $data1->concat($data2);

        $indoor_info['full_amount'] = $data1->concat($data2)->pluck('income_amount')->sum();



        // dd($indoor_info['data']);



        return view('backend.indoor_income.indoor_income', $indoor_info);
    }




    public function expenditureCalculation()
    {
        $expenditure['data'] = Expenditure::all();
        $expenditure['total_amount'] = Expenditure::pluck('amount')->sum();
        return view('backend.expenditure_amount.expenditure_account', $expenditure);
    }




    public function incomeCalculation()
    {
        $income['data'] = IncomeField::all();
        $income['total_amount'] = IncomeField::pluck('amount')->sum();
        return view('backend.income_amount.income_amount', $income);
    }






    public function gettingIncome(Request $request)
    {
        $data = Income::all();
        return response()->json($data);
    }





    public function accountsBook()
    {

        // Todays Income
        $income_field = IncomeField::whereDate('created_at', Carbon::today())->select('category as income_source', 'amount as income_amount')->get();

        $incomes = Income::whereDate('created_at', Carbon::today())->get();

        // Indoor Patients
        $fromAdmittedPatient = CashMemoInfo::whereDate('created_at', Carbon::today())->select('patient_name as income_source', 'paid as income_amount')->get();

        // Indoor Registration Fee
        $regiFee = AdmissinForm::whereDate('created_at', Carbon::today())->select('name as income_source', 'regi_fee as income_amount')->get();

        $merge_income = $income_field->concat($incomes)->concat($fromAdmittedPatient)->concat($regiFee);

        $income_balance = $merge_income->pluck('income_amount')->sum();



        // Todays Expenditure
        $expenditure = Expenditure::whereDate('created_at', Carbon::today())->get();
        $expenditureAmount = DB::table('expenditures')->whereDate('created_at', Carbon::today())->pluck('amount')->sum();

        $inCash = $income_balance - $expenditureAmount;



        // Yesterday Calculation

        //  Yesterday income

        $income_field_yd = IncomeField::whereDate('created_at', Carbon::yesterday())->select('category as income_source', 'amount as income_amount')->get();
        $incomes_yd = Income::whereDate('created_at', Carbon::yesterday())->get();
        $fromAdmittedPatient_YD = CashMemoInfo::whereDate('created_at', Carbon::yesterday())->select('patient_uuid as income_source', 'total_paid as income_amount')->get();
        $merge_income_yd = $incomes_yd->concat($income_field_yd)->concat($fromAdmittedPatient_YD);
        $income_balance_yd = $merge_income_yd->pluck('income_amount')->sum();
        $expenditure_yd = Expenditure::whereDate('created_at', Carbon::yesterday())->get();
        $expenditureAmount_yd = DB::table('expenditures')->whereDate('created_at', Carbon::yesterday())->pluck('amount')->sum();
        $inCashYd = $income_balance_yd - $expenditureAmount_yd;

        // Final Cash with forwording yesterday cash  
        $allIncomingAmount = AllInComingAmount::first();
        $allOutGoingAmount = AllOutGoingAmount::first();

        if ($allIncomingAmount == null) {
            $incomingAmount = 0;
        } else {
            $incomingAmount = $allIncomingAmount->total_amount;
        }
        if ($allOutGoingAmount == null) {
            $outGoingAmount = 0;
        } else {
            $outGoingAmount = $allOutGoingAmount->total_amount;
        }

        $inCashTotal = $incomingAmount - $outGoingAmount;


        return view('backend.accounts.account_books', compact(
            'expenditure',
            'expenditureAmount',
            'merge_income',
            'income_balance',
            'inCash',
            'inCashTotal'
        ));
    }
}
