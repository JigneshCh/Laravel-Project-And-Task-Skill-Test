<div class="row ">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
            <label for="name" class="">
                <span class="field_compulsory">*</span>Name
            </label>
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
            {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group {{ $errors->has('content') ? 'has-error' : ''}}">
            <label for="content" class="">
                <span class="field_compulsory">*</span>Description
            </label>
            {!! Form::text('content', null, ['class' => 'form-control']) !!}
            {!! $errors->first('content', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group {{ $errors->has('project_id') ? 'has-error' : ''}}">
            {!! Form::label('project_id', 'Projects', ['class' => '']) !!}
            {!! Form::select('project_id',$projects, null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::submit(isset($submitButtonText) ? $submitButtonText : "Create", ['class' => 'btn btn-primary']) !!}
            {{ Form::reset("Reset", ['class' => 'btn btn-light']) }}
        </div>
    </div>
</div>