<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('user.attendance')->with(['user' => $user]);
    }

    public function store(Request $request)
    {
        //check if user has clockin / clockout this day
        $user = auth()->user();
        if ($user->id != $request->user) return response()->json([], 400);

        $img = $request->image;
        $folderPath = "uploads/";

        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid() . '.png';

        $file = $folderPath . $fileName;
        Storage::put($file, $image_base64);

        return response()->json([
            'message' => 'Success !',
        ], 200);
    }
}
