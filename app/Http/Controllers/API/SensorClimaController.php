<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SensorClima;

class SensorClimaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SensorClima::latest()->paginate(10);
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

        SensorClima::create([
            'sensor_id' => $request['sensor_id'],
            'data' => $request['data'],
            'precipitacao' => $request['precipitacao'],
            'temperatura' => $request['temperatura'],
            'umidadeDoAr' => $request['umidadeDoAr'],
            'vento' => $request['vento'],
            'radiacao' => $request['radiacao'],
            'pressao' => $request['pressao'],
            'insolacao' => $request['insolacao']
        ]);

            return ['message' => 'Sensor Clima Success'];

        //SE FOR FALHA
        }catch(\Exception $e){
            
            //LÓGICA SMS
            return ['message' => 'Sensor Clima Error'];
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
        return SensorClima::findOrFail($id);
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
        $var = SensorClima::findOrFail($id);
        $var->update([
            'sensor_id' => $request['sensor_id'],
            'data' => $request['data'],
            'precipitacao' => $request['precipitacao'],
            'temperatura' => $request['temperatura'],
            'umidadeDoAr' => $request['umidadeDoAr'],
            'vento' => $request['vento'],
            'radiacao' => $request['radiacao'],
            'pressao' => $request['pressao'],
            'insolacao' => $request['insolacao']
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
        $variavelQualquer = SensorClima::findOrFail($id);
        $variavelQualquer->delete();

       return ['message' => 'Sensor Clima Deleted'];
    }

    /////////////////
    public function busca($sensor_id)
    {
        $busca = DB::table('sensor_climas')->where('sensor_id', $sensor_id)->get();
        return response($busca);
    }
}
