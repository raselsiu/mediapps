<?php

namespace App\Http\Controllers;

use App\Models\Income;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function dataTwentyFourHour()
    {
        // $out_income['data'] = Income::all();

        $revenue24Hours['data'] = DB::table('incomes')->where('income_source_name', 'outdoor-registration-fee')->where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())->get();

        return view('backend.outdoor_income.outdoor_income', $revenue24Hours);
    }

    public function getCurrentMonthRevenue()
    {
        // Current Month Revenue
        $currentMonth['data'] = Income::select('*')->whereMonth('created_at', Carbon::now()->month)->get();

        return view('backend.outdoor_income.outdoor_income', $currentMonth);
    }


    public function getLastMonthRevenue()
    {
        $fromDate = Carbon::now()->subMonth()->startOfMonth()->toDateString();

        $tillDate = Carbon::now()->subMonth()->endOfMonth()->toDateString();

        // Last Month Revenue from Outdoor Patient
        $revenueLastMonth['data'] = DB::table('incomes')->whereBetween('created_at', [$fromDate, $tillDate])->get();

        return view('backend.outdoor_income.outdoor_income', $revenueLastMonth);
    }
}
