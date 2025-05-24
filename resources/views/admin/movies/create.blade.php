@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Добавить фильм</h1>

        @if (session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.movies.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="title" class="form-label"><b>Название фильма:</b></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                            id="title" value="{{ old('title') }}" required maxlength="140">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label"><b>Постер:</b> <span class="text-muted">(jpg/png, макс
                                4MB)</span></label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" name="image"
                            id="image" accept="image/jpeg,image/png">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label"><b>Описание:</b></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description"
                            rows="4" maxlength="8000">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="director" class="form-label"><b>Режиссёр:</b></label>
                            <input type="text" class="form-control @error('director') is-invalid @enderror"
                                name="director" id="director" value="{{ old('director') }}" maxlength="128">
                            @error('director')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="duration_minutes" class="form-label"><b>Длительность (мин.):</b></label>
                            <input type="number" class="form-control @error('duration_minutes') is-invalid @enderror"
                                name="duration_minutes" id="duration_minutes" value="{{ old('duration_minutes') }}"
                                min="1" max="999">
                            @error('duration_minutes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="release_date" class="form-label"><b>Дата выхода:</b></label>
                            <input type="date" class="form-control @error('release_date') is-invalid @enderror"
                                name="release_date" id="release_date" value="{{ old('release_date') }}">
                            @error('release_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="genre" class="form-label"><b>Жанр:</b></label>
                            <input type="text" class="form-control @error('genre') is-invalid @enderror" name="genre"
                                id="genre" value="{{ old('genre') }}" maxlength="100">
                            @error('genre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="country" class="form-label"><b>Страна:</b></label>
                            <input type="text" class="form-control @error('country') is-invalid @enderror" name="country"
                                id="country" value="{{ old('country') }}" maxlength="100">
                            @error('country')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('admin.movies.index') }}" class="btn btn-outline-secondary me-2">Отмена</a>
                        <button type="submit" class="btn btn-primary">Добавить фильм</button>
                    </div>
                </form>
            </div>
        </div>

        @if ($errors->any() && $errors->count() > 0)
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mt-3">
            <a href="{{ route('cabinet') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Вернуться в личный кабинет
            </a>
        </div>
    </div>
@endsection
