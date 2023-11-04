@extends('user.layouts.master')

@section('css')
    <script src="{{ URL::asset('assets/js/webcam.js') }}"></script>
    <style>
        .mobile{
            max-width: 600px;
            margin-right: auto;
            margin-left: auto;
        }
        .top-section{
            padding: 10px 0;
            font-weight: 500 !important;
            color: white;
            background: rgb(237,33,58);
            background: linear-gradient(97deg, rgba(237,33,58,1) 2%, rgba(147,41,30,1) 100%);
        }

        .card{
            margin: 15px;
        }

        .card-body{
            padding: 10px 0 10px 0 !important;
        }

        .jadwal{
            text-align: center;
            font-size: 14px;
            color: rgb(78, 78, 78);
        }

        .btn-primary{
            font-weight: 600;
            width: 150px;
            background-color: rgb(54, 54, 147) !important;
        }

        .bottom-section {
            padding: 10px 15px;
        }

        .daftar-absensi{
            font-weight: 600;
        }

        .lihat-log{
            font-weight: 600;
            color: rgba(0, 0, 0, 0.579);
        }
        #my_camera{
            border-radius: 10px;
        }
        #results img{
            border-radius: 10px;
        }
    </style>
@endsection

@section('content')
<div class="top-section mobile">
    <h5 class="text-center">Absen</h5>

    <h2 id="clock" class="text-center mt-4"></h2>
    <h6 class="text-center"><span class="hari"></span>, <span class="tanggal"></span> <span class="bulan"></span> <span class="tahun"></span></h6>
    <div class="card">
        <div class="card-body">
            <div class="jadwal">
                Jadwal: <span class="hari"></span>, <span class="tanggal"></span> <span class="bulan"></span> <span class="tahun"></span>
                <hr>
                <div class="d-flex justify-content-between p-3">
                    <button type="button" class="btn btn-primary" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Clock in</button>
                    <button type="button" class="btn btn-primary">Clock out</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="bottom-section mobile">
    <div class="d-flex justify-content-between">
        <div class="daftar-absensi">Daftar absensi </div>
        <div class="lihat-log">Lihat Log</div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <form method="POST" action="{{ route('webcam.capture') }}">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex justify-content-center" style="width: 100%">
                        <div id="my_camera"></div>
                    </div>
                    <br/>

                    <input type="hidden" name="image" class="image-tag">
                </div>
                <div style="width: 100%;display: none">
                    <div id="results"></div>
                </div>
                <div class="col-md-12 text-center">
                    <br/>
                    <input type=button value="Clock In" class="btn btn-primary" onClick="take_snapshot()">
                    <button class="btn btn-primary d-none" id="submit-img">Submit</button>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
    <script>
        Webcam.set({
            width: 300,
            height: 400,
            image_format: 'jpeg',
            jpeg_quality: 50
        });

        Webcam.attach( '#my_camera' );

        function startTime() {
            const today = new Date();
            let h = today.getHours();
            let m = today.getMinutes();
            let s = today.getSeconds();
            m = checkTime(m);
            s = checkTime(s);
            document.getElementById('clock').innerHTML =  h + ":" + m + ":" + s;
            setTimeout(startTime, 1000);
        }

        function checkTime(i) {
            if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
            return i;
        }

        function getDay() {
            const days = ["Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Minggu"];
            const month = ["Jan","Feb","March","April","May","June","July","August","Sep","Oct","Nov","Dec"];
            const d = new Date();
            let day = days[d.getDay()];
            console.log(document.getElementsByClassName("hari"));
            document.getElementsByClassName("hari")[0].innerHTML = day;
            document.getElementsByClassName("tanggal")[0].innerHTML = d.getDate();
            document.getElementsByClassName("bulan")[0].innerHTML = month[d.getMonth()];
            document.getElementsByClassName("tahun")[0].innerHTML = d.getFullYear();
             document.getElementsByClassName("hari")[1].innerHTML = day;
            document.getElementsByClassName("tanggal")[1].innerHTML = d.getDate();
            document.getElementsByClassName("bulan")[1].innerHTML = month[d.getMonth()];
            document.getElementsByClassName("tahun")[1].innerHTML = d.getFullYear();
        }

        function take_snapshot() {
            Webcam.snap( function(data_uri) {
                var link = document.getElementById('submit-img');

                $(".image-tag").val(data_uri);
                document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';

                if($(".image-tag").val())  link.click();
            } );
        }

        getDay();
        startTime();
    </script>
@endsection
