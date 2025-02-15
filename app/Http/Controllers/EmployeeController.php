<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Position;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Exception;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
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
        return view('employees.create', [
            'countries' => Country::all(),
            'positions' => Position::all(),
            'employees' => Employee::all()
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'identification' => 'required|string|unique:employees',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'country_id' => 'required|exists:countries,id',
            'city_id' => [
                'required',
                'exists:cities,id',
                Rule::exists('cities', 'id')->where('country_id', $request->country_id)
            ],
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
                    return !$request->boolean('is_president');
                }),
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->boolean('is_president') && $value) {
                        $fail('El presidente no puede tener jefe');
                    }
                }
            ],
            'positions' => [
                'required',
                'array',
                'min:1',
                function ($attribute, $value, $fail) use ($request) {
                    $presidentePosition = Position::where('name', 'Presidente')->first();
                    
                    if (!$presidentePosition) {
                        $fail('No existe el cargo de Presidente configurado');
                        return;
                    }
    
                    if (in_array($presidentePosition->id, $value)) {
                        if ($presidentePosition->employees()->exists()) {
                            $fail('El cargo de Presidente ya está asignado a otro empleado');
                        }
                        if (!$request->boolean('is_president')) {
                            $fail('Debe marcar "Es presidente" si asigna este cargo');
                        }
                    }
                }
            ],
            'positions.*' => 'exists:positions,id'
        ], [
            'boss_id.required' => 'Debe seleccionar un jefe a menos que sea el presidente',
            'positions.required' => 'Debe asignar al menos un cargo',
            'is_president.*' => 'Solo puede haber un presidente en la organización',
            'city_id.exists' => 'La ciudad seleccionada no pertenece al país elegido'
        ]);
    
        try {
            DB::beginTransaction();
    
            $employee = Employee::create([
                'name' => $validatedData['name'],
                'surname' => $validatedData['surname'],
                'identification' => $validatedData['identification'],
                'address' => $validatedData['address'],
                'phone' => $validatedData['phone'],
                'city_id' => $validatedData['city_id'],
                'is_president' => $request->boolean('is_president'),
                'boss_id' => $validatedData['boss_id'] ?? null
            ]);
    
            $employee->positions()->attach($validatedData['positions']);
    
            DB::commit();
    
            return redirect()->route('employees.index')
                ->with('success', 'Empleado creado exitosamente');
    
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }

    public function edit(Employee $employee)
    {
        return view('employees.edit', [
            'employee' => $employee,
            'countries' => Country::all(),
            'positions' => Position::all(),
            'employees' => Employee::where('id', '!=', $employee->id)->get()
        ]);
    }

    public function update(Request $request, Employee $employee)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'identification' => 'required|string|unique:employees,identification,'.$employee->id,
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'country_id' => 'required|exists:countries,id',
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
                    return !$request->boolean('is_president');
                }),
                function ($attribute, $value, $fail) use ($request, $employee) {
                    if ($request->boolean('is_president') && $value) {
                        $fail('El presidente no puede tener jefe');
                    }
                    if ($value == $employee->id) {
                        $fail('Un empleado no puede ser su propio jefe');
                    }
                }
            ],
            'positions' => 'required|array|min:1',
            'positions.*' => 'exists:positions,id'
        ], [
            'boss_id.required' => 'Debe seleccionar un jefe a menos que sea el presidente',
            'positions.required' => 'Debe asignar al menos un cargo',
            'is_president.*' => 'Solo puede haber un presidente en la organización'
        ]);

        try {
            DB::beginTransaction();

            $updateData = [
                'name' => $validatedData['name'],
                'surname' => $validatedData['surname'],
                'identification' => $validatedData['identification'],
                'address' => $validatedData['address'],
                'phone' => $validatedData['phone'],
                'city_id' => $validatedData['city_id'],
                'is_president' => $request->boolean('is_president'),
                'boss_id' => $validatedData['boss_id'] ?? null
            ];

            $employee->update($updateData);
            $employee->positions()->sync($validatedData['positions']);

            DB::commit();

            return redirect()->route('employees.index')
                ->with('success', 'Empleado actualizado correctamente');

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }

    public function destroy(Employee $employee)
    {
        try {
            DB::beginTransaction();

            if ($employee->is_president) {
                throw new Exception('No se puede eliminar al presidente');
            }

            if ($employee->subordinates()->exists()) {
                throw new Exception('No se puede eliminar un empleado con subordinados');
            }

            $employee->positions()->detach();
            $employee->delete();

            DB::commit();

            return redirect()->route('employees.index')
                ->with('success', 'Empleado eliminado correctamente');

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => $e->getMessage()]);
        }
    }
}