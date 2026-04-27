<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\dato;
use Illuminate\Http\Request;

class DatoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datos = DB::table('datos')->first();
        return view('datos.dato', compact('datos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(dato $dato)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(dato $dato)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // 1. Validaciones
        $request->validate([
            'ruc_empresa'    => 'required|digits:11',
            'nombre_empresa' => 'required|string|max:255',
            'logo'           => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
            'telefono'       => 'nullable|digits:9',
            'correo'         => 'nullable|email|max:50',
        ]);

        // 2. Preparamos los datos básicos
        $data = [
            'nombre_empresa'    => $request->nombre_empresa,
            'ruc_empresa'       => $request->ruc_empresa,
            'direccion_empresa' => $request->direccion_empresa,
            'telefono'          => $request->telefono,
            'correo'            => $request->correo,
            'mensaje_ticket'    => $request->mensaje_ticket, // ¡Importante para el ticket!
            'moneda'            => $request->moneda,
            'updated_at'        => now()
        ];

        // 3. Lógica para el Logo (La parte "pro")
        if ($request->hasFile('logo')) {
            // Buscamos el registro actual para saber si ya tiene un logo
            $empresaActual = DB::table('datos')->where('id', $id)->first();

            // Si ya existe un logo guardado, lo borramos del storage para no ocupar espacio en vano
            if ($empresaActual && $empresaActual->logo) {
                Storage::disk('public')->delete($empresaActual->logo);
            }

            // Guardamos el nuevo logo en la carpeta 'logos' dentro de 'storage/app/public'
            $rutaLogo = $request->file('logo')->store('logos', 'public');
            $data['logo'] = $rutaLogo;
        }

        // 4. Actualizamos la base de datos
        DB::table('datos')->where('id', $id)->update($data);

        return back()->with('success', '¡Datos de la empresa y logo actualizados con éxito!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(dato $dato)
    {
        //
    }
}
