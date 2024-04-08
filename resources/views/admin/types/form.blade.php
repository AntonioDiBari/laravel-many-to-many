@extends('layouts.app')

@section('title', empty($type->id) ? 'Add Type' : 'Edit Type')

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
        <h1>{{ empty($type->id) ? 'Add Type' : 'Edit Type' }}</h1>
        <form action="{{ empty($type->id) ? route('admin.types.store') : route('admin.types.update', $type) }}"
            method="POST">
            @csrf

            @if (!empty($type->id))
                @method('PATCH')
            @endif
            <div class="row g-3">

                <div class="col-5">
                    <label for="name" class="form-label">Type Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name') ?? $type->name }}" {{-- required --}} />
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-5">
                    <label for="abstract" class="form-label">Type Abstract</label>
                    <input type="text" class="form-control @error('abstract') is-invalid @enderror" id="abstract"
                        name="abstract" value="{{ old('abstract') ?? $type->abstract }}" {{-- required --}} />
                    @error('abstract')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-1">
                    <label for="color" class="form-label">Type Color</label>
                    <input type="color" class="form-control @error('color') is-invalid @enderror" id="color"
                        name="color" value="{{ old('color') ?? $type->color }}" {{-- required --}} />
                    @error('color')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-3">
                    <button class="btn btn-secondary">{{ empty($type->id) ? 'Add' : 'Edit' }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection
