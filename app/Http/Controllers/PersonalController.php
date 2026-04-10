<?php

namespace App\Http\Controllers;

use App\Models\order;
use App\Models\orderDetail;
use Illuminate\Http\Request;
use App\Models\personal;
use App\Models\product;

class PersonalController extends Controller
{
    public function index(){

        $personales= personal::all();
        

        return view('personal/personal', compact('personales'));
    }

    public function store(Request $request){

        $request->validate([
            'name'=>'required|min:3',
            'dni'=>'required|min:8|unique:personals,dni'
        ]);

        $personal= new personal();
        $personal->name=$request->input('name');
        $personal->dni=$request->input('dni');
        $personal->save();

        return redirect()->route('personal.index')->with('success', 'Personal creado exitosamente.');
    }
    public function show($id){
        
    }
    public function delete(Request $request){
        $personal=personal::find($request->id);
        $personal->delete();
        return redirect()->route('personal.index')->with('success', 'Personal eliminado exitosamente.');
    }
}
