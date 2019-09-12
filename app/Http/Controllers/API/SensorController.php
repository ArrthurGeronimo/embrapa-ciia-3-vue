<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Sensor;

class SensorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return Sensor::all();
        return Sensor::latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //SE FOR SUCESSO
        //AUTH
        try{
            /*$this->validate($request,[
            'nome' => 'required|string|max:191',
            'marca' => 'required|string|max:191',
            'modelo' => 'required|string|max:191',
            'dataFabricacao' => 'required|date',
            'dataInstalacao' => 'date',
            'unidade' => 'required|numeric|min:1'
        ]);*/

        $dataFabricacao = $request['dataFabricacao'];
        $dataFabricacao = date('Y-m-d', strtotime($dataFabricacao));
        Sensor::create([
            'nome' => $request['nome'],
            'marca' => $request['marca'],
            'modelo' => $request['modelo'],
            'dataFabricacao' => $dataFabricacao,
            'dataInstalacao' => $request['dataInstalacao'],
            'unidade' => $request['unidade']
        ]);

            return ['message' => 'Sensor Success'];

        //SE FOR FALHA
        }catch(\Exception $e){
            
            //LÓGICA SMS
            return ['message' => 'Sensor Error'];
        }

        //Autenticação

        
 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Sensor::findOrFail($id);
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
        $var = Sensor::findOrFail($id);
        /*$this->validate($request,[
            'nome' => 'required|string|max:191',
            'marca' => 'required|string|max:191',
            'modelo' => 'required|string|max:191',
            'dataFabricacao' => 'required|date',
            'dataInstalacao' => 'date',
            'unidade' => 'required|numeric|min:1'
        ]);*/
        //$var->update($request->all());

        $dataFabricacao = $request['dataFabricacao'];
        $dataFabricacao = date('Y-m-d', strtotime($dataFabricacao));
        $var->update([
            'nome' => $request['nome'],
            'marca' => $request['marca'],
            'modelo' => $request['modelo'],
            'dataFabricacao' => $dataFabricacao,
            'dataInstalacao' => $request['dataInstalacao'],
            'unidade' => $request['unidade']
        ]);

        return $var;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $variavelQualquer = Sensor::findOrFail($id);
        $variavelQualquer->delete();

       return ['message' => 'Sensor Deleted'];
    }
}
