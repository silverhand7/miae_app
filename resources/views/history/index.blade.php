@extends('layouts.app')

@section('title')
Wallet
@endsection

@section('content')

<style>
    .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control { background-color: #fffcf5 !important; opacity: 1; }
</style>

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
            <div class="header"><strong>Your Wallet :  Rp. {{ number_format($balance->amount) }}</strong></div>
            <div class="content">
                <div class="row">
                    <div class="col-md-12">
                        <a class="btn btn-primary btn-fill" onclick="hideContent()" data-toggle="collapse" href="#collapseFormHistory">Add Wallet Transaction</a>
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
                                        <input type="text" class="form-control border-input" name="date" id="datepicker" autocomplete="off" readonly="true" placeholder="Click/tap..">
                                    </div>
                                    <div class="form-group">
                                        <label for="type">Type</label>
                                        <select name="type" class="form-control border-input">
                                            <option value="expense">Spending</option>
                                            <option value="income">Income</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="nominal">Nominal</label>
                                        <input type="text" id="nominal" class="form-control border-input" name="nominal" autocomplete="off">
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

<!-- tampilkan bulan 
<div class="row">
    <div class="col-lg-12 col-sm-12">
        <div class="card">
            <div class="header"><strong>Select Month</strong></div>
        
            <div class="content">
                <div class="row">
                    <div class="col-md-12">
                        <select onchange="changeMonth()" id="selectMonth" class="form-control border-input">
                            <option value="#">This Month</option>
                            <option value="2018-01">Januari 2018</option>
                        </select>
                    </div>
                </div>
                <br>
            </div>
        </div>
    </div>
</div> -->


<div id="main-content">
@foreach($dates as $date)
<div class="row">
    <div class="col-ld-12 col-sm-12">
        <div class="card">
            <div class="header"><strong>{{ date("d-m-Y", strtotime($date['date']))  }}</strong></div>
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
                                                    $type = $row['type'];
                                                 
                                                } else {
                                                   $pengeluaran += $row['nominal'];
                                                   $type = 'spend';
                                                }
                                            ?>
                                            <tr>
                                                <td>{{ number_format($row['nominal']) }}</td>
                                                <td style="color:{{( $row['type']=='income' ? 'green' : 'red')}}">{{  strtoupper($type) }}</td>
                                                <td>{{ $row['description'] }}</td>
                                                <!-- <td><a href="#" data-id="{{$row['id']}}" class="btn btn-sm btn-danger delete-btn"><i class="ti-trash" ></i></a></td> -->
                                                <form action="{{ route('history.destroy', ['id' => $row['id']]) }}" method="post">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <input type="hidden" name="id" value="{{ $row['id'] }}">
                                                <td>
                                                    <button type="submit" class="btn btn-sm btn-danger"><i class="ti-trash" onclick="return confirm('Are you sure?')" ></i></button>
                                                </td>
                                                </form>
                                            </tr>

                                        @endif

                                    @endforeach
                                        
                                @endfor
                                <tr>
                                    <td colspan="2"><b>Income Today</b></td>
                                    <td>:</td>
                                    <td>{{ number_format($pemasukan) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2"><b>Spending Today</b></td>
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
</div>

@endsection

@push('scripts')

<script>
    

    //kalo ganti bulan lewat select input, otomatis ganti linknya
    function changeMonth(){
        var month = document.getElementById('selectMonth').value;
        location.href= 'history/details/' + month;
    }

    //kalo button add di click table hidden
    function hideContent(){
        var content = document.getElementById('main-content');
        if(content.style.display === "none"){
            content.style.display = '';
        } else {
            content.style.display = 'none';
        }
    }
   
</script>

<script>
    $(".delete-btn").click(function(){
        let id = $(this).attr('data-id');
        if(confirm("Apa anda yakin akan menghapus data?")) {
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
      changeMonth: true, ignoreReadonly: true,
       allowInputToggle: true, yearRange: '1945:'+(new Date).getFullYear() });
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