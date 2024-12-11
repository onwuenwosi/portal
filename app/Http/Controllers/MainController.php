<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ClientModel;
use App\Models\QueueList;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $credentials = User::all();
        $userCount = DB::table('users')->count();
        $request = DB::table('claim_models')
            ->where('status', '=', 'Pending')
            ->count();
        $pending = DB::table('parequest_models')
            ->where('Remark', '=', 'Pending')
            ->count();
        $principal = DB::table('client_models')->count();
        $dependent = DB::table('dependent_models')->count();
        $clientCount = $principal + $dependent;
        $pending = DB::table('parequest_models')->count();
        return view('pages.AdminDashboard', compact('credentials', 'userCount', 'clientCount', 'request', 'pending'));
    }

    public function users()
    {

        $credentials = User::all();
        $userCount = DB::table('users')->count();
        $clientCount = DB::table('client_models')->count();
        return view('pages.user', compact('credentials', 'userCount', 'clientCount'));
    }

    public function UsersDashboard()
    {;
        $user_id = auth()->user()->id;
        // to get number of approved request
        $user_request = DB::table('parequest_models')
            ->whereDate('created_at', '=', today()) //to filter date
            ->where('user_id', '=', $user_id) //to filter each user
            ->where('Remark', '=', 'Approved') // to filter only appproved request
            ->count();
        //to get number of pending request
        $user_pending = DB::table('parequest_models')
            ->whereDate('created_at', '=', today()) //to filter date
            ->where('user_id', '=', $user_id) //to filter each user
            ->where('Remark', '=', 'Pending') // to filter only pending request
            ->count();
        //declined request
        $user_declined = DB::table('parequest_models')
            ->whereDate('created_at', '=', today()) //to filter date
            ->where('user_id', '=', $user_id) //to filter each user
            ->where('Remark', '=', 'Declined') // to filter only declined request
            ->count();

        // eligibility list
        $user_queue = DB::table('queue_lists')
            ->whereDate('created_at', '=', today()) //to filter date
            ->where('user_id', '=', $user_id) //to filter each user
            ->count();
        return view('pages.UserDashboard', compact('user_request', 'user_pending', 'user_declined', 'user_queue'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.//queue
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'surname' => 'required',
            'othername' => 'required',
            'DateOfBirth' => 'required',
            'gender' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'check_in_by' => 'required',
            'policynumber' => 'required',
            'StartDate' => 'required',
            'EndDate' => 'required|after:StartDate',
            'status' => 'required',
            'clienttype' => 'required',
            'plantype' => 'required',
            'policytype' => 'required',
            'enrolleetype' => 'required',
            'passport' => 'image',

        ]);

        if ($request->hasFile('passport')) {
            $file = $request->file('passport');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('img'), $fileName);
            $validatedData['passport'] = 'img/' . $fileName;
        }

        $number = $request->policynumber;
        $existingClient = DB::table('queue_models')
            ->where('policynumber', '=', $number)
            ->whereDate('created_at', '=', today())
            ->first();

        if ($existingClient) {
            return redirect()->back()->with('error', 'Client Already Checked-in Today');
        }

        QueueList::create($validatedData);
        return redirect()->route('request.queue')->with('success', 'Client Check-In successfully');
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