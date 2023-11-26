<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use App\Http\Requests\StoreModeloRequest;
use App\Http\Requests\UpdateModeloRequest;

class ModeloController extends Controller
{
    public function __construct(Modelo $modelo)
    {
        $this->modelo = $modelo;
    }

    public function index()
    {
        $modelo = $this->modelo->all();
        return $modelo;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreModeloRequest $request)
    {
        $request->validate($this->modelo->rules());
        // Recebendo imagem e selecionando local onde será salva
        $imagem = $request->file('imagem'); // pega a imagem 'nome que esta postman' do requet
        $imagem_urn = $imagem->store('imagens/modelos', 'public'); // salva a imagem na pasta imagem 'configurado no config\filesystems.php' e diretorio public

        // existem 2 sintax para salva
        $modelo = $this->modelo->create([
            'marca_id' => $request->marca_id,
            'nome' => $request->nome,
            'imagem' => $imagem_urn,
            'numero_portas' => $request->numero_portas,
            'lugares' => $request->lugares,
            'air_bag' => $request->air_bag,
            'abs' => $request->abs
        ]);


        return $modelo;
    }

    /**
     * Display the specified resource.
     */
    public function show(Modelo $modelo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateModeloRequest $request, Modelo $modelo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Modelo $modelo)
    {
        //
    }
}
