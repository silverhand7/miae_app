@extends('layouts.app')

@section('title')
Dashboard
@endsection

@section('content')

    <div class="row">
       <div class="col-lg-6 col-sm-6">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <div class="card">
                <div class="header"><strong>Welcome</strong></div>
            
                <div class="content">
                    <div class="row">
                        <div class="col-md-12">
                           anjay
                        </div>
                    </div>
                    <br>
                   
                 
                </div>
            </div>
        </div>
    </div>

@endsection
