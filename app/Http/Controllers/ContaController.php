<?php

namespace App\Http\Controllers;

use App\Conta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contas = Conta::all();
        return response()->json($contas);
    }


    public function store(Request $request)
    {
        $postData = $request->all();
        $validator = Validator::make($postData, [
            'nome' => 'required|min:2|max:255',
            'email' => 'required|email|unique:contas',
            'saldo' => 'required|numeric|between:-5000,9999.99'

        ]);
        if ($validator->fails()) {
            $erros = $validator->errors();
            return response()->json($erros, 400);
        }
        // passou pela verificacao
        $conta = Conta::create($postData);
        return response()->json($conta);
        //var_dump($postData);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Conta  $conta
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, string $email)
    {
        $conta = Conta::find($email);
        return response()->json($conta);
    }

    public function saldo(Request $request, Conta $conta)
    {
        $conta = Conta::find($conta);

        return response()->json($conta);
    }

    public function deposito(Request $request, Conta $conta)
    {

        $postData = $request->all();
        $email = $postData['email'];
        $valordeposito = $postData['valordeposito'];
        $saldo = $postData["saldo"];
        $postData['saldo'] = $saldo + $valordeposito;
        unset($postData["valordeposito"]);
        $conta =  Conta::where('email', '=', $email)->update($postData);

        //$dados = new Conta($postData);
        //$dados->update();


        return response()->json($postData);
    }
    public function saque(Request $request, Conta $conta)
    {

        $postData = $request->all();
        $email = $postData['email'];
        $valordeposito = $postData['valordeposito'];
        $saldo = $postData["saldo"];
        $postData['saldo'] = $saldo - $valordeposito;
        unset($postData["valordeposito"]);
        $conta =  Conta::where('email', '=', $email)->update($postData);

        //$dados = new Conta($postData);
        //$dados->update();


        return response()->json($postData);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Conta  $conta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Conta $conta)
    {
        $postData = $request->all();
        $validator = Validator::make($postData, [
            'nome' => 'required|min:2|max:255',
            'email' => 'required|email|unique:contas',
            'saldo' => 'required|numeric|between:-5000,9999.99'

        ]);
        if ($validator->fails()) {
            $erros = $validator->errors();
            return response()->json($erros, 400);
        } else {
            echo "valido";
        }
        // passou pela verificacao
        $conta = Conta::update($postData);
        return response()->json($conta);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Conta  $conta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conta $conta)
    {
        $apagado = $conta->delete();
        return response()->json('Conta deletada com sucesso!');
    }
}