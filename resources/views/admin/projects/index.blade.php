@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')
    <div class="container mt-3">
        <div class="container alert-container">
            @if (session('message'))
                <div class="alert {{ session('type') }} alert-dismissible my-2">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
        <div class="row g-2">
            @forelse ($projects as $project)
                <div class="col-12">
                    <div class="card">
                        <div class="d-flex justify-content-between">
                            <ul class="mb-0 p-3">
                                <li>
                                    <a href="{{ route('admin.projects.show', $project) }}"
                                        class="fs-2 fw-bold text-secondary">{{ $project->name }}</a>
                                </li>
                                <li>
                                    <a href="#" class="text-secondary-emphasis">{{ $project->link_github }}</a>
                                </li>
                                <li>
                                    <b>Tipo progetto: </b> <span class="badge"
                                        style="background-color:{{ $project->type->color }}">{{ $project->type->name }}</span>
                                </li>


                            </ul>
                            <div class="me-2 mt-2">
                                <a href="{{ route('admin.projects.edit', $project) }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.projects.destroy', $project) }}"
                                    class="mt-1">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-link text-danger p-0"><i
                                            class="fa-solid fa-trash-can"></i></button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            @empty
                Nessun Progetto
            @endforelse
        </div>
        <div class="d-flex justify-content-between my-3">{{ $projects->links() }}
            <a href="{{ route('admin.projects.create') }}">Add a Project</a>
        </div>
    </div>
@endsection
