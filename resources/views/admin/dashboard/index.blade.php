@extends('admin.app')
@section('title') Dashboard @endsection
@section('content')
    
    <section class="w3-card-4" style="padding:0.5%;">
      <!-- Payment Reversal Modal -->
<div class="modal fade centered-modal" id="reverseModal" tabsindex="-1" role="dialog" arial-labelledby="ReverseModal" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" style="text-align:center"> Enter Password To Proceed </h5>
<button  type="button" class="close" data-dismiss="modal" arial-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
<div class="form-group">
<label>
Enter Password
</label>
<input type="password" class="form-control input-lg" id="revert_password" name="revert_password">
<span id="password_check_error"></span>
</div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">Close</button>
<button type="button" id="validate_password" class="btn btn-primary">Validate</button>
</div>
</div>
</div>
</div>
<!-- End Payment Reversal Modal -->
    <div class="" id="tab-content">

<div id="list-bills" style="display:block" class="profile w3-card-4">
<!-- <h2 class="" style="text-align:center">Listed Bills</h2> -->
<div class="row" style="padding:0.5%;">

<table class="table table-responsive table-striped table-bordered">
<thead>
<tr>
<th width="15%">Select Supplier</th>
<th width="15%">Select Site</th>
<th width="15%">Select Material</th>
<th width="15%">Select Payment Status</th>
<th width="15%">Select Bill Status</th>
<th width="15%">Select Users</th>
<th width="5%">Days Due</th>
</tr>
</thead>
<tbody class="">
<td>
<select class="form-control"  name="supplier" id="supplier_all">
                        <option value="" disabled selected></option>
                    
                    </select>
</td>
<td>
<select class="form-control"  name="site_select" id="site_select">
                        <option value="" disabled selected></option>
                    
                    </select>
</td>
<td>
<select class="form-control"  name="material_select" id="material_select">
                        <option value="" disabled selected></option>
                    
                    </select>
</td>

<td>
<select class="form-control"  name="payment_status" id="payment_status">
                        <option value="" disabled selected></option>
                        <option value="paid">Paid</option>
                        <option value="unpaid">Pending</option>
                    </select>
</td>
<td>
<select class="form-control"  name="bill_status" id="bill_status">
                        <option value="" disabled selected></option>
                        <option value="approved">Approved</option>
                        <option value="pending">Pending</option>
                    </select>
</td>
<td>
<select class="form-control"  name="users_select" id="users_select">
                        <option value="" disabled selected></option>
                       
                    </select>
</td>
<td>
<input type="number" name="due_days" id="due_days">
</td>
</tbody>
</table>
 
    </div>
<div class="row" style="padding:1%;">

<div class="col-sm-2 col-sm-2 col-lg-2">
<button id="new_bill_add"  class="up-product btn btn-warning" ><i class="fa fa-product-hunt"></i>New Bill</button>

</div>
<!--
<div class="col-sm-2 col-sm-2 col-lg-2 expo">
<a href="{{ url('printExcel') }}" class="btn btn-success">Export Excel </a>
</div>
!-->

<div class="col-sm-6 col-sm-6 col-lg-6">
<div class="row input-daterange">
<div class="col-md-4">
<input type="text" name="from_date" id="from_date"  class="form-control" placeholder="From Date" readonly />
</div>
<div class="col-md-4">
                    <input type="text" name="to_date" id="to_date" class="form-control" placeholder="To Date" readonly />
                </div>
                <div class="col-md-2">
                
                    <button type="button" name="filter" id="filter" class="btn btn-primary">Filter</button>

                </div>
                <div class="col-md-2">
                <button type="button" name="refresh" id="refresh" class="btn btn-warning"><i class="fa fa-refresh"></i>Refresh</button>

                </div>
                
</div>
</div>
<div class="col-md-1 col-sm-1 col-lg-1">

</div>
</div>
<div class="row">
<div class ="w3-card-4">
<div class="row">
<div class="col-sm-1 col-md-1 col-lg-1">
</div>


  
</div>
    </div>
   
</div>
<div class="tile">
 <div class="tile-body">
 <h1 style="text-align:center;font-size:18px;border-bottom:2px solid blue;letter-spacing:0.5px;font-weight:900;font-family:cursive;">
 All Listed Bills</h1>
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
       REF<br>NO
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
        Days Due
        </th>
        <th>Status</th>
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
        <tfoot>
    
        <tr>
        <th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tr>
     </tfoot>
        </table>
</div>
</div>
        <input type="hidden" class="format_total">
        <input type="hidden" class="format_all_total">
        <div class="row">
        <div class="col-sm-2 col-md-2 col-lg-2">
        </div>
        <div class="col-sm-2 col-md-2 col-lg-2">
        </div>
        
        <div class="col-sm-2 col-md-2 col-lg-2">
        </div>
