@extends('layouts.apex')
@section('title',"Project")
@section('content')

<section id="basic-form-layouts">
    <div class="row">
        <div class="col-sm-12">
            <div class="content-header"> Project</div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ url('/projects') }}" title="Back">
                        <button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button>
                    </a>
                </div>
                <div class="card-body">
                    <div class="px-3">
                        <div class="box-content ">
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr>
                                                <td>ID</td>
                                                <td>{{ $item->id }}</td>
                                            </tr>
                                            <tr>
                                                <td>Name</td>
                                                <td> {{ $item->name }} </td>
                                            </tr>
                                            <tr>
                                                <td>Status</td>
                                                <td> {{ $item->status }} </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection