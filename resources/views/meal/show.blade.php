<?php
declare(strict_types=1);

/**
 * @var \App\Models\Meal $meal
 */

?>
@extends('layouts.layout')

@section('content')
    <h1 class="text-center" id="header">{{ $meal->name }}</h1>
    <ul class="list-inline text-center">
        <li class="list-inline-item">
            <a class="btn btn-default" href="{{ route('meals.index') }}">Список</a>
        </li>
        <li class="list-inline-item">
            <a class="btn btn-default" href="{{ route('meals.edit', ['meal' => $meal]) }}">Змінити</a>
        </li>
    </ul>
    <div class="row">
        <table class="table table-striped table-bordered detail-view" aria-describedby="header">
            <tbody>
            <tr>
                <th>Id</th>
                <td>{{ $meal->id }}</td>
            </tr>
            <tr>
                <th>Назва</th>
                <td>{{ $meal->name }}</td>
            </tr>
            <tr>
                <th>Активність</th>
                <td>{{ $meal->is_active }}</td>
            </tr>
            <tr>
                <th>Замовляв</th>
                <td>{{ $meal->is_ordered }}</td>
            </tr>
            <tr>
                <th>Сподобалось</th>
                <td>{{ $meal->is_favorite }}</td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection
