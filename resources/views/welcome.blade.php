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
        @if(session()->has('message'))
        <div class="col-md-8">
            <div class="alert alert-primary" id="alert">
                {{ session()->get('message') }}
                <button type="button" class="close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        @endif
        @if($errors->count() > 0)
        <div class="col-md-8">
            <div class="alert alert-danger" id="alert">
                {{ $errors->first() }}
                <button type="button" class="close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        @endif
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">Parkir</div>
                <div class="card-body">
                    <form role="form" method="POST" action="{{ route('save') }}">
                    @csrf
                        <div class="form-group">
                            <input id="inputNopol" name="nopol" type="text" class="form-control" placeholder="Input Nomor Polisi">
                            <span role="alert" class="invalid-feedback">test error</span>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary w-100">Input</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    Keluar
                </div>
                <div class="card-body">
                    <form role="form" method="POST" action="{{ route('kode') }}">
                    @csrf
                        <div class="form-group">
                            <input type="text" name="kode" id="inputKode" class="form-control" placeholder="Input Kode Unik">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary w-100">Input</button>
                        </div>
                    </form>
                    @if (!empty($detail))
                        <div>
                            <h5>Checkout</h5>
                            <form role="form" method="POST" action="{{ route('checkout') }}">
                            @csrf
                            <input name="nopol" type="text" class="d-none" value="{{ $detail->nopol }}">
                            <input name="kode" type="text" class="d-none" value="{{ $detail->kode }}">
                            <input name="cost" type="text" class="d-none" value="{{ $cost }}">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Nomor Polisi</th>
                                        <th scope="col">Kode Unik</th>
                                        <th scope="col">Jam Masuk</th>
                                        <th scope="col">Biaya</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $detail->nopol }}</td>
                                        <td>{{ $detail->kode }}</td>
                                        <td>{{ $detail->created_at }}</td>
                                        <td>{{ $cost }}</td>
                                        <td><button type="submit" class="btn btn-success">Keluar</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    setTimeout(function(){
        $('.close').click(function(){
            $('#alert').slideUp();
        });
    }, 100);
</script>
@endsection
