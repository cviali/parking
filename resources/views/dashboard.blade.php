@extends('layouts.app')

@section('css')
<style type="text/css">
    .table td, .table th{
        vertical-align: middle;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="mb-4">
                <form class="d-flex justify-content-between form-inline" role="form" method="POST" action="{{ route('search') }}">
                    @csrf
                    <div class="form-inline">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">dari</div>
                            </div>    
                            @if(isset($inputStart))
                                <input type="date" class="form-control" name="start" value="{{ $inputStart }}">
                            @else
                                <input type="date" class="form-control" name="start">
                            @endif
                            <div class="input-group-prepend ml-2">
                                <div class="input-group-text">ke</div>
                            </div>   
                            @if(isset($inputEnd))
                                <input type="date" class="form-control" name="end" value="{{ $inputEnd }}">
                            @else
                                <input type="date" class="form-control" name="end">
                            @endif 
                        </div>
                        <button type="submit" name="submit" value="search" class="btn btn-dark ml-2">Cari</button>
                    </div>
                    <button type="submit" name="submit" value="export" class="btn btn-success">Export .xlsx</button>
                </form>
            </div>
            <div class="card mb-4">
                <div class="card-body">
                    <span id="serverTime" class="d-none">{{ $now }}</span>
                    <div class="local-time">
                        Jam Server: <span id="machineTime"></span>
                    </div>
                </div>
            </div>
            <span id="itemIndex" class="d-none">{{ count($post) }}</span>
            @if($message != '')
            <div class="alert alert-primary" id="alert">
                {{ $message }}
                <button type="button" class="close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nomor Polisi</th>
                        <th scope="col">Kode Unik</th>
                        <th scope="col">Pegawai</th>
                        <th scope="col">Jam Masuk</th>
                        <th scope="col">Jam Keluar</th>
                        <th scope="col">Status</th>
                        <th scope="col">Total Dibayar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($post as $car)
                    <tr>
                        <td>{{ $car->id }}</td>
                        <td>{{ $car->nopol }}</td>
                        <td>{{ $car->kode }}</td>
                        <td>{{ $car->pegawai }}</td>
                        <td id="car-{{ $car->id }}">{{ $car->created_at }}</td>
                        <td id="checkout-{{ $car->id }}">
                            @if($car->checkout === '1')
                                {{ $car->updated_at }}
                            @else
                                -
                            @endif</td>
                        <td>
                            @if($car->checkout === '1')
                            <span class="badge badge-success">Checkout</span>
                            @else
                            <span class="badge badge-danger">Not Yet</span>
                            @endif
                        </td>
                        <td id="tariff-{{ $car->id }}">{{$car->cost}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script type="text/javascript">
    var x = new Date(document.getElementById("serverTime").innerHTML);
    var addThis = x.getTime();
    var carParkedDateRange;
    var now;
    var itemCount = document.getElementById("itemIndex").innerHTML;

    function addZero(i) {
        if (i < 10) {
            i = "0" + i;
        }
        return i;
    }

    function outputTimeFromServer(time){
        var y = new Date(time);
        for(var i = 1; i <= itemCount; i++){
            carParkedDateRange = new Date($("#car-"+i).html());
            // $("#tariff-"+i).html((y.getHours() - carParkedDateRange.getHours()));
            // $("#tariff-"+i).html(calculateTariff(Math.round((y.getTime() - carParkedDateRange.getTime())/36e5)));
        }
    }

    function calculateTariff(hourDiff){ 
        if(hourDiff == 0){
            hourDiff = 1;
        }
        return hourDiff*3000;
    }

    outputTimeFromServer(addThis);

    setInterval(function(){
        addThis = addThis+1000;
        now = new Date(addThis);
        document.getElementById("machineTime").innerHTML = addZero(now.getHours())+":"+addZero(now.getMinutes())+":"+addZero(now.getSeconds());
    }, 1000);
    
    setTimeout(function(){
        $('.close').click(function(){
            $('#alert').slideUp();
        });
    }, 100)
</script>
@endsection
