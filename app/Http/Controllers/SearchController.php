<?php

namespace App\Http\Controllers;

use App\Models\AdmissinForm;
use App\Models\CashMemoInfo;
use App\Models\Due;
use App\Models\DueCollection;
use App\Models\Expenditure;
use App\Models\Income;
use App\Models\IncomeField;
use App\Models\OutdoorModel;
use Carbon\Carbon;
use DateInterval;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        // $revenue24Hours['data'] = DB::table('cash_memo_infos')->where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())->get();
        // $totalAmount  = DB::table('cash_memo_infos')->where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())->pluck('paid')->sum();


        $data1 = CashMemoInfo::select('patient_uuid as uuid', 'patient_name as income_source', 'paid as income_amount')->where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())->orderBy('created_at', 'desc')->get();
        $data2 = AdmissinForm::select('uuid', 'name as income_source', 'regi_fee as income_amount')->where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())->orderBy('created_at', 'desc')->get();



        $sum1 = AdmissinForm::where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())->pluck('regi_fee')->sum();
        $sum2 = CashMemoInfo::where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())->pluck('paid')->sum();

        $indoor_info['data'] = $data1->concat($data2);

        $indoor_info['full_amount'] = $sum1 + $sum2;


        return view('backend.indoor_income.indoor_income', $indoor_info);
    }
    public function indoorGetCurrentMonthRevenue()

    {


        $data1 = CashMemoInfo::select('patient_uuid as uuid', 'patient_name as income_source', 'paid as income_amount')->whereMonth('created_at', Carbon::now()->month)->orderBy('created_at', 'desc')->get();
        $data2 = AdmissinForm::select('uuid', 'name as income_source', 'regi_fee as income_amount')->whereMonth('created_at', Carbon::now()->month)->orderBy('created_at', 'desc')->get();



        $sum1 = AdmissinForm::whereMonth('created_at', Carbon::now()->month)->pluck('regi_fee')->sum();
        $sum2 = CashMemoInfo::whereMonth('created_at', Carbon::now()->month)->pluck('paid')->sum();

        $indoor_info['data'] = $data1->concat($data2);

        $indoor_info['full_amount'] = $sum1 + $sum2;


        return view('backend.indoor_income.indoor_income', $indoor_info);
    }
    public function indoorGetLastMonthRevenue()
    {
        $fromDate = Carbon::now()->subMonth()->startOfMonth()->toDateString();
        $tillDate = Carbon::now()->subMonth()->endOfMonth()->toDateString();



        $startDate = Carbon::createFromFormat('Y-m-d', $fromDate)->startOfDay();
        $endDate = Carbon::createFromFormat('Y-m-d', $tillDate)->endOfDay();




        // Last Month Revenue from Outdoor Patient
        // $revenueLastMonth['data'] = DB::table('cash_memo_infos')->whereBetween('created_at', [$fromDate, $tillDate])->get();
        // $totalAmount  = DB::table('cash_memo_infos')->whereBetween('created_at', [$fromDate, $tillDate])->pluck('paid')->sum();

        // return view('backend.indoor_income.indoor_income', $revenueLastMonth, compact('totalAmount'));




        $data1 = CashMemoInfo::select('patient_uuid as uuid', 'patient_name as income_source', 'paid as income_amount')->whereBetween('created_at', [$startDate, $endDate])->get();
        $data2 = AdmissinForm::select('uuid', 'name as income_source', 'regi_fee as income_amount')->whereBetween('created_at', [$startDate, $endDate])->get();







        $sum1 = AdmissinForm::whereBetween('created_at', [$startDate, $endDate])->pluck('regi_fee')->sum();
        $sum2 = CashMemoInfo::whereBetween('created_at', [$startDate, $endDate])->pluck('paid')->sum();

        $indoor_info['data'] = $data1->concat($data2);

        $indoor_info['full_amount'] = $sum1 + $sum2;





        return view('backend.indoor_income.indoor_income', $indoor_info);
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


        // Getting previous day from a date
        $tz    = new DateTimeZone('Asia/Dhaka');
        $date  = new DateTime($endDate, $tz);
        $interval = new DateInterval('P1D');
        $date->sub($interval);
        $previousDayFromADate = $date->format('y-m-d');
        $previousDay = Carbon::createFromFormat('Y-m-d', $previousDayFromADate)->endOfDay();

        $indoorPre = CashMemoInfo::whereBetween('created_at', [$startDate, $previousDay])->pluck('paid')->sum();
        $outdoorPre = Income::whereBetween('created_at', [$startDate, $previousDay])->pluck('income_amount')->sum();
        $incomePre = IncomeField::whereBetween('created_at', [$startDate, $previousDay])->pluck('amount')->sum();
        $expenditurePre = Expenditure::whereBetween('created_at', [$startDate, $previousDay])->pluck('amount')->sum();

        $previousDayIncome = (($indoorPre + $outdoorPre + $incomePre) - $expenditurePre);

        // end




        $indoor = CashMemoInfo::whereBetween('created_at', [$startDate, $endDate])->pluck('paid')->sum();
        $outdoor = Income::whereBetween('created_at', [$startDate, $endDate])->pluck('income_amount')->sum();
        $income = IncomeField::whereBetween('created_at', [$startDate, $endDate])->pluck('amount')->sum();
        $expenditure = Expenditure::whereBetween('created_at', [$startDate, $endDate])->pluck('amount')->sum();
        $due = Due::whereBetween('created_at', [$startDate, $endDate])->pluck('due_amount')->sum();
        $dueCollection = DueCollection::whereBetween('created_at', [$startDate, $endDate])->pluck('amount')->sum();



        $total_income = $indoor + $outdoor + $income;



        return view('backend.search_data.search_by_calender', compact('indoor', 'outdoor', 'income', 'expenditure', 'total_income', 'due', 'dueCollection', 'previousDayIncome', 'startDate', 'endDate'));
    }
}
