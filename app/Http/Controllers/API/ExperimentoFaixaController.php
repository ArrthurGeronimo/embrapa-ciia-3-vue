<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ExperimentoFaixa;

class ExperimentoFaixaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ExperimentoFaixa::all();
        //return Experimento::latest()->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'quantidadeTratamentos' => 'required|numeric|min:1',
            'quantidadeRepeticoes' => 'required|numeric|min:1',
        ]);
        return ExperimentoFaixa::create([
            'experimento_id' => $request['experimento_id'],
            'quantidadeTratamentos' => $request['quantidadeTratamentos'],
            'quantidadeRepeticoes' => $request['quantidadeRepeticoes']
        ]);
        //return response($request);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$experimento = Experimento::findOrFail($id);

        //return response($experimento);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $experimento = ExperimentoFaixa::findOrFail($id);
        $this->validate($request,[
            'quantidadeTratamentos' => 'required|numeric|min:1',
            'quantidadeRepeticoes' => 'required|numeric|min:1',
        ]);
        $experimento->update($request->all());

        return ['Mensagem' => 'Informações do Experimento Faixa Atualizadas com Sucesso.'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $experimento = Experimento::findOrFail($id);
        $experimento->delete();

        return ['Mensagem' => 'Experimento Deletado'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function busca($experimento_id)
    {
    	$busca = DB::table('experimento_faixas')->where('experimento_id', $experimento_id)->get();
        return response($busca);
    }
}
