<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'imagem'];

    public function rules()
    {
        return [
            'nome'   => 'required|unique:marcas,nome,' . $this->id . '|min:3',
            'imagem' => 'required|file|mimes:png,jpeg'
        ];
    }

    public function feedback()
    {
        return [
            'required' => 'o campo :attribute é obrigatório',
            'nome.unique' => 'O nome da marca já existe',
            'nome.min' => 'O nome deve ter no minimo 3 caracteres',
            'imagem.mimes' => 'A imagem tem que ser no formato .php ou jpeg'

        ];
    }
}
