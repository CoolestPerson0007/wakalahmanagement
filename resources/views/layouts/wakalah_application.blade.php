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

  <h1 class="bg-corporate">Wakalah Application</h1>
</body>

@include('partials.messages')


<div class="p-4 bg-corporate">
  <form method="POST" action="{{ route('wa.store') }}" enctype="multipart/form-data" id="create-wakalah-form">
    @csrf
    <div class="form-row">
      <div class="form-group col-md-6">
        <label style="font-size: large;" for="inputFirstName">First Name</label>
        <input type="text" name="first_name" class="form-control" placeholder="First name">
      </div>
      <div class="form-group col-md-6">
        <label style="font-size: large;" for="inputLastName">Last Name</label>
        <input type="text" name="last_name" class="form-control" placeholder="Last name">
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-6">
        <label style="font-size: large;" for="inputEmail4">Email</label>
        <input type="email" name="email" class="form-control" id="inputEmail4" placeholder="Email">
      </div>
      <div class="form-group col-md-6">
        <label style="font-size: large;" for="inputICNumber">IC Number</label>
        <input type="ICNumber" name="ic_number" class="form-control" id="inputICNumber" placeholder="IC Number">
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-6">
        <label style="font-size: large;" for="inputPhoneNumber">Phone Number</label>
        <input type="text" name="phone" class="form-control" id="inputPhoneNumber" placeholder="Phone Number">
      </div>
      <div class="form-group col-md-6">
        <label style="font-size: large;" for="inputWakalahType">Wakalah Type</label>
        <select id="inputWakalahType" name="wakalah_type" class="form-control" onchange="hideInst()">
          <option selected>Choose...</option>
          <option value="individual">Individual</option>
          <option value="institution_bank">Institution(Bank)</option>
          <option value="institution_govt_org">Institution(Government Organisation)</option>
          <option value="institution_non_govt_org">Institution(Non-Government Organisation)</option>
          <option value="institution_edu">Institution(Education)</option>
          <option value="institution_govt_company">Institution(Government Linked Company)</option>
          <option value="institution_mosque">Institution(Mosque/Surau)</option>

        </select>
      </div>

      <div class="form-group col-md-6">
        <label style="font-size: large;" for="inputAddress">Address</label>
        <input type="text" name="address" class="form-control" id="inputAddress" placeholder="Full address">
      </div>
      <div class="form-group col-md-6">
        <div id="institution-section">
          <label style="font-size: large;" for="inputInstitutionName">Institution Name</label>
          <input type="text" name="institution_name" class="form-control" id="inputInstitutionName" placeholder="Institution Name">
        </div>

      </div>

      <div class="form-group col-md-6">
        <label style="font-size: large;" for="inputCity">City</label>
        <input type="text" name="city" class="form-control" id="inputCity" placeholder="City">
      </div>
      <div class="form-group col-md-4">
        <label style="font-size: large;" for="inputState">State</label>
        <select id="inputState" name="state" class="form-control">
          <option selected>Choose...</option>
          <option value="Johor">Johor</option>
          <option value="Kedah">Kedah</option>
          <option value="Kelantan">Kelantan</option>
          <option value="Kuala Lumpur">Kuala Lumpur</option>
          <option value="Labuan">Labuan</option>
          <option value="Melaka">Melaka</option>
          <option value="Negeri Sembilan">Negeri Sembilan</option>
          <option value="Pahang">Pahang</option>
          <option value="Penang">Penang</option>
          <option value="Perak">Perak</option>
          <option value="Perlis">Perlis</option>
          <option value="Putrajaya">Putrajaya</option>
          <option value="Sabah">Sabah</option>
          <option value="Sarawak">Sarawak</option>
          <option value="Selangor">Selangor</option>
          <option value="Terengganu">Terengganu</option>
        </select>
      </div>
      <div class="form-group col-md-2">
        <label style="font-size: large;" for="inputZip">Zip</label>
        <input type="text" name="zip" class="form-control" id="inputZip" placeholder="Zip">
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-6">
        <label style="font-size: large;" for="inputBankAccountNumber">Bank Account Number</label>
        <input type="text" name="bank_account" class="form-control" id="inputBankAccountNumber" placeholder="Bank Account Number">
      </div>
      <div class="form-group col-md-6">
        <label style="font-size: large;" for="inputBankName">Bank Name</label>
        <select id="inputBankName" name="bank_name" class="form-control">
          <option selected>Choose...</option>
          <option value="affin">Affin Bank</option>
          <option value="agro">Agro Bank</option>
          <option value="alliance">Alliance Bank</option>
          <option value="am">Am Bank</option>
          <option value="islam">Bank Islam</option>
          <option value="muamalat">Bank Muamalat</option>
          <option value="rakyat">Bank Rakyat</option>
          <option value="simpanan">Bank Simpanan Nasional</option>
          <option value="cimb">CIMB Bank</option>
          <option value="hong_leong">Hong Leong Bank</option>
          <option value="hsbc">HSBC Bank</option>
          <option value="kuwait_finance">Kuwait Finance House</option>
          <option value="maybank">Maybank</option>
          <option value="ocbc">OCBC Bank</option>
          <option value="public">Public Bank</option>
          <option value="rhb">RHB Bank</option>
          <option value="sc">Standard Chartered Bank</option>
          <option value="uob">UOB Bank</option>
        </select>
      </div>

      <div class="form-group col-md-6">
        <label style="font-size: large;" for="inputIC">IC</label>
        <input type="file" class="form-control" id="inputIC" id="files1" name="files1" multiple>
      </div>

      <div class="form-group col-md-6">
        <label style="font-size: large;" for="inputPhoto">Photo (passport size)</label>
        <input type="file" class="form-control" id="inputPhoto" id="files2" name="files2" multiple>
      </div>

      <div class="form-group col-md-12">
        <label style="font-size: large;" for="inputBankSatement">Bank Satement</label>
        <input type="file" class="form-control" id="inputBankSatement" id="files3" name="files3" multiple>
      </div>

      <div class="form-group col-md-12">
        <label style="font-size: large;" for="inputPaymentReceipt">Payment Receipt <BR>
          <a href="https://peyatim.onpay.my/order/form/SP/1" target="_blank">SAHABAT PEYATIM</a> <BR>
          Bank Islam YAWATIM: <BR>
          Yayasan Waqaf Pendidikan Anak Yatim Atau Miskin Malaysia <BR>
          1403 2010 0907 60 <BR>
        </label>
        <input type="file" class="form-control" id="inputPaymentReceipt" id="files4" name="files4" multiple>
      </div>

      <div class="form-group col">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="gridCheck" name="agreement">
          <label style="font-size: large;" class="form-check-label" for="gridCheck">
            I hereby declare that the information provided is correct
          </label>
        </div>
      </div>
      <button type="submit" class="btn btn-lg btn-primary">Submit Application</button>
  </form>

  @stop

  @section('scripts')
  <script>
    function hideInst() {

      if ($('#inputWakalahType').val() == 'individual') {
        $('#institution-section').hide();
      } else {
        $('#institution-section').show();
      }
    }
  </script>

  {!! JsValidator::formRequest('App\Http\Requests\CreateWakalah', '#create-wakalah-form') !!}

  @stop