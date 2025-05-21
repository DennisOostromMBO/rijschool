@extends('layouts.app')

@section('content')
<div class=" text-center">
    <h1>Cars Overview</h1>
    <table class="table table-bordered text-center table-striped table-hover align-middle">
        <thead>
            <tr>
                <th>Brand</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($cars as $car)
                <tr>
                    <td>
                        <a href="{{ route('cars.show', $car->id) }}">{{ $car->brand }}</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="1" class="text-center text-muted">No cars found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $cars->links() }}
</div>
@endsection
