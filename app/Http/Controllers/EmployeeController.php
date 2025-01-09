<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EmployeeController extends Controller
{
    /**
     * ส่งข้อมูลหนังงานทั้งหมดไปหน้าindex
     */
    public function index(Request $request)
    {
        //รับค่าจากช่อง input ที่ใช้ในการค้นหา ผ่าน requery
        $query = $request->input('search');
        $employees = DB::table('employees')


        //หาข้อความได้ทั้งชื่อเเละนามสกุล
        ->where('first_name','like','%' . $query . '%')
        ->orWhere('last_name','Like','%' .$query. '%')
        ->paginate(10);


        //Log::info($employees);

        return Inertia::render('Employee/Index',[
           'employees' => $employees,
           'query' => $query,
        //ส่งข้อมูลไปหน้า index โดนใข้ตัวเเปร query ในการเก็บค่าที่รับมาจาก input

        ]);

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
