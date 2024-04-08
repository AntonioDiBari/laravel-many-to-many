@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('title', 'Type Detail')

@section('content')
    <div class="container">
        <div class="row mt-3 g-3">
            <div class="col-12">
                <div class="card bg-dark-subtle p-3">
                    <h2 style="color:{{ $type->color }}">{{ $type->name }}</h2>
                </div>
            </div>
            <div class="col-12">
                <div class="card bg-secondary-subtle p-3">
                    <span class="mb-2 subtitle">Abstract of {{ $type->name }}:</span>
                    <p>{{ $type->abstract }}</p>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end my-4">
            <a href="{{ route('admin.types.index') }}">
                <i class="fa-regular fa-circle-left"></i> Back to Types
            </a>
        </div>
        <h4>Related Projects</h4>
        <table class="table">
            <thead>
                <th>ID</th>
                <th>Name</th>
                <th></th>
            </thead>
            <tbody>
                @foreach ($related_projects as $project)
                    <tr>
                        <td>{{ $project->id }}</td>
                        <td><a href="{{ route('admin.projects.show', $project) }}">{{ $project->name }}</a></td>
                        <td>
                            <a href="{{ route('admin.projects.edit', $project) }}">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.projects.destroy', $project) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-link text-danger p-0"><i class="fa-solid fa-trash-can"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>{{ $related_projects->links() }}</div>
    </div>
@endsection
