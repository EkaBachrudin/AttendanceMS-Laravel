<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use App\Models\Role;
use App\Models\Schedule;
use App\Http\Requests\EmployeeRec;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{

    public function index()
    {

        return view('admin.employee')->with(['employees' => Employee::all(), 'schedules' => Schedule::all()]);
    }

    public function store(EmployeeRec $request)
    {
        $request->validated();

        $employee = new Employee;
        $employee->name = $request->name;
        $employee->position = $request->position;
        $employee->email = $request->email;
        $employee->pin_code = bcrypt($request->pin_code);
        $employee->save();

        if ($request->schedule) {

            $schedule = Schedule::whereSlug($request->schedule)->first();

            $employee->schedules()->attach($schedule);
        }

        $employee->schedules()->attach($schedule);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->name);
        $user->save();

        $user->roles()->attach(2);
        $user->employees()->attach($employee->id);

        // $role = Role::whereSlug('emp')->first();

        // $employee->roles()->attach($role);

        flash()->success('Success', 'Employee Record has been created successfully !');

        return redirect()->route('employees.index')->with('success');
    }


    public function update(EmployeeRec $request, Employee $employee)
    {
        $request->validated();

        $employee->name = $request->name;
        $employee->position = $request->position;
        $employee->email = $request->email;
        $employee->pin_code = bcrypt($request->pin_code);
        $employee->save();

        if ($request->schedule) {

            $employee->schedules()->detach();

            $schedule = Schedule::whereSlug($request->schedule)->first();

            $employee->schedules()->attach($schedule);


            $user = User::find($employee->first()->users[0]->id);
            $user->email = $request->email;
            $user->save();
        }

        flash()->success('Success', 'Employee Record has been Updated successfully !');

        return redirect()->route('employees.index')->with('success');
    }


    public function destroy(Employee $employee)
    {
        $employee->users()->delete();
        $employee->delete();
        flash()->success('Success', 'Employee Record has been Deleted successfully !');
        return redirect()->route('employees.index')->with('success');
    }
}
