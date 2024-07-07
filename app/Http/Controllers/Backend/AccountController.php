<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CashMemoInfo;
use App\Models\Expenditure;
use App\Models\Income;
use App\Models\IncomeField;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{





    public function outdoor_income()
    {

        $out_income['data'] = Income::all();

        $fromDate = Carbon::now()->subMonth()->startOfMonth()->toDateString();

        $tillDate = Carbon::now()->subMonth()->endOfMonth()->toDateString();

        // Last Month Revenue from Outdoor Patient
        $revenueLastMonth = DB::table('incomes')->whereBetween('created_at', [$fromDate, $tillDate])->get();

        // Last 24 Hours Revenue from Outdoor Patient
        $revenue24Hours = DB::table('incomes')->where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())->get();

        // Current Month Revenue
        $currentMonth = Income::select('*')->whereMonth('created_at', Carbon::now()->month)->get();

        $last24HourIncomeDaily = DB::table('incomes')->where('created_at', '>=', Carbon::now()->subDays(30)->toDateTimeString())->get();

        $yearly = DB::table('incomes')->where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())->get();

        // dd($currentMonth);

        return view('backend.outdoor_income.outdoor_income', $out_income);
    }


    public function indoor_income()
    {
        $out_income['data'] = CashMemoInfo::all();

        $fromDate = Carbon::now()->subMonth()->startOfMonth()->toDateString();

        $tillDate = Carbon::now()->subMonth()->endOfMonth()->toDateString();

        // Last Month Revenue from Outdoor Patient
        $revenueLastMonth = DB::table('incomes')->whereBetween('created_at', [$fromDate, $tillDate])->get();

        // Last 24 Hours Revenue from Outdoor Patient
        $revenue24Hours = DB::table('incomes')->where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())->get();

        // Current Month Revenue
        $currentMonth = Income::select('*')->whereMonth('created_at', Carbon::now()->month)->get();

        $last24HourIncomeDaily = DB::table('incomes')->where('created_at', '>=', Carbon::now()->subDays(30)->toDateTimeString())->get();

        $yearly = DB::table('incomes')->where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())->get();

        // dd($currentMonth);

        return view('backend.indoor_income.indoor_income', $out_income);
    }





    public function expenditureCalculation()
    {
        $expenditure['data'] = Expenditure::all();
        return view('backend.expenditure_amount.expenditure_account', $expenditure);
    }




    public function incomeCalculation()
    {
        $income['data'] = IncomeField::all();
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

        $fromAdmittedPatient = CashMemoInfo::whereDate('created_at', Carbon::today())->select('patient_uuid as income_source', 'total_paid as income_amount')->get();

        $merge_income = $incomes->merge($income_field)->merge($fromAdmittedPatient);

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

        $merge_income_yd = $incomes_yd->merge($income_field_yd)->merge($fromAdmittedPatient_YD);


        $income_balance_yd = $merge_income_yd->pluck('income_amount')->sum();


        // Yesterday Expenditure
        $expenditure_yd = Expenditure::whereDate('created_at', Carbon::yesterday())->get();
        $expenditureAmount_yd = DB::table('expenditures')->whereDate('created_at', Carbon::yesterday())->pluck('amount')->sum();

        // Yesterday Cash
        $inCashYd = $income_balance_yd - $expenditureAmount_yd;


        // Yesterday Calculation End



        // Final Cash with forwording yesterday cash  
        $presentCashWithYd = $inCash + $inCashYd;




        return view('backend.accounts.account_books', compact(
            'expenditure',
            'expenditureAmount',
            'merge_income',
            'income_balance',
            'inCash',
            'inCashYd',
            'expenditure_yd',
            'expenditureAmount_yd',
            'merge_income_yd',
            'income_balance_yd',
            'presentCashWithYd'
        ));
    }



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
