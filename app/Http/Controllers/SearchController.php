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

        $fromDate = Carbon::now()->subDay()->startOfDay()->toDateString();
        $tillDate = Carbon::now()->subDay()->endOfDay()->toDateString();

        $startDate = Carbon::createFromFormat('Y-m-d', $fromDate)->startOfDay();
        $endDate = Carbon::createFromFormat('Y-m-d', $tillDate)->endOfDay();


        // Prevoius Days Outdoor Patient
        $outdoor['data'] = DB::table('outdoor_models')->whereBetween('created_at', [$startDate, $endDate])->get();
        $outdoor['total_amount'] = DB::table('outdoor_models')->whereBetween('created_at', [$startDate, $endDate])->pluck('regi_fee')->sum();

        return view('backend.outdoor_income.outdoor_income', $outdoor);
    }



    public function getCurrentMonthRevenue()
    {
        // Current Month Revenue
        $outdoor['data'] = OutdoorModel::select('*')->whereMonth('created_at', Carbon::now()->month)->get();
        $outdoor['total_amount']  = OutdoorModel::select('*')->whereMonth('created_at', Carbon::now()->month)->pluck('regi_fee')->sum();

        return view('backend.outdoor_income.outdoor_income', $outdoor);
    }






    public function getLastMonthRevenue()
    {

        $fromDate = Carbon::now()->subMonth()->startOfMonth()->toDateString();
        $tillDate = Carbon::now()->subMonth()->endOfMonth()->toDateString();

        $startDate = Carbon::createFromFormat('Y-m-d', $fromDate)->startOfDay();
        $endDate = Carbon::createFromFormat('Y-m-d', $tillDate)->endOfDay();



        // Last Month Revenue from Outdoor Patient
        $outdoor['data'] = DB::table('outdoor_models')->whereBetween('created_at', [$startDate, $endDate])->get();
        $outdoor['total_amount']  = DB::table('outdoor_models')->whereBetween('created_at', [$startDate, $endDate])->pluck('regi_fee')->sum();

        return view('backend.outdoor_income.outdoor_income', $outdoor);
    }




    // #################################################################
    // Outdoor Area End
    // #################################################################





    // #################################################################
    // Indoor Area
    // #################################################################


    public function indoorTwentyFourHour()
    {

        $fromDate = Carbon::now()->subDay()->startOfDay()->toDateString();
        $tillDate = Carbon::now()->subDay()->endOfDay()->toDateString();

        $startDate = Carbon::createFromFormat('Y-m-d', $fromDate)->startOfDay();
        $endDate = Carbon::createFromFormat('Y-m-d', $tillDate)->endOfDay();


        $data1 = CashMemoInfo::select('patient_uuid as uuid', 'patient_name as income_source', 'paid as income_amount')->whereBetween('created_at', [$startDate, $endDate])->get();
        $data2 = AdmissinForm::select('uuid', 'name as income_source', 'regi_fee as income_amount')->whereBetween('created_at', [$startDate, $endDate])->get();


        $sum1 = AdmissinForm::whereBetween('created_at', [$startDate, $endDate])->pluck('regi_fee')->sum();
        $sum2 = CashMemoInfo::whereBetween('created_at', [$startDate, $endDate])->pluck('paid')->sum();

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

        $fromDate = Carbon::now()->subDay()->startOfDay()->toDateString();
        $tillDate = Carbon::now()->subDay()->endOfDay()->toDateString();

        $startDate = Carbon::createFromFormat('Y-m-d', $fromDate)->startOfDay();
        $endDate = Carbon::createFromFormat('Y-m-d', $tillDate)->endOfDay();


        $expenditure['data'] = DB::table('expenditures')->whereBetween('created_at', [$startDate, $endDate])->get();
        $expenditure['total_amount']  = DB::table('expenditures')->whereBetween('created_at', [$startDate, $endDate])->pluck('amount')->sum();


        return view('backend.expenditure_amount.expenditure_account', $expenditure);
    }




    public function expGetCurrentMonthRevenue()
    {
        // Current Month Revenue
        $currentMonth['data'] = Expenditure::select('*')->whereMonth('created_at', Carbon::now()->month)->get();
        $currentMonth['total_amount']  = Expenditure::select('*')->whereMonth('created_at', Carbon::now()->month)->pluck('amount')->sum();

        return view('backend.expenditure_amount.expenditure_account', $currentMonth);
    }




    public function expGetLastMonthRevenue()
    {


        $fromDate = Carbon::now()->subMonth()->startOfMonth()->toDateString();
        $tillDate = Carbon::now()->subMonth()->endOfMonth()->toDateString();

        $startDate = Carbon::createFromFormat('Y-m-d', $fromDate)->startOfDay();
        $endDate = Carbon::createFromFormat('Y-m-d', $tillDate)->endOfDay();


        // Last Month Revenue from Outdoor Patient
        $lastMonth['data'] = DB::table('expenditures')->whereBetween('created_at', [$startDate, $endDate])->get();
        $lastMonth['total_amount'] = DB::table('expenditures')->whereBetween('created_at', [$startDate, $endDate])->pluck('amount')->sum();


        return view('backend.expenditure_amount.expenditure_account', $lastMonth);
    }



    #################################################################
    //Expenditure Area End
    #################################################################




    // #################################################################
    // Others Income Area
    // #################################################################
    public function othersTwentyFourHour()
    {

        $fromDate = Carbon::now()->subDay()->startOfDay()->toDateString();
        $tillDate = Carbon::now()->subDay()->endOfDay()->toDateString();

        $startDate = Carbon::createFromFormat('Y-m-d', $fromDate)->startOfDay();
        $endDate = Carbon::createFromFormat('Y-m-d', $tillDate)->endOfDay();


        $previousDay['data'] = DB::table('income_fields')->whereBetween('created_at', [$startDate, $endDate])->get();
        $previousDay['total_amount']  = DB::table('income_fields')->whereBetween('created_at', [$startDate, $endDate])->pluck('amount')->sum();

        return view('backend.income_amount.income_amount', $previousDay);
    }




    public function othersGetCurrentMonthRevenue()
    {
        // Current Month Revenue
        $currentMonth['data'] = IncomeField::select('*')->whereMonth('created_at', Carbon::now()->month)->get();
        $currentMonth['total_amount']  = IncomeField::select('*')->whereMonth('created_at', Carbon::now()->month)->pluck('amount')->sum();

        return view('backend.income_amount.income_amount', $currentMonth);
    }




    public function othersGetLastMonthRevenue()
    {

        $fromDate = Carbon::now()->subMonth()->startOfMonth()->toDateString();
        $tillDate = Carbon::now()->subMonth()->endOfMonth()->toDateString();

        $startDate = Carbon::createFromFormat('Y-m-d', $fromDate)->startOfDay();
        $endDate = Carbon::createFromFormat('Y-m-d', $tillDate)->endOfDay();



        // Last Month Revenue from Outdoor Patient
        $lastMonth['data'] = DB::table('income_fields')->whereBetween('created_at', [$startDate, $endDate])->get();
        $lastMonth['total_amount']  = DB::table('income_fields')->whereBetween('created_at', [$startDate, $endDate])->pluck('amount')->sum();

        return view('backend.income_amount.income_amount', $lastMonth);
    }




    // #################################################################
    // Others Income Area End
    // #################################################################




    public function getDatedExpenditureData(Request $request)
    {
        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required',
        ]);


        $start = $request->start_date;
        $end = $request->end_date;

        $startDate = Carbon::createFromFormat('Y-m-d', $start)->startOfDay();
        $endDate = Carbon::createFromFormat('Y-m-d', $end)->endOfDay();


        $data = Expenditure::whereBetween('created_at', [$startDate, $endDate])->get();
        $total_amount = Expenditure::whereBetween('created_at', [$startDate, $endDate])->pluck('amount')->sum();

        return view('backend.expenditure_amount.exp_search_by_calender', compact('data', 'total_amount'));
    }

    public function getDatedOutdrData(Request $request)
    {
        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required',
        ]);


        $start = $request->start_date;
        $end = $request->end_date;

        $startDate = Carbon::createFromFormat('Y-m-d', $start)->startOfDay();
        $endDate = Carbon::createFromFormat('Y-m-d', $end)->endOfDay();


        $data = OutdoorModel::whereBetween('created_at', [$startDate, $endDate])->get();
        $total_amount = OutdoorModel::whereBetween('created_at', [$startDate, $endDate])->pluck('regi_fee')->sum();

        return view('backend.outdoor_income.outdoor_search_by_calender', compact('data', 'total_amount'));
    }

    public function getDatedIndoorData(Request $request)
    {
        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required',
        ]);


        $start = $request->start_date;
        $end = $request->end_date;

        $startDate = Carbon::createFromFormat('Y-m-d', $start)->startOfDay();
        $endDate = Carbon::createFromFormat('Y-m-d', $end)->endOfDay();


        $data1 = CashMemoInfo::select('patient_uuid as uuid', 'patient_name as income_source', 'paid as income_amount', 'created_at')->whereBetween('created_at', [$startDate, $endDate])->orderBy('created_at', 'desc')->get();
        $data2 = AdmissinForm::select('uuid', 'name as income_source', 'regi_fee as income_amount', 'created_at')->whereBetween('created_at', [$startDate, $endDate])->orderBy('created_at', 'desc')->get();
        $indoor_info['data'] = $data1->concat($data2);
        $indoor_info['full_amount'] = $data1->concat($data2)->pluck('income_amount')->sum();

        return view('backend.indoor_income.indoor_search_by_calender', $indoor_info);
    }
    public function getDatedIncomesData(Request $request)
    {
        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required',
        ]);


        $start = $request->start_date;
        $end = $request->end_date;

        $startDate = Carbon::createFromFormat('Y-m-d', $start)->startOfDay();
        $endDate = Carbon::createFromFormat('Y-m-d', $end)->endOfDay();


        $data = IncomeField::whereBetween('created_at', [$startDate, $endDate])->get();
        $total_amount = IncomeField::whereBetween('created_at', [$startDate, $endDate])->pluck('amount')->sum();

        return view('backend.income_amount.income_search_by_calender', compact('data', 'total_amount'));
    }




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
        $indoorRegiFee = AdmissinForm::whereBetween('created_at', [$startDate, $endDate])->pluck('regi_fee')->sum();
        $outdoor = Income::whereBetween('created_at', [$startDate, $endDate])->pluck('income_amount')->sum();
        $income = IncomeField::whereBetween('created_at', [$startDate, $endDate])->pluck('amount')->sum();
        $expenditure = Expenditure::whereBetween('created_at', [$startDate, $endDate])->pluck('amount')->sum();
        $due = Due::whereBetween('created_at', [$startDate, $endDate])->pluck('due_amount')->sum();
        $dueCollection = DueCollection::whereBetween('created_at', [$startDate, $endDate])->pluck('amount')->sum();


        $indoors = $indoor + $indoorRegiFee;


        $total_income = $indoor + $outdoor + $income + $indoorRegiFee;



        return view(
            'backend.search_data.search_by_calender',
            compact('indoors', 'indoorRegiFee', 'outdoor', 'income', 'expenditure', 'total_income', 'due', 'dueCollection', 'previousDayIncome', 'startDate', 'endDate')
        );
    }
}
