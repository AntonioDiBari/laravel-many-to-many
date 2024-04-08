@extends('layouts.app')

@section('title', empty($technology->id) ? 'Add Technology' : 'Edit Technology')

@section('content')
    <div class="container my-4">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li> <br>
                    @endforeach
                </ul>
            </div>
        @endif
        <h1>{{ empty($technology->id) ? 'Add Technology' : 'Edit Technology' }}</h1>
        <form
            action="{{ empty($technology->id) ? route('admin.technologies.store') : route('admin.technologies.update', $technology) }}"
            method="POST">
            @csrf

            @if (!empty($technology->id))
                @method('PATCH')
            @endif
            <div class="row g-3">

                <div class="col-5">
                    <label for="name" class="form-label">Technology Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name') ?? $technology->name }}" {{-- required --}} />
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-2">
                    <label for="color" class="form-label">Technology Color</label>
                    <input type="color" class="form-control @error('color') is-invalid @enderror" id="color"
                        name="color" value="{{ old('color') ?? $technology->color }}" {{-- required --}} />
                    @error('color')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <button class="btn btn-secondary">{{ empty($technology->id) ? 'Add' : 'Edit' }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection
