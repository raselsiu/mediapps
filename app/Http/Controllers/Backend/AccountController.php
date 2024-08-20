<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
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

        $out_income['data'] = OutdoorModel::all();


        $outdoorAmount = OutdoorModel::pluck('regi_fee')->sum();


        $fromDate = Carbon::now()->subMonth()->startOfMonth()->toDateString();

        $tillDate = Carbon::now()->subMonth()->endOfMonth()->toDateString();

        // Last Month Revenue from Outdoor Patient
        $revenueLastMonth = DB::table('outdoor_models')->whereBetween('created_at', [$fromDate, $tillDate])->get();

        // Last 24 Hours Revenue from Outdoor Patient
        $revenue24Hours = DB::table('outdoor_models')->where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())->get();

        // Current Month Revenue
        $currentMonth = OutdoorModel::select('*')->whereMonth('created_at', Carbon::now()->month)->get();

        $last24HourIncomeDaily = DB::table('outdoor_models')->where('created_at', '>=', Carbon::now()->subDays(30)->toDateTimeString())->get();

        $yearly = DB::table('outdoor_models')->where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())->get();

        // dd($currentMonth);



        return view('backend.outdoor_income.outdoor_income', $out_income, compact('outdoorAmount'));
    }


    public function indoor_income()
    {
        $out_income['data'] = CashMemoInfo::all();
        $totalAmount = CashMemoInfo::pluck('paid')->sum();

        $fromDate = Carbon::now()->subMonth()->startOfMonth()->toDateString();
        $tillDate = Carbon::now()->subMonth()->endOfMonth()->toDateString();
        $revenueLastMonth = DB::table('incomes')->whereBetween('created_at', [$fromDate, $tillDate])->get();
        $revenue24Hours = DB::table('incomes')->where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())->get();
        $currentMonth = Income::select('*')->whereMonth('created_at', Carbon::now()->month)->get();

        $last24HourIncomeDaily = DB::table('incomes')->where('created_at', '>=', Carbon::now()->subDays(30)->toDateTimeString())->get();

        $yearly = DB::table('incomes')->where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())->get();



        return view('backend.indoor_income.indoor_income', $out_income, compact('totalAmount'));
    }





    public function expenditureCalculation()
    {
        $expenditure['data'] = Expenditure::all();
        $totalAmount = Expenditure::pluck('amount')->sum();
        return view('backend.expenditure_amount.expenditure_account', $expenditure, compact('totalAmount'));
    }




    public function incomeCalculation()
    {
        $income['data'] = IncomeField::all();
        $totalAmount = IncomeField::pluck('amount')->sum();
        return view('backend.income_amount.income_amount', $income, compact('totalAmount'));
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

        // Due Amount Getting 
        

        // Indoor Patients
        $fromAdmittedPatient = CashMemoInfo::whereDate('created_at', Carbon::today())->select('patient_name as income_source', 'paid as income_amount')->get();

        $merge_income = $income_field->concat($incomes)->concat($fromAdmittedPatient);

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
