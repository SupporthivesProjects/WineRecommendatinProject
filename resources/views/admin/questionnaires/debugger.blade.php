@extends('layouts.bootdashboard')

@section('admindashboardcontent')
@push('styles')

<style>
    #queryResult table{
    width:100%;
    font-size:13px;
    }

    #queryResult th{
    white-space:nowrap;
    position:sticky;
    top:0;
    z-index:10;
    }

    #queryResult td{

    white-space:nowrap;
    vertical-align:middle;

    }
</style>



@endpush

    <div class="main-content app-content">
        <div class="container-fluid">
            <div class="card shadow">
                <div class="card-header">
                    <h3 class="mb-0">
                        Questionnaire Debugger
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-5">
                            @foreach ($steps as $step)
                                <div class="card shadow-sm mb-4 border-0">
                                    <div
                                        class="card-header d-flex justify-content-between align-items-center
                                    @if ($step['status'] == 'success') bg-success text-white
                                    @else
                                        bg-warning text-dark @endif">
                                        <strong>
                                            Step {{ $step['step'] }}
                                        </strong>
                                        @if ($step['status'] == 'success')
                                            <span class="badge bg-light text-success">
                                                Applied
                                            </span>
                                        @else
                                            <span class="badge bg-dark">
                                                Skipped
                                            </span>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-5 fw-bold">
                                                Question
                                            </div>
                                            <div class="col-7">
                                                {{ ucfirst($step['question']) }}
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-5 fw-bold">
                                                Answer
                                            </div>
                                            <div class="col-7 text-primary">
                                                {{ $step['answer'] }}
                                            </div>
                                        </div>
                                        <div class="row text-center mb-4">
                                            <div class="col">
                                                <div class="border rounded p-2">
                                                    <small class="text-muted">
                                                        Before
                                                    </small>
                                                    <h4>
                                                        {{ $step['before'] }}
                                                    </h4>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="border rounded p-2">
                                                    <small class="text-muted">
                                                        Matched
                                                    </small>
                                                    <h4 class="text-info">
                                                        {{ $step['results'] }}
                                                    </h4>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="border rounded p-2">
                                                    <small class="text-muted">
                                                        After
                                                    </small>
                                                    <h4 class="text-success">
                                                        {{ $step['after'] }}
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-grid gap-2">
                                            <button class="btn btn-primary executeQuery"
                                                data-sql="{{ base64_encode($step['sql']) }}"
                                                data-bindings='@json($step["bindings"])'>
                                                Execute Query
                                            </button>
                                            <button class="btn btn-outline-secondary" data-bs-toggle="collapse"
                                                data-bs-target="#sql{{ $step['step'] }}">
                                                View SQL
                                            </button>
                                        </div>

                                        <div class="collapse mt-3" id="sql{{ $step['step'] }}">

                                            <pre class="bg-dark text-white rounded p-3">{{ $step['sql'] }}</pre>

                                        </div>

                                    </div>

                                </div>
                            @endforeach

                        </div>
                        <div class="col-lg-7">

                            <div class="card shadow-sm">

                                <div class="card-header">

                                    <h5 class="mb-0">
                                        Matching Products
                                    </h5>
                                    <span class="badge bg-primary fs-6" id="resultCount">
                                        0 Products
                                    </span>
                                </div>
                                <div class="card-body p-2" style="overflow:auto;max-height:850px;">
                                    <div id="queryResult">
                                        <div class="text-center text-muted p-5">
                                            <h5>
                                                Click Execute Query
                                            </h5>
                                            <p>
                                                Products matching that step will appear here.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @push('scripts')
    <script>
        $('.executeQuery').click(function(){

            let sql=$(this).data('sql');
            let bindings=$(this).data('bindings');

            $.ajax({

                url:"{{ route('admin.questionnaire.executeQuery') }}",

                type:"POST",

                data:{
                    sql:sql,
                    bindings:JSON.stringify(bindings),
                    _token:"{{ csrf_token() }}"
                },

                success:function(res)
                {

                    if(!res.success){

                        $('#queryResult').html(
                            '<div class="alert alert-danger">'+
                            res.message+
                            '</div>'
                        );

                        return;
                    }

                    $('#resultCount').text(res.products.length + ' Products');

                    if(res.products.length==0){

                        $('#queryResult').html(
                            '<div class="alert alert-warning">No Products Found</div>'
                        );

                        return;
                    }

                    let html='';
                    html+='<div class="table-responsive">';
                    html+='<table class="table table-bordered table-striped table-sm mb-0">';
                    html+='<thead class="table-dark">';
                    html+='<tr>';
                    Object.keys(res.products[0]).forEach(function(key){
                        html+='<th>'+key.replaceAll("_"," ").toUpperCase()+'</th>';
                    });

                    html+='</tr>';

                    html+='</thead>';

                    html+='<tbody>';

                    res.products.forEach(function(row){

                        html+='<tr>';

                        Object.values(row).forEach(function(val){

                            html+='<td>'+(val ?? '')+'</td>';

                        });

                        html+='</tr>';

                    });

                    html+='</tbody>';

                    html+='</table>';

                    html+='</div>';

                    $('#queryResult').html(html);

                    }

            });

        });

    </script>
    @endpush
