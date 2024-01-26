@extends('layouts.main')


@section('content')

<div class="container-lg" style="margin: 0 auto;">
    <h2 class="text-center mt-2">My bookings</h2>

    <table class="table table-hover">

        <thead>

            <tr>

            <th scope="col">Booking id</th>

            <th scope="col">Appointment id</th>

            <th scope="col">Department name</th>

            <th scope="col">Appointment date</th>

            <th>want to cancel ?</th>

            </tr>

        </thead>

        <tbody>

            @foreach($bookings as $booking)

            <tr>

                <th scope="col">{{$booking->id}}</th>

                <td>{{$booking->appointment_id}}</td>

                <td>{{$booking->department_name}}</td>

                <td>{{$booking->appointment_date}}</td>

                <td>
                <form method="POST" action="{{route('cancelBooking')}}">
                    @csrf
                    <input type="text" style="display:none; value="{{$booking->id}}" name="booking_id">
                    <input type="text" style="display:none; value="{{$booking->appointment_id}}" name="appointment_id">
                    <input type="submit" value="cancel" class="btn btn-primary"/>
                </form>
            </td>
               

            @endforeach

        </tbody>
    </table>
</div>
@endsection