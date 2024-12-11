<?php

namespace App\Http\Controllers;

use App\Mail\check_in;
use Illuminate\Support\Facades\Mail;
use App\Models\claimModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\ClientModel;
use App\Models\TariffModel;
use App\Models\RequestModel;
use App\Models\ParequestModel;
use App\Models\QueueList;
use App\Models\DxModel;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class RequestController extends Controller
{
    public function index()
    {
        $user = auth()->user()->id;
        if (auth()->user()->role === 'Admin') {
            $principal = DB::table('parequest_models')
                ->join('client_models', 'client_models.policynumber', '=', 'parequest_models.client_id')
                ->select('client_models.surname', 'client_models.othername', 'client_models.policynumber', 'parequest_models.*')
                ->whereDate('parequest_models.created_at', '=', today())
                ->groupBy('parequest_models.batch_id')
                ->get();

            $dependent = DB::table('parequest_models')
                ->join('dependent_models', 'dependent_models.policynumber', '=', 'parequest_models.client_id')
                ->select('dependent_models.surname', 'dependent_models.othername', 'dependent_models.policynumber', 'parequest_models.*')
                ->whereDate('parequest_models.created_at', '=', today())
                ->groupBy('parequest_models.batch_id')
                ->get();
            return view('pages.ListofEncounter', compact('principal', 'dependent'));
        } else {
            $principal = DB::table('parequest_models')
                ->join('client_models', 'client_models.policynumber', '=', 'parequest_models.client_id')
                ->select('client_models.surname', 'client_models.othername', 'client_models.policynumber', 'parequest_models.*')
                ->where('parequest_models.user_id', '=', $user)
                ->whereDate('parequest_models.created_at', '=', today())
                ->groupBy('parequest_models.batch_id')
                ->get();

            $dependent = DB::table('parequest_models')
                ->join('dependent_models', 'dependent_models.policynumber', '=', 'parequest_models.client_id')
                ->select('dependent_models.surname', 'dependent_models.othername', 'dependent_models.policynumber', 'parequest_models.*')
                ->where('parequest_models.user_id', '=', $user)
                ->whereDate('parequest_models.created_at', '=', today())
                ->groupBy('parequest_models.batch_id')
                ->get();
            return view('pages.ListofEncounter', compact('principal', 'dependent'));
        }
    }

    public function create()
    {
        $user = auth()->user()->role; //role of the login user
        $user_id = auth()->user()->id; //id of the login user

        if ($user === 'Admin') {
            $credentials = DB::table('queue_lists')
                ->join('client_models', 'client_models.policynumber', '=', 'queue_lists.client_id')
                ->select('client_models.*', 'queue_lists.id as queue_id', 'queue_lists.check_in_by')
                ->whereDate('queue_lists.created_at', '=', today())
                ->orderBy('queue_lists.created_at', 'DESC')
                ->get();
            $dependent = DB::table('queue_lists')
                ->join('dependent_models', 'dependent_models.policynumber', '=', 'queue_lists.client_id')
                ->select('dependent_models.*', 'queue_lists.id as queue_id', 'queue_lists.check_in_by')
                ->whereDate('queue_lists.created_at', '=', today())
                ->orderBy('queue_lists.created_at', 'DESC')
                ->get();
            return view('pages.queue', compact('credentials', 'dependent'));
        } else {
            $userClient = DB::table('queue_lists')
                ->join('client_models', 'client_models.policynumber', '=', 'queue_lists.client_id')
                ->select('client_models.*', 'queue_lists.id as queue_id', 'queue_lists.check_in_by')
                ->where('queue_lists.user_id', '=', $user_id)
                ->whereDate('queue_lists.created_at', '=', today())
                ->orderBy('queue_lists.created_at', 'DESC')
                ->get();
            $dependent = DB::table('queue_lists')
                ->join('dependent_models', 'dependent_models.policynumber', '=', 'queue_lists.client_id')
                ->select('dependent_models.*', 'queue_lists.id as queue_id', 'queue_lists.check_in_by')
                ->where('queue_lists.user_id', '=', $user_id)
                ->whereDate('queue_lists.created_at', '=', today())
                ->orderBy('queue_lists.created_at', 'DESC')
                ->get();
            return view('pages.queue', compact('userClient', 'dependent'));
        }
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'check_in_by' => 'required',
            'client_id' => 'required',
            'user_id' => 'required',

        ]);

        $number = $request->client_id;
        $user = auth()->user()->name;

        $existingClient = DB::table('queue_lists')
            ->where('client_id', '=', $number)
            ->whereDate('created_at', '=', today())
            ->first();

        if ($existingClient) {
            return redirect()->back()->with('error', 'Client Already Checked-in Today');
        }
        QueueList::create($validatedData);


        $recipient = DB::table('client_models')
            ->where('policynumber', '=', $number)
            ->first();

        if (!$recipient) {
            $recipient = DB::table('dependent_models')
                ->where('policynumber', '=', $number)
                ->first();
        }

        if ($recipient && $recipient->email) {
            $policy = $recipient->policynumber;
            $surname = $recipient->surname;
            $othername = $recipient->othername;
            $user = auth()->user()->name;
            $time = now();

            Mail::to($recipient->email)
                ->send(new check_in($policy, $surname, $othername, $time, $user));
        }

        return redirect()->route('request.queue')->with('success', 'Client Check-In successfully');
    }


    public function claimSubmit(Request $request)
    {
        $validatedData = $request->validate([
            'batch_id' => 'required',
            'user_id' => 'required',
            'request_id' => 'required',
            'policynumber' => 'required',
            'Remark' => 'required|string|in:Approved',
        ]);

        $number = $request->request_id;

        // Check if the claim has already been submitted or if the Remark is not 'Approved'
        $existingClient = DB::table('claim_models')
            ->where('id', '=', $number)
            ->first();

        if ($existingClient) {
            if ($existingClient->id == $number) {
                return redirect()->back()->with('error', 'Claim already submitted');
            } else {
                return redirect()->back()->with('error', 'Request has not been Approved');
            }
        }
        claimModel::create($validatedData);
        return redirect()->back()->with('success', 'Claim submitted successfully');
    }


    public function saveRequests(Request $request)
    {
        $validatedData = $request->validate([
            'requests' => 'required|array',
            'requests.*.diagnosis' => 'required|string',
            'requests.*.procedure' => 'required|string',
            'requests.*.qty' => 'required|integer',
            'requests.*.total' => 'required|integer',
            'requests.*.comment' => 'required|string',
            'requests.*.client_id' => 'required|string',
            'requests.*.user' => 'required|string',
            'requests.*.user_id' => 'required|string',
            'requests.*.unitprice' => 'numeric',
            'requests.*.remark' => 'nullable|string',
            'requests.*.hmo_comment' => 'nullable|string',
            'requests.*.code' => 'nullable|string',
            'requests.*.approvedBy' => 'nullable|string',
        ]);

        // Generate a unique batch ID
        $batchId = Str::uuid();

        // Add the batch ID and timestamps to each request data
        foreach ($validatedData['requests'] as &$requestItem) {
            $requestItem['batch_id'] = $batchId;
            $requestItem['created_at'] = Carbon::now();
            $requestItem['updated_at'] = Carbon::now();
        }

        // Bulk insert with batch ID and timestamps
        ParequestModel::insert($validatedData['requests']);

        return response()->json([
            'status' => '200',
            'message' => 'Requests Saved Successfully',
            'batch_id' => $batchId,
        ]);
    }


    //showing one request based on the batch_id
    public function batch_request(string $batch_id)
    {
        $client_type = DB::table('parequest_models')
            ->join('client_models', 'client_models.policynumber', '=', 'parequest_models.client_id')
            ->select('client_models.enrolleetype')
            ->where('parequest_models.batch_id', '=', $batch_id)
            ->first();
        if ($client_type) {
            $credentials = DB::table('parequest_models')
                ->join('client_models', 'client_models.policynumber', '=', 'parequest_models.client_id')
                ->select('client_models.*', 'parequest_models.id as request_id', 'parequest_models.*')
                ->where('parequest_models.batch_id', '=', $batch_id)
                ->get();
            return view('pages.batch', compact('credentials'));
        } else {
            $credentials = DB::table('parequest_models')
                ->join('dependent_models', 'dependent_models.policynumber', '=', 'parequest_models.client_id')
                ->select('dependent_models.*', 'parequest_models.id as request_id', 'parequest_models.*')
                ->where('parequest_models.batch_id', '=', $batch_id)
                ->get();
            return view('pages.batch', compact('credentials'));
        }
    }



    public function getPrice(Request $request)
    {
        $procedure = $request->input('Procedure');

        if ($procedure) {
            $price = DB::table('tariff_models')
                ->select('price')
                ->where('procedure', $procedure)
                ->first();
            if ($price) {
                return response()->json(['price' => $price->price]);
            } else {
                return response()->json(['error' => 'Procedure not found'], 404);
            }
        }
        return response()->json(['error' => 'Procedure not provided'], 400);
    }


    public function edit(string $queue_id)
    {
        $queue = QueueList::findOrFail($queue_id); //to find the unique queue list
        $procedure = TariffModel::all(); //to get the procedure list
        $diagnosis = DxModel::all(); //to get the procedure list
        $id = auth()->user()->id; // login user id

        // to check if the client is principal enrolee
        $client_type = DB::table('client_models')
            ->join('queue_lists', 'queue_lists.client_id', '=', 'client_models.policynumber')
            ->select('client_models.enrolleetype')
            ->where('queue_lists.id', '=', $queue_id)
            ->first();
        if (auth::check() && auth::user()->role === 'Admin') {
            if ($client_type) {
                $data_prin = DB::table('queue_lists')
                    ->join('client_models', 'queue_lists.client_id', '=', 'client_models.policynumber')
                    ->select('queue_lists.*', 'queue_lists.id as list_id', 'client_models.*')
                    ->where('queue_lists.id', '=', $queue_id)
                    ->whereDate('queue_lists.created_at', '=', today())
                    ->first();
                $credentials = DB::table('parequest_models')
                    ->join('client_models', 'client_models.policynumber', '=', 'parequest_models.client_id')
                    ->select('client_models.*', 'parequest_models.*')
                    ->where('client_models.policynumber', '=', $queue->client_id)
                    ->groupBy('parequest_models.batch_id')
                    ->orderBy('parequest_models.created_at', 'DESC')
                    ->get();
                return view('pages.request', compact('data_prin', 'credentials', 'procedure', 'diagnosis'));
            } else {
                $data_prin = DB::table('queue_lists')
                    ->join('dependent_models', 'queue_lists.client_id', '=', 'dependent_models.policynumber')
                    ->select('queue_lists.*', 'queue_lists.id as list_id', 'dependent_models.*')
                    ->where('queue_lists.id', '=', $queue_id)
                    ->whereDate('queue_lists.created_at', '=', today())
                    ->first();
                $credentials = DB::table('parequest_models')
                    ->join('dependent_models', 'dependent_models.policynumber', '=', 'parequest_models.client_id')
                    ->select('dependent_models.*', 'parequest_models.*')
                    ->where('dependent_models.policynumber', '=', $queue->client_id)
                    ->groupBy('parequest_models.batch_id')
                    ->orderBy('parequest_models.created_at', 'DESC')
                    ->get();
            }
        } else {
            if ($client_type) {
                $data_prin = DB::table('queue_lists')
                    ->join('client_models', 'queue_lists.client_id', '=', 'client_models.policynumber')
                    ->select('queue_lists.*', 'queue_lists.id as list_id', 'client_models.*')
                    ->where('queue_lists.id', '=', $queue_id)
                    ->whereDate('queue_lists.created_at', '=', today())
                    ->first();
                $credentials = DB::table('parequest_models')
                    ->join('client_models', 'client_models.policynumber', '=', 'parequest_models.client_id')
                    ->select('client_models.*', 'parequest_models.*')
                    ->where('client_models.policynumber', '=', $queue->client_id)
                    ->where('parequest_models.user_id', '=', $id)
                    ->groupBy('parequest_models.batch_id')
                    ->orderBy('parequest_models.created_at', 'DESC')
                    ->get();
                return view('pages.request', compact('data_prin', 'credentials', 'procedure', 'diagnosis'));
            } else {
                $data_prin = DB::table('queue_lists')
                    ->join('dependent_models', 'queue_lists.client_id', '=', 'dependent_models.policynumber')
                    ->select('queue_lists.*', 'queue_lists.id as list_id', 'dependent_models.*')
                    ->where('queue_lists.id', '=', $queue_id)
                    ->whereDate('queue_lists.created_at', '=', today())
                    ->first();
                $credentials = DB::table('parequest_models')
                    ->join('dependent_models', 'dependent_models.policynumber', '=', 'parequest_models.client_id')
                    ->select('dependent_models.*', 'parequest_models.*')
                    ->where('dependent_models.policynumber', '=', $queue->client_id)
                    ->where('parequest_models.user_id', '=', $id)
                    ->groupBy('parequest_models.batch_id')
                    ->orderBy('parequest_models.created_at', 'DESC')
                    ->get();
            }
        }
        return view('pages.request', compact('data_prin', 'credentials', 'procedure', 'diagnosis'));
    }


    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'Qty' => 'required|numeric|min:1',
            'UnitPrice' => 'required|numeric|min:1',
            'approvedBy' => 'required|string|max:255',
            'Remark' => 'required|string|max:255',
            'HMO_comment' => 'nullable|string|max:255',
        ]);

        try {
            $Total = $validatedData['Qty'] * $validatedData['UnitPrice'];
            $code = Str::uuid();
            $client = ParequestModel::findOrFail($id);
            $client->update(array_merge($validatedData, [
                'Total' => $Total,
                'code' => $code,
            ]));

            return redirect()->back()->with('success', 'Record updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update record: ' . $e->getMessage());
        }
    }


    public function authorization(Request $request)
    {
        $user = auth()->user()->id;
        if (auth()->user()->role === 'Admin') {
            $principal = DB::table('parequest_models')
                ->join('client_models', 'client_models.policynumber', '=', 'parequest_models.client_id')
                ->select('client_models.surname', 'client_models.othername', 'client_models.policynumber', 'parequest_models.*')
                ->groupBy('parequest_models.batch_id')
                ->paginate(10);

            $dependent = DB::table('parequest_models')
                ->join('dependent_models', 'dependent_models.policynumber', '=', 'parequest_models.client_id')
                ->select('dependent_models.surname', 'dependent_models.othername', 'dependent_models.policynumber', 'parequest_models.*')
                ->groupBy('parequest_models.batch_id')
                ->paginate(10);
            return view('pages.pre-authorization', compact('principal', 'dependent'));
        } else {
            $principal = DB::table('parequest_models')
                ->join('client_models', 'client_models.policynumber', '=', 'parequest_models.client_id')
                ->select('client_models.surname', 'client_models.othername', 'client_models.policynumber', 'parequest_models.*')
                ->where('parequest_models.user_id', '=', $user)
                ->groupBy('parequest_models.batch_id')
                ->paginate(10);

            $dependent = DB::table('parequest_models')
                ->join('dependent_models', 'dependent_models.policynumber', '=', 'parequest_models.client_id')
                ->select('dependent_models.surname', 'dependent_models.othername', 'dependent_models.policynumber', 'parequest_models.*')
                ->where('parequest_models.user_id', '=', $user)
                ->groupBy('parequest_models.batch_id')
                ->paginate(10);
            return view('pages.pre-authorization', compact('principal', 'dependent'));
        }
    }
    public function claims()
    {
        $user = auth()->user()->id;
        if (auth()->user()->role === 'Admin') {
            $principal = DB::table('claim_models')
                ->join('parequest_models', 'parequest_models.id', '=', 'claim_models.request_id')
                ->join('client_models', 'client_models.policynumber', '=', 'parequest_models.client_id')
                ->select('claim_models.created_at as date', 'claim_models.id as claim_id', 'claim_models.status as stat', 'claim_models.*', 'client_models.*', 'parequest_models.*',)
                ->get();

            $dependent = DB::table('claim_models')
                ->join('parequest_models', 'parequest_models.id', '=', 'claim_models.request_id')
                ->join('dependent_models', 'dependent_models.policynumber', '=', 'parequest_models.client_id')
                ->select('claim_models.created_at as date', 'claim_models.id as claim_id', 'claim_models.status as stat', 'claim_models.*', 'dependent_models.*', 'parequest_models.*')
                ->get();
        } else {
            $principal = DB::table('claim_models')
                ->join('parequest_models', 'parequest_models.id', '=', 'claim_models.request_id')
                ->join('client_models', 'client_models.policynumber', '=', 'parequest_models.client_id')
                ->select('claim_models.created_at as date', 'claim_models.id as claim_id', 'claim_models.status as stat', 'claim_models.*', 'client_models.*', 'parequest_models.*')
                ->where('claim_models.user_id', '=', $user)
                ->get();

            $dependent = DB::table('claim_models')
                ->join('parequest_models', 'parequest_models.id', '=', 'claim_models.request_id')
                ->join('dependent_models', 'dependent_models.policynumber', '=', 'parequest_models.client_id')
                ->select('claim_models.created_at as date', 'claim_models.id as claim_id', 'claim_models.status as stat', 'claim_models.*', 'dependent_models.*', 'parequest_models.*')
                ->where('claim_models.user_id', '=', $user)
                ->get();
        }
        return view('pages.claims', compact('principal', 'dependent'));
    }

    public function Claimupdate(Request $request, string $claim_id)
    {
        $validatedData = $request->validate([
            'status' => 'required|string',
        ]);

        try {
            $data = ClaimModel::findOrFail($claim_id);
            $data->update($validatedData);
            return redirect()->back()->with('success', 'Claim processed successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while processing the claim.');
        }
    }
}