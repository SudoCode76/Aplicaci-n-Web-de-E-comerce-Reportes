<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomersController extends Controller
{

    public function index()
    {
        $items = Customer::all();
        return response()->json($items);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $items= Customer::create($request->all());
        return response()->json($items, 201);
    }


    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
