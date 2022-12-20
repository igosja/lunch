<?php
declare(strict_types=1);

/**
 * @var array $menu
 */
?>
@extends('layouts.layout')

@section('content')
    <h1 class="text-center">Замовлення</h1>

    <div class="row">
        @for($i=0; $i<5; $i++)
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
                <table class="table table-bordered table-hover">
                    <tbody>
                    @foreach ($menu as $meal)
                        <tr>
                            <td>{{ $meal[$i] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endfor
    </div>

@endsection
