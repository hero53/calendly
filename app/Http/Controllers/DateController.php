<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        return view('welcome');
    }

    public function getDate()
    {


        try {
            $data = DB::table('appointments')
                ->select('appointments.id', 'appointments.date')
                ->get();
            return response()->json([
                'status' => 'success',
                'data' => $data,
                'code' => 200,
                'message' => []
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'data' => [],
                'code' => 400,
                'message' => $th
            ]);
        }
    }

    public function getChrono(Request $request)
    {




        try {
            $data = DB::table('chronos')
                ->where('appointment_id', $request->date)
                ->select('chronos.id', 'chronos.start_time as heure')
                ->get();
            //   dd($data);
            return response()->json([
                'status' => 'success',
                'data' => $data,
                'code' => 200,
                'message' => []
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'data' => [],
                'code' => 400,
                'message' => $th
            ]);
        }
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
