<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
Use App\Models\Pessoa;
use Illuminate\Support\Facades\Http;

class PessoaController extends Controller
{
    public function adicionar(Request $request){
        $array = ['error'=>''];

        $rules = [
            'nome'=>'required',
            'cpf'=>'required',
            'cidade'=> 'required',
            'estado'=> 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            $array['error'] = $validator->messages();
            return $array;
        }

        $nome = $request->input('nome');
        $cpf = $request->input('cpf');
        $cidade = $request->input('cidade');
        $estado = $request->input('estado');




        ////////////////// Verificando CPF cadastrado ////////////////

        $validaCpf = Pessoa::where('cpf',$cpf)->count();
        if($validaCpf > 0){
            $array['error'] = 'CPF ja cadastrado';
            return $array;

        }

       /////////////////// buscando dados da cidade ////////////////
       $response = Http::get('http://localhost:9000/api/cidade/verifica',[
           'cidade' => $cidade
       ]);

       if($response == '0'){

           $response = Http::post('http://localhost:9000/api/cidade',[
                'estado'=>$estado,
                'nome'=>$cidade
            ]);

            $response = Http::get('http://localhost:9000/api/cidade/verifica',[
                'cidade' => $cidade
            ]);

        }


        $idcidade = $response[0]['id'];

        switch ($estado) {
            case 'Acre': $estado = 1; break;
            case 'Alagoas': $estado = 2; break;
            case 'Amazonas': $estado = 3; break;
            case 'Amapa': $estado = 4; break;
            case 'Bahia': $estado = 5; break;
            case 'Ceará': $estado = 6; break;
            case 'Distrito Federal': $estado = 7; break;
            case 'Espirito Santo': $estado = 8; break;
            case 'Goias': $estado = 9; break;
            case 'Maranhao': $estado = 10; break;
            case 'Minas Gerais': $estado = 11; break;
            case 'Mato Grosso do Sul': $estado = 12; break;
            case 'Mato Grosso': $estado = 13; break;
            case 'Para': $estado = 14; break;
            case 'Paraiba': $estado = 15; break;
            case 'Pernambuco': $estado = 16; break;
            case 'Piaui': $estado = 17; break;
            case 'Parana': $estado = 18; break;
            case 'Rio de Janeiro': $estado = 19; break;
            case 'Rio Grande do Norte': $estado = 20; break;
            case 'Rondonia': $estado = 21; break;
            case 'Roraima': $estado = 22; break;
            case 'Rio Grande do Sul': $estado = 23; break;
            case 'Santa Catarina': $estado = 24; break;
            case 'Sergipe': $estado = 25; break;
            case 'São Paulo': $estado = 26; break;
            case 'Tocantins': $estado = 27; break;

        }

        ////////////////verificando o estado /////////////////////
        if(is_string($estado)){
            $array['error'] = 'estado inexistente';
            return $array;
        }

        //////////////////////////////////////////////////////////

        $pessoa = new Pessoa();
        $pessoa->nome = $nome;
        $pessoa->cpf = $cpf;
        $pessoa->cidade = $idcidade;
        $pessoa->estado = $estado;
        $pessoa->save();

        $array['sucess'] = 'Salvo com sucesso';

        return $array;
    }

    public function list(Request $request){

        $array = ['error'=>''];

        $pessoas = Pessoa::paginate(10);
        if($pessoas){
            $array['list'] = $pessoas;
        }else{
            $array['error'] = 'Nao tem ha ninguem para exibir';
            return $array;
        }
        return $array;
    }
}
