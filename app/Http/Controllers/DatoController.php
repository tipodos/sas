<?php

namespace App\Http\Controllers;

use App\Models\dato;
use Illuminate\Http\Request;

class DatoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datos = dato::all();
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
    public function update(Request $request, dato $dato)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(dato $dato)
    {
        //
    }
}
