<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePresentacioneRequest;
use App\Models\caracteristica;
use App\Models\presentacione;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PresentacioneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
    {
        $presentaciones = presentacione::with('caracteristica')->latest()->get();


        return view('presentaciones.index', ['presentaciones' => $presentaciones]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('presentaciones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePresentacioneRequest $request)
    {
        //dd($request);
        try{
            DB::beginTransaction();
            $caracteristica = Caracteristica::create($request->validated());
            $caracteristica = presentacione::create([
                'caracteristica_id' => $caracteristica->id
            ]);
            DB::commit();
        }catch(Exception $e){
            DB::rollback();
        }
        return redirect()->route('presentaciones.index')->with('success','Presentacion Registrada');
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
