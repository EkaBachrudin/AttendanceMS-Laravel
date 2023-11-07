@extends('layouts.master')

@section('css')
    <!-- Table css -->
    <link href="{{ URL::asset('plugins/RWD-Table-Patterns/dist/css/rwd-table.min.css') }}" rel="stylesheet" type="text/css" media="screen">
    <style>
        .first{
            color:white;
            position: absolute;
            width: 120px;
            background-color: #343a40;
            z-index:1;
            text-overflow:ellipsis;
            overflow: hidden !important;
            text-overflow: ellipsis;
        }
        body::-webkit-scrollbar {
  width: 12px;               /* width of the entire scrollbar */
}

body::-webkit-scrollbar-track {
  background: orange;        /* color of the tracking area */
}

body::-webkit-scrollbar-thumb {
  background-color: blue;    /* color of the scroll thumb */
  border-radius: 20px;       /* roundness of the scroll thumb */
  border: 3px solid orange;  /* creates padding around scroll thumb */
}
    </style>
    @endsection

@section('content')

    <div class="card">
        <div class="card-header bg-success text-white">
            Attendance Sheet Report
        </div>
        <div class="card-body">
            <div data-pattern="priority-columns">
                <table id="datatable-buttons" class="table-responsive table table-hover table-striped nowrap" style="width: 100%;" style="overflow-y: scroll;">
                <thead class="thead-dark">
                        <tr >

                            <th data-priority="1">Employee &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
                            <th data-priority="2">Position</th>
                            <!-- <th>ID</th> -->
							<!-- Log on to codeastro.com for more projects! -->
                            @php
                                $today = today();
                                $dates = [];

                                for ($i = 1; $i < $today->daysInMonth + 1; ++$i) {
                                    $dates[] = \Carbon\Carbon::createFromDate($today->year, $today->month, $i)->format('Y-m-d');
                                }

                            @endphp
                            
                            @foreach ($dates as $date)
                            <th class="not-export-col">


                                    {{ $date }}

                            </th>
                            
                            @endforeach

                        </tr>
                    </thead>

                    <tbody>





                        @foreach ($employees as $employee)

                            <input type="hidden" name="emp_id" value="{{ $employee->id }}">


                            <tr>
                                <td class="first">{{ $employee->name }}</td>
                                <td>{{ $employee->position }}</td>
                                <!-- <td>{{ $employee->id }}</td> -->
								<!-- Log on to codeastro.com for more projects! -->






                                @for ($i = 1; $i < $today->daysInMonth + 1; ++$i)


                                    @php

                                        $date_picker = \Carbon\Carbon::createFromDate($today->year, $today->month, $i)->format('Y-m-d');

                                        $check_attd = \App\Models\Attendance::query()
                                            ->where('emp_id', $employee->id)
                                            ->where('attendance_date', $date_picker)
                                            ->first();

                                        $check_leave = \App\Models\Leave::query()
                                            ->where('emp_id', $employee->id)
                                            ->where('leave_date', $date_picker)
                                            ->first();

                                    @endphp
                                    <td>

                                        <div class="form-check form-check-inline " style="max-width: 100px">

                                            @if (isset($check_attd))

                                                 @if ($check_attd->status==1)
                                                 <i class="fa fa-check text-success"></i>
                                                 @else
                                                 <i class="fa fa-check text-danger"></i>
                                                 @endif
                                                 &nbsp{{$check_attd->attendance_time	}}
                                            @else
                                            <i class="fas fa-times text-danger"></i>
                                            @endif
                                        </div>
                                        <div class="form-check form-check-inline">

                                            @if (isset($check_leave))

                                            @if ($check_leave->status==1)
                                            <i class="fa fa-check text-success"></i>
                                            @else
                                            <i class="fa fa-check text-danger"></i>
                                            @endif
                                            &nbsp{{$check_leave->leave_time}}
                                       @else
                                       <i class="fas fa-times text-danger"></i>
                                       @endif


                                        </div>

                                    </td>

                                @endfor
                            </tr>
                        @endforeach





                    </tbody>
					<!-- Log on to codeastro.com for more projects! -->


                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('plugins/RWD-Table-Patterns/dist/js/rwd-table.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var table = $('#datatable-buttons').DataTable({
                lengthChange: false,
                buttons: [
                    {
                        text: 'export',
                        extend: 'pdfHtml5',
                        exportOptions: {
                        columns: ':visible:not(.not-export-col)'
                        }
                    },
                    {
                        text: 'excel',
                        exportOptions: {
                            columns: [1,2,3]
                        }
                    },'colvis'
                ]
            });

            table.buttons().container()
                .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
        } );
    </script>
@endsection
