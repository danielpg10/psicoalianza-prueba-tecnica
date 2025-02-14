<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Position;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Exception;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if ($request->is_president && $request->boss_id) {
                return redirect()->back()
                    ->withErrors(['boss_id' => 'El presidente no puede tener jefe'])
                    ->withInput();
            }
            return $next($request);
        });
    }

    public function index()
    {
        $employees = Employee::with(['city.country', 'positions', 'boss'])
            ->orderBy('is_president', 'desc')
            ->latest()
            ->get();

        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        $countries = Country::all();
        $positions = Position::all();
        $employees = Employee::where('is_president', false)->get();

        return view('employees.create', compact(
            'countries', 
            'positions', 
            'employees'
        ));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'identification' => 'required|string|unique:employees',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'city_id' => 'required|exists:cities,id',
            'is_president' => [
                'sometimes',
                'boolean',
                function ($attribute, $value, $fail) {
                    if ($value && Employee::where('is_president', true)->exists()) {
                        $fail('Ya existe un presidente en la organización');
                    }
                }
            ],
            'boss_id' => [
                'nullable',
                'exists:employees,id',
                Rule::requiredIf(function () use ($request) {
                    return !$request->is_president;
                })
            ],
            'positions' => 'required|array|min:1',
            'positions.*' => 'exists:positions,id'
        ], [
            'boss_id.required' => 'Debe seleccionar un jefe a menos que sea el presidente',
            'positions.required' => 'Debe asignar al menos un cargo',
            'is_president.*' => 'Solo puede haber un presidente en la organización'
        ]);

        try {
            if ($validatedData['is_president'] ?? false) {
                if (Employee::where('is_president', true)->exists()) {
                    throw new Exception('Ya existe un presidente registrado');
                }
                $validatedData['boss_id'] = null;
            }

            $employee = Employee::create($validatedData);
            $employee->positions()->attach($request->positions);

            return redirect()->route('employees.index')
                ->with('success', 'Empleado creado exitosamente');

        } catch (Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }

    public function edit(Employee $employee)
    {
        $countries = Country::all();
        $positions = Position::all();
        $employees = Employee::where('id', '!=', $employee->id)
            ->where('is_president', false)
            ->get();

        return view('employees.edit', compact(
            'employee', 
            'countries', 
            'positions', 
            'employees'
        ));
    }

    public function update(Request $request, Employee $employee)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'identification' => 'required|string|unique:employees,identification,'.$employee->id,
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'city_id' => 'required|exists:cities,id',
            'is_president' => [
                'sometimes',
                'boolean',
                function ($attribute, $value, $fail) use ($employee) {
                    if ($value && Employee::where('is_president', true)
                        ->where('id', '!=', $employee->id)
                        ->exists()) {
                        $fail('Ya existe un presidente en la organización');
                    }
                }
            ],
            'boss_id' => [
                'nullable',
                'exists:employees,id',
                Rule::requiredIf(function () use ($request) {
                    return !$request->is_president;
                })
            ],
            'positions' => 'required|array|min:1',
            'positions.*' => 'exists:positions,id'
        ], [
            'boss_id.required' => 'Debe seleccionar un jefe a menos que sea el presidente',
            'positions.required' => 'Debe asignar al menos un cargo',
            'is_president.*' => 'Solo puede haber un presidente en la organización'
        ]);

        try {
            if ($validatedData['is_president'] ?? false) {
                if (Employee::where('is_president', true)
                    ->where('id', '!=', $employee->id)
                    ->exists()) {
                    throw new Exception('Ya existe un presidente registrado');
                }
                $validatedData['boss_id'] = null;
            }

            $employee->update($validatedData);
            $employee->positions()->sync($request->positions);

            return redirect()->route('employees.index')
                ->with('success', 'Empleado actualizado correctamente');

        } catch (Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }

    public function destroy(Employee $employee)
    {
        try {
            if ($employee->is_president) {
                throw new Exception('No se puede eliminar al presidente');
            }

            if ($employee->subordinates()->exists()) {
                throw new Exception('No se puede eliminar un empleado con subordinados');
            }

            $employee->delete();

            return redirect()->route('employees.index')
                ->with('success', 'Empleado eliminado correctamente');

        } catch (Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => $e->getMessage()]);
        }
    }
}