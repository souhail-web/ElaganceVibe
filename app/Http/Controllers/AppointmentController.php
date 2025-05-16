<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with(['client', 'employee', 'service']);

        if ($request->has('search')) {
            $search = $request->input('search');

            $query->whereHas('client', function ($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                  ->orWhere('last_name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            })->orWhereHas('service', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            });
        }

        $appointments = $query->orderBy('date', 'desc')->paginate(5);
        
        $total = Appointment::count();
        $upcoming = Appointment::where('date', '>', now())->count();
        $today = Appointment::whereDate('date', today())->count();
        $confirmedCount = Appointment::where('status', 'confirmed')->count();
        $cancelledCount = Appointment::where('status', 'cancelled')->count();
        $pendingCount = Appointment::where('status', 'pending')->count();

        return view('admin.appointment.appointment', compact(
            'appointments', 'total', 'upcoming', 'today',
            'confirmedCount', 'cancelledCount', 'pendingCount'
        ));

    }

    public function edit($id)
    {
        $appointment = Appointment::findOrFail($id);
        $clients = User::where('usertype', 'client')->get();
        $employees = User::where('usertype', 'employee')->get();
        $services = Service::all();

        return view('admin.appointment.edit', compact('appointment', 'clients', 'employees', 'services'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'client_id' => 'required|exists:users,id',
            'employee_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        Appointment::findOrFail($id)->update($data);

        return redirect()->route('admin.appointment.appointment')->with('success', 'Rendez-vous mis à jour avec succès.');
    }

    public function destroy($id)
    {
        Appointment::findOrFail($id)->delete();

        return redirect()->route('admin.appointment.appointment')->with('success', 'Rendez-vous supprimé avec succès.');
    }
}
