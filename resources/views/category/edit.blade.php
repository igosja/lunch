<?php
declare(strict_types=1);

/**
 * @var \App\Models\Category $category
 */

?>
@extends('layouts.layout')

@section('content')
    <h1 class="text-center">Змінити категорію</h1>
    <ul class="list-inline text-center">
        <li class="list-inline-item">
            <a class="btn btn-default" href="{{ route('categories.index') }}">Список</a>
        </li>
        <li class="list-inline-item">
            <a class="btn btn-default" href="{{ route('categories.show', ['category' => $category]) }}">Перегляд</a>
        </li>
    </ul>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <form method="POST" action="{{ route('categories.update', ['category' => $category]) }}">
                @csrf
                @method('PUT')
                <div class="mb-3 required">
                    <label class="form-label" for="name">Назва</label>
                    <input id="name" class="form-control @error('name') is-invalid @enderror" name="name"
                           value="{{ old('name', $category->name) }}"/>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <div class="form-check">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" id="is_active"
                               class="form-check-input @error('is_active') is-invalid @enderror" name="is_active"
                               @checked(old('is_active', $category->is_active))
                               value="1">
                        <label class="form-check-label" for="is_active">Is active</label>
                        @error('is_active')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                        <button type="submit" class="btn btn-default">Зберегти</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
