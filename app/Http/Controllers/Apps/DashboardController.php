<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\Field;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        // Logic find budget
        // $budget = DB::table('fields')->select(DB::raw('SUM(budget) as totalBudget, '))->get();
        // foreach ($budget as $allBudget) {
        // $allBudget = (int)$allBudget;
        //     return dd($allBudget);
        // }

        // Financial Target chart data
        $chart_financial_target = DB::table('activities')
            ->select(DB::raw('MONTHNAME(updated_at) as ftTanggal,
            SUM(financial_target) as ftTotal'))
            ->groupBy('ftTanggal')
            ->get();

        // Financial Realization chart data
        $chart_financial_realization = DB::table('activities')
            ->select(DB::raw('MONTHNAME(updated_at) as frTanggal,
            SUM(financial_realization) as frTotal'))
            ->groupBy('frTanggal')
            ->get();

        // Financial Target Logic
        if (count($chart_financial_target)) {
            foreach ($chart_financial_target as $result) {
                $ftDate[] = $result->ftTanggal;
                $financial_target[] = (int)$result->ftTotal;
            }
        } else {
            $ftDate[] = "";
            $financial_target[] = "";
        }

        // Financial Realization Logic
        if (count($chart_financial_realization)) {
            foreach ($chart_financial_realization as $result) {
                $frDate[] = $result->frTanggal;
                $financial_realization[] = (int)$result->frTotal;
            }
        } else {
            $frDate[] = "";
            $financial_realization[] = "";
        }


        // Physical Target chart data
        $chart_physical_target = DB::table('activities')
            ->select(DB::raw('MONTHNAME(updated_at) AS ptTanggal,
            SUM(physical_target) AS ptTotal'))
            ->groupBy('ptTanggal')
            ->get();

        // Physical Realization chart data
        $chart_physical_realization = DB::table('activities')
            ->select(DB::raw('MONTHNAME(updated_at) AS prTanggal,
            SUM(physical_realization) AS prTotal'))
            ->groupBy('prTanggal')
            ->get();

        // Physical Target Logic
        if (count($chart_physical_target)) {
            foreach ($chart_physical_target as $result) {
                $ptDate[] = $result->ptTanggal;
                $physical_target[] = (int)$result->ptTotal;
            }
        } else {
            $ptDate[] = "";
            $physical_target[] = "";
        }

        // Physical Realization Logic
        if (count($chart_physical_realization)) {
            foreach ($chart_physical_realization as $result) {
                $prDate[] = $result->prTanggal;
                $physical_realization[] = (int)$result->prTotal;
            }
        } else {
            $prDate[] = "";
            $physical_realization[] = "";
        }

        return Inertia::render('Apps/Dashboard/Index', [
            'ftDate' => $ftDate,
            'frDate' => $frDate,
            'ptDate' => $ftDate,
            'prDate' => $frDate,
            'financial_target' => $financial_target,
            'financial_realization' => $financial_realization,
            'physical_target' => $physical_target,
            'physical_realization' => $physical_realization,
        ]);
    }
}
