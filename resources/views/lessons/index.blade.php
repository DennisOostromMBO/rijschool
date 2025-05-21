{{-- filepath: c:\school2024-05\Project\rijschool\resources\views\lessons\index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class=" text-center">
    <h1 class="mb-4">Lesson Overview</h1>

    {{-- Success and Error Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-inline-block text-start" role="alert">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show d-inline-block text-start" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Filter Form --}}
    {{-- <div class="d-flex justify-content-center mb-4">
        <form action="{{ route('lessons.index') }}" method="GET" class="d-flex gap-3 align-items-end">
            <div>
                <label for="status" class="form-label text-start d-block">Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="">All</option>
                    <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    <option value="no_show" {{ request('status') == 'no_show' ? 'selected' : '' }}>No Show</option>
                </select>
            </div>
            <div>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-funnel-fill"></i> Filter
                </button>
            </div>
        </form>
    </div> 

    {{-- Lessons Table --}}
    <div class="d-flex justify-content-center">
        <div class="table-responsive shadow-sm rounded mx-auto" style="max-width: 90%;">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Student</th>
                        <th>rij instructeur</th>
                        <th>auto</th>
                        <th>datum les</th>
                        <th>Status</th>
                        <th>Goal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lessons as $lesson)
                        <tr>
                            <td>{{ $lesson->student_name }}</td>
                            <td>{{ $lesson->instructor_name }}</td>
                            <td>{{ $lesson->car_license_plate }}</td>
                            <td>{{ $lesson->lesson_date }}</td>
                            <td>{{ ucfirst($lesson->lesson_status) }}</td>
                            <td>{{ $lesson->lesson_goal }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">No lessons found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
