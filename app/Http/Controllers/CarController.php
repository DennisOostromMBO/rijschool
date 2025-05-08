<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * Display a listing of the cars.
     */
    public function index()
    {
        $cars = Car::paginate(10);
        return view('cars.index', compact('cars'));
    }

    /**
     * Show the form for creating a new car.
     */
    public function create()
    {
        return view('cars.create');
    }

    /**
     * Store a newly created car in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'make' => ['required', 'string', 'max:100'],
            'model' => ['required', 'string', 'max:100'],
            'year' => ['required', 'integer', 'min:1990', 'max:' . (date('Y') + 1)],
            'license_plate' => ['required', 'string', 'max:20', 'unique:cars'],
            'color' => ['required', 'string', 'max:50'],
            'transmission_type' => ['required', 'in:automatic,manual'],
            'status' => ['required', 'in:available,in_use,maintenance,retired'],
            'last_maintenance_date' => ['nullable', 'date'],
            'next_maintenance_date' => ['nullable', 'date', 'after:last_maintenance_date'],
            'notes' => ['nullable', 'string'],
        ]);

        $car = Car::create($validated);

        return redirect()->route('cars.index')
            ->with('success', 'Car created successfully.');
    }

    /**
     * Display the specified car.
     */
    public function show(Car $car)
    {
        $car->load('instructor');
        return view('cars.show', compact('car'));
    }

    /**
     * Show the form for editing the specified car.
     */
    public function edit(Car $car)
    {
        return view('cars.edit', compact('car'));
    }

    /**
     * Update the specified car in storage.
     */
    public function update(Request $request, Car $car)
    {
        $validated = $request->validate([
            'make' => ['required', 'string', 'max:100'],
            'model' => ['required', 'string', 'max:100'],
            'year' => ['required', 'integer', 'min:1990', 'max:' . (date('Y') + 1)],
            'license_plate' => ['required', 'string', 'max:20', 'unique:cars,license_plate,' . $car->id],
            'color' => ['required', 'string', 'max:50'],
            'transmission_type' => ['required', 'in:automatic,manual'],
            'status' => ['required', 'in:available,in_use,maintenance,retired'],
            'last_maintenance_date' => ['nullable', 'date'],
            'next_maintenance_date' => ['nullable', 'date', 'after:last_maintenance_date'],
            'notes' => ['nullable', 'string'],
        ]);

        $car->update($validated);

        return redirect()->route('cars.index')
            ->with('success', 'Car updated successfully.');
    }

    /**
     * Remove the specified car from storage.
     */
    public function destroy(Car $car)
    {
        // Check if car is assigned to instructor
        if ($car->instructor()->exists()) {
            return redirect()->route('cars.index')
                ->with('error', 'Cannot delete car that is assigned to an instructor.');
        }

        $car->delete();

        return redirect()->route('cars.index')
            ->with('success', 'Car deleted successfully.');
    }

    /**
     * Display the maintenance schedule for all cars.
     */
    public function maintenanceSchedule()
    {
        $cars = Car::whereNotNull('next_maintenance_date')
            ->orderBy('next_maintenance_date')
            ->paginate(10);

        return view('cars.maintenance-schedule', compact('cars'));
    }

    /**
     * Schedule maintenance for a car.
     */
    public function scheduleMaintenance(Request $request, Car $car)
    {
        $validated = $request->validate([
            'maintenance_date' => ['required', 'date', 'after_or_equal:today'],
            'maintenance_type' => ['required', 'string', 'max:100'],
            'notes' => ['nullable', 'string'],
        ]);

        $car->update([
            'status' => 'maintenance',
            'next_maintenance_date' => $validated['maintenance_date'],
            'maintenance_type' => $validated['maintenance_type'],
            'notes' => $validated['notes'] ?? $car->notes,
        ]);

        return redirect()->route('cars.maintenance-schedule')
            ->with('success', 'Maintenance scheduled successfully.');
    }
}
