<?php
declare(strict_types=1);

/**
 * @var \App\Models\Category $category
 */

?>
@extends('layouts.layout')

@section('content')
    <h1 class="text-center">{{ $category->name }}</h1>
    <ul class="list-inline text-center">
        <li class="list-inline-item">
            <a class="btn btn-default" href="{{ route('categories.index') }}">Список</a>
        </li>
        <li class="list-inline-item">
            <a class="btn btn-default" href="{{ route('categories.edit', ['category' => $category]) }}">Змінити</a>
        </li>
    </ul>
    <div class="row">
        <table class="table table-striped table-bordered detail-view">
            <tbody>
            <tr>
                <td>Id</td>
                <td>{{ $category->id }}</td>
            </tr>
            <tr>
                <td>Назва</td>
                <td>{{ $category->name }}</td>
            </tr>
            <tr>
                <td>Активність</td>
                <td>{{ $category->is_active }}</td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection
