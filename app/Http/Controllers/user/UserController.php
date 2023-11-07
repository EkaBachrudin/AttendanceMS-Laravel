<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Leave;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $employeeId = User::find($user->id)->employees->first()->id;
        $attendance = Attendance::where('emp_id', $employeeId)->whereDate('created_at', Carbon::today())->get();
        $leave = Leave::where('emp_id', $employeeId)->whereDate('created_at', Carbon::today())->get();
        
        return view('user.attendance')->with([
            'user' => $user,
            'attendance' => $attendance,
            'leave' => $leave
        ]);
    }

    public function clockin(Request $request)
    {
        $employeeId = User::find($request->user)->employees->first()->id;
        $user = auth()->user();
        if ($user->id != $request->user) return response()->json([], 400);

        $image = $this->uploadImage($request->image);

        $data = new Attendance();
        $employee = Employee::whereId($employeeId)->first();

        $data->emp_id = $employeeId;
        $emp_req = Employee::whereId($data->emp_id)->first();
        $data->attendance_time = date('H:i:s');
        $data->attendance_date = date('Y-m-d');
        $data->latlong = $request->latlong;
        $data->image = $image;

        $emps = date('H:i:s', strtotime($employee->schedules->first()->time_in));
        if (!($emps >= $data->attendance_time)) {
            $data->status = 0;
        }
        $data->save();

        return response()->json([
            'message' => 'Success !',
            'data' => $request->latlong
        ], 200);
    }

    public function clockout(Request $request)
    {
        $employeeId = User::find($request->user)->employees->first()->id;
        $user = auth()->user();
        if ($user->id != $request->user) return response()->json([], 400);

        $image = $this->uploadImage($request->image);

        $data = new Leave();
        $employee = Employee::whereId($employeeId)->first();

        $data->emp_id = $employeeId;
        $emp_req = Employee::whereId($data->emp_id)->first();
        $data->leave_time = date('H:i:s');
        $data->leave_date = date('Y-m-d');
        $data->latlong = $request->latlong;

        $emps = date('H:i:s', strtotime($employee->schedules->first()->time_out));
        if (!($emps <= $data->leave_time)) {
            $data->status = 0;
        }
        $data->save();

        return response()->json([
            'message' => 'Success !',
            'data' => $request->latlong
        ], 200);
    }

    private function uploadImage($img)
    {
        $folderPath = "public/uploads/";

        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid() . '.png';

        $file = $folderPath . $fileName;
        Storage::put($file, $image_base64);

        return $fileName;
    }
}
