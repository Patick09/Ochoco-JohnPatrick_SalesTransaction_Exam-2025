@extends('layout')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h2>Schedulers List</h2>
    <div>
        <a href="{{ route('dashboard') }}" class="btn btn-dark me-2">⬅ Back to Dashboard</a>
        <a href="{{ route('sales.index') }}" class="btn btn-secondary me-2">View Sales</a>
        <a href="{{ route('schedulers.create') }}" class="btn btn-primary">+ Add Scheduler</a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success mb-3">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <tr>
        <th>Name</th>
        <th>Event</th>
        <th>Actions</th>
    </tr>
    @foreach($schedulers as $scheduler)
    <tr>
        <td>{{ $scheduler->name }}</td>
        <td>{{ $scheduler->event }}</td>
        <td>
            <a href="{{ route('schedulers.edit', $scheduler) }}" class="btn btn-sm btn-warning">Edit</a>
            <form action="{{ route('schedulers.destroy', $scheduler) }}" method="POST" class="d-inline">
                @csrf 
                @method('DELETE')
                <button type="submit" onclick="return confirm('Delete this scheduler?')" class="btn btn-sm btn-danger">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection
