@extends('layout.app')

@section('content')
    <div class="header animate-fade">
        <div>
            <h1 class="page-title">Edit Category</h1>
        </div>
        <a href="{{ route('categories.index') }}" class="btn"
            style="background: white; border: 1px solid var(--border);">Cancel</a>
    </div>

    <div class="card animate-fade" style="max-width: 500px; margin: 0 auto;">
        <form action="{{ route('categories.update', $category->id) }}" method="POST">
            @csrf @method('PUT')
            <label>Category Name</label>
            <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
            <button class="btn btn-primary" style="width: 100%; justify-content: center; margin-top: 1rem;">Update</button>
        </form>
    </div>
@endsection