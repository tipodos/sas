<?php

namespace App\Http\Controllers;

use App\Models\gasto;
use Illuminate\Http\Request;

class GastoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gastos = gasto::all();
        return view('gastos.gasto', compact('gastos'));
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
    public function show(gasto $gasto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(gasto $gasto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, gasto $gasto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(gasto $gasto)
    {
        //
    }
}
