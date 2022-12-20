<?php
declare(strict_types=1);

/**
 * @var \App\Models\Meal $meal
 */

?>
@extends('layouts.layout')

@section('content')
    <h1 class="text-center">{{ $meal->name }}</h1>
    <ul class="list-inline text-center">
        <li class="list-inline-item">
            <a class="btn btn-default" href="{{ route('meals.index') }}">Список</a>
        </li>
        <li class="list-inline-item">
            <a class="btn btn-default" href="{{ route('meals.edit', ['meal' => $meal]) }}">Змінити</a>
        </li>
    </ul>
    <div class="row">
        <table class="table table-striped table-bordered detail-view">
            <tbody>
            <tr>
                <td>Id</td>
                <td>{{ $meal->id }}</td>
            </tr>
            <tr>
                <td>Назва</td>
                <td>{{ $meal->name }}</td>
            </tr>
            <tr>
                <td>Активність</td>
                <td>{{ $meal->is_active }}</td>
            </tr>
            <tr>
                <td>Замовляв</td>
                <td>{{ $meal->is_ordered }}</td>
            </tr>
            <tr>
                <td>Сподобалось</td>
                <td>{{ $meal->is_favorite }}</td>
            </tr>
            <tr>
                <td>Не підходить</td>
                <td>{{ $meal->is_unsuitable }}</td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection
