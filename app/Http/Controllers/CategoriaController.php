<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateCategoriaRequest;
use App\Models\caracteristica;
use App\Models\categoria;
use Exception;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = categoria::with('caracteristica')->latest()->get();


        return view('categorias.index', ['categorias' => $categorias]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoriaRequest $request)
    {
        //dd($request);
        try {
            DB::beginTransaction();
            $caracteristica = Caracteristica::create($request->validated());
            $caracteristica->categoria()->create([
                'caracteristica_id' => $caracteristica->id
            ]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
        return redirect()->route('categorias.index')->with('success', 'Categoria Registrada');
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
    public function edit(categoria $categoria)
    {
        //dd($categoria);
        return view('categorias.edit', ['categoria' => $categoria]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoriaRequest $request, categoria $categoria)
    {
        caracteristica::where('id', $categoria->caracteristica->id)
            ->update($request->validated());

        return redirect()->route('categorias.index')->with('success', 'Categoría Editada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $message = '';
        $categoria = Categoria::find($id);
        if ($categoria->caracteristica->estado == 1) {
            caracteristica::where('id', $categoria->caracteristica->id)
                ->update([
                    'estado' => 0
                ]);
            $message = 'Categoría eliminada';
        } else {
            caracteristica::where('id', $categoria->caracteristica->id)
                ->update([
                    'estado' => 1
                ]);
            $message = 'Categoría Restaurada';
        }

        return redirect()->route('categorias.index')->with('success', $message);
    }
}
