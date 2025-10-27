@extends('layout')

@section('content')
<h2>Edit Scheduler</h2>

<form action="{{ route('schedulers.update', $scheduler) }}" method="POST">
    @csrf @method('PUT')

    <div class="mb-3">
        <label for="name" class="form-label">Scheduler Name</label>
        <input type="text" name="name" class="form-control" value="{{ $scheduler->name }}" required>
    </div>

    <div class="mb-3">
        <label for="event" class="form-label">Event</label>
        <textarea name="event" class="form-control">{{ $scheduler->event }}</textarea>
    </div>

    <button type="submit" class="btn btn-success">Update</button>
    <a href="{{ route('schedulers.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
