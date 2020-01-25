<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\API\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $produtos = Produto::all();

        return response()->json($produtos);
    }


    public function getNome($nome){
        if(trim($nome) === "" || $nome == null || !isset($nome)){
            $produtos = Produto::all();
        }else{
            $produtos = Produto::where('nome','like', '%'.$nome.'%')->get();
        }

        return response()->json($produtos);
    }

    public function getNomeApagado($nome){
        if(trim($nome) === "" || $nome == null || !isset($nome)){
            $produtos = Produto::all();
        }else{
            $produtos = Produto::where('nome','like', '%'.$nome.'%')->onlyTrashed()->get();
        }

        return response()->json($produtos);
    }

	public function apagados(){
        $produtos = Produto::onlyTrashed()->get();
		return response()->json($produtos);
	}

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome'      => 'required|min:3|max:20|unique:produtos',
            'fornecedor'  => 'required|min:3|max:20',
            'UN'        => 'required|min:2',
			'preco'		=> 'required',
			'qtde'		=>  'required'
        ]);

        if( $validator->fails() ){
            $response = [
                'success' => false,
                'message' => 'Validation error: ', $validator->errors()
            ];
            return response()->json($response, 400);
        }

        $produto = Produto::create( $request->all() );
        return response()->json($produto, 200);

    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $produto = Produto::find($id);

        return response()->json($produto);
    }

     /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nome'      => 'required|min:3|max:20|', Rule::unique('produtos')->ignore($id),
            'fornecedor'  => 'required|min:3',
            'UN'        => 'required|min:2',
			'preco'		=> 'required',
			'qtde'		=>  'required'
        ]);

        if( $validator->fails() ){
            $response = [
                'success' => false,
                'message' => 'Validation error: ', $validator->errors()
            ];
            return response()->json($response, 400);
        }

        $produto = Produto::findOrFail($id);

        $produto->update($request->all());

        return response()->json($produto, 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produto = Produto::withTrashed()->find($id);
        $msg = "Deletado";

		if( $produto->trashed() ){
			$produto->restore();
			$msg = "Restaurado";
		}else
			$produto->delete();

        return response()->json($msg, 200);
    }
}
