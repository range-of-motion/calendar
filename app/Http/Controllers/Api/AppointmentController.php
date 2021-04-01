<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        return Appointment::all();
    }

    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'scheduled_at' => 'required|date_format:Y-m-d H:i:s',
            'memo' => 'required|max:255'
        ]);

        $appointment->update([
            'schedule_at' => $request->shceduled_at,
            'memo' => $request->memo
        ]);

        return $appointment;
    }
}
