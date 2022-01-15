<?php

namespace App\Http\Controllers;

use App\Models\Alumnos;
use Illuminate\Http\Request;

class AlumnosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Alumnos::all();
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
        $alumno = Alumnos::create($request->all());
        if (isset($alumno)) {
            return response()->json(["Alumno creado:"=>$alumno], 201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Alumnos  $alumnos
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $alumno = Alumnos::where("id", $request->id)->first();
        if ($alumno) {
            return response()->json(["Alumno encontrado por id:"=>$alumno], 200);
        }
        $alumno = Alumnos::where("matricula", $request->matricula)->first();
        if ($alumno) {
            return response()->json(["Alumno encontrado por matricula:"=>$alumno], 200);
        }
        $datos = collect(['nombre' => $request->nombre, 'apellido_paterno' => $request->apellido_paterno, 'apellido_materno' => $request->apellido_materno]);
        $where = collect();
        foreach ($datos as $key => $value) {
            if ($value) {
                $where->push(['key'=>$key, 'value'=>$value]);
            }
        }
        if ($where->get(0)) {
            $alumnos = Alumnos::where($where->all())->get();
            if($alumnos){
                return response()->json(["Alumnos encontrados por:"=> $where->map(function($dato, $key) {
                    return $dato['key'];
                }) , "Resultados: " . count($alumnos) => $alumnos], 200);
            }
        }
        return abort(400, "Verifica que estés enviando los campos correctos.");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Alumnos  $alumnos
     * @return \Illuminate\Http\Response
     */
    public function edit(Alumnos $alumnos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Alumnos  $alumnos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // $datos = collect(['id' => $request->id, 'nombre' => $request->nombre, 'apellido_paterno' => $request->apellido_paterno,
        // 'apellido_materno' => $request->apellido_materno, 'matricula' => $request->matricula,]);
        // $where = "";

        // foreach ($datos as $key => $value) {
        //     if ($value) {
        //         $where .= $key . "=" . $value . ",";
        //     }
        // }
        $antes = Alumnos::where('id', $request->id)->first();
        Alumnos::where('id', $request->id)
            ->update([
                'nombre' => $request->nombre,
                'apellido_paterno' => $request->apellido_paterno,
                'apellido_materno' => $request->apellido_materno,
                'matricula' => $request->matricula,
            ]);
        $despues = Alumnos::where('id', $request->id)->first();
        if ($despues) {
            return response()->json(["Se editó el alumno de:"=>$antes,"a:"=>$despues ]);
        }
        return abort(400, "Error al editar alumno, verifique haber llenado todos los
        campos incluyendo el id y que este pertenezca a un alumno");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Alumnos  $alumnos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $eliminado = Alumnos::where('id', $request->id)->first();
        Alumnos::where('id', '=', $request->id)->delete();
        if ($eliminado) {
            return response()->json(["Se eliminó el alumno:"=>$eliminado]);
        }
        else {
            return response()->json("No se eliminó ningún alumno, verifica que el alumno exista");
        }
    }
}
