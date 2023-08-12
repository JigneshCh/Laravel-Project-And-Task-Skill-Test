@extends('layouts.apex')
@section('title',"Projects")
@section('content')

<section id="basic-form-layouts">
    <div class="row">
        <div class="col-sm-12">
            <div class="content-header"> Projects # {{$item->name}} </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ url('/projects') }}" title="Back">
                        <button class="btn-link-back"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back
                        </button>
                    </a>
                </div>
                <div class="card-body">
                    <div class="px-3">
                        @if ($errors->any())
                        <ul class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        @endif
                        {!! Form::model($item, [
                        'method' => 'PATCH',
                        'url' => ['/projects', $item->id],
                        'class' => 'form-horizontal',
                        'files' => true,
                        'autocomplete'=>'off'
                        ]) !!}
                        @include ('projects.form', ['submitButtonText' => "Update"])
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection