@extends('admin.layout')
@section('title','Admin Profile')
@section('content')

<div class="card p-3" style="max-width:500px; margin:auto;">
    <h4>Admin Profile</h4>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
        @csrf

        {{-- Avatar --}}
     
      

        {{-- Name --}}
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{ $admin->name }}" class="form-control" required>
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="{{ $admin->email }}" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
</div>

@endsection
