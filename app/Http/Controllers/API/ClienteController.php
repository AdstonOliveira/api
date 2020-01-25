<?php

namespace App\Http\Controllers\API;

use App\Http\API\Cliente;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */


    // ############# ROTAS GET ####################
    public function index()
    {
        $clientes = Cliente::all();

        return response()->json($clientes);
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $cliente = Cliente::find($id);

        return response()->json($cliente);
    }


    public function getNome($nome){
        if(trim($nome) === "" || $nome == null || !isset($nome)){
            $clientes = Cliente::all();
        }else{
            $clientes = Cliente::where('nome','like', '%'.$nome.'%')->get();
        }

        return response()->json($clientes);
    }

    public function getNomeApagado($nome){
        if(trim($nome) === "" || $nome == null || !isset($nome)){
            $clientes = Cliente::all();
        }else{
            $clientes = Cliente::where('nome','like', '%'.$nome.'%')->onlyTrashed()->get();
        }

        return response()->json($clientes);
    }

	public function apagados(){
		$clientes = Cliente::onlyTrashed()->get();
		return response()->json($clientes);
	}

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


     /** ################# ROTAS POST ####################### */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome'      => 'required|min:3|max:20|unique:clientes',
            'endereco'  => 'required|min:3|max:20',
            'telefone'  => 'required|min:13|max:15',
			'filho'		=> 'required',
			'idade'		=>  'required'
        ]);

        if( $validator->fails() ){
            $response = [
                'success' => false,
                'message' => 'Validation error: ', $validator->errors()
            ];
            return response()->json($response, 400);
        }


        $cliente = Cliente::create( $request->all() );
        return response()->json($cliente, 200);
    }



    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


     // ################ ROTAS PUT ########################
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nome'      => 'required|min:3|max:20|', Rule::unique('clientes')->ignore($id),
            'endereco'  => 'required|min:3|max:20',
            'telefone'  => 'required|min:13|max:15',
			'filho'		=> 'required',
			'idade'		=>  'required'
        ]);

        if( $validator->fails() ){
            $response = [
                'success' => false,
                'message' => 'Validation error: '. $validator->errors()
            ];
            return response()->json($response, 400);
        }

        $cliente = Cliente::findOrFail($id);

        $cliente->update($request->all());

        return response()->json($cliente, 200);
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */



     // ################# ROTAS DELETE ####################
    public function destroy($id)
    {
        $cliente = Cliente::withTrashed()->find($id);
        $msg = "Deletado";

		if( $cliente->trashed() ){

			$cliente->restore();
			$msg = "Restaurado";
		}else
			$cliente->delete();

        return response()->json($msg, 200);
    }
}
