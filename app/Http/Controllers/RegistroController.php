<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Registro;
use Carbon\Carbon; // Importa Carbon para manejar fechas y horas
use PDF; // Para los pdfs

class RegistroController extends Controller
{
    //
    public function createRegistro(){
    }

    public function getRegistros(){
        // Obtener todos los registros desde la base de datos
        $registros = Registro::all();
        
        // Retornar la vista 'registros' y pasarle los registros
        return view('welcome', ['registros' => $registros]);
    }

    public function saveRegistro(Request $request){
        // Validar formulario
        $validateData = $this->validate($request, [
            'placa' => 'required|min:5|max:10',
            'tipo' => 'required',
        ]);

        // Crear una nueva instancia del modelo Registro
        $registro = new Registro();

        // Asignar los valores del formulario al modelo
        $registro->placa = $request->input('placa');
        $registro->tipo = $request->input('tipo');
        
        // Asignar la fecha y hora actual a la columna entrada
        $registro->entrada = Carbon::now()->subHour();
        // Guardar el registro en la base de datos
        $registro->save();
        
        // Redirigir de vuelta a la página anterior
        return redirect()->back()->with('message', 'Registro guardado con éxito');
    }

    public function marcarSalida($id){
        $registro = Registro::find($id);

        if ($registro) {
            // Restar 1 hora a la hora actual
            $registro->salida = Carbon::now()->subHour();

            // Convertir entrada y salida a objetos Carbon
            $entrada = Carbon::parse($registro->entrada);
            $salida = Carbon::parse($registro->salida);

            // Calcular la diferencia en minutos
            $diferenciaMinutos = intval($entrada->diffInMinutes($salida));

            // Convertir a formato HH:MM:SS
            $horas = floor($diferenciaMinutos / 60);
            $minutos = $diferenciaMinutos % 60;
            $registro->duracion = sprintf('%02d:%02d:00', $horas, $minutos);

            // Asignar la diferencia al campo pago
            if ($registro->tipo == 'residente') {
                $registro->pago = $diferenciaMinutos;
            } elseif ($registro->tipo == 'no_residente') {
                $registro->pago = $diferenciaMinutos * 3;
            } else {
                $registro->pago = 0;
            }

            // Guardar el registro
            $registro->update([
                'duracion' => $registro->duracion,
                'salida' => $registro->salida,
                'pago' => $registro->pago,
            ]);
        }

        return redirect()->back()->with('message', 'Salida marcada con éxito');
    }

    public function crearPdf(Request $request){
        // Validar las fechas
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        // Convertir las fechas de entrada a un formato adecuado
        $fechaInicio = Carbon::parse($request->fecha_inicio)->startOfDay();
        $fechaFin = Carbon::parse($request->fecha_fin)->endOfDay();

        // Obtener los registros dentro del rango de fechas
        $registros = Registro::whereBetween('entrada', [$fechaInicio, $fechaFin])->get();

        // Cargar la vista con los registros
        $pdf = PDF::loadView('pdf.registros', ['registros' => $registros]);

        // Descargar el PDF
        return $pdf->download('registros.pdf');
    }
}
