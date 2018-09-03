@extends('layouts.app')

@section('title')
Dashboard
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <p class="alert alert-warning"><b>Note</b> : Click the row for details activity</p>
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
                                <form action="" method="post">
                                    <div class="form-group">
                                        <label for="date">Date</label>
                                        <input type="text" class="form-control border-input" name="date">
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
                                        <input type="number" class="form-control border-input" name="nominal">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea name="description" class="form-control border-input"></textarea>
                                        
                                    </div>
                                    
                                </form>
                              </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- UI Mobile -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="bg-mobile">
                                <p><b>{{ date('d-m-Y', strtotime('2018-09-03')) }}</b></p>
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
                    <hr>
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
                    <hr>
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
                    <hr>

                  
                  
                    <br>
                   
                 
                </div>
            </div>
        </div>
    </div>

@endsection
