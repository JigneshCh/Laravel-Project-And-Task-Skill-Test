@extends('layouts.apex')
@section('title',"Projects")
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="content-header"> Projects </div>
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
                                <a href="{{ url('/projects/create') }}" class="btn btn-success btn-sm" title="Add New">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Add New
                                </a>
                            </div>
                        </div>
                        <div class="col-6"></div>
                        <div class="col-3">
                            <div class="form-group">
                                <select class="full-width filter form-control" id="filter_status" name="filter">
                                    <option value="">All</option>
                                    <option value="active" selected>Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body collapse show">
                    <div class="card-block card-dashboard">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped datatable responsive">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('js')
<script>
    var url = "{{url('projects')}}";
    datatable = $('.datatable').dataTable({
        pagingType: "full_numbers",
        processing: true,
        serverSide: true,
        autoWidth: false,
        stateSave: false,
        order: [1, "asc"],
        columns: [{
                "data": "id",
                "name": "id",
                "searchable": false,
                "width": "8%"
            },
            {
                "data": null,
                "name": "name",
                "searchable": true,
                "orderable": true,
                "render": function(o) {
                    return o.name;
                }
            },
            {
                "data": "status",
                "name": "status",
                "width": "20%"
            },
            {
                "data": null,
                "searchable": false,
                "orderable": false,
                "width": "4%",
                "render": function(o) {
                    var e = "";
                    var d = "";
                    var v = "";
                    e = " <a href='" + url + "/" + o.id + "/edit' data-id=" + o.id + " title='@lang('tooltip.common.icon.edit')'><i class='fa fa-edit action_icon'></i></a>";
                    d = " <a href='javascript:void(0);' class='del-item' data-id=" + o.id + " title='@lang('tooltip.common.icon.delete')' ><i class='fa fa-trash action_icon '></i></a>";
                    v = " <a href='" + url + "/" + o.id + "' data-id=" + o.id + " title='@lang('tooltip.common.icon.eye')'><i class='fa fa-eye' aria-hidden='true'></i></a>";
                    return v + d + e;

                }
            }

        ],
        fnRowCallback: function(nRow, aData, iDisplayIndex) {
            $('td', nRow).attr('nowrap', 'nowrap');
            return nRow;
        },
        ajax: {
            url: "{{ url('projects/datatable') }}", 
            type: "get", 
            data: function(d) {
                d.status = $('#filter_status').val();
            }
        }
    });

    $('.filter').change(function() {
        datatable.fnDraw();
    });

    $(document).on('click', '.del-item', function(e) {
        var id = $(this).attr('data-id');
        var r = confirm("Are you sure! you want to delete this item?");
        if (r == true) {
            $.ajax({
                type: "DELETE",
                url: url + "/" + id,
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                success: function(data) {
                    datatable.fnDraw();
                    toastr.success('Action Success!', data.message)
                },
                error: function(xhr, status, error) {
                    var erro = ajaxError(xhr, status, error);
                    toastr.error('Action Not Procede!', erro)
                }
            });
        }
    });
</script>

@endpush