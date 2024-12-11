<?php

namespace App\Http\Controllers;

use App\Models\DxModel;
use Illuminate\Http\Request;
use App\Models\TariffModel;
use Illuminate\Support\Facades\DB;

class TariffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->input('query');
        $result =  DB::table('tariff_models')
            ->where('procedure', 'like', "%{$query}")
            ->orWhere('description', 'like', "%{$query}")
            ->paginate(5);


        $credentials = DB::table('tariff_models')
            ->orderBy('created_at', 'DESC')
            ->paginate(10);
        //diagnosis
        return view('pages.tariff', compact('credentials', 'result', 'query'));
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

    //for procedure
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'procedure' => 'required|string|unique:tariff_models,procedure',
            'description' => 'required|string',
            'price' => 'required'
        ]);

        TariffModel::create($validatedData);
        return redirect()->back()->with('success', 'Procedure Added successful!');
    }

    //for procedure
    public function dxAdd(Request $request)
    {
        $validatedData = $request->validate([
            'diagnosis' => 'required|string|unique:Dx_models,diagnosis',

        ]);

        DxModel::create($validatedData);
        return redirect()->back()->with('success', 'Diagnosis Added successful!');
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
        $credentials = DB::table('tariff_models')->paginate(5);
        $data = TariffModel::findOrFail($id);
        return view('pages.EditTariff', compact('credentials', 'data'));
    }

    public function edit_dx(string $id)
    {
        $credentials = DB::table('dx_models')->paginate(5);
        $data = DxModel::findOrFail($id);
        return view('pages.editDiagnosis', compact('credentials', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'procedure' => 'required|string',
            'description' => 'required|string',
            'price' => 'required'
        ]);
        $data = TariffModel::findOrFail($id);
        $data->update($validatedData);
        return redirect()->route('tariff.index')->with('success', 'Procedure Updated successful!');
    }

    public function update_dx(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'diagnosis' => 'required|string',

        ]);
        $data = DxModel::findOrFail($id);
        $data->update($validatedData);
        return redirect()->route('diagnosis_index')->with('success', 'Diagnosis Updated successful!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = TariffModel::findOrFail($id);
        $data->delete();
        return redirect()->route('tariff.index')->with('success', 'Tariff deleted successfully!');
    }

    public function destroy_dx(string $id)
    {
        $data = DxModel::findOrFail($id);
        $data->delete();
        return redirect()->route('tariff.index')->with('success', 'Diagnosis deleted successfully!');
    }

    function diagnosis_index(Request $request)
    {
        $query = $request->input('query');
        $result =  DB::table('dx_models')
            ->where('procedure', 'like', "%{$query}")
            ->orWhere('description', 'like', "%{$query}")
            ->paginate(10);
        $credentials = DB::table('dx_models')
            ->orderBy('created_at', 'DESC')
            ->paginate(10);
        //diagnosis
        return view('pages.tariff_diagnosis', compact('result', 'credentials'));
    }
}