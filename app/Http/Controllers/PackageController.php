<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Student;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    /**
     * Display a listing of the packages.
     */
    public function index()
    {
        $packages = Package::paginate(10);
        return view('packages.index', compact('packages'));
    }

    /**
     * Show the form for creating a new package.
     */
    public function create()
    {
        return view('packages.create');
    }

    /**
     * Store a newly created package in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string'],
            'lessons_count' => ['required', 'integer', 'min:1'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration_weeks' => ['required', 'integer', 'min:1'],
            'is_active' => ['boolean'],
            'includes_theory' => ['boolean'],
            'includes_exam' => ['boolean'],
        ]);

        // Set boolean values based on checkbox status
        $validated['is_active'] = $request->has('is_active');
        $validated['includes_theory'] = $request->has('includes_theory');
        $validated['includes_exam'] = $request->has('includes_exam');

        $package = Package::create($validated);

        return redirect()->route('packages.index')
            ->with('success', 'Package created successfully.');
    }

    /**
     * Display the specified package.
     */
    public function show(Package $package)
    {
        $package->load('registrations.student.user');
        return view('packages.show', compact('package'));
    }

    /**
     * Show the form for editing the specified package.
     */
    public function edit(Package $package)
    {
        return view('packages.edit', compact('package'));
    }

    /**
     * Update the specified package in storage.
     */
    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string'],
            'lessons_count' => ['required', 'integer', 'min:1'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration_weeks' => ['required', 'integer', 'min:1'],
            'is_active' => ['boolean'],
            'includes_theory' => ['boolean'],
            'includes_exam' => ['boolean'],
        ]);

        // Set boolean values based on checkbox status
        $validated['is_active'] = $request->has('is_active');
        $validated['includes_theory'] = $request->has('includes_theory');
        $validated['includes_exam'] = $request->has('includes_exam');

        $package->update($validated);

        return redirect()->route('packages.index')
            ->with('success', 'Package updated successfully.');
    }

    /**
     * Remove the specified package from storage.
     */
    public function destroy(Package $package)
    {
        // Check if there are any registrations using this package
        if ($package->registrations()->exists()) {
            return redirect()->route('packages.index')
                ->with('error', 'Cannot delete package that is in use by students.');
        }

        $package->delete();

        return redirect()->route('packages.index')
            ->with('success', 'Package deleted successfully.');
    }

    /**
     * Get packages for a specific student.
     */
    public function studentPackages(Student $student)
    {
        $packages = $student->registrations()->with('package')->get()->pluck('package');
        return view('packages.student', compact('packages', 'student'));
    }
}
