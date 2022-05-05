<?php

namespace App\Http\Controllers;

use App\Models\employees;
use Illuminate\Http\Request;

class homeController extends Controller
{
    public function index()
    {
        return view('home');
    }
    
    public function cargarArchivoEmpleados(Request $request){
        for ($i = 0; $i >= -1; $i++) {
            if(!isset($request[$i])){break;}
            if (!is_array($request->all())) {
                return ['error' => 'request must be an array'];
            }
            // Creamos las reglas de validación
            $rules = [
                'name'      => 'required',
                'email'     => 'required|email|unique:employees,email',
                'phone'  => 'required',
                'address'  => 'required',
                'position'  => 'required',
                'salary'  => 'required',
                'skills'  => 'required'
                ];
            try {
                // Ejecutamos el validador y en caso de que falle devolvemos la respuesta
                // con los errores
                $validator = \Validator::make($request[$i], $rules);
                if ($validator->fails()) {
                    return [
                        'created' => false,
                        'errors'  => $validator->errors()->all()
                    ];
                }
                // Si el validador pasa, almacenamos el usuario
            } catch (Exception $e) {
                return "error";
                // Si algo sale mal devolvemos un error.
                \Log::info('Error creating empleado: '.$e);
                return \Response::json(['created' => false], 500);
            }
        }
        for ($i = 0; $i >= -1; $i++) {
            if(!isset($request[$i])){break;}
            if(!employees::create($request[$i])){
                return ['created' => true, 'user' => $request[$i]];
            }
        }
        return ['created' => true];
    }

    public function empleadosList(){
        $empleados = employees::all();
        $concatenaTabla=collect([]);
        foreach($empleados as $empleado){
            $collectionTabla = collect([
                [
                    'id'=>$empleado->id,
                    'name'=>$empleado->name,
                    'email'=>$empleado->email,
                    'phone'=>$empleado->phone,
                    'address'=>$empleado->address,
                    'position'=>$empleado->position,
                    'salary'=>$empleado->salary,
                    'skills'=>$empleado->skills,
                ]
            ]);
            $concatenaTabla = $collectionTabla->concat($concatenaTabla);
        }
        return response()->json($concatenaTabla);
    }
    
    public function findSalary($salaryMin, $salaryMax){
        if(!is_numeric($salaryMin) || !is_numeric($salaryMax)){
            return "Debe ingresar valores numericos";
        }
        if($salaryMin > $salaryMax){
            return "El primer valor debe ser menor al segundo";
        }
        return employees::whereBetween('salary', [$salaryMin, $salaryMax])->get();
    }
}
