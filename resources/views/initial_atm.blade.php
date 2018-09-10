@extends('layouts.app')

@section('title')
Initial ATM
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
                            Welcome to Monthly Income and Expenses Information System. I think this is your first time to sign in, for better service please enter your latest saldo in form below, which you want to calculate in the future. Cheers! :)
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <p class="alert alert-danger">{{ $error }}</p>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('atm.initial') }}" method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <strong>Initial ATM</strong>
                                    <input type="text" name="amount" id="amount" class="form-control border-input" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary btn-fill">
                                </div>
                            </form>
                            
                        </div>
                    </div>
                    

                    
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<!-- cleave js -->
<script src="{{ asset('cleave-js/dist/cleave.min.js') }}"></script>
<script>
    //number format 
    var cleave = new Cleave('#amount', {
        numeral: true,
        numeralThousandsGroupStyle: 'thousand'
    });
</script>


@endpush