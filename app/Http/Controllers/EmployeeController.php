<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EmployeeController extends Controller
{
    /**
     * ส่งข้อมูลพนังงานทั้งหมดไปหน้าindex
     */
    public function index(Request $request)
    {
        //รับค่าจากช่อง input ที่ใช้ในการค้นหา ผ่าน requery
        $query = $request->input('search');

        $employees = DB::table('employees')
            ->join('dept_emp', 'employees.emp_no', '=', 'dept_emp.emp_no')
            ->join('departments', 'dept_emp.dept_no', '=', 'departments.dept_no')
            ->leftJoin('dept_manager', 'employees.emp_no', '=', 'dept_manager.emp_no') // Join with dept_manager table
            //หาข้อความได้ทั้งชื่อเเละนามสกุล

            ->where('employees.first_name', 'like', '%' . $query . '%')
            ->orWhere('employees.last_name', 'like', '%' . $query . '%')
            ->orWhere('employees.emp_no', '=', $query)
            ->select('employees.*', 'departments.dept_name', 'dept_emp.from_date', 'dept_emp.to_date')
            ->orderBy('employees.emp_no', 'desc') // Sort by emp_no in descending order
            ->paginate(10);

        //Log::info($employees);

        return Inertia::render('Employee/Index', [
            'employees' => $employees,
            'query' => $query,
            //ส่งข้อมูลไปหน้า index โดนใข้ตัวเเปร query ในการเก็บค่าที่รับมาจาก input
        ]);
    }
    //ส่งข้อมูลไปหน้ากลับ index  ที่รับมาจาก input ที่ใช้ในการค้นหา

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // ดึงข้อมูลจาก department เพื่อไปแสดงให้เลือกรายการในแบบฟอร์ม
        $departments = DB:: table('departments' )->select('dept_no', 'dept_name' )->get();

        // Inertia จะส่งข้อมูล departments ไปที่หน้า Create ในรูปเเบบของ json
        return inertia('Employee/Create', ['departments' => $departments]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info( $request->all());
        //ตรวจสอบข้อมูลที่รับมาจาก form ว่าตรงตามเงื่อนไขหรือไม่
        $validated = $request->validate([
            'birth_date' => 'required|date',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'gender' => 'required|string|in:M,F',
            'hire_date' => 'required|date',
            'department' => 'required|string|exists:departments,dept_no',
    ]);

        DB::transaction(function () use ($validated, $request) {
            // Get the latest emp_no
            $latestEmpNo = DB::table('employees')->max('emp_no') ?? 0;
            $newEmpNo = $latestEmpNo + 1;

            Log::info($newEmpNo);

            // Insert ข้อมูลลงตาราง employees
            DB::table('employees')->insert([
                'emp_no' => $newEmpNo,
                'birth_date' => $validated['birth_date'],
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'gender' => $validated['gender'],
                'hire_date' => $validated['hire_date'],
            ]);

            // Insert into dept_emp table
            DB::table('dept_emp')->insert([
                'emp_no' => $newEmpNo,
                'dept_no' => $validated['department'],
                'from_date' => $validated['hire_date'],
                'to_date' => '9999-01-01'
            ]);


        DB::table('dept_manager')->insert([
            'emp_no' => $newEmpNo,
            'dept_no' => $validated['department'],
            'from_date' => $validated['hire_date'],
            'to_date' => '9999-01-01'
        ]);
    });



        // เพิ่มข้อมูลพนักงานเสร็จแล้ว ส่งกลับไปหน้า index
        return redirect()->route('employee.index')
        ->with('success', 'Employee created successfully.');









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
