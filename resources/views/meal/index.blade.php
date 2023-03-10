<?php
declare(strict_types=1);

/**
 * @var \App\Models\Meal[] $meals
 */

?>
@extends('layouts.layout')

@section('content')
    <h1 class="text-center">Страви</h1>

    <div class="row">
        <div id="w0" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
            <div class="summary">
                Показані <b>
                    {{ ($meals->currentPage() - 1) * $meals->perPage() + 1 }}
                    -
                    @if($meals->currentPage() * $meals->perPage() < $meals->total())
                        {{ $meals->currentPage() * $meals->perPage() }}
                    @else
                        {{ $meals->total() }}
                    @endif
                </b> із <b>
                    {{ $meals->total() }}
                </b> записів.
            </div>
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th class="col-lg-1">
                        <a
                            class="@if ('id' === app('request')->query('sort'))
                                    asc
                                @elseif ('-id' === app('request')->query('sort'))
                                    desc
                                @endif"
                            href="{{ route('meals.index', ['sort' => ('id' === app('request')->query('sort') ? '-id' : 'id')]) }}"
                        >
                            ID
                        </a>
                    </th>
                    <th>
                        <a
                            class="@if ('name' === app('request')->query('sort'))
                                    asc
                                @elseif ('-name' === app('request')->query('sort'))
                                    desc
                                @endif"
                            href="{{ route('meals.index', ['sort' => ('name' === app('request')->query('sort') ? '-name' : 'name')]) }}"
                        >
                            Назва
                        </a>
                    </th>
                    <th class="col-lg-1">
                        Фаворит
                    </th>
                    <th class="col-lg-1">&nbsp;</th>
                </tr>
                <tr class="filters" data-url="{{ route('meals.index') }}">
                    <td>
                        <label for="filter-id" style="display: none;"></label>
                        <input id="filter-id" type="text" class="form-control" name="id"
                               value="{{ app('request')->query('id') }}">
                    </td>
                    <td>
                        <label for="filter-code" style="display: none;"></label>
                        <input id="filter-name" type="text" class="form-control" name="name"
                               value="{{ app('request')->query('name') }}">
                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                </thead>
                <tbody>
                @foreach ($meals as $meal)
                    <tr data-key="{{ $meal->id }}">
                        <td>{{ $meal->id }}</td>
                        <td>{{ $meal->name }} {{ $meal->is_ordered ? '' : ' (Нове)' }}</td>
                        <td>{{ $meal->is_favorite ? '+' : '' }}</td>
                        <td class="text-center">
                            <a href="{{ route('meals.show', ['meal' => $meal]) }}" title="Переглянути"
                               aria-label="Переглянути" data-pjax="0">
                                <svg aria-hidden="true"
                                     style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:1.125em"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                    <path fill="currentColor"
                                          d="M573 241C518 136 411 64 288 64S58 136 3 241a32 32 0 000 30c55 105 162 177 285 177s230-72 285-177a32 32 0 000-30zM288 400a144 144 0 11144-144 144 144 0 01-144 144zm0-240a95 95 0 00-25 4 48 48 0 01-67 67 96 96 0 1092-71z"></path>
                                </svg>
                            </a>
                            <a href="{{ route('meals.edit', ['meal' => $meal]) }}" title="Оновити"
                               aria-label="Оновити" data-pjax="0">
                                <svg aria-hidden="true"
                                     style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:1em"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <path fill="currentColor"
                                          d="M498 142l-46 46c-5 5-13 5-17 0L324 77c-5-5-5-12 0-17l46-46c19-19 49-19 68 0l60 60c19 19 19 49 0 68zm-214-42L22 362 0 484c-3 16 12 30 28 28l122-22 262-262c5-5 5-13 0-17L301 100c-4-5-12-5-17 0zM124 340c-5-6-5-14 0-20l154-154c6-5 14-5 20 0s5 14 0 20L144 340c-6 5-14 5-20 0zm-36 84h48v36l-64 12-32-31 12-65h36v48z"></path>
                                </svg>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <nav>
                <ul class="pagination">
                    <li class="page-item prev @if($meals->currentPage() - 1 < 1) disabled @endif">
                        <a class="page-link"
                           href="{{ route(Route::currentRouteName(), ['page' => $meals->currentPage() - 1]) }}">
                            <span aria-hidden="true">«</span>
                        </a>
                    </li>
                    @for ($i = $meals->currentPage() - 2; $i < $meals->currentPage() + 3; $i++)
                        @if ($i >= 1 && $i <= $meals->lastPage())
                            <li class="page-item @if($meals->currentPage() === $i) active @endif"
                                aria-current="page">
                                <a class="page-link" href="{{ route(Route::currentRouteName(), ['page' => $i]) }}">
                                    {{ $i }}
                                </a>
                            </li>
                        @endif
                    @endfor
                    <li class="page-item next @if($meals->currentPage() + 1 > $meals->lastPage()) disabled @endif">
                        <a class="page-link"
                           href="{{ route(Route::currentRouteName(), ['page' => $meals->currentPage() + 1]) }}">
                            <span aria-hidden="true">»</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
@endsection
