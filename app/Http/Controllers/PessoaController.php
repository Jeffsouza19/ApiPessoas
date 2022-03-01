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


        /////////////////////////////////////////////////////////////////////////

        $estado = strtolower($estado);

        switch ($estado) {
            case 'acre': $estado = 1; break;
            case 'alagoas': $estado = 2; break;
            case 'amazonas': $estado = 3; break;
            case 'amapa': $estado = 4; break;
            case 'bahia': $estado = 5; break;
            case 'ceará': $estado = 6; break;
            case 'distrito federal': $estado = 7; break;
            case 'espirito santo': $estado = 8; break;
            case 'goias': $estado = 9; break;
            case 'maranhao': $estado = 10; break;
            case 'minas gerais': $estado = 11; break;
            case 'mato grosso do Sul': $estado = 12; break;
            case 'mato grosso': $estado = 13; break;
            case 'para': $estado = 14; break;
            case 'paraiba': $estado = 15; break;
            case 'pernambuco': $estado = 16; break;
            case 'piaui': $estado = 17; break;
            case 'parana': $estado = 18; break;
            case 'rio de janeiro': $estado = 19; break;
            case 'rio grande do norte': $estado = 20; break;
            case 'rondonia': $estado = 21; break;
            case 'roraima': $estado = 22; break;
            case 'rio grande do sul': $estado = 23; break;
            case 'santa catarina': $estado = 24; break;
            case 'sergipe': $estado = 25; break;
            case 'são paulo': $estado = 26; break;
            case 'tocantins': $estado = 27; break;

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