<div class="col-sm-2 col-md-2 col-lg-2">

   <span style="color:#000;font-size:12px;"  id="total_cost"></span>



        </div>

    </div>
</div>
<div id="list-suppliers" style="" class="profile w3-card-4">
<button data-toggle="modal" data-target="#mySuppliers" class="up-product btn btn-warning" ><i class="fa fa-user-plus"></i>New Supplier</button>
<h2 class="w3-center w3-bottombar w3-text-green w3-large" style="text-align:center;font-size:18px;border-bottom:2px solid blue;letter-spacing:0.5px;font-weight:900;font-family:cursive;">Listed Suppliers</h2>
<div class="tile">
            <div class="tile-body">
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
</div>
     
</div>
<div id="paid-bills" style="" class="profile w3-card-4">

<h2 style="text-align:center;font-size:18px;border-bottom:2px solid blue;letter-spacing:0.5px;font-weight:900;font-family:cursive;" class="w3-center w3-bottombar w3-text-green w3-large">Listed Payments</h2>
<input type="hidden" name="data-print" id="data-print" value="all">
<div class="row" style="">
<div class="tile">
<div class="tile-body">
<table class="table table-responsive table-striped table-bordered">
<thead>
<tr>
<th width="15%">Select Supplier</th>
<th width="15%">Select Site</th>
<th width="15%">Select Material</th>
<th width="15%">Select Payment Status</th>
<th width="50%">Date</th>

</tr>
</thead>
<tbody class="">
<td>
<select class="form-control"  name="supplier_pdf" id="supplier_pdf">
                        <option value="" disabled selected></option>
                    
                    </select>
</td>
<td>
<select class="form-control"  name="payment_site" id="payment_site">
                        <option value="" disabled selected></option>
                    
                    </select>
</td>
<td>
<select class="form-control"  name="payment_material" id="payment_material">
                        <option value="" disabled selected></option>
                    
                    </select>
</td>

<td>
<select class="form-control"  name="payment_statusp" id="payment_statusp">
                        <option value="" disabled selected></option>
                        <option value="BANK">BANK</option>
                        <option value="CASH">CASH</option>
                        <option value="MPESA">MPESA</option>
                    </select>
</td>
<td>
<div class="row input-daterange" style="padding-bottom:0.5%;" >
              <div class="col-md-5">
              <input type="text" name="from_date_payment" id="from_date_payment"  class="form-control" placeholder="From Date" readonly />
              </div>
               <div class="col-md-4">
                 <input type="text" name="to_date_payment" id="to_date_payment" class="form-control" placeholder="To Date" readonly />
                </div>
                <div class="col-md-3">
                
                    <button type="button" name="filter" id="filterp" class="btn btn-primary pull-right">Filter</button>

                </div>
                
                
</div>
</td>
</tbody>
</table>
<div class="row">
<div class="col-md-4">
                

                </div>
                <div class="col-md-4">
                

                </div>

<div class="col-md-4">
                <button type="button" name="refreshp" id="refreshp" class="btn btn-warning"><i class="fa fa-refresh"></i>Refresh</button>

                </div>
</div>
</div>
</div>
</div>

<div class="tile">
            <div class="tile-body">
            
<table  id="data-paid" style="width:100%;" class="table table-hover table-bordered  data-paid">
				<thead>
        <tr>
        <th>
        #
        </th>
        <th>Supplier</th>
        <th>Site</th>
        <th>Item</th>
        <th>Ref NO</th>
        <th>Amount Due</th>
        <th>Amount Paid</th>
        <th>Balance</th>
        <th>Paid On</th>
        <th>Mode</th>
        <th>Posting Date</th>
        <th>Clearing Date</th>
        <th>Clearance Status</th>
        <th>MPESA CODE</th>
        <th>Added On</th>
        <th>Revert</th>
				</thead>
				<tbody>
				
				</tbody>
				</table>
</div>
</div>
</div>
<div id="listed-sites" style="" class="profile w3-card-4">
<button data-toggle="modal" data-target="#sitesModal" class="btn btn-warning" ><i class="fa fa-product-hunt"></i>New Site</button>
<h2 style="text-align:center;font-size:18px;border-bottom:2px solid blue;letter-spacing:0.5px;font-weight:900;font-family:cursive;" class="w3-center w3-bottombar w3-text-green w3-large">Available Sites</h2>
<table style="width:100%" class="table table-hover table-bordered data-sites">
<thead>
<tr>
<th>
#
</th>
<th style="width:280px">
Name
</th>
<th style="width:280px">
Location
</th>
<th style="width:280px">
Edit
</th>
<th style="width:280px">
Delete
</th>
</tr>
</thead>
<tbody>

