@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('title', 'Technology')

@section('content')
    <div class="container mt-3">
        <h1 class="my-3">Technology of Progets</h1>
        <div class="container alert-container">
            @if (session('message'))
                <div class="alert {{ session('type') }} alert-dismissible my-2">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
        <div class="row g-2">
            @forelse ($technologies as $technology)
                <div class="col-12">
                    <div class="card">
                        <div class="d-flex justify-content-between">
                            <ul class="mb-0 p-3">
                                <li>
                                    <a href="{{ route('admin.technologies.show', $technology) }}"
                                        class="fs-2 fw-bold text-secondary">{{ $technology->name }}</a>
                                </li>
                            </ul>
                            <div class="me-2 mt-2">
                                <a href="{{ route('admin.technologies.edit', $technology) }}" class="btn btn-link p-0">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <button type="button" class="btn btn-link text-danger p-0" data-bs-toggle="modal"
                                    data-bs-target="#delete-{{ $technology->id }}-technology">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                Nessun Tipo
            @endforelse
        </div>
        <div class="d-flex justify-content-between my-3">
            {{ $technologies->links() }}
            <a href="{{ route('admin.technologies.create') }}">Add a Technology</a>
        </div>
    </div>
@endsection

@section('modal')
    @foreach ($technologies as $technology)
        <div class="modal fade" id="delete-{{ $technology->id }}-technology" tabindex="-1"
            aria-labelledby="delete-{{ $technology->id }}-technology" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="delete-{{ $technology->id }}-technology">Eliminate
                            {{ $technology->name }}?
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Deleting this technology will delete the relationship with all the related projects with this
                        technology</b>.
                        Are you sure ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <form method="POST" action="{{ route('admin.technologies.destroy', $technology) }}"
                            class="mt-1">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
