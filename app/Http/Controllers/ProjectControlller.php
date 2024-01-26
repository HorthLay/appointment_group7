<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Department;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Support\Facades\Session;

class ProjectControlller extends Controller
{
    public function getData(Request $request)
    {
        $data = "";
        return view('index', ['key' => $data]);
    }
    public function getAllDepartments(Request $request)
    {
        $department = Department::all();
        return view('index', ['departments' => $department]);
    }

    public function showAppointment(Request $request)
    {
        $department_id = $request->input('department_id');
        $appointments = Appointment::where('department_id', $department_id)->get();
        return \view('appointments', ['appointments' => $appointments]);
    }
    public function bookAppointment(Request $request)
    {
        $appointment_id = $request->input('appointment_id'); // Fix the typo here
        $department_name = $request->input('department_name');
        $appointment_date = $request->input('appointment_date');

        $exists = Booking::where('appointment_id', '=', $appointment_id)->exists(); // Fix the typo here

        if ($exists) {
            Session::flash('message', 'Appointment was already Taken');
            Session::flash('alert-class', 'alert-danger');
            return redirect('/');
        } else {
            $booking = new Booking;
            $booking->appointment_id = $appointment_id;
            $booking->department_name = $department_name;
            $booking->appointment_date = $appointment_date;
            $booking->username = Auth::user()->name;
            $booking->user_id = Auth::user()->id;

            $booking->save();
            ////

            Appointment::where('id', $appointment_id)->update(['taken' => 1]);

            Session::flash('message', 'Appointment was successfully'); // Fix the typo here
            Session::flash('alert-class', 'alert-success'); // Fix the typo here
            return redirect('/');
        }
    }
    public function myBookings(Request $request)
    {
        $bookings = Booking::where('user_id', Auth::user()->id)->get();
        return view('myBookings', ['bookings' => $bookings]);
    }
    public function cancelBooking(Request $request)
    {
        $bookings_id = $request->input('booking_id');
        $appointment_id = $request->input('appointment_id');

        Booking::where('id', $bookings_id)->delete();
        Appointment::where('id', $appointment_id)->update(['taken' => 0]);
        Session::flash('message', 'Appointment cancel succesfully'); // Fix the typo here
        Session::flash('alert-class', 'alert-success'); // Fix the typo here
        return redirect('/');
    }
}