</tbody>
<tfoot>
</tfoot>
</table>
</div>
<div id="pay-bills" style="" class="profile w3-card-4">
<h2 style="text-align:center;font-size:18px;border-bottom:2px solid blue;letter-spacing:0.5px;font-weight:900;font-family:cursive;" class="w3-center w3-bottombar w3-text-green w3-large">Pay Bills</h2>

<table style="width:100%;" class="table table-hover table-bordered  pay-bills">
				<thead>
        <tr>
        <th>
        #
        </th>
        <th>Supplier</th>
        <th>Material</th>
        <th>Ref No</th>
           <th>Amount Due</th>
           <th>Amount Paid</th>
           <th>Balance</th>
           <th>Added On</th>
           <th>Edit Amount </th>
           <th>Update</th>
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
     <a href="#" class="btn btn-primary pay_total">PAY</a>
     </div>
     </div>
</div>
<div id="pending-bills" style="" class="profile w3-card-4">

<h2 style="text-align:center;font-size:18px;border-bottom:2px solid blue;letter-spacing:0.5px;font-weight:900;font-family:cursive;" class="w3-center w3-bottombar w3-text-green w3-large">Listed Pending Bills</h2>

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
<div id="update-pass" style="" class="profile card" style="padding-top:1%">

<h2 style="text-align:center;font-size:18px;border-bottom:2px solid blue;letter-spacing:0.5px;font-weight:900;font-family:cursive;" class="card-header w3-bottombar w3-text-green w3-large text-center">Update Password</h2>

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
                    <input class="form-control" name="old_password" id="old_password" type="password" aria-describedby="emailHelp" placeholder="">
                   
                  </div>
</div>
</div>
<div class="row">
<div class="col-sm-12 col-lg-12 col-md-12">
            <div class="form-group">
                    <label for="material">New Password</label>
                    <input class="form-control" name="new_password" id="new_password" type="password" aria-describedby="emailHelp" placeholder="">
                   
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
<div id="listed-users" style="" class="profile card" style="padding-top:5%">

<h2 style="text-align:center;font-size:18px;border-bottom:2px solid blue;letter-spacing:0.5px;font-weight:900;font-family:cursive;" class="card-header w3-bottombar w3-text-green w3-large text-center">Registered Eastline Users</h2>
<div class="row" style="padding:1%;">

<div class="col-sm-2 col-sm-2 col-lg-2">
<button data-toggle="modal" data-target="#myModalUsers" class="up-product btn btn-warning" ><i class="fa fa-user-plus"></i>Register User</button>

</div>
</div>
<div class="row">
<div class="col-sm-12 col-lg-12 col-md-12">
<div class="tile">
 <div class="tile-body">
<table style="width:100%;" class="table table-hover table-bordered  data-table-users">
				<thead>
				<tr>
        <th>
        #
        </th>
				<th>
				Name
				</th>
				<th>
				Email
				</th>
        <th>
				Username
				</th>
				<th>
				Phone
				</th>
				<th>
        Role
        </th>
       
        <th>
        Registered On
        </th>
        <th>
				Edit
				</th>
        <th>
       Delete
        </th>
        <th>
       Change Password
        </th>
       
       
				</tr>
				</thead>
				<tbody>
				
				</tbody>
        </table>
</div>
</div>
</div>
</div>
</div>

<div id="list-materials" style="" class="profile w3-card-4">
<button data-toggle="modal" data-target="#myMaterials" class="up-product btn btn-warning" ><i class="fa fa-product-hunt"></i>New Material</button>
<h2 style="text-align:center;font-size:18px;border-bottom:2px solid blue;letter-spacing:0.5px;font-weight:900;font-family:cursive;" class="w3-center w3-bottombar w3-text-green w3-large">Listed Materials</h2>
<div class="tile">
<div class="tile-body">
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
     
</div>
<div id="list-passwords" class="profile" style="padding-top:5%;">
<div class="row">
<div class="col-sm-6 col-lg-6 col-md-6 card">
<form method="POST" id="promptPassword">
<div class="card-header">
<h4  class="card-title" style="text-align:center">Add New Password </h4 >

</div>
<div class="card-body">
<div id="prompt_errors" class="alert alert-danger print-error-msg w3-padding-right w3-padding-left" style="display:none;padding-right:100px;">
							<a href="#" class="close" data-dismiss="alert" arial-label="close">&times;</a>
							<ul class="w3-ul" style="list-style:none;">
							
							</ul>
							</div>
<div class="form-group">
<label>Prompt On</label>
<select name="prompt_on" class="form-control input-lg selectpicker">
<option value="" disabled></option>
<option value="revert_payment">Revert Payment</option>
<option value="edit_payment">Edit Payment</option>
<option value="add_bill">Add Bill</option>
<option value="edit_bill">Edit Bill</option>
<option value="remove_bill">Remove Bill</option>
<option value="add_payment">Add Payment</option>

</select>
</div>
<div class="form-group">
<label>Password</label>
<input type="password" name="password_prompt" class="form-control input-lg">
</div>
<div class="form-group">
<label>Confirm Password</label>
<input type="password" name="password_prompt_confirm" class="form-control input-lg">
</div>

</div>
<div class="card-footer">
<button type="submit" id="btn-prompt" class="btn btn-block btn-success btn-lg">Submit</button>
</div>
</form>
</div>
<div class="col-sm-6 col-lg-6 col-md-6 card">

<div class="card-header">
<h4  class="card-title" style="text-align:center">Listed Passwords </h4 >
</div>
<div class="card-body">
<div class="tile">
            <div class="tile-body">
<table style="width:100%;"  class="table table-responsive data-passwords">
<thead style="width:100%;">
<tr>
<th style="width:100%;">#</th>
<th style="width:100%;">
Prompt On
</th>
<th style="width:100%;">
Actions
</th>
</tr>
</thead>
<tbody>

</tbody>
<tfoot>
</tfoot>
</table>
</div>
</div>
</div>
<div class="card-footer">

</div>

</div>
</div>
</div>
<div id="list-expenses-new" style="" class="profile w3-card-4" >
<button data-toggle="modal" data-target="#newExpenses" class="up-expense btn btn-warning" ><i class="fa fa-product-hunt"></i>New Expense</button>
<h2 style="text-align:center;font-size:18px;border-bottom:2px solid blue;letter-spacing:0.5px;font-weight:900;font-family:cursive;" class="w3-center w3-bottombar w3-text-green w3-large">Listed Expenses</h2>
<div class="tile">
<div class="tile-body">
<table style="width:100%;"  class="table table-bordered new-expense table-responsive">
<thead>
<tr>
<th>#</th>
<th style="width:300px;">Expense Name</th>
<th style="width:300px;" >Description</th>
<th>
     Edit   
        </th>
        <th>
       Remove
        </th>
</tr>
</thead>
<tbody>

</tbody>
</table>
</div>
</div>
</div>
<div class="profile card text-center" id="list-roles" style="padding-top:5%">
<div class="card-header font-weight-bold">
Manage Roles And Permissions
</div> 
<div class="card-body">

<form method="POST" id="roleForm">
<div class="row">
<div class="col-sm-12 col-md-12 col-lg-12" id="roleError">

</div>
</div>
<div class="row">
<div class="col-sm-2 col-md-2 col-lg-2">
</div>
<div class="col-sm-8 col-md-8 col-lg-8">
<div class="form-group">
<label>Select Role</label>
<select id="role-select" name="role_select" class="form-control input-lg selectpicker">


</select>
</div>
</div>
<div class="col-sm-2 col-md-2 col-lg-2">
</div>
</div>
<div class="row" style="display:none;" id="rol_name">
<div class="col-sm-6 col-lg-6 col-md-6">
<div class="input-group">
                 
  <span class="input-group-addon">
 Role Name
  </span>
  <input type="text" class="form-control"  name="role_name" id="role_name" >
</div>
      
</div>
</div>
<div class="row" style="padding:2%;">
<div class="col-sm-4 col-md-4 col-lg-4 card">
<div class="card-header font-weight-bold">
Bills Permission
</div>
<div class="card-body">
<div class="row select_all">
<div class="col-sm-12 col-md-12 col-lg-12">
<span class="pull-right">
<div class="icheck-primary">
    <input type="checkbox" class="bills_check_all all_checks" name="" id="bills_check_all" />
    <label  for="bills_check_all"  class="">Select All</label>
</div>
</span>
</div>
</div>
<div class="row single_permission">
<div class="col-sm-6 col-lg-6 col-md-6">
<label   class="">Add New Bill</label>
</div>
<div class="col-sm-6 col-lg-6 col-md-6">
<div class="icheck-primary">
    <input type="checkbox" class="check_bill all_checks" value="add_bill" name="permission[]" id="add_bill" />
    <label  for="add_bill"  class=""></label>
</div>


</div>
</div>
<div class="row single_permission">
<div class="col-sm-6 col-lg-6 col-md-6">
<label class="">Edit Bill<label>
</div>
<div class="col-sm-6 col-lg-6 col-md-6">
<div class="icheck-primary">
    <input type="checkbox" class="check_bill all_checks" value="edit_bill" name="permission[]" id="edit_bill" />
    <label  for="edit_bill" class=""><label>
</div>

</div>
</div>
<div class="row single_permission">
<div class="col-sm-6 col-md-6 col-lg">
<label  for=""  class="">Remove Bill</label>
</div>
<div class="col-sm-6 col-lg-6 col-md-6">
<div class="icheck-primary">
    <input type="checkbox" class="check_bill all_checks" value="remove_bill" name="permission[]" id="remove_bill" />
    <label  for="remove_bill"  class=""></label>
</div>
</div>
</div>
<div class="row single_permission">
<div class="col-sm-6 col-lg-6 col-md-6">
<label   class="">Pay Bill</label>
</div>
<div class="col-sm-6 col-lg-6 col-md-6">
<div class="icheck-primary">
    <input type="checkbox" class="check_bill all_checks" value="pay_bill" name="permission[]" id="pay_bill" />
    <label for="pay_bill"  class=""></label>
</div>
</div>
</div>
<div class="row single_permission">
<div class="col-sm-6 col-lg-6 col-md-6">
<label>Revert Bill Payment</label>
</div>
<div class="col-sm-6 col-lg-6 col-md-6">
<div class="icheck-primary">
    <input type="checkbox"  class="check_bill all_checks" value="revert_bill" name="permission[]" id="revert_bill" />
    <label for="revert_bill"  class="" ></label>
</div>
</div>
</div>
<div class="row single_permission">
<div class="col-sm-6 col-lg-6 col-md-6">
<label>View Bills</label>
</div>
<div class="col-sm-6 col-lg-6 col-md-6">
<div class="icheck-primary">
    <input type="checkbox"  class="check_bill all_checks" value="view_bill" name="permission[]" id="view_bill" />
    <label for="view_bill"  class=""></label>
</div>
</div>
</div>
<div class="row">
<div class="col-sm-6 col-lg-6 col-md-6">
<label>View Bill Payments</label>
</div>
<div class="col-sm-6 col-lg-6 col-md-6">
<div class="icheck-primary">
    <input type="checkbox"  class="check_bill all_checks" value="view_bill_payments" name="permission[]" id="view_bill_payments" />
    <label for="view_bill_payments"  class=""></label>
</div>
</div>
</div>
</div>
</div>
<div class="col-sm-4 col-md-4 col-lg-4 card">
    <div class="card-header font-weight-bold">
    Expenses Permission
    </div>
    <div class="card-body">
    <div class="row select_all">
<div class="col-sm-12 col-md-12 col-lg-12">
<span class="pull-right">
<div class="icheck-primary">
    <input type="checkbox" class="expense_check_all all_checks" name="" id="expense_check_all" />
    <label  for="expense_check_all"  class="">Select All</label>
</div>
</span>
</div>
</div>
    <div class="row single_permission">
    <div class="col-sm-6 col-lg-6 col-md-6">
    <label   class="">Add New Expense</label>
    </div>
    <div class="col-sm-6 col-lg-6 col-md-6">
    <div class="checkbox  icheck-primary">
        <input type="checkbox" style="padding-right:1%" class="check_expense all_checks" value="add_new_expense" name="permission[]" id="add_new_expense" />
        <label  for="add_new_expense"  class=""></label>
    </div>
    
    
    </div>
    </div>
    <div class="row single_permission">
    <div class="col-sm-6 col-lg-6 col-md-6">
    <label   class="">Edit Expense</label>
    </div>
    <div class="col-sm-6 col-lg-6 col-md-6">
    <div class="checkbox icheck-primary">
        <input type="checkbox" class="check_expense all_checks" value="edit_expense" name="permission[]" id="edit_expense" />
        <label  for="edit_expense"  class=""></label>
    </div>
    
    </div>
    </div>
    <div class="row single_permission">
    <div class="col-sm-6 col-lg-6 col-md-6">
    <label   class="">Remove Expense</label>
    </div>
    <div class="col-sm-6 col-lg-6 col-md-6">
    <div class="checkbox icheck-primary">
        <input type="checkbox" class="check_expense all_checks" value="remove_expense" name="permission[]" id="remove_expense" />
        <label  for="remove_expense"></label>
    </div>
    </div>
    </div>
    <div class="row single_permission">
    <div class="col-sm-6 col-lg-6 col-md-6">
    <label   class="">Pay Expense</label>
    </div>
    <div class="col-sm-6 col-lg-6 col-md-6">
    <div class="checkbox icheck-primary">
        <input type="checkbox" class="check_expense all_checks" value="pay_expense" name="permission[]" id="pay_expense" />
        <label for="pay_expense"></label>
    </div>
    </div>
    </div>
    <div class="row single_permission">
    <div class="col-sm-6 col-lg-6 col-md-6">
    <label   class="">Revert Expense Payment</label>
    </div>
    <div class="col-sm-6 col-lg-6 col-md-6">
    <div class="checkbox icheck-primary">
        <input type="checkbox" class="check_expense all_checks" value="revert_expense_payment" name="permission[]" id="revert_expense_payment" />
        <label for="revert_expense_payment"></label>
    </div>
    </div>
    </div>
    <div class="row single_permission">
    <div class="col-sm-6 col-lg-6 col-md-6">
    <label   class="">View Expenses</label>
    </div>
    <div class="col-sm-6 col-lg-6 col-md-6">
    <div class="checkbox icheck-primary">
        <input type="checkbox" class="check_expense all_checks all_checks" name="permission[]" value="view_expense"  id="view_expense" />
        <label for="view_expense"></label>
    </div>
    </div>
    </div>
    <div class="row">
    <div class="col-sm-6 col-lg-6 col-md-6">
    <label   class="">View Expense Payments</label>
    </div>
    <div class="col-sm-6 col-lg-6 col-md-6">
    <div class="checkbox icheck-primary">
        <input type="checkbox" class="check_expense all_checks" value="view_expense_payment" name="permission[]"  id="view_expense_payment" />
        <label for="view_expense_payment"></label>
    </div>
    </div>
    </div>
    </div>
    </div>
    <div class="col-sm-4 col-md-4 col-lg-4 card">
    <div class="card-header font-weight-bold">
    Materials Permission
    </div>
    <div class="card-body">
     <div class="row select_all">
<div class="col-sm-12 col-md-12 col-lg-12">
<span class="pull-right">
<div class="icheck-primary">
    <input type="checkbox" class="material_check_all all_checks" name="" id="material_check_all" />
    <label  for="material_check_all"  class="">Select All</label>
</div>
</span>
</div>
</div>
    <div class="row single_permission">
    <div class="col-sm-6 col-md-6 col-lg-6">
    <label>Add New Material</label>
    </div>
    <div class="col-sm-6 col-lg-6 col-md-6">
    <div class="checkbox  icheck-primary">
        <input type="checkbox" value="add_new_material" class="check_material all_checks" id="add_new_material" />
        <label  for="add_new_material"></label>
    </div>
  
    </div>
    </div>
    <div class="row single_permission">
    <div class="col-sm-6 col-lg-6 col-md-6">
    <label>Edit Material</label>
    </div>
    <div class="col-sm-6 col-lg-6 col-md-6">
    <div class="checkbox icheck-primary">
        <input type="checkbox" name="permission[]" value="edit_material"  class="check_material all_checks"  id="edit_material" />
        <label  for="edit_material"></label>
    </div>
    
    </div>
    </div>
    <div class="row single_permission">
    <div class="col-sm-6 col-lg-6 col-md-6">
    <label >Remove Material</label>
    </div>
    <div class="col-sm-6 col-lg-6 col-md-6">
    <div class="checkbox icheck-primary">
        <input type="checkbox" name="permission[]" value="remove_material"  class="check_material all_checks" id="remove_material" />
        <label  for="remove_material"></label>
    </div>
    </div>
    </div>
    <div class="row ">
    <div class="col-sm-6 col-lg-6 col-md-6">
    <label for="">View Materials</label>
    </div>
    <div class="col-sm-6 col-lg-6 col-md-6">
    <div class="checkbox icheck-primary">
        <input type="checkbox" name="permission[]" value="view_material" class="check_material all_checks" id="view_material" />
        <label for="view_material"></label>
    </div>
    </div>
    </div>
    </div>
    </div>
</div>
<!-- End Row  -->
<div class="row" style="padding:2%;">
<div class="col-sm-4 col-md-4 col-lg-4 card">
<div class="card-header font-weight-bold">
Sites Permission
</div>
<div class="card-body">
<div class="row select_all">
<div class="col-sm-12 col-md-12 col-lg-12">
<span class="pull-right">
<div class="icheck-primary">
    <input type="checkbox" class="site_check_all all_checks" name="permission[]"  id="site_check_all" />
    <label  for="site_check_all"  class="">Select All</label>
</div>
</span>
</div>
</div>
<div class="row single_permission">
<div class="col-sm-6 col-lg-6 col-md-6">
<label  >Add New Site</label>
</div>
<div class="col-sm-6 col-lg-6 col-md-6">
<div class="checkbox  icheck-primary">
    <input type="checkbox" class="check_site all_checks" name="permission[]" value="add_site" id="add_site" />
    <label  for="add_site"></label>
</div>


</div>
</div>
<div class="row single_permission">
<div class="col-sm-6 col-lg-6 col-md-6">
<label>Edit Site</label>
</div>
<div class="col-sm-6 col-lg-6 col-md-6">
<div class="checkbox icheck-primary">
    <input type="checkbox" class="check_site all_checks" value="edit_site" name="permission[]"  id="edit_site" />
    <label  for="edit_site"></label>
</div>

</div>
</div>
<div class="row single_permission">
<div class="col-sm-6 col-lg-6 col-md-6">
<label >Remove Site</label>
</div>
<div class="col-sm-6 col-lg-6 col-md-6">
<div class="checkbox icheck-primary">
    <input type="checkbox" class="check_site all_checks" value="remove_site" name="permission[]"  id="remove_site" />
    <label  for="remove_site"></label>
</div>
</div>
</div>
<div class="row">
<div class="col-sm-6 col-lg-6 col-md-6">
<label >View Sites</label>
</div>
<div class="col-sm-6 col-lg-6 col-md-6">
<div class="checkbox icheck-primary">
    <input type="checkbox" name="permission[]" value="view_site" class="check_site all_checks" id="view_site" />
    <label  for="view_site"></label>
</div>
</div>
</div>
</div>
</div>
<div class="col-sm-4 col-md-4 col-lg-4 card">
    <div class="card-header font-weight-bold">
    Users Permission
    </div>
    <div class="card-body ">
    <div class="row select_all">
<div class="col-sm-12 col-md-12 col-lg-12">
<span class="pull-right">
<div class="icheck-primary">
    <input type="checkbox" class="user_check_all all_checks" name="permission[]" id="user_check_all" />
    <label  for="user_check_all"  class="">Select All</label>
</div>
</span>
</div>
</div>
    <div class="row single_permission">
    <div class="col-sm-6 col-lg-6 col-md-6">
    <label>Add New User</label>
    </div>
    <div class="col-sm-6 col-lg-6 col-md-6">
    <div class="checkbox  icheck-primary">
        <input type="checkbox" class="check_user all_checks" value="add_user" name="permission[]" id="add_user" />
        <label  for="add_user"></label>
    </div>
    
    
    </div>
    </div>
    <div class="row single_permission">
    <div class="col-sm-6 col-lg-6 col-md-6">
    <label >Edit User</label>
    </div>
    <div class="col-sm-6 col-lg-6 col-md-6">
    <div class="checkbox icheck-primary">
        <input type="checkbox" class="check_user all_checks" value="edit_user" name="permission[]" id="edit_user" />
        <label  for="edit_user"></label>
    </div>
    
    </div>
    </div>
    <div class="row single_permission">
    <div class="col-sm-6 col-lg-6 col-md-6">
    <label>Remove User</label>
    </div>
    <div class="col-sm-6 col-lg-6 col-md-6">
    <div class="checkbox icheck-primary">
        <input type="checkbox" class="check_user all_checks" value="remove_user" name="permission[]" id="remove_user" />
        <label  for="remove_user"></label>
    </div>
    </div>
    </div>
    <div class="row">
    <div class="col-sm-6 col-lg-6 col-md-6">
    <label>View Users</label>
    </div>
    <div class="col-sm-6 col-lg-6 col-md-6">
    <div class="checkbox icheck-primary">
        <input type="checkbox" class="check_user all_checks" value="view_user" name="permission[]" id="view_user" />
        <label  for="view_user"></label>
    </div>
    </div>
    </div>
    </div>
    </div>
    <div class="col-sm-4 col-md-4 col-lg-4 card">
    <div class="card-header font-weight-bold">
    Passwords Permission
    </div>
    <div class="card-body">
    <div class="row select_all">
<div class="col-sm-12 col-md-12 col-lg-12">
<span class="pull-right">
<div class="icheck-primary">
    <input type="checkbox" class="password_check_all all_checks" name="" id="password_check_all" />
    <label  for="password_check_all"  class="">Select All</label>
</div>
</span>
</div>
</div>
    <div class="row single_permission">
    <div class="col-sm-6 col-lg-6 col-md-6">
    <label>Add New Password</label>
    </div>
    <div class="col-sm-6 col-lg-6 col-md-6">
    <div class="checkbox  icheck-primary">
        <input type="checkbox" class="check_password all_checks" value="add_password" name="permission[]" id="add_password" />
        <label  for="add_password"></label>
    </div>
  
    </div>
    </div>
    <div class="row single_permission">
    <div class="col-sm-6 col-lg-6 col-md-6">
    <label>Update Password</label>
    </div>
    <div class="col-sm-6 col-lg-6 col-md-6">
    <div class="checkbox icheck-primary">
        <input type="checkbox" class="check_password all_checks" value="update_password" name="permission[]" id="update_password" />
        <label  for="update_password"></label>
    </div>
    
    </div>
    </div>
    <div class="row">
    <div class="col-sm-6 col-lg-6 col-md-6">
    <label>Remove Password</label>
    </div>
    <div class="col-sm-6 col-lg-6 col-md-6">
    <div class="checkbox icheck-primary">
        <input type="checkbox" class="check_password all_checks" value="remove_password" name="permission[]" id="remove_password" />
        <label  for="remove_password"></label>
    </div>
    </div>
    </div>
    
    </div>
    </div>
</div>
<div class="row">
<div class="col-sm-12 col-lg-12 col-md-12">
<button type="submit" id="save-roles" class="btn btn-primary btn-block btn-lg"><span><i class="fa fa-check"></i></span>SAVE</button>
</div>
</div>
<!-- End Row  -->
</form>
</div>
</div>
<div id="list-expenses" style="" class="profile w3-card-4">
<h2 style="text-align:center;font-size:18px;border-bottom:2px solid blue;letter-spacing:0.5px;font-weight:900;font-family:cursive;" class="w3-center w3-bottombar w3-text-green w3-large">Listed Bill Expenses</h2>

 <div class="row">
<div class="col-sm-12 col-lg-12 col-md-12">
<div class="tile">
 <div class="tile-body">
<table class="table table-responsive table-striped table-bordered">
<thead>
<tr>
<th width="15%">Select Expense</th>
<th width="15%">Select Site</th>
<th width="15%">Mode of Payment</th>
<th width="50%">Date</th>



</tr>
</thead>
<tbody class="">
<td>
<select class="form-control"  name="select_expense" id="select_expense">
                        <option value="" disabled selected></option>
                    
                    </select>
</td>
<td>
<select class="form-control"  name="site_select_expense" id="site_select_expense">
                        <option value="" disabled selected></option>
                    
                    </select>
</td>


<td>
<select class="form-control"  name="payment_status_expense" id="payment_status_expense">
                        <option value="" disabled selected></option>
                        <option value="cheque">Cheque</option>
                    <option value="cash">Cash</option>
                    <option value="mpesa">MPESA</option>
                    </select>
</td>
<td>
<div class="row input-daterange">
<div class="col-md-4">
<input type="text" name="from_date_expense" id="from_date_expense"  class="form-control" placeholder="From Date" readonly />
</div>
<div class="col-md-5">
    <input type="text" name="to_date_expense" id="to_date_expense" class="form-control" placeholder="To Date" readonly />
</div>
<div class="col-md-3">

    <button type="button" name="filter_expense" id="filter_expense" class="btn btn-primary">Filter</button>

</div>


</div>
</td>

</tbody>
</table>
</div>
</div>
</div>

 </div>
 <div class="row" style="padding:1%;">
 <div class="col-sm-12 col-lg-12 col-md-12">
 <button data-toggle="modal" data-target="#myExpenses" class="up-expense btn btn-warning" ><i class="fa fa-product-hunt"></i>New Bill Expense</button>
 <button type="button" name="refresh_expense" id="refresh_expense" class="btn btn-warning pull-right"><i class="fa fa-refresh"></i>Refresh</button>

 </div>
 </div>
 <div class="tile">
            <div class="tile-body">
<table style="width:100%;" class="table table-hover table-bordered  data-table-expenses">
				<thead>
				<tr>
        <th>
        #
        </th>
				<th>
				Expense
				</th>
			
        <th>
				Site 
				</th>
        <th>
        Description
        </th>
        <th>
				Quantity
				</th>
        <th>
        Unit Price
        </th>
        <th>
        VAT
        </th>
        <th>
        Total
        </th>
        <th>
				Mode
				</th>
        <th>
				Cheque No
				</th>
        <th>
				Bank
				</th>
       
        <th>
				MPESA CODE
				</th>
        <th>
				Date Paid
				</th>
       
        <th>
        Added On
        </th>
        <th>
        Edit
        </th>
        <th>
       Delete
        </th>
       
				</tr>
				</thead>
				<tbody>
				
				</tbody>
        <tfoot>
    
        <tr>
        <th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tr>
     </tfoot>
        </table>
</div>
</div>
     
</div>
</div>

    </section>

  
@endsection