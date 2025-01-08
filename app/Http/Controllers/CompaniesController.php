<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreCompaniesRequest;
use App\Http\Requests\UpdateCompaniesRequest;

class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $companies = Companies::latest()->paginate(10);
            return view('admin.companies.index', compact('companies'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.companies.create');
    }


    private function generateStoragePath($file)
    {
        return $this->generateUniqueFileName($file); // Hanya nama file
    }
    
    private function generateUniqueFileName($file)
    {
        return md5(uniqid() . $file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompaniesRequest $request)
    {
        try {
            $photo = ''; // Default jika logo tidak diunggah
    
            if ($request->file('logo')) {
                $uploadedFile = $request->file('logo');
                $fileName = $this->generateStoragePath($uploadedFile); 
                $photo = $uploadedFile->storeAs('images/logo', $fileName, 'public'); 
            }
    
            // return dd($photo);
            $companies = Companies::create([
                "name" => $request->name,
                "email" => $request->email,
                "logo" => $photo,
                "website" => $request->website,
            ]);
    
            return redirect($companies ? '/companies' : '/companies/create')
                ->with($companies ? 'success' : 'error', $companies ? 'Success Create Companies' : 'Failed Create Companies');
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
            $companie = Companies::findOrFail($id);  
            return view('admin.companies.show', compact('companie'));
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
            $companie = Companies::findOrFail($id);  
            return view('admin.companies.edit', compact('companie'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompaniesRequest $request, $id)
    {
        try{
            $companie = Companies::findOrFail($id);
            if ($request->file('logo')) {
                Storage::disk('public')->delete($companie->logo);
                $uploadedFile = $request->file('logo');
                $fileName = $this->generateStoragePath($uploadedFile); 
                $photo = $uploadedFile->storeAs('images/logo', $fileName, 'public'); 
            }else{
                $photo = $companie->logo;
            }

            $update = $companie->update([
                "name" => $request->name,
                "email" => $request->email,
                "logo" => $photo,
                "website" => $request->website
            ]);

            return redirect($update ? '/companies' : 'companies/'.$companie->id.'/edit')
            ->with($update ? 'success' : 'error', $update ? 'Success Edit Companies' : 'Failed Edit Companies');
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
            $companie = Companies::findOrFail($id);
            Storage::disk('public')->delete($companie->logo);
            $delete = $companie->delete();
            return redirect( '/companies')
            ->with($delete ? 'success' : 'error', $delete ? 'Success Delete Companies' : 'Failed Delete Companies');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
