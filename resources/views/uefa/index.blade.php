<?php
declare(strict_types=1);

/**
 * @var array $data
 */
?>
@extends('layouts.layout')

@section('content')
    <h1 class="text-center" id="header">UEFA</h1>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
            <table class="table table-bordered table-hover" aria-describedby="header">
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Country</th>
                    <th class="text-center">Points</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($data as $key => $value)
                    <tr>
                        <td class="text-center">{{ $key + 1 }}</td>
                        <td>{{ $value[0] }}</td>
                        <td class="text-right">{{ $value[1] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
