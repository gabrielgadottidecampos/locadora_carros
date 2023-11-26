<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    use HasFactory;
    protected $fillable = ['marca_id', 'nome', 'imagem', 'numero_porta', 'lugares', 'air_bag', 'abs'];

    public function rules()
    {
        return [
            'marca_id' => 'exists:marcas,id',
            'nome'   => 'required|unique:modelos,nome,' . $this->id . '|min:3',
            'imagem' => 'required|file|mimes:png,jpeg',
            'numero_portas' => 'required|integer|diggits_between:1,5',
            'lugares' => 'required|integer',
            'air_bag' => 'required|boolean',
            'abs' => 'required|boolean'

        ];
    }
}
