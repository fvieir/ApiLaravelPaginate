<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Veiculo;
use \App\Http\Requests\VeiculoRequest;
use Exception;
use Illuminate\Http\JsonResponse;

class VeiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            $qtd = 3;
            $data = \App\Veiculo::paginate($qtd);
            if ($data) // Verifica se variavel data recebeu valores
            {
                return response()->json(['data' => $data], 200);
            }

        }catch (Exception $e) {
            return response()->json("Erro interno do servidor !", 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
 
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VeiculoRequest $request)
    {
        try {
            $input = $request->validated(); // Validada os dados usando injeção de dependecia com a Classe Veiculo Request

            $data = $request->only(
                ['marca', 'modelo', 'ano', 'preco']
            ); // Deixa apenas entrar no banco de dados, os dados passado no metodo only()
            
            if ($data) // Veirifica se existe dados na requisição
            {
                $veiculo = Veiculo::create($data); // Criar o no banco novo registro

                if($veiculo) // Verifica se foi criado registro no banco
                {
                    return response()->json
                        (['data' => $veiculo], 200); // Retorno os dados no formato de Json
                } else {
                    return response()->json
                        ("Dados invalidos", 400); // Envia msg que os dados são invalidos
                }
            } 
        }catch (Exception $e) {
                return response()->json("Erro interno do servidor !", 500);
        }
            
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{

            if ($id <= 0) {
                return response()->json('Passe um valor maior que 0', 400);
            } else {
                $veiculo = \App\Veiculo::find($id);
                if ($veiculo) {
                    return response()->json
                        (['data' => $veiculo], 200);
                } else if (!$veiculo) {
                    return response()->json
                        ('Veículo com id: ' .$id. ' não encontrado', 404);
                } else {
                    return response()->json
                        ('Ocorreu algum erro interno ', 500);
                }
            }
        }catch (Exception $e) {
            return response()->json("Erro interno do servidor !", 500);
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VeiculoRequest $request, $id)
    {
        try { 
            $input = $request->validated();
            
            if ($id <= 0) return response()->json("O ID $id informado e menor ou igual a 0. ID invalido", 404);

            $data = $request->only([
                'marca', 'modelo', 'ano', 'preco'
            ]);

            if($data){
                $veiculo = Veiculo::find($id);

                if ($veiculo) {
                    $veiculo->update($data);
                    return response()->json
                        (['mensagem' => 'Veiculo com id: '.$id.' atualizado com sucesso!',
                        'data' => $veiculo],
                        200);
                } else {
                    return response()->json
                        ('Veículo com ID: ' .$id. ' não encontrado', 404);
                }
            } else {
                return response()->json
                    ('Favor informar dados validos', 200);
            }
        }catch (Exception $e) {
            return response()->json("Erro interno do servidor !", 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            if($id <=0 ) return response()->json('Informe o ID com valor maior que 0', 400);
            
            $veiculo = Veiculo::find($id);

            if ($veiculo) {
                $veiculo->delete();
                return response()->json
                    ('Veiculo com o ID: ' .$id.' excluido com sucesso!', 200);
            } else {
                return response()->json
                    ('Veiculo com o ID' .$id. ' não encontrado', 404);
            }
        }catch (Exception $e) {
            return response()->json("Erro interno do servidor !", 500);
        }
    }   
}
