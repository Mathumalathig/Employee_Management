<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    
    public function index()
    {
        $employees = Employee::with('department', 'designation')->get(); 
        $departments = Department::all(); 

        return view('employees.index', compact('employees', 'departments')); 
    }

    // Method to store a new employee
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required',
            'dob' => 'required|date|before_or_equal:today',
            'doj' => 'required|date',
            'mobile' => 'required|digits:10',
            'email' => 'required|email',
            'department_id' => 'required|exists:departments,id',
            'designation_id' => 'required|exists:designations,id',
            'address' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('employees', 'public'); 
        }

        $employee = new Employee();
        $employee->name = $validatedData['name'];
        $employee->gender = $validatedData['gender'];
        $employee->dob = $validatedData['dob'];
        $employee->doj = $validatedData['doj'];
        $employee->mobile = $validatedData['mobile'];
        $employee->email = $validatedData['email'];
        $employee->department_id = $validatedData['department_id'];
        $employee->designation_id = $validatedData['designation_id'];
        $employee->address = $validatedData['address'] ?? null;
        $employee->image = $imagePath;
        $employee->save(); 

        return redirect('/employees')->with('success', 'Employee added successfully!');
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required',
            'dob' => 'required|date|before_or_equal:today',
            'doj' => 'required|date',
            'mobile' => 'required|digits:10',
            'email' => 'required|email',
            'department_id' => 'required|exists:departments,id',
            'designation_id' => 'required|exists:designations,id',
            'address' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($employee->image) {
                Storage::delete('public/' . $employee->image);
            }
            $imagePath = $request->file('image')->store('employees', 'public');
            $employee->image = $imagePath;
        }

        $employee->name = $validatedData['name'];
        $employee->gender = $validatedData['gender'];
        $employee->dob = $validatedData['dob'];
        $employee->doj = $validatedData['doj'];
        $employee->mobile = $validatedData['mobile'];
        $employee->email = $validatedData['email'];
        $employee->department_id = $validatedData['department_id'];
        $employee->designation_id = $validatedData['designation_id'];
        $employee->address = $validatedData['address'] ?? null;
        $employee->save(); 

        return redirect('/employees')->with('success', 'Employee updated successfully!');
        
    }

    public function edit($id)
    {
        $employee = Employee::with('department', 'designation')->findOrFail($id); 
        $designations = Designation::where('department_id', $employee->department_id)->get(); 

        return response()->json([
            'employee' => $employee,
            'designations' => $designations
        ]);
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);

        if ($employee->image) {
            Storage::delete('public/' . $employee->image);
        }

        $employee->delete();

        return redirect('/employees')->with('success', 'Employee deleted successfully!');
    }

    
    public function getDesignations($department_id)
    {
        $designations = Designation::where('department_id', $department_id)->get();
        return response()->json($designations);
    }
}
