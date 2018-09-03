@extends('layouts.app')

@section('title')
Dashboard
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <p class="alert alert-info"><b>Note</b> : Click the row for details activity</p>
    </div>
</div>
<!-- error message -->
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
    <div class="col-lg-12 col-sm-12">
        <div class="card">
            <div class="header"><strong>Your Balance : {{ $balance->amount }}</strong></div>
        
            <div class="content">
                <div class="row">
                    <div class="col-md-12">
                        <a class="btn btn-primary btn-fill" data-toggle="collapse" href="#collapseFormHistory">Add History</a>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="collapse" id="collapseFormHistory">
                            <div class="card card-body content">
                                <form action="{{ route('history.store') }}" method="post">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="date">Date</label>
                                        <input type="text" class="form-control border-input" name="date" id="datepicker">
                                    </div>
                                    <div class="form-group">
                                        <label for="type">Type</label>
                                        <select name="type" class="form-control border-input">
                                            <option value="expense">Expenses</option>
                                            <option value="income">Income</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="nominal">Nominal</label>
                                        <input type="text" id="nominal" class="form-control border-input" name="nominal">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea name="description" class="form-control border-input"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-success btn-block btn-fill">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                @foreach($dates as $date)
                <div class="row">
                    <div class="col-md-12">
                        <div class="bg-mobile">
                            <p>{{ $date['date'] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- UI Mobile -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="bg-mobile">
                            <p>2018-03-09</p>
                            <center>
                                <table class="table table-m">
                                    <tr>
                                        <th>In</th>
                                        <th>Out</th>
                                        <th>Balance</th>
                                        <th>Delete</th>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>50.000</td>
                                        <td>100.000</td>
                                        <td><a href="" class="btn btn-sm btn-danger"><i class="ti-trash"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td>1.000</td>
                                        <td></td>
                                        <td>7.100.000</td>
                                        <td> <a href="" class="btn btn-sm btn-danger"><i class="ti-trash"></i></a> </td>
                                    </tr>
                                </table>
                            </center>
                        </div>
                    </div>
                </div>
               
                 <!-- UI Mobile -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="bg-mobile">
                            <p>2018-03-09</p>
                            <center>
                                <table class="table table-m">
                                    <tr>
                                        <th>In</th>
                                        <th>Out</th>
                                        <th>Balance</th>
                                        <th>Delete</th>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>8.000.000</td>
                                        <td>8.000.000</td>
                                        <td><a href="" class="btn btn-sm btn-danger"><i class="ti-trash"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td>1.900.000</td>
                                        <td></td>
                                        <td>7.100.000</td>
                                        <td> <a href="" class="btn btn-sm btn-danger"><i class="ti-trash"></i></a> </td>
                                    </tr>
                                </table>
                            </center>
                        </div>
                    </div>
                </div>
             
                 <!-- UI Mobile -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="bg-mobile">
                            <p>2018-03-09</p>
                            <table class="table table-m">
                                <tr>
                                    <th>In</th>
                                    <th>Out</th>
                                    <th>Balance</th>
                                    <th>Delete</th>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>8.000.000</td>
                                    <td>8.000.000</td>
                                    <td><a href="" class="btn btn-sm btn-danger"><i class="ti-trash"></i></a></td>
                                </tr>
                                <tr>
                                    <td>1.900.000</td>
                                    <td></td>
                                    <td>7.100.000</td>
                                    <td> <a href="" class="btn btn-sm btn-danger"><i class="ti-trash"></i></a> </td>
                                </tr>
                                
                            </table>
                        </div>
                    </div>
                </div>
               
                <br>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<!-- Datepicker -->
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$( function(){
     $( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd', changeYear: true,
      changeMonth: true, yearRange: '1945:'+(new Date).getFullYear() });
     $( "#datepicker2" ).datepicker({ dateFormat: 'yy-mm-dd', changeYear: true,
      changeMonth: true, yearRange: '1945:'+(new Date).getFullYear() });
    });
</script>

<!-- cleave js -->
<script src="{{ asset('cleave-js/dist/cleave.min.js') }}"></script>
<script>
    //number format 
    var cleave = new Cleave('#nominal', {
        numeral: true,
        numeralThousandsGroupStyle: 'thousand'
    });
</script>
@endpush