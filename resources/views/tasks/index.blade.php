@extends('layouts.apex')
@section('title',"Tasks")

@push('css')
<link href="{!! asset('apex/vendors/css/dragula.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
@endpush

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="content-header"> Tasks </div>
    </div>
</div>
<section id="configuration">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-3">
                            <div class="actions pull-left">
                                <a href="{{ url('/tasks/create') }}" class="btn btn-success btn-sm" title="Add New">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Add Task
                                </a>
                                <a href="{{ url('/projects/create') }}" class="btn btn-success btn-sm" title="Add New">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Add Project
                                </a>
                            </div>
                        </div>
                        <div class="col-6"></div>
                        <div class="col-3">
                            <div class="form-group">
                                {!! Form::select('filter',$filters, app('request')->input('project_id'), ['class' => 'form-control full-width filter','id'=>'filter_project_id']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body collapse show">
                    <div class="row match-height">
                        <div class="col-lg-12 col-xl-12">
                            <div id="accordionWrap1" role="tablist" aria-multiselectable="true">
                                <div class="card collapse-icon accordion-icon-rotate">
                                    @foreach($projects as $item)
                                    <div id="heading{{$item->id}}" class="card-header">
                                        <a href="{{ url('/projects/' . $item->id) }}" title="View">
                                            <span class="text-warning" id="project_{{$item->id}}"> {{$item->name}} </span>
                                        </a>
                                    </div>
                                    <div class="tasks">
                                        <div class="card-body">
                                            <div class="card-block">
                                                <table class="table table-bordered">
                                                    <tbody id="basic-list-group-{{$item->id}}">
                                                        @foreach($item->tasks as $task)
                                                        <tr class="draggable" data-projectid="{{$task->project_id}}" data-taskid="{{$task->id}}">
                                                            <td class="width-80" id="tasks_{{$task->id}}">
                                                                <i class="text-success"><span class="text-warning">{{$task->priority}} </span> {{$task->name}}</i> | {{$task->created}}
                                                            </td>
                                                            <td class="width-20">
                                                                <a href="{{ url('/tasks/' . $task->id) }}" class="btn btn-info btn-xs ipad-mb10" title="View">
                                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                                </a>
                                                                <a href="{{ url('/tasks/' . $task->id . '/edit') }}" class="btn btn-primary btn-xs ipad-mb10" title="Edit">
                                                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                                </a>
                                                                {!! Form::open([
                                                                'method' => 'DELETE',
                                                                'url' => ['/tasks', $task->id],
                                                                'style' => 'display:inline'
                                                                ]) !!}
                                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> ', array(
                                                                'type' => 'submit',
                                                                'class' => 'btn btn-danger btn-xs',
                                                                'title' => 'Delete',
                                                                'onclick'=>"return confirm('Are you sure! You want to delete this Task?')"
                                                                )) !!}
                                                                {!! Form::close() !!}
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
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

@push('js')
<script src="{!! asset('apex/vendors/js/dragula.min.js') !!}" type="text/javascript"></script>

<script>
    $(document).ready(function() {
        @foreach($projects as $items)

        var drake = dragula([document.getElementById('basic-list-group-{{$items->id}}')]);
        drake.on('drop', function(el, target, source, sibling) {
            var projectid = $(el).attr('data-projectid');
            resetorder(projectid);
        });

        @endforeach

        function resetorder(projectid) {
            var neworder = 0;
            var ob = [];
            $('#basic-list-group-' + projectid).children('tr').each(function() {
                neworder++;
                var id = $(this).attr('data-taskid');
                ob.push({
                    id: id,
                    priority: neworder
                });
            });

            $.ajax({
                type: "POST",
                url: "{{ url('tasks/reset-priority') }}",
                data: {
                    projectid: projectid,
                    dataarray: ob
                },
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                }
            }).done(function(data) {
                toastr.success('Action Success!', data.message);
            });
        }
    });
</script>

<script>
    $('#filter_project_id').change(function() {
        window.location.href = "{{ url('tasks') }}?project_id=" + $('#filter_project_id').val();
    });
</script>

@endpush