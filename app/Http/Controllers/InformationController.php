<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Information;
use Carbon\Carbon;

class InformationController extends Controller
{
    public function index() {
        return Information::all();
    }
    public function store(Request $request) {
        $currentTime = Carbon::now()->format('y-m-d');
        $data = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required', 
            'middle_name' => '', 
            'dob' => 'required|before:' . $currentTime
        ]);
        Information::create($data);
        return ['message' => 'Information created!'];
        
    }
}
