@extends('layouts.admin-master')
@section('content')
 


<head>
  <style>
    h1 {
      text-align: center;
      color: #000000;
    }
  </style>
</head>

<body>

  <h1 class="bg-corporate">View Application</h1>


  @include('partials.messages')



  <div>
    <div class="card bg-corporate p-4">
    <form method="POST" action="{{ route('wa.store') }}" enctype="multipart/form-data" id="create-wakalah-form">
      @csrf

      <div class="form-row">
        <div class="form-group col-md-12">
          <label style="font-size: large;" for="inputName">Name</label>
          <h6>{{$wakalahApplication->first_name}}{{$wakalahApplication->last_name}}</h6>
        </div>

      </div>

      <div class="form-row">
        <div class="form-group col-md-6">
          <label style="font-size: large;" for="inputEmail4">Email</label>
          <h6>{{$wakalahApplication->email}}</h6> 
      
        </div>
        <div class="form-group col-md-6">
          <label style="font-size: large;" for="inputICNumber">IC Number</label>
          <h6>{{$wakalahApplication->ic_number}}</h6> 
        </div>
      </div>

      <div class="form-row">
        <div class="form-group col-md-6">
          <label style="font-size: large;" for="inputPhoneNumber">Phone Number</label>
          <h6>{{$wakalahApplication->phone}}</h6> 
            
        </div>
        <div class="form-group col-md-6">
          <label style="font-size: large;" for="inputWakalahType">Wakalah Type</label>
          <h6>{{$wakalahApplication->wakalah_type}}</h6> 
        </div>

        <div class="form-group col-md-12">
          <label style="font-size: large;" for="inputAddress">Address</label>
          <h6>{{$wakalahApplication->address}}</h6>
        </div>

        <div class="form-group col-md-6">
          <label style="font-size: large;" for="inputCity">City</label>
          <h6>{{$wakalahApplication->city}}</h6> 
        </div>
        <div class="form-group col-md-4">
          <label style="font-size: large;" for="inputState">State</label>
          <h6>{{$wakalahApplication->state}}</h6>
        </div>

        <div class="form-group col-md-2">
          <label style="font-size: large;" for="inputZip">Zip</label>
          <h6>{{$wakalahApplication->zip}}</h6>
        </div>

      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label style="font-size: large;" for="inputBankAccountNumber">Bank Account Number</label>
          <h6>{{$wakalahApplication->bank_account}}</h6> 
        </div>

        <div class="form-group col-md-6">
          <label style="font-size: large;" for="inputBankName">Bank Name</label>
          <h6>{{$wakalahApplication->bank_name}}</h6> 
        </div>
        
        <div class="form-group col-md-12">
          <label style="font-size: large;">Download Attached Files:</label>

          <a href="{!! $wakalahApplication->getFirstMediaUrl('IC') !!}" download class="btn btn-lg btn-primary">
            <i class="fa fa-download"></i> Download IC
          </a>

          <a href="{!! $wakalahApplication->getFirstMediaUrl('Photo') !!}" download class="btn btn-lg btn-primary">
            <i class="fa fa-download"></i> Download Photo
          </a>

          <a href="{!! $wakalahApplication->getFirstMediaUrl('Bank Statement') !!}" download class="btn btn-lg btn-primary">
            <i class="fa fa-download"></i> Download Bank Statement
          </a>

          <a href="{!! $wakalahApplication->getFirstMediaUrl('Payment Receipt') !!}" download class="btn btn-lg btn-primary">
            <i class="fa fa-download"></i> Download Payment Receipt
          </a>


        </div>
        <div class="text-dark">
          <label style="font-size: large" ;>Application Status:</label>
          <button type="button" class="btn btn-lg btn-success" data-toggle="modal" data-target="#exampleModal1">Approve</button>
          <button type="button" class="btn btn-lg btn-danger" data-toggle="modal" data-target="#exampleModal2">Reject</button>
        </div>

        </form>

    </div>
    <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel1">Upload Materials</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body" style="background-color: #00FF27;">
                  <form method="POST" action="{{ route('wa.approve', $wakalahApplication->id) }}" enctype="multipart/form-data" id="approve_wakalah_application">
                  @csrf  
                  <div class="text-dark">
                      <div class="card-body p-10">
                        <div class="w-100">
                          <h5>Affiliate Link</h5>
                          <div class="form-outline">
                            <textarea class="form-control" id="textAreaExample" name="affiliate_link" rows="10"></textarea>
                            <label class="form-label" for="textAreaExample"></label>
                          </div>
                          <h5>Wakalah ID</h5>
                          <div class="form-outline">
                            <textarea class="form-control" id="textAreaExample" name="wakalah_id" rows="10"></textarea>
                            <label class="form-label" for="textAreaExample"></label>
                          </div>

                          <div class="form-group">
                            <h5>Appointment Letter</h5>
                            <input type="file" class="form-control" id="inputAppointmentLetter" id="files5" name="files5" multiple>
                          </div>
                          <button type="submit" class="btn btn-dark">
                            Send <i class="fas fa-long-arrow-alt-right ms-1"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>


          <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Reason for rejection</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body" style="background-color: #FFB5B5;">
              <form method="POST" action="{{ route('wa.reject', $wakalahApplication->id) }}" enctype="multipart/form-data" id="reject-wakalah-application">
                  @csrf  
                  <div class="text-dark">
                    <div class="card-body p-10">
                      <div class="w-100">
                        <div class="form-outline">
                          <textarea class="form-control" id="textAreaExample" name="rejection_reason" rows="10"></textarea>
                          <label class="form-label" for="textAreaExample"></label>
                        </div>
                        <button type="submit" class="btn btn-dark">
                          Send <i class="fas fa-long-arrow-alt-right ms-1"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
   


  </div>
</body>
@stop

@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\ApproveWakalah', '#approve_wakalah_application') !!}
{!! JsValidator::formRequest('App\Http\Requests\RejectWakalah', '#reject-wakalah-application') !!}
{!! JsValidator::formRequest('App\Http\Requests\CreateWakalah', '#create-wakalah-form') !!}

@stop