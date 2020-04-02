@extends('layout.master')

@section('header')
    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
@stop
@section('content')
<div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
            {{-- alern --}}
            @if(session('succes'))
            <div class="alert alert-success" role="alert">
               {{session('succes')}}
           </div>
           @endif
            @if(session('error'))
            <div class="alert alert-danger" role="alert">
               {{session('error')}}
           </div>
           @endif
            <div class="panel panel-profile">
                <div class="clearfix">
                    <!-- LEFT COLUMN -->
                    <div class="profile-left">
                        <!-- PROFILE HEADER -->
                        <div class="profile-header">
                            <div class="overlay"></div>
                            <div class="profile-main">
                                <img src="{{$guru->guruAvatar()}}" class="img-circle" alt="Avatar" width="200p">
                                <h3 class="name">{{$guru->nama}}</h3>
                                {{--  <span class="online-status status-available">Available</span> --}}

                        <!-- END PROFILE HEADER -->



                        </div>
                    </div>
                </div>


                    <!-- RIGHT COLUMN -->
                    <div class="profile-right">
                       <!-- Button trigger modal -->


                     <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Mata Pelajaran yang di Ajar oleh Guru {{$guru->nama}}</h3>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>NAMA</th>
                                        <th>SEMESTER</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($guru->mapel as $mapel)
                                    <tr>
                                       <td>{{$mapel->nama}}</td>
                                       <td>{{$mapel->semester}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="panel">
                        <div id="charNilai"></div>
                    </div>
                </div>
                <!-- END RIGHT COLUMN -->
            </div>
        </div>
    </div>
</div>
<!-- END MAIN CONTENT -->
</div>

@stop
