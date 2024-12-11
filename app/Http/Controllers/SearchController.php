<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\ClientModel;
use App\Models\TariffModel;
use App\Models\DependentModel;
use App\Models\RequestModel;
use App\Models\ParequestModel;
use App\Models\QueueModel;


class SearchController extends Controller
{
    public function tariff(Request $request)
    {
        $query = $request->input('query');

        if ($query) {
            $result = DB::table('tariff_models')
                ->where('procedure', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%")
                ->paginate(5);
        } else {
            $result = DB::table('tariff_models')->paginate(5);
        }

        $credentials = DB::table('tariff_models')
            ->orderBy('created_at', 'DESC')
            ->paginate(5);

        return view('pages.tariff', compact('credentials', 'result', 'query'));
    }

    public function tariff_diagnosis(Request $request)
    {
        $query = $request->input('query');

        if ($query) {
            $result = DB::table('dx_models')
                ->where('diagnosis', 'like', "%{$query}%")
                ->paginate(10);
        } else {
            $result = DB::table('dx_models')->paginate(5);
        }

        $credentials = DB::table('dx_models')
            ->orderBy('created_at', 'DESC')
            ->paginate(5);

        return view('pages.tariff_diagnosis', compact('credentials', 'result', 'query'));
    }

    public function client(Request $request)
    {
        $query = $request->input('query');

        if ($query) {
            $result = DB::table('client_models')
                ->where('surname', 'like', "%{$query}%")
                ->orWhere('othername', 'like', "%{$query}%")
                ->orWhere('phone', 'like', "%{$query}%")
                ->orWhere('policynumber', 'like', "%{$query}%")
                ->paginate(6);
        } else {
            $result = DB::table('client_models')->paginate(5);
        }

        $pix = DB::table('client_models')
            ->select('passport')->first();

        $Principal = DB::table('client_models')
            ->where('enrolleetype', "=", 'Principal')->get();
        $credentials = DB::table('client_models')->paginate(10);
        $data = ClientModel::all();

        return view('pages.client', compact('result', 'query', 'credentials', 'Principal', 'data', 'pix'));
    }

    public function eligibility(Request $request)
    {
        $query = $request->input('query');

        if ($query) {
            $result = DB::table('client_models')
                ->where('surname', 'like', "%{$query}%")
                ->orWhere('othername', 'like', "%{$query}%")
                ->orWhere('phone', 'like', "%{$query}%")
                ->orWhere('policynumber', 'like', "%{$query}%")
                ->paginate(6);
        } else {
            $result = DB::table('client_models')->paginate(5);
        }

        $pix = DB::table('client_models')
            ->select('passport')->first();

        $Principal = DB::table('client_models')
            ->where('enrolleetype', "=", 'Principal')->get();
        $credentials = DB::table('client_models')->paginate(10);
        $data = ClientModel::all();

        return view('pages.searchCheck', compact('result', 'query', 'credentials', 'Principal', 'data', 'pix'));
    }

    public function eligibility2(Request $request)
    {
        $query = $request->input('query');

        if ($query) {
            $result = DB::table('dependent_models')
                ->where('surname', 'like', "%{$query}%")
                ->orWhere('othername', 'like', "%{$query}%")
                ->orWhere('phone', 'like', "%{$query}%")
                ->orWhere('policynumber', 'like', "%{$query}%")
                ->paginate(6);
        } else {
            $result = DB::table('dependent_models')->paginate(5);
        }

        $pix = DB::table('dependent_models')
            ->select('passport')->first();

        $credentials = DB::table('dependent_models')->paginate(10);
        $data = DependentModel::all();

        return view('pages.searchCheck2', compact('result', 'query', 'credentials', 'data', 'pix'));
    }

    public function auth_view(Request $request)
    {
        $request->validate([
            'query' => 'required|int|min:14',
        ]);
        $query = $request->input('query');

        if ($query) {
            $result = DB::table('parequest_models')
                ->join('client_models', 'client_models.policynumber', '=', 'parequest_models.client_id')
                ->where('parequest_models.client_id', 'like', "%{$query}%")
                ->orWhere('parequest_models.batch_id', 'like', "%{$query}%")
                ->select('parequest_models.*', 'client_models.*')
                ->groupBy('parequest_models.batch_id')
                ->paginate(6);

            if ($result->isEmpty()) {
                $result = DB::table('parequest_models')
                    ->join('dependent_models', 'dependent_models.policynumber', '=', 'parequest_models.client_id')
                    ->where('parequest_models.client_id', 'like', "%{$query}%")
                    ->orWhere('parequest_models.batch_id', 'like', "%{$query}%")
                    ->select('parequest_models.*', 'dependent_models.*')
                    ->groupBy('parequest_models.batch_id')
                    ->paginate(6);
            }
        }

        return view('pages.auth_view', compact('result'));
    }

    public function encounter_view(Request $request)
    {
        $request->validate([
            'query' => 'required|int|min:14',
        ]);
        $query = $request->input('query');

        if ($query) {
            $result = DB::table('parequest_models')
                ->join('client_models', 'client_models.policynumber', '=', 'parequest_models.client_id')
                ->where('parequest_models.client_id', 'like', "%{$query}%")
                ->orWhere('parequest_models.batch_id', 'like', "%{$query}%")
                ->select('parequest_models.*', 'client_models.*')
                ->whereDate('parequest_models.created_at', '=', today())
                ->groupBy('parequest_models.batch_id')
                ->paginate(6);

            if ($result->isEmpty()) {
                $result = DB::table('parequest_models')
                    ->join('dependent_models', 'dependent_models.policynumber', '=', 'parequest_models.client_id')
                    ->where('parequest_models.client_id', 'like', "%{$query}%")
                    ->orWhere('parequest_models.batch_id', 'like', "%{$query}%")
                    ->select('parequest_models.*', 'dependent_models.*')
                    ->whereDate('parequest_models.created_at', '=', today())
                    ->groupBy('parequest_models.batch_id')
                    ->paginate(6);
            }
        }

        return view('pages.encounter_view', compact('result'));
    }
    public function queue_view(Request $request)
    {
        $request->validate([
            'query' => 'required|int|min:14',
        ]);
        $query = $request->input('query');

        if ($query) {
            $result = DB::table('queue_lists')
                ->join('client_models', 'client_models.policynumber', '=', 'queue_lists.client_id')
                ->where('queue_lists.client_id', 'like', "%{$query}%")
                ->select('queue_lists.id as queue_id', 'queue_lists.*', 'client_models.*')
                ->whereDate('queue_lists.created_at', '=', today())
                ->paginate(6);

            if ($result->isEmpty()) {
                $result = DB::table('queue_lists')
                    ->join('dependent_models', 'dependent_models.policynumber', '=', 'queue_lists.client_id')
                    ->where('queue_lists.client_id', 'like', "%{$query}%")
                    ->select('queue_lists.id as queue_id', 'queue_list.*', 'dependent_models.*')
                    ->whereDate('queue_lists.created_at', '=', today())
                    ->paginate(6);
            }
        }

        return view('pages.queue_view', compact('result'));
    }
}