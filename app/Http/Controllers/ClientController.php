<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\ClientModel;
use App\Models\DependentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\select;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $credentials = DB::table('client_models')->paginate(10);
        return view('pages.client', compact('credentials'));
    }
    /**
     * Display a listing of the resource.
     */
    public function check()
    {
        $data = DB::table('client_models')->paginate(5);
        return view('pages.check', compact('data'));
    }

    //to view single client
    public function viewcheck(string $id)
    {
        $data = DB::table('client_models');
        return view('pages.ViewCheck', compact('data'));
    }

    //eligibility queue
    public function queue()
    {
        $credentials = DB::table('client_models')
            ->whereDate('updated_at', '=', today())->paginate(10);




        return view('pages.queue', compact('credentials', 'userClient'));
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
        // Validate the incoming request
        $credentials = $request->validate([
            'surname' => 'required',
            'othername' => 'required',
            'gender' => 'required',
            'DateOfBirth' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'passport' => 'required|image', // Added image validation
            'status' => 'required',
            'StartDate' => 'required',
            'EndDate' => 'required|after:StartDate',
            'clienttype' => 'required',
            'plantype' => 'required',
            'user_id' => 'string',
            'policytype' => 'required',
            'enrolleetype' => 'required',
        ]);

        // Handle passport file upload
        if ($request->hasFile('passport')) {
            $file = $request->file('passport');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('img'), $fileName);
            $credentials['passport'] = 'img/' . $fileName;
        }

        // return redirect()->back()->with('error', 'Principal not found.')->withInput();

        // if ($request->enrolleetype === 'Dependent') {
        //     $principal = DB::table('client_models')
        //         ->select('surname', 'othername')
        //         ->where('policynumber', '=', $request->policynumber)
        //         ->first();

        //     if ($principal) {
        //         $credentials['PrincipalName'] = $principal->surname . ' ' . $principal->othername; // Example usage
        //     } else {
        //         return redirect()->back()->with('error', 'Principal not found.')->withInput();
        //     }
        // }

        // Create a new client record
        ClientModel::create($credentials);

        // Redirect with success message
        return redirect()->route('client.index')->with('success', 'Customer created successfully!');
    }
    public function Dependentstore(Request $request)
    {
        // Validate the incoming request
        $credentials = $request->validate([
            'surname' => 'required',
            'othername' => 'required',
            'gender' => 'required',
            'DateOfBirth' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'passport' => 'required|image', // Added image validation
            'status' => 'required',
            'StartDate' => 'required',
            'EndDate' => 'required|after:StartDate',
            'clienttype' => 'required',
            'plantype' => 'required',
            'relationship' => 'required',
            'policytype' => 'required',
            'enrolleetype' => 'required',
            'principal' => 'required',
            'principal_ID' => 'required',
        ]);

        // Handle passport file upload
        if ($request->hasFile('passport')) {
            $file = $request->file('passport');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('img'), $fileName);
            $credentials['passport'] = 'img/' . $fileName;
        }
        DependentModel::create($credentials);

        return redirect()->back()->with('success', 'Dependent added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $principal = DB::table('client_models')
            ->select('policynumber')
            ->where('id', $id)
            ->first();

        $dependents = DB::table('dependent_models')
            ->where('principal_ID', $principal->policynumber)
            ->get();

        $data = ClientModel::findOrFail($id);
        return view('pages.ShowClient', compact('data', 'dependents'));
    }

    public function Dependentshow(string $id)
    {
        $data = DependentModel::findOrFail($id);
        return view('pages.DependentShow', compact('data'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dependents = DB::table('client_models')
            ->where('enrolleetype', "=", 'Dependent')
            ->where('policynumber', "=", 'PrincipalNumber')->paginate(4);
        $credentials = DB::table('client_models')->paginate(10);
        $data = ClientModel::findOrFail($id);
        return view('pages.EditClient', compact('credentials', 'data', 'dependents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'surname' => 'required',
            'othername' => 'required',
            'gender' => 'required',
            'DateOfBirth' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'passport' => 'nullable|image', // Allow passport to be nullable
            'status' => 'required',
            'StartDate' => 'required',
            'EndDate' => 'required|after:StartDate',
            'clienttype' => 'required',
            'plantype' => 'required',
            'policytype' => 'required',
            'enrolleetype' => 'required',
        ]);

        if ($request->hasFile('passport')) {
            $file = $request->file('passport');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('img'), $fileName);
            $validatedData['passport'] = 'img/' . $fileName; // Save the new file path
        }

        $client = ClientModel::findOrFail($id);
        $client->update($validatedData);
        return redirect()->route('client.index')->with('success', 'Successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = ClientModel::findOrFail($id);
        $data->delete();
        return redirect()->route('client.index')->with('success', 'Client deleted successfully!');
    }

    public function Dependentdestroy(string $id)
    {
        $data = DependentModel::findOrFail($id);
        $data->delete();
        return redirect()->back()->with('success', 'Dependent deleted successfully!');
    }


    public function ClientSearch(Request $request)
    {
        $search = $request->input('search');

        $data = DB::table('client_models')
            ->where('policynumber', '=', $search)
            ->orWhere('surname', '=', $search)
            ->paginate(10);

        if ($data->isEmpty()) {
            return redirect()->route('client.index')->with('error', 'No results found for your search.');
        }

        return view('pages.client.index', compact('data'));
    }
}
