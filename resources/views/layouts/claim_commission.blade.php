@extends('layouts.admin-master')
@section('content')
@include('partials.messages')



<head>
    <meta charset="UTF-8">

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

    <style>
        h1 {
            text-align: center;
            color: #000000;
        }

        h3 {
            text-align: center;
            color: #000000;
        }


        .form-control::placeholder {
            font-style: italic;
            font-size: 0.85rem;
            color: #aaa;
        }
    </style>
</head>
<h1 class="bg-corporate">Claim Commission</h1>
<br>

<body>

    <div>
        <div class="card">
            <div class="card-header">
                <h3>Wakalah Details</h3>

            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label style="font-size: large;" for="inputName">Name</label>
                        <h6>{!!$user->first_name!!}{!!$user->last_name!!}</h6>

                    </div>

                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label style="font-size: large;" for="inputEmail4">Email</label>
                        <h6>{!!$user->email!!}</h6> 
                    </div>
                    <div class="form-group col-md-6">
                        <label style="font-size: large;" for="inputICNumber">IC Number</label>
                        <h6>{!!$user->ic_number!!}</h6> 
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label style="font-size: large;" for="inputPhoneNumber">Phone Number</label>
                        <h6>{!!$user->phone!!}</h6> 
                    </div>

                    <div class="form-group col-md-6">
                        <label style="font-size: large;" for="inputWakalahID">Wakalah ID</label>
                        <h6>{!!$user->wakalah_id!!}</h6> 
                    </div>

                    <div class="form-group col-md-6">
                        <label style="font-size: large;" for="inputWakalahType">Wakalah Type</label>
                        <h6>{!!$user->wakalah_type!!}</h6> 
                    </div>

                    <div class="form-group col-md-6">
                        <label style="font-size: large;" for="inputInstitutionName">Institution Name</label>
                        <h6>{!!$user->institution_name!!}</h6> 
                    </div>


                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label style="font-size: large;" for="inputBankAccountNumber">Bank Account Number</label>
                        <h6>{!!$user->bank_account!!}</h6>
                    </div>
                    <div class="form-group col-md-6">
                        <label style="font-size: large;" for="inputBankName">Bank Name</label>
                        <h6>{!!$user->bank_name!!}</h6> 
                    </div>


                </div>
            </div>

        </div>

    </div>





    <div class="container py-1 ">
        <div class="row">
            <div class="col-lg-14 mx-auto">
                <div class="card  border-0 shadow bg-corporate">
                    <div class="card-body p-5">

                        <!--  Collection detsils table-->
                        <div class="table-responsive">
                            <table class="table">
                                <h3 class="bg-corporate">Collection Details</h3>
                                <thead>
                                    <tr style="background-color: #FFFFFF;">
                                        <th scope="col">#</th>
                                        <th scope="col">Official Receipt Number(From/To)</th>
                                        <th scope="col">Total Receipt(RM)</th>
                                        <th scope="col">Deposit Date</th>
                                        <th scope="col">Bank Name</th>
                                        <th scope="col">Slip Bank Number</th>
                                        <th scope="col">Slip Bank Amount(RM)</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>

                        <!-- Add rows button-->
                        <a class="btn btn-primary  " id="insertRow" href="#">Add new row</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function() {

            // Start counting from the third row
            var counter = 1;

            $("#insertRow").on("click", function(event) {
                event.preventDefault();

                var newRow = $("<tr>");
                var cols = '';

                // Table columns
                cols += '<th scrope="row">' + counter + '</th>';
                cols += '<td><input class="form-control " type="text" name="receiptNumber" placeholder="Receipt Number"></td>';
                cols += '<td><input class="form-control " type="text" name="totalReceipt" placeholder="Total Receipt"></td>';
                cols += '<td><input class="form-control " type="text" name="depositDate" placeholder="Deposit Date"></td>';
                cols += '<td><input class="form-control " type="text" name="bankName" placeholder="Bank Name"></td>';
                cols += '<td><input class="form-control " type="text" name="slipBankNumber" placeholder="Slip Bank Number"></td>';
                cols += '<td><input class="form-control " type="text" name="slipBankAmount" placeholder="Slip Bank Amount"></td>';
                cols += '<td><button class="btn btn-danger " id ="deleteRow"><i class="fa fa-trash"></i></button</td>';

                // Insert the columns inside a row
                newRow.append(cols);

                // Insert the row inside a table
                $("table").append(newRow);

                // Increase counter after each row insertion
                counter++;
            });

            // Remove row when delete btn is clicked
            $("table").on("click", "#deleteRow", function(event) {
                $(this).closest("tr").remove();
                counter -= 1
            });
        });
    </script>

</body>

</html>

@stop


@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\CreateWakalah', '#create-wakalah-form') !!}

@stop