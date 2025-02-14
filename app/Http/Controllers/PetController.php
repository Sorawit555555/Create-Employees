<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // เพิ่มการนำเข้าคลาส Log

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Pet::query();
        // ค้นหาตามประเภท (species)
        if ($request->filled('species')) {
            $query->where('species', 'LIKE', "%{$request->species}%");
        }

        // ค้นหาตามอายุ (age)
        if ($request->filled('age')) {
            $query->where('age', $request->age);
        }
        // ค้นหาตามสถานะ (status)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        // ค้นหาตามช่วงราคา (price_min - price_max)
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }
        // ดึงข้อมูลทั้งหมดตามเงื่อนไข
        $pets = $query->get();

        return response()->json([
            'success' => true,
            'message' => count($pets) > 0 ? 'Data found' : 'No data available',
            'count' => count($pets),
            'data' => $pets
        ], 200);
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
        Log::info('Request received:', $request->all()); // เพิ่มการบันทึก log

        // validate ข้อมูล
        $request->validate([
            'name' => 'required',
            'species' => 'required',
            'price' => 'required',
            'status' => 'required',
            'breed' => 'required', // เพิ่มการตรวจสอบฟิลด์ breed
            'age' => 'required|integer', // Add validation for age
            
        ]);

        try {
            // สร้างข้อมูลใหม่ จากข้อมูลที่ผ่านการตรวจสอบแล้ว
            $pet = Pet::create($request->all());
            Log::info('Pet created:', $pet->toArray()); // เพิ่มการบันทึก log

            // return json response
            // ส่งข้อมูลกลับไปในรูปแบบ json
            return response()->json([
                'success' => true,
                'message' => 'Pet created successfully',
                'data' => $pet
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error creating pet:', ['error' => $e->getMessage()]); // เพิ่มการบันทึกข้อผิดพลาด
            return response()->json([
                'success' => false,
                'message' => 'Failed to create pet',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pet $pet)
    {
           //
           return response()->json([
            'success' => true,
            'message' => 'Pet data found',
            'data' => $pet
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pet $pet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pet $pet)
    {
        Log::info('Update request received:', $request->all()); // เพิ่มการบันทึก log

        // validate ข้อมูล
        $request->validate([
            'name' => 'required',
            'species' => 'required',
            'price' => 'required',
            'status' => 'required',
            'breed' => 'required', // เพิ่มการตรวจสอบฟิลด์ breed
            'age' => 'required|integer', // Add validation for age
            'detail' => 'required', // Add validation for detail
            'photo' => 'required' // Add validation for photo
        ]);

        try {
            // อัปเดตข้อมูล จากข้อมูลที่ผ่านการตรวจสอบแล้ว
            $pet->update($request->all());
            Log::info('Pet updated:', $pet->toArray()); // เพิ่มการบันทึก log

            // return json response
            // ส่งข้อมูลกลับไปในรูปแบบ json
            return response()->json([
                'success' => true,
                'message' => 'Pet updated successfully',
                'data' => $pet
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error updating pet:', ['error' => $e->getMessage()]); // เพิ่มการบันทึกข้อผิดพลาด
            return response()->json([
                'success' => false,
                'message' => 'Failed to update pet',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pet $pet)
    {
        try {
            // ลบข้อมูล
            $pet->delete();
            Log::info('Pet deleted:', $pet->toArray()); // เพิ่มการบันทึก log

            // return json response
            // ส่งข้อมูลกลับไปในรูปแบบ json
            return response()->json([
                'success' => true,
                'message' => 'Pet deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting pet:', ['error' => $e->getMessage()]); // เพิ่มการบันทึกข้อผิดพลาด
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete pet',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
