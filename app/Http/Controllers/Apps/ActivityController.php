<?php

namespace App\Http\Controllers\Apps;

use App\Exports\ActivityExport;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Field;
use App\Models\Group;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // return dd(Carbon::now()->translatedFormat('F'));
        // Get All Activities or Find it!
        // $activities = Activity::when(request()->q, function ($activities) {
        //     $activities = $activities->where('name', 'like', '%' . request()->q . '%')->whereMonth('created_at', '==', now()->submon('M'));
        // })->with(['user', 'group', 'field'])->latest()->paginate(10);
        $activities = Activity::with(['user', 'group', 'field'])->whereMonth('created_at', '=', Carbon::now())->latest()->paginate(10);

        foreach ($activities as $activity) {
            $activity['financial_target'] = round($activity['financial_target'] / $activity->budget * 100, 2);
            $activity['financial_realization'] = round($activity['financial_realization'] / $activity->budget * 100, 2);
            $activity['physical_target'] = round($activity['physical_target'] / $activity->budget * 100, 2);
            $activity['physical_realization'] = round($activity['physical_realization'] / $activity->budget * 100, 2);
        }

        // Next Month
        $next_month = Carbon::parse(now()->addMonth(1))->translatedFormat('F');

        // Get All Groups
        $groups = DB::table('groups')->orderBy('name')->get();

        // Get All Fields
        $fields = DB::table('fields')->orderBy('name')->get();

        // Get All Users
        $users = DB::table('users')->orderBy('name')->get();

        // Return Inertia
        return Inertia::render('Apps/Activities/Index', [
            'activities' => $activities,
            'next_month' => $next_month,
            'users' => $users,
            'groups' => $groups,
            'fields' => $fields,
        ]);
    }

    /**
     * filter
     *
     * @param  mixed $request
     * @return void
     */
    public function filter(Request $request)
    {

        if ($request->sfi && $request->sgi && $request->sui) {
            $activities = Activity::with('user', 'group', 'field')->where('field_id', '=', $request->sfi)->where('group_id', '=', $request->sgi)->where('user_id', '=', $request->sui)->whereMonth('created_at', '=', now())->latest()->paginate(10);
        } elseif ($request->sfi && $request->sgi && !$request->sui) {
            $activities = Activity::with(['user', 'group', 'field'])->where('field_id', '=', $request->sfi)->where('group_id', '=', $request->sgi)->whereMonth('created_at', '=', now())->latest()->paginate(10);
        } elseif ($request->sfi && !$request->sgi && $request->sui) {
            $activities = Activity::with(['user', 'group', 'field'])->where('field_id', '=', $request->sfi)->where('user_id', '=', $request->sui)->whereMonth('created_at', '=', now())->latest()->paginate(10);
        } elseif ($request->sfi && !$request->sgi && !$request->sui) {
            $activities = Activity::with(['user', 'group', 'field'])->where('field_id', '=', $request->sfi)->whereMonth('created_at', '=', now())->latest()->paginate(10);
        } elseif (!$request->sfi && $request->sgi && $request->sui) {
            $activities = Activity::with(['user', 'group', 'field'])->where('group_id', '=', $request->sgi)->where('user_id', '=', $request->sui)->whereMonth('created_at', '=', now())->latest()->paginate(10);
        } elseif (!$request->sfi && $request->sgi && !$request->sui) {
            $activities = Activity::with(['user', 'group', 'field'])->where('group_id', '=', $request->sgi)->whereMonth('created_at', '=', now())->latest()->paginate(10);
        } elseif (!$request->sfi && !$request->sgi && $request->sui) {
            $activities = Activity::with(['user', 'group', 'field'])->where('user_id', '=', $request->sui)->whereMonth('created_at', '=', now())->latest()->paginate(10);
        } else {
            return redirect()->route('apps.activities.index');
        }


        foreach ($activities as $activity) {
            $activity['financial_target'] = round($activity['financial_target'] / $activity->budget * 100, 2);
            $activity['financial_realization'] = round($activity['financial_realization'] / $activity->budget * 100, 2);
            $activity['physical_target'] = round($activity['physical_target'] / $activity->budget * 100, 2);
            $activity['physical_realization'] = round($activity['physical_realization'] / $activity->budget * 100, 2);
        }


        // Next Month
        $next_month = Carbon::parse(now()->addMonth(1))->translatedFormat('F');

        // Get All Groups
        $groups = DB::table('groups')->orderBy('name')->get();

        // Get All Fields
        $fields = DB::table('fields')->orderBy('name')->get();

        // Get All Users
        $users = DB::table('users')->orderBy('name')->get();

        $fieldSearchId = Field::where('id', '=', $request->sfi)->pluck('id');
        $groupSearchId = Group::where('id', '=', $request->sgi)->pluck('id');
        $userSearchId = User::where('id', '=', $request->sui)->pluck('id');
        $field_name = Field::where('id', '=', $request->sfi)->pluck('name');
        $group_name = Group::where('id', '=', $request->sgi)->pluck('name');
        $user_name = User::where('id', '=', $request->sui)->pluck('name');

        // return dd($field_name);

        // Return Inertia
        return Inertia::render('Apps/Activities/Index', [
            'activities' => $activities,
            'next_month' => $next_month,
            'users' => $users,
            'groups' => $groups,
            'fields' => $fields,
            'fieldSearchId' => $fieldSearchId,
            'groupSearchId' => $groupSearchId,
            'userSearchId' => $userSearchId,
            'field_name' => $field_name,
            'group_name' => $group_name,
            'user_name' => $user_name,
        ]);
    }


    /**
     * create
     *
     * @return void
     */
    public function create()
    {
        // Get All Groups
        $groups = DB::table('groups')->orderBy('name')->get();

        // Get All Fields
        $fields = DB::table('fields')->orderBy('name')->get();

        // Get All Users
        $users = DB::table('users')->orderBy('name')->get();

        $next_month = Carbon::parse(now()->addMonth(1))->translatedFormat('F');

        // Return Inertia
        return Inertia::render('Apps/Activities/Create', [
            'users' => $users,
            'groups' => $groups,
            'fields' => $fields,
            'next_month' => $next_month,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate Request
        $this->validate($request, [
            'user_id' => 'required',
            'group_id' => 'required',
            'field_id' => 'required',
            'name' => 'required',
            'budget' => 'required',
            'financial_target' => 'nullable',
            'financial_realization' => 'required',
            'physical_target' => 'nullable',
            'physical_realization' => 'required',
            'dones' => 'nullable',
            'problems' => 'nullable',
            'follow_up' => 'nullable',
            'todos' => 'nullable',
        ]);

        Activity::create([
            'user_id' => $request->user_id,
            'group_id' =>  $request->group_id,
            'field_id' =>  $request->field_id,
            'name' =>  $request->name,
            'budget' => $request->budget,
            'financial_target' => $request->financial_target,
            'financial_realization' => $request->financial_realization,
            'physical_target' => $request->physical_target,
            'physical_realization' => $request->physical_realization,
            'dones' => $request->dones,
            'problems' => $request->problems,
            'follow_up' => $request->follow_up,
            'todos' => $request->todos,
        ]);

        return redirect()->route('apps.activities.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Activity $activity)
    {
        // Get activity data
        $activity = Activity::with(['field', 'group', 'user'])->find($activity->id);

        $activity['financial_target'] = round($activity['financial_target'] / $activity->budget * 100, 2);
        $activity['financial_realization'] = round($activity['financial_realization'] / $activity->budget * 100, 2);
        $activity['physical_target'] = round($activity['physical_target'] / $activity->budget * 100, 2);
        $activity['physical_realization'] = round($activity['physical_realization'] / $activity->budget * 100, 2);


        $month = Carbon::now()->format('F Y');
        $next_month = Carbon::parse(now()->addMonth(1))->translatedFormat('F');

        $chart_financial_relaization = DB::table('activities')
            ->select(DB::raw('DATE(updated_at) as tanggal, SUM(financial_realization) as T '))
            ->where('id', '=', $activity->id)
            ->get();

        if (count($chart_financial_relaization)) {
            foreach ($chart_financial_relaization as $result) {
                $financial_date[] = $result->tanggal;
                $financial_realization[] = (int)$result->T;
            }
        } else {
            $financial_date[] = "";
            $financial_realization[] = "";
        }



        return Inertia::render('Apps/Activities/Show', [
            'activity' => $activity,
            'month' => $month,
            'next_month' => $next_month,
            'financial_date' => $financial_date,
            'financial_realization' => $financial_realization,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Activity $activity)
    {
        // Get All Groups
        $groups = DB::table('groups')->orderBy('name')->get();

        // Get All Fields
        $fields = DB::table('fields')->orderBy('name')->get();

        // Get All Users
        $users = DB::table('users')->orderBy('name')->get();

        $next_month = Carbon::parse(now()->addMonth(1))->translatedFormat('F');

        // Return Inertia
        return Inertia::render('Apps/Activities/Edit', [
            'users' => $users,
            'fields' => $fields,
            'groups' => $groups,
            'activity' => $activity,
            'next_month' => $next_month,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Activity $activity)
    {
        // return dd($request->all());

        // Validate Request
        $this->validate($request, [
            'user_id' => 'required',
            'group_id' => 'required',
            'field_id' => 'required',
            'name' => 'required',
            'budget' => 'required',
            'financial_target' => 'required',
            'financial_realization' => 'required',
            'physical_target' => 'required',
            'physical_realization' => 'required',
            'dones' => 'nullable',
            'problems' => 'nullable',
            'follow_up' => 'nullable',
            'todos' => 'nullable',
        ]);

        $activity->update([
            'user_id' => $request->user_id,
            'group_id' =>  $request->group_id,
            'field_id' =>  $request->field_id,
            'name' =>  $request->name,
            'budget' => $request->budget,
            'financial_target' => $request->financial_target,
            'financial_realization' => $request->financial_realization,
            'physical_target' => $request->physical_target,
            'physical_realization' => $request->physical_realization,
            'dones' => $request->dones,
            'problems' => $request->problems,
            'follow_up' => $request->follow_up,
            'todos' => $request->todos,
        ]);

        // Redirect
        return redirect()->route('apps.activities.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $activity = Activity::findOrFail($id);

        $activity->delete();

        return redirect()->route('apps.activities.index');
    }

    public function export(Request $request)
    {
        $current_month = Carbon::parse(now())->translatedFormat('F Y');
        // $currentMonth = Carbon::now()->month;
        // $sfi = $request->sfi;
        // $sgi = $request->sgi;
        // $sui = $request->sui;

        // if (($sfi == "undefined" || $sfi == null) &&  ($sgi == "undefined" || $sgi == null) && ($sui == "undefined" || $sui == null)) {
        //     $activities = Activity::with('user', 'group', 'field')->whereMonth('created_at',  now('F'))->latest()->get();
        // } else {
        //     $activities = Activity::with('user', 'group', 'field')->where(function ($query) use ($sfi, $sgi, $sui) {
        //         $query->where('field_id', '=', $sfi)
        //             ->orWhere('group_id', '=', $sgi)
        //             ->orWhere('user_id', '=', $sui);
        //     })->whereMonth('created_at', $currentMonth)->latest()->get();
        // }

        // return Excel::download(function ($excel) use ($activities) {
        //     $excel->sheet('Sheet1', function ($sheet) use ($activities) {
        //         $sheet->loadView('activity', ['activities' => $activities]);
        //         $sheet->setFreeze('A2');
        //     });
        // }, 'E-Monev BBPSI Mektan' . ' - ' . $current_month . '.xlsx');

        return Excel::download(new ActivityExport($request->sfi, $request->sgi, $request->sui), 'E-Monev BBPSI Mektan' . ' - ' . $current_month . '.xlsx');
    }

    public function pdf(Request $request)
    {
        $current_month = Carbon::parse(now())->translatedFormat('F Y');
        $current_month1 = Carbon::parse(now())->translatedFormat('m');
        $next_month = Carbon::parse(now()->addMonth(1))->translatedFormat('F');
        $sfi = $request->sfi;
        $sgi = $request->sgi;
        $sui = $request->sui;

        if (($sfi == "undefined" || $sfi == null) &&  ($sgi == "undefined" || $sgi == null) && ($sui == "undefined" || $sui == null)) {
            $activities = Activity::with('user', 'group', 'field')->whereMonth('created_at',  now('F'))->latest()->get();
        } else {
            $activities = Activity::with('user', 'group', 'field')->where(function ($query) use ($sfi, $sgi, $sui) {
                $query->where('field_id', '=', $sfi)
                    ->orWhere('group_id', '=', $sgi)
                    ->orWhere('user_id', '=', $sui);
            })->whereMonth('created_at', $current_month1)->latest()->get();
        }


        // $pdf = Pdf::loadView('exports.export_pdf', compact('current_month', 'next_month', 'activities'));

        if (($sfi == "undefined" || $sfi == null) &&  ($sgi == "undefined" || $sgi == null) && ($sui == "undefined" || $sui == null)) {
            $pdf = Pdf::loadView('exports.export_all_pdf', compact('current_month', 'next_month', 'activities'));
        } else {
            $pdf = Pdf::loadView('exports.export_pdf', compact('current_month', 'next_month', 'activities'));
        }
        return $pdf->stream();
        // return $pdf->download('E-Monev BBPSI Mektan' . ' - ' . $current_month . '.pdf');
    }
}
