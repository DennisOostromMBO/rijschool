@extends('layouts.app')

@section('content')
<div class="">
    <h1>Car Details</h1>
    <table class="table table-bordered">
        <tr>
            <th>Brand</th>
            <td>{{ $car->brand }}</td>
        </tr>
        <tr>
            <th>Type</th>
            <td>{{ $car->type }}</td>
        </tr>
        <tr>
            <th>License Plate</th>
            <td>{{ $car->license_plate }}</td>
        </tr>
        <tr>
            <th>Fuel</th>
            <td>{{ $car->fuel }}</td>
        </tr>
        <tr>
            <th>Remarks</th>
            <td>{{ $car->remark }}</td>
        </tr>
        <tr>
            <th>Active</th>
            <td>{{ $car->is_active ? 'Yes' : 'No' }}</td>
        </tr>
    </table>
    <a href="{{ route('cars.index') }}" class="btn btn-primary">Back to Overview</a>
</div>
@endsection
