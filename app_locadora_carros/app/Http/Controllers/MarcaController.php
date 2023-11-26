<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Http\Requests\StoreMarcaRequest;
use App\Http\Requests\UpdateMarcaRequest;
use Illuminate\Support\Facades\Storage;

class MarcaController extends Controller
{
    // construtor marca
    public function __construct(Marca $marca)
    {
        $this->marca = $marca;
    }

    public function index()
    {
        //$marca = Marca::all();
        $marca = $this->marca->all();
        return $marca;
    }


    public function store(StoreMarcaRequest $request)
    {
        // return ['erro' => 'criar'];

        $request->validate($this->marca->rules(), $this->marca->feedback());
        // Recebendo imagem e selecionando local onde será salva
        $imagem = $request->file('imagem'); // pega a imagem 'nome que esta postman' do requet
        $imagem_urn = $imagem->store('imagens', 'public'); // salva a imagem na pasta imagem 'configurado no config\filesystems.php' e diretorio public

        // existem 2 sintax para salva
        $marca = $this->marca->create([
            'nome' => $request->nome,
            'imagem' => $imagem_urn
        ]);
        // segunda forma de salvar
        //$marca->nome = $request->nome;
        //$marca->imagem = $imagem_urn;
        //$marca->save();

        // $marca = $this->marca->create($request->all());
        return $marca;
    }


    public function show($id)
    {
        $marca = $this->marca->find($id);
        if ($marca === null) {
            return response()->json(['erro' => 'Recurso Não Encontrado'], 404);
        }
        return $marca;
    }

    public function update(UpdateMarcaRequest $request, $id)
    {
        //return ['erro' => 'update'];
        $marca = $this->marca->find($id);

        if ($marca === null) {
            return response()->json(['erro' => 'Não foi possivel atualizar o arquivo, o mesmo não existe'], 404);
        }

        if ($request->method() === 'PATCH') {
            $regrasDinamicas = array();
            foreach ($marca->rules() as $input => $regra) {
                if (array_key_exists($input, $request->all())) {
                    $regrasDinamica[$input] = $regra;
                }
            }
            $request->validate($regrasDinamicas, $marca->feedback());
        } else {
            $request->validate($marca->rules(), $marca->feedback());
        }

        if ($request->file('imagem')) { // verifica se o requist enviou uma imagem
            Storage::disk('public')->delete($marca->imagem); // remove o arquivo antigo
        }

        $imagem = $request->file('imagem'); // pega a imagem 'nome que esta postman' do requet
        $imagem_urn = $imagem->store('imagens', 'public'); // salva a imagem na pasta imagem 'configurado no config\filesystems.php' e diretorio public

        $marca->update([
            'nome' => $request->nome,
            'imagem' => $imagem_urn
        ]);
        return $marca;
    }

    public function destroy($id)
    {
        //print_r($marca->getAttributes());
        //getAttributes()
        $marca = $this->marca->find($id);
        if ($marca === null) {
            return response()->json(['erro' => 'Não foi possivel excuir arquivo, o mesmo não existe'], 404);
        }
        Storage::disk('public')->delete($marca->imagem); // remove o arquivo antigo


        $marca->delete();
    }
}
