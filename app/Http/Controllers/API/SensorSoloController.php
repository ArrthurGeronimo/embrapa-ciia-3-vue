<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SensorSolo;

class SensorSoloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SensorSolo::latest()->paginate(10);
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
        try{
            /*$this->validate($request,[
            'nome' => 'required|string|max:191',
            'marca' => 'required|string|max:191',
            'modelo' => 'required|string|max:191',
            'dataFabricacao' => 'required|date',
            'dataInstalacao' => 'date',
            'unidade' => 'required|numeric|min:1'
        ]);*/

        SensorSolo::create([
            'sensor_id' => $request['sensor_id'],
            'data' => $request['data'],
            'latitude' => $request['latitude'],
            'longitude' => $request['longitude'],
            'temperatura' => $request['temperatura'],
            'umidade' => $request['umidade']
        ]);

            return ['message' => 'Sensor Solo Success'];

        //SE FOR FALHA
        }catch(\Exception $e){
            
            //LÓGICA SMS
            return ['message' => 'Sensor Solo Error'];
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
        return SensorSolo::findOrFail($id);
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
        $var = SensorSolo::findOrFail($id);
        $var->update([
            'sensor_id' => $request['sensor_id'],
            'data' => $request['data'],
            'latitude' => $request['latitude'],
            'longitude' => $request['longitude'],
            'temperatura' => $request['temperatura'],
            'umidade' => $request['umidade']
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
        $variavelQualquer = SensorSolo::findOrFail($id);
        $variavelQualquer->delete();

       return ['message' => 'Sensor Solo Deleted'];
    }
}
