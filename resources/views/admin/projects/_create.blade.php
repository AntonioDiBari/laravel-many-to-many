{{-- VECCHIO FORM DI CREAZIONE --}}

@extends('layouts.app')

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
        <form action="{{ route('admin.projects.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-5">
                    <label for="name" class="form-label">Project Title</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name') }}" {{-- required --}} />
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-5">
                    <label for="author" class="form-label">Author</label>
                    <input type="text" class="form-control @error('author') is-invalid @enderror" id="author"
                        name="author" value="{{ old('author') }}" {{-- required --}} />
                    @error('author')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-5">
                    <label for="link_github" class="form-label">Link Github</label>
                    <input type="text" class="form-control @error('link_github') is-invalid @enderror" id="link_github"
                        name="link_github" value="{{ old('link_github') }}" {{-- required --}} />
                    @error('link_github')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12">
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                        rows="4" placeholder="Insert project's description">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-3">
                    <button class="btn btn-secondary">Add Project</button>
                </div>
            </div>
        </form>
    </div>
@endsection
