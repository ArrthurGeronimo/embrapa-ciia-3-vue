<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Experimento;

class ExperimentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Experimento::all();
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
            'nome' => 'string|max:191',
            'categoria' => 'required',
            'tipoDado' => 'required',
        ]);
        return Experimento::create([
            'nome' => $request['nome'],
            'categoria' => $request['categoria'],
            'tipoDado' => $request['tipoDado']
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
        $experimento = Experimento::findOrFail($id);

        return response($experimento);
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
        $experimento = Experimento::findOrFail($id);
        $this->validate($request,[
            'nome' => 'string|max:191',
            'categoria' => 'required',
            'tipoDado' => 'required',
        ]);
        $experimento->update($request->all());

        return ['Mensagem' => 'Informações do Experimento Atualizadas com Sucesso.'];
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
}
