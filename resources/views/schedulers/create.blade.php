@extends('layout')

@section('content')
<h2>Add Scheduler</h2>

<form action="{{ route('schedulers.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Scheduler Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="event" class="form-label">Event</label>
        <textarea name="event" class="form-control"></textarea>
    </div>

    <button type="submit" class="btn btn-success">Save</button>
    <a href="{{ route('schedulers.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
