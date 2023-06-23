<?php
declare(strict_types=1);

/**
 * @var \App\Models\Category[] $categories
 * @var \App\Models\Meal $meal
 */

?>
@extends('layouts.layout')

@section('content')
    <h1 class="text-center">Змінити страву</h1>
    <ul class="list-inline text-center">
        <li class="list-inline-item">
            <a class="btn btn-default" href="{{ route('meals.index') }}">Список</a>
        </li>
        <li class="list-inline-item">
            <a class="btn btn-default" href="{{ route('meals.show', ['meal' => $meal]) }}">Перегляд</a>
        </li>
    </ul>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <form method="POST" action="{{ route('meals.update', ['meal' => $meal]) }}">
                @csrf
                @method('PUT')
                <div class="mb-3 required">
                    <label class="form-label" for="name">Назва</label>
                    <input id="name" class="form-control @error('name') is-invalid @enderror" name="name"
                           value="{{ old('name', $meal->name) }}"/>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 required">
                    <label class="form-label" for="category_id">Category</label>
                    <select id="category_id" class="form-control @error('category_id') is-invalid @enderror"
                            name="category_id">
                        @foreach($categories as $category)
                            <option
                                value="{{ $category->id }}"
                                @selected(old('category_id', $meal->category_id) === $category->id)
                            >
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <div class="form-check">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" id="is_active"
                               class="form-check-input @error('is_active') is-invalid @enderror" name="is_active"
                               @checked(old('is_active', $meal->is_active))
                               value="1">
                        <label class="form-check-label" for="is_active">Активність</label>
                        @error('is_active')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-check">
                        <input type="hidden" name="is_ordered" value="0">
                        <input type="checkbox" id="is_ordered"
                               class="form-check-input @error('is_ordered') is-invalid @enderror" name="is_ordered"
                               @checked(old('is_ordered', $meal->is_ordered))
                               value="1">
                        <label class="form-check-label" for="is_ordered">Замовляв</label>
                        @error('is_ordered')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-check">
                        <input type="hidden" name="is_favorite" value="0">
                        <input type="checkbox" id="is_favorite"
                               class="form-check-input @error('is_favorite') is-invalid @enderror" name="is_favorite"
                               @checked(old('is_favorite', $meal->is_favorite))
                               value="1">
                        <label class="form-check-label" for="is_favorite">Фаворит</label>
                        @error('is_favorite')
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
