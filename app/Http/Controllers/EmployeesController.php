<?php

namespace App\Http\Controllers;

use App\Mail\EmployeeMail;
use App\Models\Companies;
use App\Models\Employees;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\StoreEmployeesRequest;
use App\Http\Requests\UpdateEmployeesRequest;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $employees = Employees::with('companies')->latest()->paginate(10);
            return view('admin.employees.index', compact('employees'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Companies::get();
        return view('admin.employees.create', compact('companies'));
    }

    private function emailNotif()
    {
        return Mail::to('mobadaff@gmail.com')->send(new EmployeeMail());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeesRequest $request)
    {
        try{
            $employee = Employees::create($request->all());
            try {
                Mail::to('daffawork2@gmail.com')->send(new EmployeeMail());
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Failed to send email: ' . $e->getMessage());
            }
            return redirect($employee ? '/employees' : '/employees/create')
                ->with($employee ? 'success' : 'error', $employee ? 'Success Create Employee' : 'Failed Create Employee');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try{
            $employee = Employees::with('companies')->findOrFail($id);
            return view('admin.employees.show', compact('employee'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try{
            $employee = Employees::with('companies')->findOrFail($id);
            $companies = Companies::get();
            return view('admin.employees.edit', compact('employee','companies'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeesRequest $request, $id)
    {
        try{
            $employee = Employees::findOrFail($id);
            $update = $employee->update( $request->all() );
            return redirect($update ? '/employees' : 'employees/'.$employee->id.'/edit')
            ->with($update ? 'success' : 'error', $update ? 'Success Edit Employee' : 'Failed Edit Employee');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try{
            $employee = Employees::findOrFail($id);
            $delete = $employee->delete();
            return redirect('/employees')
            ->with($delete ? 'success' : 'error', $delete ? 'Success Delete Employee' : 'Failed Delete Employee');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
