@extends('layouts.app')

@section('content')
<div class="text-center">
    <h1 class="mb-4">Packages Overview</h1>

    {{-- Success and Error Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Packages Table --}}
    <div class="table-responsive shadow-sm rounded mx-auto" style="max-width: 90%;">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr class="text-center">
                    <th>Naam</th>
                    <th>aantal lessen</th>
                    <th>Prijs</th>
                    <th>extra</th>
                </tr>
            </thead>
            <tbody>
                @forelse($packages as $package)
                    <tr class="text-center">
                        <td>{{ $package->type }}</td>
                        <td>{{ $package->lesson_count }}</td>
                        <td>{{ $package->price_per_lesson }}</td>
                        <td>
                            <a href="{{ route('packages.edit', $package) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('packages.destroy', $package) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted">No packages found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $packages->links() }}
    </div>
</div>
@endsection
