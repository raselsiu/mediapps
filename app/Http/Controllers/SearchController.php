<?php

namespace App\Http\Controllers;

use App\Models\CashMemoInfo;
use App\Models\Due;
use App\Models\DueCollection;
use App\Models\Expenditure;
use App\Models\Income;
use App\Models\IncomeField;
use App\Models\OutdoorModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Contracts\Service\Attribute\Required;

class SearchController extends Controller
{

    // #################################################################
    // Outdoor Area
    // #################################################################
    public function dataTwentyFourHour()
    {
        // Last 24 Hours Revenue from Outdoor Patient
        $revenue24Hours['data'] = DB::table('outdoor_models')->where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())->get();
        $outdoorAmount  = DB::table('outdoor_models')->where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())->pluck('regi_fee')->sum();

        return view('backend.outdoor_income.outdoor_income', $revenue24Hours, compact('outdoorAmount'));
    }

    public function getCurrentMonthRevenue()
    {
        // Current Month Revenue
        $currentMonth['data'] = OutdoorModel::select('*')->whereMonth('created_at', Carbon::now()->month)->get();
        $outdoorAmount  = OutdoorModel::select('*')->whereMonth('created_at', Carbon::now()->month)->pluck('regi_fee')->sum();

        return view('backend.outdoor_income.outdoor_income', $currentMonth, compact('outdoorAmount'));
    }


    public function getLastMonthRevenue()
    {
        $fromDate = Carbon::now()->subMonth()->startOfMonth()->toDateString();
        $tillDate = Carbon::now()->subMonth()->endOfMonth()->toDateString();

        // Last Month Revenue from Outdoor Patient
        $revenueLastMonth['data'] = DB::table('outdoor_models')->whereBetween('created_at', [$fromDate, $tillDate])->get();
        $outdoorAmount  = DB::table('outdoor_models')->whereBetween('created_at', [$fromDate, $tillDate])->pluck('regi_fee')->sum();

        return view('backend.outdoor_income.outdoor_income', $revenueLastMonth, compact('outdoorAmount'));
    }

    // #################################################################
    // Outdoor Area End
    // #################################################################







    // #################################################################
    // Indoor Area
    // #################################################################
    public function indoorTwentyFourHour()
    {
        $revenue24Hours['data'] = DB::table('cash_memo_infos')->where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())->get();
        $totalAmount  = DB::table('cash_memo_infos')->where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())->pluck('paid')->sum();

        return view('backend.indoor_income.indoor_income', $revenue24Hours, compact('totalAmount'));
    }
    public function indoorGetCurrentMonthRevenue()
    {
        // Current Month Revenue
        $currentMonth['data'] = CashMemoInfo::select('*')->whereMonth('created_at', Carbon::now()->month)->get();
        $totalAmount  = CashMemoInfo::select('*')->whereMonth('created_at', Carbon::now()->month)->pluck('paid')->sum();

        return view('backend.indoor_income.indoor_income', $currentMonth, compact('totalAmount'));
    }
    public function indoorGetLastMonthRevenue()
    {
        $fromDate = Carbon::now()->subMonth()->startOfMonth()->toDateString();
        $tillDate = Carbon::now()->subMonth()->endOfMonth()->toDateString();

        // Last Month Revenue from Outdoor Patient
        $revenueLastMonth['data'] = DB::table('cash_memo_infos')->whereBetween('created_at', [$fromDate, $tillDate])->get();
        $totalAmount  = DB::table('cash_memo_infos')->whereBetween('created_at', [$fromDate, $tillDate])->pluck('paid')->sum();

        return view('backend.indoor_income.indoor_income', $revenueLastMonth, compact('totalAmount'));
    }
    // #################################################################
    // Indoor Area End
    // #################################################################







    #################################################################
    //Expenditure Area
    #################################################################
    public function expTwentyFourHour()
    {
        $revenue24Hours['data'] = DB::table('expenditures')->where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())->get();
        $totalAmount  = DB::table('expenditures')->where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())->pluck('amount')->sum();

        return view('backend.expenditure_amount.expenditure_account', $revenue24Hours, compact('totalAmount'));
    }
    public function expGetCurrentMonthRevenue()
    {
        // Current Month Revenue
        $currentMonth['data'] = Expenditure::select('*')->whereMonth('created_at', Carbon::now()->month)->get();
        $totalAmount  = Expenditure::select('*')->whereMonth('created_at', Carbon::now()->month)->pluck('amount')->sum();

        return view('backend.expenditure_amount.expenditure_account', $currentMonth, compact('totalAmount'));
    }
    public function expGetLastMonthRevenue()
    {
        $fromDate = Carbon::now()->subMonth()->startOfMonth()->toDateString();
        $tillDate = Carbon::now()->subMonth()->endOfMonth()->toDateString();

        // Last Month Revenue from Outdoor Patient
        $revenueLastMonth['data'] = DB::table('expenditures')->whereBetween('created_at', [$fromDate, $tillDate])->get();
        $totalAmount  = DB::table('expenditures')->whereBetween('created_at', [$fromDate, $tillDate])->pluck('amount')->sum();

        return view('backend.expenditure_amount.expenditure_account', $revenueLastMonth, compact('totalAmount'));
    }



    #################################################################
    //Expenditure Area End
    #################################################################




    // #################################################################
    // Others Income Area
    // #################################################################
    public function othersTwentyFourHour()
    {
        $revenue24Hours['data'] = DB::table('income_fields')->where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())->get();
        $totalAmount  = DB::table('income_fields')->where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())->pluck('amount')->sum();

        return view('backend.income_amount.income_amount', $revenue24Hours, compact('totalAmount'));
    }
    public function othersGetCurrentMonthRevenue()
    {
        // Current Month Revenue
        $currentMonth['data'] = IncomeField::select('*')->whereMonth('created_at', Carbon::now()->month)->get();
        $totalAmount  = IncomeField::select('*')->whereMonth('created_at', Carbon::now()->month)->pluck('amount')->sum();

        return view('backend.income_amount.income_amount', $currentMonth, compact('totalAmount'));
    }
    public function othersGetLastMonthRevenue()
    {
        $fromDate = Carbon::now()->subMonth()->startOfMonth()->toDateString();
        $tillDate = Carbon::now()->subMonth()->endOfMonth()->toDateString();

        // Last Month Revenue from Outdoor Patient
        $revenueLastMonth['data'] = DB::table('income_fields')->whereBetween('created_at', [$fromDate, $tillDate])->get();
        $totalAmount  = DB::table('income_fields')->whereBetween('created_at', [$fromDate, $tillDate])->pluck('amount')->sum();

        return view('backend.income_amount.income_amount', $revenueLastMonth, compact('totalAmount'));
    }
    // #################################################################
    // Others Income Area End
    // #################################################################













    public function getDatedData(Request $request)
    {
        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required',
        ]);
        // Start and End Date
        // $startDate = Carbon::createFromFormat('Y-m-d', $request->start_date);
        // $endDate = Carbon::createFromFormat('Y-m-d', $request->end_date);

        $start = $request->start_date;
        $end = $request->end_date;

        $startDate = Carbon::createFromFormat('Y-m-d', $start)->startOfDay();
        $endDate = Carbon::createFromFormat('Y-m-d', $end)->endOfDay();

        $indoor = CashMemoInfo::whereBetween('created_at', [$startDate, $endDate])->pluck('paid')->sum();
        $outdoor = Income::whereBetween('created_at', [$startDate, $endDate])->pluck('income_amount')->sum();
        $income = IncomeField::whereBetween('created_at', [$startDate, $endDate])->pluck('amount')->sum();
        $expenditure = Expenditure::whereBetween('created_at', [$startDate, $endDate])->pluck('amount')->sum();
        $due = Due::whereBetween('created_at', [$startDate, $endDate])->pluck('due_amount')->sum();
        $dueCollection = DueCollection::whereBetween('created_at', [$startDate, $endDate])->pluck('amount')->sum();

        $total_income = $indoor + $outdoor + $income;



        return view('backend.search_data.search_by_calender', compact('indoor', 'outdoor', 'income', 'expenditure', 'total_income', 'due', 'dueCollection', 'startDate', 'endDate'));
    }
}
