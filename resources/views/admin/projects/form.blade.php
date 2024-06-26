{{-- NUOVO FORM DI CREAZIONE E MODIFICA UNIFICATO 
    (passandoci il nuovo El anche nella create e verificando la 
    presenza o meno dell'ID) --}}


@extends('layouts.app')

@section('title', empty($project->id) ? 'Add Project' : 'Edit Project')

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
        <h1>{{ empty($project->id) ? 'Add Project' : 'Edit Project' }}</h1>
        <form action="{{ empty($project->id) ? route('admin.projects.store') : route('admin.projects.update', $project) }}"
            method="POST" enctype="multipart/form-data">
            @csrf

            @if (!empty($project->id))
                @method('PATCH')
            @endif

            <div class="row">
                <div class="col-10">
                    <div class="row">
                        <div class="col-5">
                            <label for="name" class="form-label">Project Title</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') ?? $project->name }}" {{-- required --}} />
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-5">
                            <label for="author" class="form-label">Author</label>
                            <input type="text" class="form-control @error('author') is-invalid @enderror" id="author"
                                name="author" value="{{ old('author') ?? $project->author }}" {{-- required --}} />
                            @error('author')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5">
                            <label for="link_github" class="form-label">Link Github</label>
                            <input type="text" class="form-control @error('link_github') is-invalid @enderror"
                                id="link_github" name="link_github"
                                value="{{ old('link_github') ?? $project->link_github }}" {{-- required --}} />
                            @error('link_github')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-5">
                            <label for="type_id" class="form-label">Type</label>
                            <select name="type_id" id="type_id"
                                class="form-select  @error('type_id') is-invalid @enderror">
                                <option value="" class="d-none">Select a type</option>
                                @foreach ($types as $type)
                                    <option {{ old('type_id', $project->type_id) == $type->id ? 'selected' : '' }}
                                        value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                            @error('type_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-10 my-3">
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                            rows="4" placeholder="Insert project's description">{{ old('description') ?? $project->description }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-8">
                        <section class="mb-4 d-flex gap-3">
                            <div>
                                <label for="image" class="form-label">Image for the project</label>
                                <input class="form-control @error('image') is-invalid @enderror" type="file"
                                    name="image" id="image">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            @if (isset($project->image))
                                <div>
                                    <label clas="form-label">Previus image</label>
                                    <img src="{{ asset('storage/' . $project->image) }}" alt=""
                                        class="image_project">
                                </div>
                            @endif
                        </section>
                    </div>
                </div>
                <div class="col-2">
                    @foreach ($technologies as $technology)
                        <input type="checkbox" id="technologies-{{ $technology->id }}" name="technologies[]"
                            value="{{ $technology->id }}"
                            class="form-check-input @error('technologies') is-invalid @enderror"
                            {{ in_array($technology->id, old('technologies', $project->technologies->pluck('id')->toArray())) ? 'checked' : '' }}>
                        {{-- Funzione che controlla e salva in caso di edit o create le checbox --}}
                        <label for="technologies-{{ $technology->id }}"
                            class="form-check-label">{{ $technology->name }}</label><br>
                    @endforeach
                    @error('technologies')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-3">
                    <button class="btn btn-secondary">{{ empty($project->id) ? 'Add' : 'Edit' }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection
