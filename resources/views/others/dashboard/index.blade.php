@extends('others.app')
@section('title') Dashboard @endsection
@section('content')
    
    <section class="w3-card-4">
    <div class="" id="tab-content">

<div id="list-bills" style="display:block" class="profile w3-card-4">
<button data-toggle="modal" data-target="#myModal" class="up-product btn btn-warning pull-left" ><i class="fa fa-product-hunt"></i>New Bill</button>

<h2 class="" style="text-align:center">Listed Bills



 <button type="button" class="btn btn-primary pull-right">
  Bills Added <span class="badge badge-light" id="user_bills">0</span>
</button></h2>


<div class="row card">
<div class="col-sm-12 col-md-12 col-lg-12 card-body">
<table id="data_table" style="width:100%;" class="table table-hover table-bordered">
				<thead>
				<tr>
        <th>
        #
        </th>
       
				<th>
				Material
        </th>
        <th>
       Description
       </th>
			
				<th>
				Quantity
				</th>
				<th>
				Unit Cost
				</th>
        <th>
       VAT
       </th>
       <th>
       Total Cost
       </th>
     
       <th>
       REF NO
       </th>
       <th>
       Site name
       </th>
       <th>
				Supplier
				</th>
        <th>Balance</th>
        <th>Amount Paid</th>
        <th>
        Due Date
        </th>
        <th>
        Added On
        </th>
        <th>
        Action
        </th>
        
        
				</tr>
				</thead>
				<tbody>
				
				</tbody>
				</table>
</div>
</div>
</div>
<div id="list-suppliers" style="" class="profile w3-card-4">
<button data-toggle="modal" data-target="#mySuppliers" class="up-product btn btn-warning" ><i class="fa fa-user-plus"></i>New Supplier</button>
<h2 class="w3-center w3-bottombar w3-text-green w3-large">Listed Suppliers</h2>

<table style="width:100%;" class="table table-hover table-bordered  data-tableS">
				<thead>
				<tr>
        <th>
        #
        </th>
				<th>
				Supplier
				</th>
				<th>
				Email
				</th>
				<th>
				Phone
				</th>
				<th>
				Company
				</th>
       
        <th>
        Registered On
        </th>
        <th>
       
        </th>
        <th>
       
        </th>
       
				</tr>
				</thead>
				<tbody>
				
				</tbody>
				</table>
     
</div>
<div id="paid-bills" style="" class="profile w3-card-4">

<h2 class="w3-center w3-bottombar w3-text-green w3-large">Listed Paid Bills</h2>
<input type="hidden" name="data-print" id="data-print" value="all">
<div class="row" style="padding:3%;">
  <div class="col-md-5"  align="">
      <label>Select Supplier</label>
    <select class="form-control"  name="supplier_pdf" id="supplier_pdf">
                        <option value="" disabled selected></option>
                    
                    </select>
    </div>
<div class="col-md-5 con" align="right">
     <a href="{{ url('dynamic_pdf') }}" class="btn btn-primary pull-right convert">Convert into PDF</a>
    </div>
</div>
<table  id="data-paid" style="width:100%;" class="table table-hover table-bordered  data-paid">
				<thead>
        <tr>
        <th>
        #
        </th>
        <th>Supplier</th>
           <th>Amount Due</th>
           <th>Amount Paid</th>
           <th>Balance</th>
           
           <th>Added On</th>
           <th>Edit</th>
           <th>Remove</th>
				</thead>
				<tbody>
				
				</tbody>
				</table>
        
</div>
<div id="pay-bills" style="" class="profile w3-card-4">
<h2 class="w3-center w3-bottombar w3-text-green w3-large">Pay Bills</h2>

<table style="width:100%;" class="table table-hover table-bordered  pay-bills">
				<thead>
        <tr>
        <th>
        #
        </th>
        <th>Supplier</th>
           <th>Amount Due</th>
           <th>Amount Paid</th>
           <th>Balance</th>
           <th>Added On</th>
           <th>Edit Amount</th>
           <th></th>
           <th></th>
				</thead>
				<tbody>
				
				</tbody>
				</table>
        <div class="row">
        <div class="col-sm-2 col-md-2 col-lg-2">
        </div>
        <div class="col-sm-2 col-md-2 col-lg-2">
     

<span><input type="text" name="total_amount" style="color:#000;font-size:24px;" class="total_amount form-control input-lg" id="total_amount" readonly/></span>

        </div>
        <div class="col-sm-2 col-md-2 col-lg-2">
        <input type="hidden" name="ids[]" class="ids">
        </div>
        <div class="col-sm-2 col-md-2 col-lg-2">
        <input type="hidden" name="balance[]" class="balance">
        <input type="hidden" name="amount_paid[]" class="amount_paid">
     </div>
     <div class="col-sm-2 col-md-2 col-lg-2">
     <a href="#"  id="pay_total" class="btn btn-primary pay_total">PAY</a>
     </div>
     </div>
</div>
<div id="pending-bills" style="" class="profile w3-card-4">

<h2 class="w3-center w3-bottombar w3-text-green w3-large">Listed Pending Bills</h2>

<table style="width:100%;" class="table table-hover table-bordered  data-pending">
				<thead>
				<tr>
        <th>
        #
        </th>
        <th>Supplier</th>
           <th>Amount Due</th>
           <th>Amount Paid</th>
           <th>Balance</th>
           <th>Mode</th>
           <th>MPESA Code</th>
           <th>Added On</th>
           <th></th>
           <th></th>
           <th></th>
				</tr>
				</thead>
				<tbody>
				
				</tbody>
				</table>
    
</div>
<div id="update-pass" style="" class="profile card">

<h2 class="card-header w3-bottombar w3-text-green w3-large text-center">Update Password</h2>

<form id="changePassword" class="card-body" method="POST" >
        <div>
							<div id="changeError" class="alert alert-danger print-error-msg w3-padding-right w3-padding-left" style="display:none;padding-right:100px;">
							<a href="#" class="close" data-dismiss="alert" arial-label="close">&times;</a>
							<ul class="w3-ul" style="list-style:none;">
							
							</ul>
							</div>
							</div>
              <div class="row">
            <div class="col-sm-12 col-lg-12 col-md-11">
            <div class="form-group">
                    <label for="material">Email/Username</label>
                    <input class="form-control"name="new_email" id="new_email" type="text" aria-describedby="emailHelp" placeholder="">
                   
                  </div>
</div>
</div>
        <div class="row">
            <div class="col-sm-12 col-lg-12 col-md-11">
            <div class="form-group">
                    <label for="material">Old Password</label>
                    <input class="form-control"name="old_password" id="old_password" type="password" aria-describedby="emailHelp" placeholder="">
                   
                  </div>
</div>
</div>
<div class="row">
<div class="col-sm-12 col-lg-12 col-md-12">
            <div class="form-group">
                    <label for="material">New Password</label>
                    <input class="form-control"name="new_password" id="new_password" type="password" aria-describedby="emailHelp" placeholder="">
                   
                  </div>
</div>
</div>
<div class="row">
            <div class="col-sm-12 col-lg-12 col-md-12">
            <div class="form-group">
                    <label for="price">Confirm Password</label>
                    <input class="form-control"name="confirm_password" id="confirm_passsword" type="password" aria-describedby="emailHelp" placeholder="">
                   
                  </div>
</div>

</div>

                  
                  <div class="tile-footesr">
              <div class="row">
                <div class="col-md-12 col-sm-12 col-lg-12 col-md-offset-3">
                  <button class="btn btn-primary" id="buttonReset" type="submit">
                    <i class="fa fa-fw fa-lg fa-check-circle"></i
                    >Update</button
                  >&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary cancel-pass" href="#"
                    ><i class="fa fa-fw fa-lg fa-times-circle"></i>Clear</a>
                  
                </div>
              </div>
            </div>
                </form>
</div>

<div id="list-materials" style="" class="profile w3-card-4">
<button data-toggle="modal" data-target="#myMaterials" class="up-product btn btn-warning" ><i class="fa fa-product-hunt"></i>New Material</button>
<h2 class="w3-center w3-bottombar w3-text-green w3-large">Listed Materials</h2>

<table style="width:100%;" class="table table-hover table-bordered  data-tableM">
				<thead>
				<tr>
        <th>
        #
        </th>
				<th>
				Material Name
				</th>
			
        <th>
				Description
				</th>
        <th>
        Added On
        </th>
        <th>
        
        </th>
        <th>
       
        </th>
       
				</tr>
				</thead>
				<tbody>
				
				</tbody>
				</table>
     
</div>
</div>

    </section>

  
@endsection