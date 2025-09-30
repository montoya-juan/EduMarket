<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePresentacioneRequest;
use App\Http\Requests\UpdatePresentacioneRequest;
use App\Models\caracteristica;
use App\Models\categoria;
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
    public function edit(presentacione $presentacione)
    {
        return view('presentaciones.edit', ['presentacione' => $presentacione]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePresentacioneRequest $request, presentacione $presentacione)
    {
        caracteristica::where('id', $presentacione->caracteristica->id)
            ->update($request->validated());

        return redirect()->route('presentaciones.index')->with('success', 'Presentación Editada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
 {
        $message = '';
        $presentacione = presentacione::find($id);
        if ($presentacione->caracteristica->estado == 1) {
            caracteristica::where('id', $presentacione->caracteristica->id)
                ->update([
                    'estado' => 0
                ]);
            $message = 'Presentación eliminada';
        } else {
            caracteristica::where('id', $presentacione->caracteristica->id)
                ->update([
                    'estado' => 1
                ]);
            $message = 'Presentación Restaurada';
        }

        return redirect()->route('presentaciones.index')->with('success', $message);
    }
}
