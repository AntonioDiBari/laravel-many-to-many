@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('title', 'Project Detail')

@section('content')
    <div class="container">
        <div class="row mt-3 g-3">
            <div class="col-12">
                <div class="card bg-dark-subtle p-3">
                    <h2>{{ $project->name }}</h2>
                    <span class="fst-italic">{{ $project->author }}</span>
                </div>
            </div>
            <div class="col-12">
                <div class="card bg-secondary-subtle p-3">
                    <span class="mb-2 subtitle">Description of the project:</span>
                    <p>{{ $project->description }}</p>
                    <b>Tipo progetto: </b>
                    <div class="mx-1">
                        <span class="badge"
                            style="background-color:{{ $project->type->color }} ">{{ $project->type->name }}</span>
                    </div>
                    <b>Tecnologie usate: </b>
                    <div class="mx-1">
                        @foreach ($project->technologies as $technology)
                            <span class="badge"
                                style="background-color:{{ $technology->color }} ">{{ $technology->name }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
            @if (isset($project->image))
                <div class="col-4">
                    <div class="card">
                        <img src="{{ asset('storage/' . $project->image) }}" alt="" class="image_project">
                    </div>
                </div>
            @endif
        </div>
        <div class="d-flex justify-content-end my-4">
            <a href="{{ route('admin.projects.index') }}">
                <i class="fa-regular fa-circle-left"></i> Back to Projects
            </a>
        </div>
    </div>
@endsection
