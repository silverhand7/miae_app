@extends('layouts.app')

@section('title')
Dashboard
@endsection

@section('content')

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
<!-- form intput -->
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

            </div>
        </div>
    </div>
</div>

@foreach($dates as $date)
<div class="row">
    <div class="col-ld-12 col-sm-12">
        <div class="card">
            <div class="header"><strong>{{ $date['date'] }}</strong></div>
            <div class="content">
                <div class="row">
                    <div class="col-md-12">
                        <center>
                            <table class="table table-m">
                                 <tr>
                                    <th>Nominal</th>
                                    <th>Type</th>
                                    <th>Desc</th>
                                    <th>Delete</th>
                                <?php
                                $pemasukan = 0;
                                $pengeluaran = 0;
                                ?>
                                </tr> 
                                @for($i=0; $i < count($daily); $i++)
                                    @foreach($daily[$i] as $row)
                                        @if($date['date'] == $row['date'])
                                             <?php
                                                if($row['type'] == 'income') {
                                                    $pemasukan += $row['nominal'];
                                                 
                                                } else {
                                                   $pengeluaran += $row['nominal'];
                                                }
                                            ?>
                                            <tr>
                                                <td>{{ number_format($row['nominal']) }}</td>
                                                <td style="color:{{( $row['type']=='income' ? 'green' : 'red')}}">{{ strtoupper($row['type']) }}</td>
                                                <td>{{ $row['description'] }}</td>
                                                <td><a href="#" data-id="{{$row['id']}}" class="btn btn-sm btn-danger delete-btn"><i class="ti-trash" ></i></a></td>
                                            </tr>

                                        @endif

                                    @endforeach
                                        
                                @endfor
                                <tr>
                                    <td colspan="2"><b>Total Pemasukan</b></td>
                                    <td>:</td>
                                    <td>{{ number_format($pemasukan) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2"><b>Total Pengeluaran</b></td>
                                    <td>:</td>
                                    <td>{{ number_format($pengeluaran) }}</td>
                                </tr>
                                
                            </table>
                         
                            
                        </center>
                      
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>

@endforeach

@endsection

@push('scripts')

<script>
    $(".delete-btn").click(function(){
        let id = $(this).attr('data-id');
        if(confirm("Apa anda yakin akan menghapus? data ")) {
            $.ajax({
                url : "{{url('/')}}/history/"+id,
                method : "POST",
                data : {
                    _token : "{{csrf_token()}}",
                    _method : "DELETE",
                }
            })
            .then(function(data){
                location.reload();
            });
        }
    })
</script>

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