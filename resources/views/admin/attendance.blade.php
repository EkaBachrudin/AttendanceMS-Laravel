@extends('layouts.master')

@section('css')
    <!-- Table css -->
    <link href="{{ URL::asset('plugins/RWD-Table-Patterns/dist/css/rwd-table.min.css') }}" rel="stylesheet" type="text/css" media="screen">
@endsection

@section('breadcrumb')
    <div class="col-sm-6">
        <h4 class="page-title text-left">Attendance</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0);">Attendance</a></li>


        </ol>
    </div>
@endsection
@section('button')
    <a href="check" class="btn btn-success btn-sm btn-flat"><i class="mdi mdi-plus mr-2"></i>Add New</a>
@endsection

@section('content')
@include('includes.flash')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table id="datatable-buttons" class="table table-hover table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                            <thead class="thead-dark">
							<!-- Log on to codeastro.com for more projects! -->
                                    <tr>
                                        <th data-priority="1">Date</th>
                                        <th data-priority="2">EmpID</th>
                                        <th data-priority="3">Name</th>
                                        <th data-priority="4">Attendance</th>
                                        <th data-priority="7">Image</th>
                                        <th data-priority="8">Location</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($attendances as $attendance)

                                        <tr>
                                            <td>{{ $attendance->attendance_date }}</td>
                                            <td>{{ $attendance->emp_id }}</td>
                                            <td>{{ $attendance->employee->name }}</td>
                                            <td>{{ $attendance->attendance_time }}
                                                @if ($attendance->status == 1)
                                                    <span class="badge badge-success badge-pill float-right">On Time</span>
                                                @else
                                                    <span class="badge badge-danger badge-pill float-right">Late</span>
                                                @endif
                                            </td>
                                            <td> <a target="_blank" href="<?php echo asset("storage/uploads/$attendance->image")?>">Open image</a> </td>
                                            <td> <a target="_blank" href="http://maps.google.com/maps?q={{ $attendance->latlong }}&ll={{ $attendance->latlong }}&z=17">Open Location</a></td>
                                            {{-- <img src="<?php echo asset("storage/uploads/$attendance->image")?>"></img> --}}
                                        </tr>

                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div><!-- Log on to codeastro.com for more projects! -->
        </div> <!-- end col -->
    </div> <!-- end row -->

@endsection


@section('script')
    <!-- Responsive-table-->
	<!-- Log on to codeastro.com for more projects! -->
    <script src="{{ URL::asset('plugins/RWD-Table-Patterns/dist/js/rwd-table.min.js') }}"></script>

@endsection

@section('script')
    <script>
        $(function() {
            $('.table-responsive').responsiveTable({
                addDisplayAllBtn: 'btn btn-secondary'
            });
        });
    </script>
@endsection
