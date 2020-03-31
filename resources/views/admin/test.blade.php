<!DOCTYPE html>
<html lang="en">
<head>
<title>EASTLINE
</title>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="csrf-token" content="{{ csrf_token()}}">
<link rel="stylesheet" type="text/css" href="backend/css/main.css" />
<link rel="stylesheet" type="text/css" href="backend/css/bootstrap.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" integrity="sha256-rByPlHULObEjJ6XQxW/flG2r+22R5dKiAoef+aXWfik=" crossorigin="anonymous" />
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />
    							
<style>
.centered-modal.in
{
  display:flex !important;
}
.centered-modal .modal-dialog 
{
  margin:auto;
  vertical-align: middle;
}
.index 
{
  z-index:1000000000;
}
    .profile 
    {
        display:none;
    }
    .busy
{
    position: absolute;
    left: 50%;
    top: 35%;
    display: none;
   
    background: transparent url('{{asset('images/ezgif-2-6d0b072c3d3f.gif')}}');
    z-index: 1000;
    height: 31px;
    width: 31px;
}

#busy-holder
{
    background: transparent;
    width: 100%;
    height: 100%;        
}
table{
  overflow-y:scroll;
  overflow-x:scroll;
  width:100%;
  height:100%;
  display:block;
  

}
    </style>
</head>
<body class="app sidebar-mini rtl">

<!--Start Return Modal !-->
<div id="returnModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 style="text-align:center;" class="modal-title">Confirmation</h2>
            </div>
            <div class="modal-body">
                <h4 align="center" style="margin:0;text-align:center;">Are you sure you want to Return this Bill?</h4>
            </div>
            <div class="modal-footer">
             <button type="button" name="ok_return" id="ok_return" class="btn btn-danger">YES</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
            </div>
        </div>
    </div>
</div>
<!--End Return Modal !-->
  <!--Start Delete Modal !-->
<div id="confirmModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 style="text-align:center;" class="modal-title">Confirmation</h2>
            </div>
            <div class="modal-body">
                <h4 align="center" style="margin:0;text-align:center;">Are you sure you want to remove this Bill?</h4>
            </div>
            <div class="modal-footer">
             <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!--End Delete Modal !-->
  <!--Start Delete Modal !-->
  <div id="confirmExpenseModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 style="text-align:center;" class="modal-title">Confirmation</h2>
            </div>
            <div class="modal-body">
                <h4 align="center" style="margin:0;text-align:center;">Are you sure you want to remove this Expense?</h4>
            </div>
            <div class="modal-footer">
             <button type="button" name="ok_expense" id="ok_expense" class="btn btn-danger">OK</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!--End Delete Modal !-->
<!--More Details Modal !-->
<div class="modal fade" id="confirmPayment" aria-hidden="true">

    <div class="modal-dialog" style="width:100%;">
    
            <div class="modal-content">
    
                    <div class="modal-header">
    
                            <h4 class="modal-title" style="text-align:center;font-size:18px;color:#000;" id="modelHeading">Confirm You Want To This Bills</h4>
    
                    </div>
    
                    <div class="modal-body">
            <div class="row">
            <div class="col-md-6 col-lg-6 col-sm-6">
                    <table class="table table-hover table-responsive">
                    <thead>
                    <tr>
                    <th style="width:280px;">
                    Supplier
                    </th>
                    <th style="width:280px;">
                    Ref NO
                    </th>
                    <th style="width:280px;">
                    Amount To Pay
                    </th>
                  
                    
                    </tr>
                    </thead>
                    <tbody id="confirm-data">
                   
                    </tbody>
                    <tfoot>
                    <tr>
                    <th>Total</th><th></th><th id="totals"></th>
                    </tr>
                   
                    
                    </tfoot>
                    </table>
                  </div>

                    <div class="col-sm-6 col-lg-6 col-md-6">
                        <form method="POST" id="addPayment">
                        <div class="row">
                        <div class="col-sm-6 col-lg-6 col-md-6">
                   <div class="form-group">
              <label>Date Paid</label>
              <input type="date" class="form-control date_payment" id="date_payment">
              </div>
              </div>
                    <div class="col-sm-6 col-lg-6 col-md-6">
                   <div class="form-group">
              <label>Mode of Payment</label>
           <select class="form-control mode"  name="mode" id="mode">
                       <option value="" disabled selected></option>
                       <option value="CASH">CASH</option>
                       <option value="MPESA">MPESA</option>
                       <option value="BANK">BANK</option>
                       </select>
                        
                   
                       </div>
                       </div>
                       </div>
                       <div class="row input-daterange">
                       <div class="posting_date form-group col-sm-6 col-lg-6 col-md-6">
                       <label>Posting Date</label>
                       <input type="text"   placeholder="Posting Date"  name="posting_date" id="posting_date" class="form-control posting " readonly />
                       </div>
                      <div class = "clearing_date col-sm-6 col-lg-6 col-md-6">
                      <label>Clearing  Date</label>
                       <input type="text"  name="clearing_date" placeholder="Clearing Date"  id="clearing_date" class="form-control clearing" readonly />
                      </div>
                     
                      </div>
                      <div class="row">
                       <div class="mpesa_code col-sm-12 col-lg-12 col-md-12">
                      <div class="form-group">
                      <label>MPESA CODE</label>
                       <input type="text" name="mpesa_code"  placeholder="MPESA CODE"  id="mpesa_code" class="form-control ">  
                      
                     </div> 
                       </div> 
                       </div>
                        <div class="row">
                        <div class="col-sm-12 col-lg-12 col-md-12">
                        <div class="form-group">
                        <a id="add_multiple" class="btn btn-lg btn-block btn-success">Add Payment</a>
                        </div>
                        </div>
                        </div>
                        </form>
                  
                </div>
                <div style="padding:1%;" >
                <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">Close</button>
</div>
                    </div>

                    </div>
    
            </div>
    
    </div>
    
    </div>
<!-- End More Details Modal !-->
<input type="hidden" name="hidden_count" class="hidden_count" id="hidden_count">
<!-- Modal !-->
<div id="myModalEdit" class="modal fade w3-padding-left" role="dialog">
  <div class="modal-dialog"  style="width:90%;height:80%;">

    <!-- Modal content-->
    <div class="modal-content w3-padding-left w3-padding-right">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title w3-bottombar w3-center w3-padding-8" style="font-family:cursive;text-align:center;">EDIT BILL</h4>
      </div>
      <div class="modal-body">
       
      <form id="formEditBills" method="POST" >
        <div>
          <input type="hidden" name="hidden_id" id="hidden_id">
          <input type="hidden" name="hidden_details" id="hidden_details">
							<div id="siteErroru" class="alert alert-danger print-error-msg w3-padding-right w3-padding-left" style="display:none;padding-right:100px;">
							<a href="#" class="close" data-dismiss="alert" arial-label="close">&times;</a>
							<ul class="w3-ul" style="list-style:none;">
							
							</ul>
							</div>
							</div>
        <div class="row">
            <div class="col-sm-6 col-lg-6 col-md-6">
            <div class="form-group">
            <label for="price">Material</label>
            <input type="text" class="form-control"  name="matu" id="matu">
                      
                   
                  </div>
</div>
<div class="col-sm-6 col-lg-6 col-md-6">
            <div class="form-group">
            <label for="price">Supplier</label>
            <input type="text" class="form-control"  name="supplieru" id="supplieru">
                        
                   
                  </div>
</div>
</div>
<div class="row">
            <div class="col-sm-6 col-lg-6 col-md-6">
            <div class="form-group">
                    <label for="sparepart">Quantity</label>
                    <input class="form-control" name="quantityu" id="quantityu" type="number" aria-describedby="emailHelp" placeholder="">
                   
                  </div>
</div>
<div class="col-sm-6 col-lg-6 col-md-6">
            <div class="form-group">
                    <label for="price">Unit Cost</label>
                    <input class="form-control" name="unit_costu" id="unit_costu" type="number" aria-describedby="" placeholder="">
                   
                  </div>
</div>
</div>

<div class="row">
            <div class="col-sm-6 col-lg-6 col-md-6">
            <div class="form-group">
                    <label for="sparepart">REF NO</label>
                    <input class="form-control" name="ref_nou" id="ref_nou" type="text" aria-describedby="emailHelp" placeholder="">
                   
                  </div>
</div>
<div class="col-sm-6 col-lg-6 col-md-6">
            <div class="form-group">
                    <label for="price">Site Name </label>
                    <input class="form-control" name="site_nameu" id="site_nameu" type="text" aria-describedby="" placeholder="">
                   
                  </div>
</div>
</div>
<div class="row">
            <div class="col-sm-6 col-lg-6 col-md-6">
            <div class="form-group">
            <label for="price">Days Due</label>
            <input class="form-control" name="dueu" id="dueu" type="number" aria-describedby="emailHelp" placeholder="">
                   
                   
                  </div>
</div>
<div class="col-sm-3 col-lg-3 col-md-3">
<div class="form-group">
                    <label for="date">DATE </label>
                    <input class="form-control" name="date_addedu" id="date_addedu" type="date" aria-describedby="emailHelp" placeholder="">
                   
                  </div>
</div>
</div>
                  
                  <div class="tile-footer">
              <div class="row">
                <div class="col-md-12 col-sm-12 col-lg-12 col-md-offset-3">
                  <button class="btn btn-primary" id="buttonEditBills" type="submit">
                    <i class="fa fa-fw fa-lg fa-check-circle"></i
                    >EDIT</button
                  >&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary cancel_editbills" href="#"
                    ><i class="fa fa-fw fa-lg fa-times-circle"></i>RESET</a>
                  
                </div>
              </div>
            </div>
                </form>
    </div>

  </div>
</div>
           </div>
        </div>
    <!--End Modal !-->
 <!-- Modal !-->
 <div id="myModalUsers" class="modal fade w3-padding-left" role="dialog">
  <div class="modal-dialog"  style="width:90%;height:80%;">

    <!-- Modal content-->
    <div class="modal-content w3-padding-left w3-padding-right">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title w3-bottombar w3-center w3-padding-8" style="font-family:cursive;text-align:center;">New User Registration</h4>
      </div>
      <div class="modal-body">
       
      <form id="registerUser" class="card-body" method="POST">
        <div>
							<div id="userError" class="alert alert-danger print-error-msg w3-padding-right w3-padding-left" style="display:none;padding-right:100px;">
							<a href="#" class="close" data-dismiss="alert" arial-label="close">&times;</a>
							<ul class="w3-ul" style="list-style:none;">
							
							</ul>
							</div>
							</div>
              <div class="row">
            <div class="col-sm-6 col-lg-6 col-md-6">
            <div class="form-group">
                    <label for="material">Name</label>
                    <input class="form-control"name="user_name" id="user_name" type="text" aria-describedby="emailHelp" placeholder="">
                   
                  </div>
</div>

            <div class="col-sm-6 col-lg-6 col-md-6">
            <div class="form-group">
                    <label for="material">Username</label>
                    <input class="form-control"name="user_email" id="user_email" type="text" aria-describedby="emailHelp" placeholder="">
                   
                  </div>
</div>
</div>

        <div class="row">
            <div class="col-sm-12 col-lg-12 col-md-12">
            <div class="form-group">
                    <label for="material">Phone Number</label>
                    <input class="form-control"name="phone_number" id="phone_number" type="number" aria-describedby="emailHelp" placeholder="">
                   
                  </div>
</div>

        
</div>
<div class="row">
<div class="col-sm-6 col-lg-6 col-md-6">
            <div class="form-group">
                    <label for="material">Password</label>
                    <input class="form-control"name="user_password" id="user_password" type="password" aria-describedby="emailHelp" placeholder="">
                   
                  </div>
</div>

            <div class="col-sm-6 col-lg-6 col-md-6">
            <div class="form-group">
                    <label for="price">Confirm Password</label>
                    <input class="form-control"name="user_confirm_password" id="user_confirm_passsword" type="password" aria-describedby="emailHelp" placeholder="">
                   
                  </div>
</div>

</div>

                  
                  <div class="tile-footesr">
              <div class="row">
                <div class="col-md-12 col-sm-12 col-lg-12 col-md-offset-3">
                  <button class="btn btn-primary" id="buttonUser" type="submit">
                    <i class="fa fa-fw fa-lg fa-check-circle"></i
                    >Register</button
                  >&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary cancel-pass" href="#"
                    ><i class="fa fa-fw fa-lg fa-times-circle"></i>Clear</a>
                  
                </div>
              </div>
            </div>
                </form>
    </div>

  </div>
</div>
           </div>
        </div>
    <!--End Modal !-->
     <!-- Modal !-->
     
 <div id="sitesModal"  class="modal fade w3-padding-left" role="dialog">
  <div class="modal-dialog"  style="width:90%;height:80%;">

    <!-- Modal content-->
    <div class="modal-content w3-padding-left w3-padding-right">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title w3-bottombar w3-center w3-padding-8" style="font-family:cursive;text-align:center;">Add New Site</h4>
      </div>
      <div class="modal-body">
       
      <form id="formSites" class="card-body" method="POST">
        <div>
							<div id="siteError" class="alert alert-danger print-error-msg w3-padding-right w3-padding-left" style="display:none;padding-right:100px;">
							<a href="#" class="close" data-dismiss="alert" arial-label="close">&times;</a>
							<ul class="w3-ul" style="list-style:none;">
							
							</ul>
							</div>
							</div>
              <div class="row">
            <div class="col-sm-6 col-lg-6 col-md-6">
            <div class="form-group">
                    <label for="material">Site Name</label>
                    <input class="form-control" name="site_name" id="site_name" type="text" aria-describedby="emailHelp" placeholder="">
                   
                  </div>
</div>

            <div class="col-sm-6 col-lg-6 col-md-6">
            <div class="form-group">
                    <label for="material">Location</label>
                    <input class="form-control"name="location_site" id="location_site" type="text" aria-describedby="emailHelp" placeholder="">
                   
                  </div>
</div>
</div>


                  
                  <div class="tile-footesr">
              <div class="row">

                <div class="col-md-4 col-sm-4 col-lg-4">
                <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">Close</button>
                </div>
                <div class="col-md-4 col-sm-4 col-lg-4">
                  <button class="btn btn-primary" id="buttonSites" type="submit">
                    <i class="fa fa-fw fa-lg fa-check-circle"></i
                    >Add Site</button
                  >&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary cancel-pass" href="#"
                    ><i class="fa fa-fw fa-lg fa-times-circle"></i>Clear</a>
                 </div>
                </div>
              </div>
              
            </div>
                </form>
    </div>
    <div class="row">
                <div class="col-md-12 col-sm-12 col-lg-12" style="padding-left:10%;padding-bottom:4%;">

                </div>
                </div>

  </div>
</div>
           </div>
        </div>
    <!--End Modal !-->
    <!-- Modal !-->
<div id="myModalEditUsers" class="modal fade w3-padding-left" role="dialog">
  <div class="modal-dialog"  style="width:90%;height:80%;">

    <!-- Modal content-->
    <div class="modal-content w3-padding-left w3-padding-right">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title w3-bottombar w3-center w3-padding-8" style="font-family:cursive;text-align:center;">EDIT USER DETAILS</h4>
      </div>
      <div class="modal-body">
       
      <form id="registerEditUser" class="card-body" method="POST">
        <input type="hidden" name="hidden_user_id" id="hidden_user_id">
        <div>
							<div id="edituserError" class="alert alert-danger print-error-msg w3-padding-right w3-padding-left" style="display:none;padding-right:100px;">
							<a href="#" class="close" data-dismiss="alert" arial-label="close">&times;</a>
							<ul class="w3-ul" style="list-style:none;">
							
							</ul>
							</div>
							</div>
              <div class="row">
            <div class="col-sm-6 col-lg-6 col-md-6">
            <div class="form-group">
                    <label for="material">Name</label>
                    <input class="form-control"name="user_nameu" id="user_nameu" type="text" aria-describedby="emailHelp" placeholder="">
                   
                  </div>
</div>

            <div class="col-sm-6 col-lg-6 col-md-6">
            <div class="form-group">
                    <label for="material">Username</label>
                    <input class="form-control" name="user_emailu" id="user_emailu" type="text" aria-describedby="emailHelp" placeholder="">
                   
                  </div>
</div>
</div>

        <div class="row">
            <div class="col-sm-12 col-lg-12 col-md-12">
            <div class="form-group">
                    <label for="material">Phone Number</label>
                    <input class="form-control"name="phone_numberu" id="phone_numberu" type="number" aria-describedby="emailHelp" placeholder="">
                   
                  </div>
</div>

        
</div>
<div class="row">
  <!--
<div class="col-sm-6 col-lg-6 col-md-6">
            <div class="form-group">
                    <label for="material">Password</label>
                    <input class="form-control"name="user_passwordu" id="user_passwordu" type="password" aria-describedby="emailHelp" placeholder="">
                   
                  </div>
</div>

            <div class="col-sm-6 col-lg-6 col-md-6">
            <div class="form-group">
                    <label for="price">Confirm Password</label>
                    <input class="form-control"name="user_confirm_passwordu" id="user_confirm_passswordu" type="password" aria-describedby="emailHelp" placeholder="">
                   
                  </div>
</div>
!-->
</div>

                  
                  <div class="tile-footesr">
              <div class="row">
                <div class="col-md-12 col-sm-12 col-lg-12 col-md-offset-3">
                  <button class="btn btn-primary" id="buttonUserEdit" type="submit">
                    <i class="fa fa-fw fa-lg fa-check-circle"></i
                    >EDIT</button
                  >&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary cancel-pass" href="#"
                    ><i class="fa fa-fw fa-lg fa-times-circle"></i>Clear</a>
                  
                </div>
              </div>
            </div>
                </form>
    </div>

  </div>
</div>
           </div>
        </div>
    <!--End Modal !-->
     <!-- Modal !-->
<div id="myModalshowBill" class="modal fade w3-padding-left" role="dialog">
  <div class="modal-dialog"  style="width:90%;height:80%;">

    <!-- Modal content-->
    <div class="modal-content w3-padding-left w3-padding-right">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title w3-bottombar w3-center w3-padding-8" style="font-family:cursive;text-align:center;">Confirm You Want To Approve This Bill</h4>
      </div>
      <div class="modal-body">
       <div class="row">
       <div class="col-sm-4 col-lg-4 col-md-4">
       </div>
       <div class="col-md-8 col-sm-8 col-lg-8">
       <table class="table table-hover table-responsive">
       <thead>
       <tr>
       <td>
       RefNo
       </td>
       <td>
       Added By
       </td>
       <td>
       Material
       </td>
       <td>
       Supplier
     </td>
     <td>
       Total Cost
     </td>
       </tr>
       </thead>
       <tbody>
       <tr>
       <td id="td_ref">

       </td>
       <td id="td_by">

</td>
<td id="td_mat">

</td>
<td id="td_sup">

</td>
<td id="td_total">

</td>
       </tr>
       </tbody>
       </table>
       </div>
       </div>

       <div class="modal-footer">
             <button type="button" name="ok_approve" id="ok_approve" class="btn btn-success">OK</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
            </div>
    </div>

  </div>
</div>
           </div>
        </div>
    <!--End Modal !-->
<!-- Modal !-->
<div id="myModalEditUserspassword" class="modal fade w3-padding-left" role="dialog">
  <div class="modal-dialog"  style="width:90%;height:80%;">

    <!-- Modal content-->
    <div class="modal-content w3-padding-left w3-padding-right">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title w3-bottombar w3-center w3-padding-8" style="font-family:cursive;text-align:center;">EDIT USER DETAILS</h4>
      </div>
      <div class="modal-body">
       
      <form id="registerEditPassword" class="card-body" method="POST">
        <input type="hidden" name="hidden_password_id" id="hidden_password_id">
        <div>
							<div id="editpasswordError" class="alert alert-danger print-error-msg w3-padding-right w3-padding-left" style="display:none;padding-right:100px;">
							<a href="#" class="close" data-dismiss="alert" arial-label="close">&times;</a>
							<ul class="w3-ul" style="list-style:none;">
							
							</ul>
							</div>
							</div>
              <div class="row">
           

       
</div>

<div class="row">
  
<div class="col-sm-6 col-lg-6 col-md-6">
            <div class="form-group">
                    <label for="material">Password</label>
                    <input class="form-control"name="user_passwordu" id="user_passwordu" type="password" aria-describedby="emailHelp" placeholder="">
                   
                  </div>
</div>

            <div class="col-sm-6 col-lg-6 col-md-6">
            <div class="form-group">
                    <label for="price">Confirm Password</label>
                    <input class="form-control"name="user_confirm_passwordu" id="user_confirm_passswordu" type="password" aria-describedby="emailHelp" placeholder="">
                   
                  </div>
</div>

</div>

                  
                  <div class="tile-footesr">
              <div class="row">
                <div class="col-md-12 col-sm-12 col-lg-12 col-md-offset-3">
                  <button class="btn btn-primary" id="buttonPasswordEdit" type="submit">
                    <i class="fa fa-fw fa-lg fa-check-circle"></i
                    >EDIT</button
                  >&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary cancel-pass" href="#"
                    ><i class="fa fa-fw fa-lg fa-times-circle"></i>Clear</a>
                  
                </div>
              </div>
            </div>
                </form>
    </div>

  </div>
</div>
           </div>
        </div>
    <!--End Modal !-->
    <!-- Modal !-->
<div id="myModalEditPaid" class="modal fade w3-padding-left" role="dialog">
  <div class="modal-dialog"  style="width:90%;height:80%;">

    <!-- Modal content-->
    <div class="modal-content w3-padding-left w3-padding-right">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title w3-bottombar w3-center w3-padding-8" style="font-family:cursive;text-align:center;">Edit Amount Paid</h4>
      </div>
      <div class="modal-body">
       
      <form id="editPaid" class="card-body" method="POST">
        <input type="hidden" name="hidden_edit_paid_id" id="hidden_edit_paid_id">
        <div>
							<div id="editpaidError" class="alert alert-danger print-error-msg w3-padding-right w3-padding-left" style="display:none;padding-right:100px;">
							<a href="#" class="close" data-dismiss="alert" arial-label="close">&times;</a>
							<ul class="w3-ul" style="list-style:none;">
							
							</ul>
							</div>
							</div>
              <div class="row">
           

       
</div>

<div class="row">
  
<div class="col-sm-12 col-lg-12 col-md-12">
            <div class="form-group">
                    <label for="material">Amount_paid</label>
                    <input class="form-control input-lg" name="amount_edit_paid" id="amount_edit_paid" type="number" aria-describedby="emailHelp" placeholder="">
                   
                  </div>
</div>
<input type="hidden" name="amount_edit_due" id="amount_edit_due">

  
</div>

                  
                  <div class="tile-footesr">
              <div class="row">
                <div class="col-md-12 col-sm-12 col-lg-12 col-md-offset-3">
                  <button class="btn btn-primary" id="buttonEditPaid" type="submit">
                    <i class="fa fa-fw fa-lg fa-check-circle"></i
                    >Update</button
                  >&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary cancel-pass" href="#"
                    ><i class="fa fa-fw fa-lg fa-times-circle"></i>Clear</a>
                  
                </div>
              </div>
            </div>
                </form>
    </div>

  </div>
</div>
           </div>
        </div>
    <!--End Modal !-->
     <!-- Modal !-->
 <div id="myModalView" class="modal fade w3-padding-left" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content w3-padding-left w3-padding-right">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title w3-bottombar w3-center w3-padding-8" id="supplier-name" style="font-family:cursive;text-align:center;">Payment Details</h4>
      </div>
      <div  class="modal-body">
       <table id="data" class="table table-responsive">
         <tr>
           <td>Supplier</td>
           <td>Amount Due</td>
           <td>Amount Paid</td>
           <td>Balance</td>
           <td>Mode</td>
           <td>MPESA Code</td>
           <td>Added On</td>
</tr>
 

</table>
      
    </div>

  </div>
</div>
           </div>
        </div>
    <!--End Modal !-->
    <!-- Modal !-->
 <div id="myModalPay" class="modal fade w3-padding-left" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content w3-padding-left w3-padding-right">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title w3-bottombar w3-center w3-padding-8" id="supplier-name" style="font-family:cursive;text-align:center;">EDIT BILL</h4>
      </div>
      <div class="modal-body">
       
      <form id="formPayBills" method="POST" >
        <div>
          <input type="hidden" name="hidden_pay" id="hidden_pay">
          <input type="hidden" name="hidden_payid" id="hidden_payid">
          <input type="hidden" name="hidden_refno" id="hidden_refno">
							<div id="siteErrorPay" class="alert alert-danger print-error-msg w3-padding-right w3-padding-left" style="display:none;padding-right:100px;">
							<a href="#" class="close" data-dismiss="alert" arial-label="close">&times;</a>
							<ul class="w3-ul" style="list-style:none;">
							
							</ul>
							</div>
							</div>
        <div class="row">
            <div class="col-sm-12 col-lg-12 col-md-12">
            <div class="form-group">
            <label for="price">Amount Due</label>
            <input type="text" class="form-control"  name="amount_due" id="amount-due" readonly required="">
                      
                   
                  </div>
</div>
<div class="col-sm-12 col-lg-12 col-md-12">
            <div class="form-group">
            <label for="price">Balance</label>
            <input type="text" class="form-control"  name="balance" id="balance" required="" readonly>
                        
                   
                  </div>
</div>
<div class="col-sm-12 col-lg-12 col-md-12">
            <div class="form-group">
            <label for="price">Amount Paid</label>
            <input type="text" class="form-control"  name="amount_paid" id="amount-paid" required="">
                        
                   
                  </div>
</div>
                  <div class="col-sm-12 col-lg-12 col-md-12">
            <div class="form-group">
            <label for="price">Mode of Payment</label>
            <select class="form-control"  name="" id="">
                        <option value="" disabled selected></option>
                    <option value="CASH">CASH</option>
                    <option value="MPESA">MPESA</option>
                    <option value="BANK">BANK</option>
                    </select>
                        
                   
                  </div>
                
</div>
<div class="col-sm-12 col-lg-12 col-md-12  mpesa_code" style="display:none">
            <div class="form-group">
            <label for="price">MPESA CODE</label>
            <input type="text" class="form-control"  name="mpesa_code" id="mpesa_code">
                        
                   
                  </div>
</div>


</div>
                  
                  <div class="tile-footer">
              <div class="row">
                <div class="col-md-12 col-sm-12 col-lg-12 col-md-offset-3">
                  <button class="btn btn-primary" id="buttonPayBills" type="submit">
                    <i class="fa fa-fw fa-lg fa-check-circle"></i
                    >PAY</button
                  >&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary cancel_paybills" href="#"
                    ><i class="fa fa-fw fa-lg fa-times-circle"></i>RESET</a>
                  
                </div>
              </div>
            </div>
                </form>
    </div>

  </div>
</div>
           </div>
        </div>
    <!--End Modal !-->
             <!-- Modal !-->
             <div id="myModal" class="modal fade w3-padding-left" role="dialog">
  <div class="modal-dialog" style="width:90%;height:80%;">

    <!-- Modal content-->
    <div class="modal-content w3-padding-left w3-padding-right">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title w3-bottombar w3-center w3-padding-8" style="font-family:cursive;text-align:center;">Add New Bill </h4>
      </div>
      <div class="modal-body">
       
      <form id="formBills" method="POST" >
      <input type="hidden" name="logged_in" class="logged_in" id="logged_in" value="<?php  echo Auth::user()->name ?>">
        
        <div>
							<div id="billError" class="alert alert-danger print-error-msg w3-padding-right w3-padding-left" style="display:none;padding-right:100px;">
							<a href="#" class="close" data-dismiss="alert" arial-label="close">&times;</a>
							<ul class="w3-ul" style="list-style:none;">
							
							</ul>
							</div>
							</div>
        <div class="row">
            <div class="col-sm-3 col-lg-3 col-md-3">
            <label for="price">Supplier</label>
            <div class="input-group">
           
            <select id="supplier" class="selectpicker form-control" data-live-search="true"  name="supplier">
                       

                    </select>           
  <span class="input-group-btn">
  <button data-toggle="modal" data-target="#mySuppliers" class="up-product btn btn-warning" ><i class="fa fa-user-plus"></i>New</button>
  </span>
</div>
            
</div>
<div class="col-sm-3 col-lg-3 col-md-3">
<div class="form-group">
                    <label for="sparepart">REF NO</label>
                    <input class="form-control"name="ref_no" id="ref_no" type="text" aria-describedby="emailHelp" placeholder="">
                   
                  </div>
</div>
<div class="col-sm-3 col-lg-3 col-md-3">
<label for="price">Site Name </label>
<div class="input-group">

                   <select id="select-box" name="site_name_select" class="selectpicker form-control" data-live-search="true">
                 <option value="" disabled>Select Site</option>
                   
                   </select>
                   <span class="input-group-btn">
  <a  data-toggle="modal" data-target="#sitesModal" id="new-select-site" class="up-product btn btn-warning" ><i class="fa fa-home"></i>New</a>
  </span>
                  </div>
</div>
<div class="col-sm-3 col-lg-3 col-md-3">
<div class="form-group">
                    <label for="date">DATE </label>
                    <input class="form-control" name="date_added" id="date_added" type="date" aria-describedby="emailHelp" placeholder="">
                   
                  </div>
</div>
</div>
<div class="row">
<div class="col-sm-12 col-md-12 col-lg-12">
<table class="table table-responsive table-striped table-bordered" id="item_table">
<thead>
<tr>
<th width="20%">Item</th>
<th width="20%">Price</th>
<th width="20%">Quantity</th>
<th width="20%">Total</th>
<th width="20%">Days Due</th>
<th width="20%">Action</th>
</tr>
</thead>
<tbody class="new-item">
</tbody>
<tfoot>
<td colspan="3" align="right">
<b>GRAND TOTAL</b>
</td>
<td id="grand_total"></td>
</tfoot>
</table>
</div>
</div>


                  
                  <div class="tile-footer" style="padding:1%;">
              <div class="row">
              <div class="col-md-4 col-sm-4 col-lg-4">
                <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">Close</button>
                </div>
                <div class="col-md-4 col-sm- col-lg-4 col-md-offset-3">
                  <button class="btn btn-primary" id="buttonBills" type="submit">
                    <i class="fa fa-fw fa-lg fa-check-circle"></i
                    >ADD</button
                  >&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary cancel_bills" href="#"
                    ><i class="fa fa-fw fa-lg fa-times-circle"></i>RESET</a>
                  
                </div>
              </div>
            </div>
                </form>
    </div>

  </div>
</div>
           </div>
        </div>
    <!--End Modal !-->
   <!-- Modal !-->
   <div id="mySuppliers" class="modal fade w3-padding-left" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content w3-padding-left w3-padding-right">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title w3-bottombar w3-center w3-padding-8" style="font-family:cursive;">Add New Supplier </h4>
      </div>
      <div class="modal-body">
       
      <form id="formSuppliers" method="POST" >
        <div>
							<div id="supError" class="alert alert-danger print-error-msg w3-padding-right w3-padding-left" style="display:none;padding-right:100px;">
							<a href="#" class="close" data-dismiss="alert" arial-label="close">&times;</a>
							<ul class="w3-ul" style="list-style:none;">
							
							</ul>
							</div>
							</div>
        <div class="row">
            <div class="col-sm-6 col-lg-6 col-md-6">
            <div class="form-group">
                    <label for="material">Supplier Name</label>
                    <input class="form-control"name="supplier_name" id="supplier_name" type="text" aria-describedby="emailHelp" placeholder="">
                   
                  </div>
</div>
<div class="col-sm-6 col-lg-6 col-md-6">
            <div class="form-group">
                    <label for="material">Supplier Email</label>
                    <input class="form-control"name="supplier_email" id="spare_name" type="text" aria-describedby="emailHelp" placeholder="">
                   
                  </div>
</div>
</div>
<div class="row">
            <div class="col-sm-6 col-lg-6 col-md-6">
            <div class="form-group">
                    <label for="price">Supplier Phone</label>
                    <input class="form-control"name="supplier_phone" id="supplier_phone" type="number" aria-describedby="emailHelp" placeholder="">
                   
                  </div>
</div>
<div class="col-sm-6 col-lg-6 col-md-6">
            <div class="form-group">
                    <label for="price">Company Name</label>
                    <input class="form-control" name="company_name" id="company_name" type="text" aria-describedby="" placeholder="">
                   
                  </div>
</div>
</div>

                  
                  <div class="tile-footesr">
              <div class="row">
                <div class="col-md-12 col-sm-12 col-lg-12 col-md-offset-3">
                  <button class="btn btn-primary" id="buttonSupplier" type="submit">
                    <i class="fa fa-fw fa-lg fa-check-circle"></i
                    >ADD</button
                  >&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary cancel" href="#"
                    ><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                  
                </div>
              </div>
            </div>
                </form>
    </div>

  </div>
</div>
           </div>
        </div>
    <!--End Modal !-->
    <!-- Modal !-->
   <div id="mySuppliersEdit" class="modal fade w3-padding-left" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content w3-padding-left w3-padding-right">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title w3-bottombar w3-center w3-padding-8" style="font-family:cursive;">EDIT SUPPLIER DETAILS</h4>
      </div>
      <div class="modal-body">
       
      <form id="formSuppliersEdit" method="POST" >
      <input type="hidden" id="hidden_sup_edit" name="hidden_sup_edit">
      <input type="hidden" id="hidden_sup_name" name="hidden_sup_name">
        <div>
							<div id="supErroru" class="alert alert-danger print-error-msg w3-padding-right w3-padding-left" style="display:none;padding-right:100px;">
							<a href="#" class="close" data-dismiss="alert" arial-label="close">&times;</a>
							<ul class="w3-ul" style="list-style:none;">
							
							</ul>
							</div>
							</div>
        <div class="row">
            <div class="col-sm-6 col-lg-6 col-md-6">
            <div class="form-group">
                    <label for="material">Supplier Name</label>
                    <input class="form-control"name="supplier_nameu" id="supplier_nameu" type="text" aria-describedby="emailHelp" placeholder="">
                   
                  </div>
</div>
<div class="col-sm-6 col-lg-6 col-md-6">
            <div class="form-group">
                    <label for="material">Supplier Email</label>
                    <input class="form-control"name="supplier_emailu" id="supplier_emailu" type="text" aria-describedby="emailHelp" placeholder="">
                   
                  </div>
</div>
</div>
<div class="row">
            <div class="col-sm-6 col-lg-6 col-md-6">
            <div class="form-group">
                    <label for="price">Supplier Phone</label>
                    <input class="form-control"name="supplier_phoneu" id="supplier_phoneu" type="number" aria-describedby="emailHelp" placeholder="">
                   
                  </div>
</div>
<div class="col-sm-6 col-lg-6 col-md-6">
            <div class="form-group">
                    <label for="price">Company Name</label>
                    <input class="form-control" name="company_nameu" id="company_nameu" type="text" aria-describedby="" placeholder="">
                   
                  </div>
</div>
</div>

                  
                  <div class="tile-footesr">
              <div class="row">
                <div class="col-md-12 col-sm-12 col-lg-12 col-md-offset-3">
                  <button class="btn btn-primary" id="buttonSupplieru" type="submit">
                    <i class="fa fa-fw fa-lg fa-check-circle"></i
                    >EDIT</button
                  >&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary cancel" href="#"
                    ><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                  
                </div>
              </div>
            </div>
                </form>
    </div>

  </div>
</div>
           </div>
        </div>
    <!--End Modal !-->
     <!-- Modal !-->
   <div id="myMaterials" class="modal fade w3-padding-left" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content w3-padding-left w3-padding-right">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title w3-bottombar w3-center w3-padding-8" style="font-family:cursive;">Add New Material </h4>
      </div>
      <div class="modal-body">
       
      <form id="formMaterials" method="POST" >
        <div>
							<div id="supMat" class="alert alert-danger print-error-msg w3-padding-right w3-padding-left" style="display:none;padding-right:100px;">
							<a href="#" class="close" data-dismiss="alert" arial-label="close">&times;</a>
							<ul class="w3-ul" style="list-style:none;">
							
							</ul>
							</div>
							</div>
        <div class="row">
            <div class="col-sm-12 col-lg-12 col-md-12">
            <div class="input-group">
                    <label for="material">Material Name</label>
                    <input class="form-control" name="material_name" id="material_name" type="text" aria-describedby="emailHelp" placeholder="">
           
                  </div>
                  
</div>


</div>
<div class="row">
            <div class="col-sm-12 col-lg-12 col-md-12">
<div class="form-group">
            <label for="price">Description</label>
                   <textarea name="material_desc" id="material_desc" class="form-control">

                   </textarea>
                   
                   
                  </div>
                  </div>
                  </div>

                  
                  <div class="tile-footesr">
              <div class="row">
                <div class="col-md-12 col-sm-12 col-lg-12 col-md-offset-3">
                  <button class="btn btn-primary" id="buttonMaterial" type="submit">
                    <i class="fa fa-fw fa-lg fa-check-circle"></i
                    >ADD</button
                  >&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary cancel" href="#"
                    ><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                  
                </div>
              </div>
            </div>
                </form>
    </div>

  </div>
</div>
           </div>
        </div>
    <!--End Modal !-->
      <!-- Modal !-->
   <div id="newExpenses" class="modal fade w3-padding-left" role="dialog">
  <div class="modal-dialog" style="width:100%">

    <!-- Modal content-->
    <div class="modal-content w3-padding-left w3-padding-right">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title w3-bottombar w3-center w3-padding-8" style="font-family:cursive;text-align:center">Add New Expense </h4>
      </div>
      <div class="modal-body">
       
      <form id="formnewExpenses" method="POST" >
        <div>
							<div id="expensenewError" class="alert alert-danger print-error-msg w3-padding-right w3-padding-left" style="display:none;padding-right:100px;">
							<a href="#" class="close" data-dismiss="alert" arial-label="close">&times;</a>
							<ul class="w3-ul" style="list-style:none;">
							
							</ul>
							</div>
							</div>
        <div class="row">
            <div class="col-sm-6 col-lg-6 col-md-6">
            <div class="input-group">
                    <label for="material">Expense Name</label>
                    <input type="text" name="expense_name" class="form-control" id="expense_name">
                  </div>
                  
</div>
<div class="col-sm-6 col-lg-6 col-md-6">
<div class="form-group">
<label>Description</label>
<textarea class="form-control" name="expense_description">
</textarea>
</div>
          </div>

</div>
                  
                  <div class="tile-footesr">
              <div class="row">
                <div class="col-md-12 col-sm-12 col-lg-12 col-md-offset-3">
                  <button class="btn btn-primary" id="buttonnewExpense" type="submit">
                    <i class="fa fa-fw fa-lg fa-check-circle"></i
                    >ADD EXPENSE</button
                  >&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary cancel" href="#"
                    ><i class="fa fa-fw fa-lg fa-times-circle"></i>RESET</a>
                </div>
                <div class="row">
                <div class="col-md-12 col-sm-12 col-lg-12 col-md-offset-3">
                <button type="button" class="btn btn-secondary pull-right" data-dismiss="modal">Close</button>

                </div>
                </div>

              </div>
            </div>
                </form>
    </div>

  </div>
</div>
           </div>
        </div>
    <!--End Modal !-->
     <!-- Modal !-->
   <div id="myExpenses" class="modal fade w3-padding-left" role="dialog">
  <div class="modal-dialog" style="width:100%">

    <!-- Modal content-->
    <div class="modal-content w3-padding-left w3-padding-right">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title w3-bottombar w3-center w3-padding-8" style="font-family:cursive;text-align:center">Add New Expense </h4>
      </div>
      <div class="modal-body">
       
      <form id="formExpenses" method="POST" >
        <div>
							<div id="expenseError" class="alert alert-danger print-error-msg w3-padding-right w3-padding-left" style="display:none;padding-right:100px;">
							<a href="#" class="close" data-dismiss="alert" arial-label="close">&times;</a>
							<ul class="w3-ul" style="list-style:none;">
							
							</ul>
							</div>
							</div>
        <div class="row">
            
<div class="col-sm-4 col-lg-4 col-md-4">
<div class="form-group">
            <label for="price">Site Name</label>
            <select  name="site_name_expense" id="site_name_expense" class="selectpicker form-control" data-live-search="true">
                 <option value="" disabled><option>
                   
                   </select>
          
          </div>
          </div>
          <div class="col-sm-4 col-lg-4 col-md-4">
<div class="form-group input-daterange">
            <label for="price">Date Paid</label>
            <input type="text" name="date_paid" id="date_paid" class="form-control" required/>
          </div>
          </div>   
          <div class="col-sm-4 col-lg-4 col-md-4">
            <div class="input-group">
                    <label for="material">Mode of Payment</label>
                    <select class="form-control" name="mode_expense" id="mode_expense">
                    <option value="" disabled selected></option>
                    <option value="">Select Mode</option>
                    <option value="cheque">Cheque</option>
                    <option value="cash">Cash</option>
                    <option value="mpesa">MPESA</option>
                  </select>
           
                  </div>
                  
</div>

</div>
<div class="row">
 <div class="col-sm-4 col-lg-4 col-md-4" id="bank_expense">
 <label>Bank Name</label>
<input type="text" name="expense_bank_name" id="expense_bank_name" class="form-control">
 </div>
<div class="col-sm-4 col-lg-4 col-md-4" id="cheque_expense">
<div class="form-group">
            <label for="price">Cheque No</label>
            <input type="text" name="cheque_no" id="cheque_no" class="form-control" >
          </div>
          </div>   
          <div class="col-sm-4 col-lg-4 col-md-4" id="expense_code">
          <div class="form-group">
            <label for="price">MPESA CODE </label>
            <input type="text" name="mpesa_code_expense" id="mpesa_code_expense" class="form-control" >
          </div>
</div>
 </div>
<div class="row">
<table class="table table-striped table-bordered table-responsive">
<thead>
<tr>
<th style="width:300px;">
<label>Expense</label>
</th>
<th style="width:300px;">
<label>Quantity</label>
</th>
<th style="width:300px;">
<label>Unit Cost</label>
</th>
<th style="width:300px;">TOTAL</th>
</tr>
</thead>
<tbody class="new_expense">

</tbody>
<tfoot>
<td colspan="3" align="right">
<b>GRAND TOTAL</b>
</td>
<td id="grand_total_expense"></td>
</tfoot>
</table>
</div>



                  
                  <div class="tile-footesr">
              <div class="row">
                <div class="col-md-12 col-sm-12 col-lg-12 col-md-offset-3">
                  <button class="btn btn-primary" id="buttonExpense" type="submit">
                    <i class="fa fa-fw fa-lg fa-check-circle"></i
                    >ADD EXPENSE</button
                  >&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary cancel" href="#"
                    ><i class="fa fa-fw fa-lg fa-times-circle"></i>RESET</a>
                </div>
                <div class="row">
                <div class="col-md-12 col-sm-12 col-lg-12 col-md-offset-3">
                <button type="button" class="btn btn-secondary pull-right" data-dismiss="modal">Close</button>

                </div>
                </div>

              </div>
            </div>
                </form>
    </div>

  </div>
</div>
           </div>
        </div>
    <!--End Modal !-->
    <!-- Modal !-->
   <div id="editExpenses" class="modal fade w3-padding-left" role="dialog">
  <div class="modal-dialog" style="width:100%">

    <!-- Modal content-->
    <div class="modal-content w3-padding-left w3-padding-right">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title w3-bottombar w3-center w3-padding-8" style="font-family:cursive;text-align:center">Edit Expense </h4>
      </div>
      <div class="modal-body">
       
      <form id="formEditExpenses" method="POST" >
      <input type="hidden" name="hidden_expense_id" id="hidden_expense_id">
        <div>
							<div id="expenseError" class="alert alert-danger print-error-msg w3-padding-right w3-padding-left" style="display:none;padding-right:100px;">
							<a href="#" class="close" data-dismiss="alert" arial-label="close">&times;</a>
							<ul class="w3-ul" style="list-style:none;">
							
							</ul>
							</div>
							</div>
        <div class="row">
            <div class="col-sm-6 col-lg-6 col-md-6">
            <div class="input-group">
                    <label for="material">Expense Name</label>
                    <select class="form-control" name="expenseu" id="expenseu">
                    <option value="" disabled selected></option>
                    <option value="electricity">Electricity</option>
                    <option value="labour">Labour</option>
                    
                  </select>
           
                  </div>
                  
</div>
<div class="col-sm-6 col-lg-6 col-md-6">
<div class="form-group">
            <label for="price">Site Name</label>
            <input type="text" name="site_namee" id="site_namee" class="form-control" required/>
          </div>
          </div>

</div>
<div class="row">
<div class="col-sm-6 col-lg-6 col-md-6">
<div class="form-group">
            <label for="price">Amount Paid</label>
            <input type="text" name="amount_expenseu" id="amount_expenseu" class="form-control" required/>
          </div>
          </div>   
          <div class="col-sm-6 col-lg-6 col-md-6">
            <div class="input-group">
                    <label for="material">Mode of Payment</label>
                    <select class="form-control" name="mode_expenseu" id="mode_expenseu">
                    <option value="" disabled selected></option>
                    <option value="cheque">Cheque</option>
                    <option value="cash">Cash</option>
                    <option value="mpesa">MPESA</option>
                  </select>
           
                  </div>
                  
</div>
 </div>
 <div class="row">
<div class="col-sm-6 col-lg-6 col-md-6">
<div class="form-group">
            <label for="price">Cheque No</label>
            <input type="text" name="cheque_nou" id="cheque_nou" class="form-control" >
          </div>
          </div>   
          <div class="col-sm-6 col-lg-6 col-md-6">
          <div class="form-group">
            <label for="price">MPESA CODE </label>
            <input type="text" name="mpesa_codeu" id="mpesa_codeu" class="form-control" >
          </div>
</div>
 </div>
 <div class="row">
<div class="col-sm-4 col-lg-4 col-md-4">
<div class="form-group input-daterange">
            <label for="price">Date Paid</label>
            <input type="text" name="date_paidu" id="date_paidu" class="form-control" required/>
          </div>
          </div>   
          <div class="col-sm-4 col-lg-4 col-md-4">
          <div class="form-group">
            <label for="price">Month </label>
            <input type="text" name="monthu" id="monthu" class="form-control" required/>
          </div>
          </div> 
          <div class="col-sm-4 col-lg-4 col-md-4">
          <div class="form-group">
            <label for="price">YEAR </label>
            <input type="text" name="yearu" id="yearu" class="form-control" required/>
          </div>
          </div>

          </div>
                  
                  <div class="tile-footesr">
              <div class="row">
                <div class="col-md-12 col-sm-12 col-lg-12 col-md-offset-3">
                  <button class="btn btn-primary" id="buttoneditExpense" type="submit">
                    <i class="fa fa-fw fa-lg fa-check-circle"></i
                    >EDIT EXPENSE</button
                  >&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary cancel" href="#"
                    ><i class="fa fa-fw fa-lg fa-times-circle"></i>RESET</a>
                </div>
                <div class="row">
                <div class="col-md-12 col-sm-12 col-lg-12 col-md-offset-3">
                <button type="button" class="btn btn-secondary pull-right" data-dismiss="modal">Close</button>

                </div>
                </div>

              </div>
            </div>
                </form>
    </div>

  </div>
</div>
           </div>
        </div>
    <!--End Modal !-->
@include('admin.partials.header')
@include('admin.partials.siderbar')
<main class="app-content">
@yield('content')
</main>

<script src="backend/js/jquery-3.3.1.min.js"></script>
<script  src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
			  integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
			  crossorigin="anonymous"></script>
<script src="backend/js/simple.money.format.js"></script>
<script src="backend/js/popper.min.js"></script>
<script src="backend/js/bootstrap.min.js"></script>
    <script src="backend/js/main.js"></script>
    <script src="backend/js/screenfull.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>  
    <script src="backend/js/plugins/pace.min.js"></script>
<script type="text/javascript" src="js/sweetalert.min.js"></script>
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.62/vfs_fonts.js" integrity="sha256-UsYCHdwExTu9cZB+QgcOkNzUCTweXr5cNfRlAAtIlPY=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.colVis.min.js"></script>

<script src="https://cdn.datatables.net/plug-ins/1.10.20/api/sum().js"></script>


<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
<script type="text/javascript">
function fetchMaterials()
{
  
  $.ajax({
        url:"fetchMaterials",
        type:"GET",
        dataType:'json',
        success:function(data)
        {
          var materials =" ";
          $.each(data,function(index,element){
              materials +='<option value="' + element.material_name + '">' + element.material_name + '</option>'
              $('body').find('.mat').html(materials);
             
          });
          $('#material_select').append(materials);
              $('#payment_material').append(materials);
         
        }
    });

}
// function dynamicSites()
// {
//   $.ajax({
//         type:"GET",
//         url:"fetchSites",
//         success:function(response)
//         {
//           var selectize = element[0].selectize;
//           var my_data = response.data;
//           if(my_data.length)
//           {
//             for(var i=0;i < my_data.length;i++)
//             {
//               var item = my_data[i]
//               var data = {
//                 'site_name' :item.site_name
//               };
//               selectize.addOptions(data);
//               selectize.refreshOptions();
//             }
//           }
//         },
//         error:function(error)
//         {
//           console.log(error);
//         }
//   });
// }
function fetchNotifications()
{
  $.ajax({
     url:"notifyLatest",
     type:"GET",
     dataType:'json',
     success:function(data)
     {
       var notifications ="";
       var due_days ;
       var count = data.length;
       
       $('#note-count').html(count);
       $('#new-notes').html(count);
       $.each(data,function(index,element){
        if(element.due_in < 0)
        {
          due_days = "<b class='text-danger'> " +  Math.abs(element.due_in) + " Days Overdue </b>";
        }
        else if(element.due_in >0)
        {
          due_days = "<b class='text-warning'>" + element.due_in + " Days</b>";
        }
         notifications +=' <li>' +
                '<a class="app-notification__item" href="javascript:;">' +
                '<span class="app-notification__icon" ' +
                   ' ><span class="fa-stack fa-lg" ' +
                     ' ><i class="fa fa-circle fa-stack-2x text-primary"></i ' +
                     '><i class="fa fa-envelope fa-stack-1x fa-inverse" ></i> ' +
                     '</span></span>' +
                 '<div>' +
                   '<p class="app-notification__message">' +
                      'Bill With REF NO '  + element.ref_no +
                    '</p>' +
                   '<p class="app-notification__meta">' + due_days + '</p>' +
                  '</div></a></li>';
       });
       $('#latest-notifications').html(notifications);
     }
  });
}
// function fetchSites()
// {

//   $.ajax({
//         url:"fetchSites",
//         type:"GET",
//         dataType:'json',
//         success:function(data)
//         {
//           var sites =" ";
//           $.each(data,function(index,element){
//               sites +='<option value="' + element.site_name + '">' + element.site_name + '</option>'
             
//               $('#site_select').append(sites);
//               $('#payment_site').append(sites);

//           });
         
//         }
//     });

// }
function fetchSuppliers()
{
    $.ajax({
        url:"fetchSuppliers",
        type:"GET",
        dataType:'json',
        success:function(data)
        {
          var suppliers =" ";
          $.each(data,function(index,element){
              suppliers +='<option value="' + element.supplier_name + '" data-tokens="' + element.supplier_name + '">' + element.supplier_name + '</option>';
          });
        //  $('#supplier').val('');
          $('#supplier').trigger('reset');
          $('#supplier').html(suppliers);
          $('#supplier').selectpicker('refresh');
        }
    });
}
function fetchSites()
{
  $.ajax({
        url:'fetchSites',
        type:'GET',
        contentType: "application/json; charset=utf-8",
        dataType:'json',
        success:function(data)
        {
          //alert("DATA");
          var sites = '';
       //  $('#select-box').html('<option data-tokens="ketchup mustard">Hot Dog, Fries and a Soda</option>');
         
          $.each(data,function(index,element){
            //alert();
            sites +='<option value="' + element.site_name + '" data-tokens="' + element.site_name + '">' + element.site_name + '</option>';
          });
          $('#select-box').append(sites);
          $('#site_select_expense').append(sites);
          $('#payment_site').append(sites);
          $('#site_select').append(sites);
          $('#site_name_expense').append(sites);
          $('#site_name_expense').selectpicker('refresh');
          $('#select-box').selectpicker('refresh');
        },
        failure:function()
        {
          alert("Failed!");
        }
    });
}
function fetchExpenses()
{
  $.ajax({
        url:'fetchExpenses',
        type:'GET',
        contentType: "application/json; charset=utf-8",
        dataType:'json',
        success:function(data)
        {
          //alert("DATA");
          var expense = '';
       //  $('#select-box').html('<option data-tokens="ketchup mustard">Hot Dog, Fries and a Soda</option>');
         
          $.each(data,function(index,element){
            //alert();
            expense +='<option value="' + element.expense_name + '" data-tokens="' + element.expense_name + '">' + element.expense_name + '</option>';
          });
          $('.expense2').append(expense);
          $('#select_expense').append(expense);
          // $('.expense2').selectpicker('refresh');
        },
        failure:function()
        {
          alert("Failed!");
        }
    });
}
function fetchSupplier()
{
    $.ajax({
        url:"fetchSuppliers",
        type:"GET",
        dataType:'json',
        success:function(data)
        {
          var suppliers =" ";
          $.each(data,function(index,element){
              suppliers +='<option value="' + element.id + '">' + element.supplier_name + '</option>'
          });
          $('#select-suppliers').append(suppliers);
        }
    })
}
function fetchPdfSupplier()
{
    $.ajax({
        url:"fetchSuppliers",
        type:"GET",
        dataType:'json',
        success:function(data)
        {
          var suppliers =" ";
          $.each(data,function(index,element){
              suppliers +='<option value="' + element.supplier_name + '">' + element.supplier_name + '</option>'
          });
          $('#supplier_pdf').append(suppliers);
          $('#supplier_all').append(suppliers);
        }
    })
}
function fetchUsers()
{
    $.ajax({
        url:"fetchUsersData",
        type:"GET",
        dataType:'json',
        success:function(data)
        {
          var users =" ";
          $.each(data,function(index,element){
              users +='<option value="' + element.name + '">' + element.name + '</option>'
          });
          $('#users_select').append(users);
     
        }
    })
}


function load_paid(supplierp='',materialp='',sitep='',from_datep='',to_datep='',paymentp='')
{
  var supplierp = $("#supplier_pdf").val();
  var sitep = $("#payment_site").val();
  var materialp = $("#payment_material").val();
  var paymentp = $("#payment_statusp").val();
  var from_datep =$("#from_date_payment").val();
  var to_datep = $("#to_date_payment").val();

  var paid = $('.data-paid').DataTable({
    processing:true,
       serverSide:true,
       responsive:true,
        ajax:
        {
         url: 'paid',
         data:{supplierp:supplierp,materialp,sitep,from_datep,to_datep,paymentp},
        },
        "columns":[
 
                {data:'DT_RowIndex',name: 'DT_RowIndex'},
                {data:'supplier_name',name:'supplier_name'},
                {data:'site_name',name:'site_name'},
                {data:'item',name:'item'},
                {data:'ref_no',name:'ref_no'},
                {data:'total_cost',name:'total_cost',render: $.fn.dataTable.render.number( ',' )},
                {data:'amount_paid',name:'amount_paid',render: $.fn.dataTable.render.number( ',' )},
                {data:'balance',name:'balance',render: $.fn.dataTable.render.number( ',' )},
                {data:'date_payment',name:'date_payment'},
                {data:'mode_payment',name:'mode_payment'},
                {data:'posting_date',name:'posting_date'},
                {data:'clearing_date',name:'clearing_date'},
                {data:'payment_clearance_status',name:'payment_clearance_status'},
                {data:'mpesa_code',name:'mpesa_code'},
                {data:'created_at',name:'created_at'},
                {data:'revert',name:'revert',orderable:false,searchable:false},
				
            
        ],
        dom: 'lBfrtip',
        buttons: [
    {extend:'excel',footer:true, exportOptions: {
                    columns: ':visible',
                   }
                   
                   },
    {extend:'csv',footer:true,},
    {extend:'pdf',footer:true},
    {extend:'copy',footer:true},
    'colvis'
   ],
   "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ]
    
  
});
}
//new-expense
function load_expense(from_date ='', to_date ='',expense='',site='',payment_status='')
{
  //var exportTitle = $("#supplier_all").val();
  var expense = $('#select_expense').val();
  var site =    $("#site_select_expense").val();
  var payment_status  = $("#payment_status_expense").val();
 
 var from_date = $('#from_date_expense').val();
 var to_date = $('#to_date_expense').val();
  var paid = $('.data-table-expenses').DataTable({
    processing:true,
       serverSide:true,
       responsive:true,
        ajax:
        {
         url: 'expense',
         data:{from_date:from_date,to_date:to_date,expense:expense,site:site,payment_status:payment_status},

        },
        "columns":[
 
                {data:'DT_RowIndex',name: 'DT_RowIndex'},
                {data:'expense_name',name:'expense_name'},
                {data:'site',name:'site'},
                {data:'expense_description',name:'expense_description'},
                {data:'quantity',name:'quantity'},
                {data:'unit_price',name:'unit_price',render: $.fn.dataTable.render.number( ',' )},
                {data:'vat',name:'vat',render: $.fn.dataTable.render.number( ',' )},
                {data:'total_amount',name:'total_amount',render: $.fn.dataTable.render.number( ',' )},
                {data:'mode_payment',name:'mode_payment'},
                {data:'cheque_no',name:'cheque_no'},
                {data:'bank_name',name:'bank_name'},
                {data:'mpesa_code',name:'mpesa_code'},
                {data:'date_paid',name:'date_paid'},
                {data:'created_at',name:'created_at'},
                {data:'edit',name:'edit',orderable:false,searchable:false},
                {data:'delete',name:'delete',orderable:false,searchable:false},
			
			
                
				
            
        ],
        drawCallback: function () {
      var api = this.api();
     var total  = $('.format_total').val(
        api.column( 7, {search:'applied',page:'current'} ).data().sum()
 );
 // Total over all pages
 //$('.format_all_total').val(api.column(6,{search:'applied'} ).data().sum());
 var numFormat = $.fn.dataTable.render.number( ",", ".", 0, " " ).display;
 var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
            total_all = api
                .column(7,{search:'applied'})
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
                $( api.column( 7 ).footer() ).html
            (
                numFormat(total_all)
            );
                /*
                $('.format_all_total').val(total_all);     
 $('.format_all_total').simpleMoneyFormat();
// $('.format_total').simpleMoneyFormat();
// var new_tot= $('.format_total').val();
 var total_pages = $('.format_all_total').val();
 //$('#total_order').html(new_tot);
 $('#total_all').html(total_pages);
 */

    },
        dom: 'lBfrtip',
        buttons: [
    {extend:'excel',footer:true, exportOptions: {
                    columns: ':visible',
                   }
                   
                   },
    {extend:'csv',footer:true,},
    {extend:'pdf',footer:true},
    {extend:'copy',footer:true},
    'colvis'
   ],
   "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ]
    
  
});
}

function loadNewExpense()
{
  //var exportTitle = $("#supplier_all").val();
  var new_expense = $('.new-expense').DataTable({
    processing:true,
       serverSide:true,
       responsive:true,
        ajax:
        {
         url: 'exp',
         
        },
        "columns":[
 
                {data:'DT_RowIndex',name: 'DT_RowIndex'},
                {data:'expense_name',name:'expense_name'},
                {data:'expense_description',name:'expense_description'},
                {data:'edit',name:'edit',orderable:false,searchable:false},
                {data:'delete',name:'delete',orderable:false,searchable:false},
			
			
                
				
            
        ],
        dom: 'lBfrtip',
        buttons: [
    {extend:'excel',footer:true, exportOptions: {
                    columns: ':visible',
                   }
                   
                   },
    {extend:'csv',footer:true,},
    {extend:'pdf',footer:true},
    {extend:'copy',footer:true},
    'colvis'
   ],
   "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ]
    
  
});
}
function load_sites()
{
  //var exportTitle = $("#supplier_all").val();
  var paid = $('.data-sites').DataTable({
    processing:true,
       serverSide:true,
       responsive:true,
        ajax:
        {
         url: 'sites',
         
        },
        "columns":[
 
                {data:'DT_RowIndex',name: 'DT_RowIndex'},
                {data:'site_name',name:'site_name'},
                {data:'location',name:'location'},
                {data:'edit',name:'edit',orderable:false,searchable:false},
                {data:'delete',name:'delete',orderable:false,searchable:false},
			
			
                
				
            
        ],
        dom: 'lBfrtip',
        buttons: [
    {extend:'excel',footer:true, exportOptions: {
                    columns: ':visible',
                   }
                   
                   },
    {extend:'csv',footer:true,},
    {extend:'pdf',footer:true},
    {extend:'copy',footer:true},
    'colvis'
   ],
   "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ]
    
  
});
}
function load_passwords()
{
  //var exportTitle = $("#supplier_all").val();
  var paid = $('.data-passwords').DataTable({
    processing:true,
       serverSide:true,
       responsive:true,
        ajax:
        {
         url: 'passwords',
         
        },
        "columns":[
 
                {data:'DT_RowIndex',name: 'DT_RowIndex'},
                {data:'prompt_on',name:'prompt_on'},
                {data:'edit',name:'edit',orderable:false,searchable:false},
			
			
                
				
            
        ],
        
    
  
});
}
function load_data(from_date ='', to_date ='',supplier='',payment_status='',bill_status='',users='',days_due='')
{
  var logged_in = $('#logged_in').val();
  var supplier =  $("#supplier_all").val();
  var site =    $("#site_select").val();
  var material = $("#material_select").val();
  var payment_status  = $("#payment_status").val();
  var bill_status = $("#bill_status").val();
  var users_select = $("#users_select").val();
  var due_days = $('#due_days').val();
  var supplier_name;
 
 var from_date = $('#from_date').val();
var to_date = $('#to_date').val();
var date,site_title,material_title,due_days_title,payment_title;
var exportTitle;
if(!$("#supplier_all").val())
{
  //alert('Both Date is required');
  supplier_name= " ";
}
else
{
  supplier_name = supplier;
}
if(from_date !='' && to_date !='')
{
  date = " From " + from_date + " To " + to_date;
}
else if(!$("#from_date").val() && !$("#to_date").val())
{
  date = " "
}

if(!$('#site_select').val())
{
  site_title = " ";
}
else
{
  site_title =" Supplied to " + site + " site ";
}
if(!$('#material_select').val())
{
  material_title = " ";
}
else
{
  material_title = " Supplied " +  material + " ";
}
if(!$('#payment_status').val())
{
  payment_title = " ";
}
else
{
  payment_title = payment_status + " Payments ";
}
if(due_days !='')
{
  //alert('Both Date is required');
  due_days_title = "Due in " + due_days_title;
}
else
{
  due_days_title = " ";
}
if(!$("#from_date").val() && !$("#to_date").val() && !$("#supplier_all").val()
 && !$("#site_select").val() && !$("#material_select").val()
  && !$('#due_days').val() && !$('#payment_status').val())
{
 exportTitle = "All Records";
}
else
{
  exportTitle = supplier_name + date + site_title  + material_title  + payment_title + due_days_title ;
}
  //alert(logged_in);
  
  var table = $('#data_table').DataTable({
    
       responsive:true,
        ajax:
        {
         url: '{{route("bills.index")}}',
         data:{from_date:from_date,to_date:to_date,supplier:supplier,site:site,material:material,payment_status:payment_status,bill_status:bill_status,users_select:users_select,logged_in:logged_in,due_days:due_days},
        },
        "columns":[
            
                {data:'DT_RowIndex',name: 'DT_RowIndex'},
                {data:'item',name:'item'},
                {data:'mat_description',name:'mat_description'},
                {data:'quantity',name:'quantity'},
                {data:'price',name:'price',render: $.fn.dataTable.render.number( ',' )},
                {data:'vat',name:'vat',render: $.fn.dataTable.render.number( ',' )},
                {data:'total_cost',name:'total_cost',render: $.fn.dataTable.render.number( ',' )},
                {data:'ref_no',name:'ref_no'},
                {data:'site_name',name:'site_name'},
                {data:'supplier_name',name:'supplier_name'},
                {data:'balance',name:'balance',render: $.fn.dataTable.render.number( ',' )},
                {data:'amount_paid',name:'amount_paid',render: $.fn.dataTable.render.number( ',')},
                {data:'due_date',name:'due_date'},
                {data:'days',name:'days'},
                {data:'status_new',name:'status_new'},
                {data:'date_added',name:'date_added'},
                {data:'edit',name:'edit',orderable:false,searchable:false},
			
				
            
        ],
        drawCallback: function () {
      var api = this.api();
     var total  = $('.format_total').val(
        api.column( 6, {search:'applied',page:'current'} ).data().sum()
 );
 // Total over all pages
 //$('.format_all_total').val(api.column(6,{search:'applied'} ).data().sum());
 var numFormat = $.fn.dataTable.render.number( ",", ".", 0, " " ).display;
 var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
            total_all = api
                .column(6,{search:'applied'})
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
                $( api.column( 6 ).footer() ).html
            (
                numFormat(total_all)
            );
                /*
                $('.format_all_total').val(total_all);     
 $('.format_all_total').simpleMoneyFormat();
// $('.format_total').simpleMoneyFormat();
// var new_tot= $('.format_total').val();
 var total_pages = $('.format_all_total').val();
 //$('#total_order').html(new_tot);
 $('#total_all').html(total_pages);
 */

    },
        dom: 'lBfrtip',
        buttons: [
    {extend:'excel',footer:true, exportOptions: {
                    columns: ':visible',
                   },
                   title:exportTitle
                   },
    {extend:'csv',footer:true,},
    {extend:'pdf',footer:true, exportOptions: {
                    columns: ':visible',
                   },
                   title:exportTitle
                   },
    {extend:'copy',footer:true},
    'colvis'
   ],
   "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
   
    });
   var total_sum = table.column( 6 ).data().sum();
 // alert(data.total_cost);
}
function fetchVat()
{
  var from_date = $('#from_date').val();
var to_date = $('#to_date').val();

  $.ajax({
    url:'fetchvat',
    type:'GET',
    data:{from_date:from_date,to_date:to_date},
   
    success:function(data)
    {
      
        //alert(element.total_vat);
       // $('#total_vat').html(data);
      
    	
    }
  });
}
function fetchTotal()
{
  var payment_status = $('#payment_status').val();
  var bill_status = $('#bill_status').val();
var from_date = $('#from_date').val();
var to_date = $('#to_date').val();
var supplier=$('#supplier_all').val();
var users=$('#users_select').val();
  $.ajax({
    url:'fetchtotal',
    type:'GET',

    data:{from_date:from_date,to_date:to_date,supplier:supplier,payment_status:payment_status,bill_status:bill_status,users:users},
    success:function(data)
    {
      
      //  $('#total_cost').html(data);
     
    	
    }
  });
}

function updateClearance()
{
  $.ajax({
    url:'updateClearance',
    type:'GET',
    success:function(data)
    {

    }
  })
}
function insertAll()
{
  
  $.ajax({
    url:'insertSites',
    type:'GET',
    success:function(data)
    {

    //  $('#select-box').append('<option data-tokens="ketchup mustard">Hot Dog, Fries and a Soda</option>');

    }
  })
} 
function insertAllExp()
{
  
  $.ajax({
    url:'expNames',
    type:'GET',
    success:function(data)
    {

    //  $('#select-box').append('<option data-tokens="ketchup mustard">Hot Dog, Fries and a Soda</option>');

    }
  })
}
function insertAllDetails()
{
  
  $.ajax({
    url:'expDetails',
    type:'GET',
    success:function(data)
    {

    //  $('#select-box').append('<option data-tokens="ketchup mustard">Hot Dog, Fries and a Soda</option>');

    }
  })
}

$(document).ready(function(){
  $('#select-box').selectpicker();
  $('#supplier').selectpicker();
  // $('.expense2').selectpicker();
 $('#new-select-site').click(function(){
   $('#sitesModal').addClass("index");
 });
$(document).on('click','.confirmRevert',function(){
  var id = $(this).attr('id');
  var payment_id = $(this).attr('data-id');
  swal({
  title: "Are you sure you want to revert this payment ?",
  text: "Once reverted, you will not be able to recover this payment!",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
    var prompt= "revert_payment";
    $.ajax({
      url:"checkpassword",
      method:"POST",
      data:{prompt:prompt},
      success:function(data)
      {
         if(data=="ok")
         {
          $('#reverseModal').modal('show');
           
             $('#validate_password').click(function(){
              var password = $('#revert_password').val();
            $.ajax({
              url:"confirm_password",
              method:"POST",
              data:{password:password,prompt:prompt},
              success:function(data)
              {
                if(data=="ok")
                {
                  $.ajax({
              url:"revert_payment",
              method:"POST",
              data:{id:id,payment_id:payment_id},
              success:function(data)
              {
                
                if(data=="ok")
                {
                  swal({
                    icon:"success",
                    text:"Payment Has Been Reversed",
                    buttons:true
                  });
                  $('.pay-bills').DataTable().ajax.reload();
                  $('.data-paid').DataTable().ajax.reload();
                  $('#data_table').DataTable().ajax.reload();
                  $('#reverseModal').modal('toggle');
                  $('#password_check_error').html('');
                  $('#revert_password').val('');
                }
              }
            });
                }
                else
                {
                  $('#password_check_error').html('<b id="password_shake" class="text-danger">Wrong Password!!!</b>');
                  $('#password_shake').effect('shake');
                  $('#revert_password').val('');
                }
              }
            });
             });
         }
         else
         {
            
         }
      }

    })



  } else {
    swal("Your payment file is safe!");
  }
});
});
 
  insertAll();
  insertAllExp();
  insertAllDetails();
 //$('#select-box').append('<option value="Parklands">Parklands</option>');
  
  $(function () {
			$('#supported').text('Supported/allowed: ' + !!screenfull.enabled);

			if (!screenfull.enabled) {
				return false;
			}

			

			$('#toggle').click(function () {
				screenfull.toggle($('.app')[0]);
			});
			

			
		});
    $(document).on('keyup','.change-amount',function(){
      var max_value=$(this).attr('id');
     // alert(max_value);
      var value = parseInt($(this).val());
      if(value>max_value)
      {
       // alert(value);
        //alert(max_value);
        alert("This Amount Exceeds The Balance");
        $(this).val(max_value);
      }
    });
  $(document).on('click','.returnBill',function(){
               var bil_id = $(this).attr('data-id');
							 var return_id = $(this).attr('id');
							 $('#returnModal').modal('show');
						 $('#ok_return').click(function(){
                $.ajax({
                  url:"return",
                  type:'GET',
                  data:{
                    return_id:return_id
                  },
									beforeSend:function()
									{
										$('#ok_button').text('Returning Bill...');
									},
									success:function(data)
									{
										swal({
												title:"Success",
												text:"Bill Successfully Returned",
												icon:"success",
												button:"OK"
											});
                      $('#ok_button').text('Return');
										setTimeout(function(){
											$('#returnModal').modal('hide');
											$('#data_table').DataTable().ajax.reload()
										,2000});
                  
            fetchTotal();
									}
								});
						 });
						});
$(document).on('keyup','.quant',function(){
  var value = this.value;
  var index = $(this).index();
 
 var sum = 0;
  var unit = $(".un_cost");
  var total_input = $(".total_count");
 
  for(var i=0;i<unit.length;i++)
  { 
   
    if(i==index)
    {
      var element = $(this).closest('tr').find(".un_cost").val();
     
   var  total = value * element;
    $(this).closest('tr').find(".total_count").val(total);
    }
   
  }
 
  $('.total_count').each(function(){
    var new_value = this.value;
   // alert(new_value);
    if(new_value)
    {
      sum = parseFloat(sum) + parseFloat(new_value);
    }
  });
  $('#grand_total').html(sum);
})
$(document).on('keyup','.expense_price',function(){
  var value = this.value;
  var index = $(this).index();
 
 var sum = 0;
  var quantity = $(".expense_quantity");
  //var total_input = $(".total_count");
 
  for(var i=0;i<quantity.length;i++)
  { 
   
    if(i==index)
    {
      var element = $(this).closest('tr').find(".expense_quantity").val();
     
   var  total = value * element;
   //alert(total);
    $(this).closest('tr').find(".total_expense").val(total);
    }
   
  }
 
  $('.total_expense').each(function(){
    var new_value = this.value;
   // alert(new_value);
    if(new_value)
    {
      sum = parseFloat(sum) + parseFloat(new_value);
    }
  });
  $('#grand_total_expense').html(sum);
})
 var count = 1;
 dynamic_field(count);
 function dynamic_field(number)
 {
   $('.hidden_count').val(count);
  html = '<tr>';
  html += '<td>' +
           '<div class="input-group"><select class="mat form-control"  name="mat[]" id="mat">' +
                        '<option value="" disabled selected></option>' +
                    '<option></option>'+
             
                  '</select>' +
                  '<span class="input-group-btn">'+
  '<a data-toggle="modal" data-target="#myMaterials" class="up-product btn btn-warning" ><i class="fa fa-shopping-cart"></i>New</a>'
 +'</span>'+'</div></td>';
                  html += '<td><input class="form-control un_cost" name="unit_cost[]" id="unit_cost" type="number" aria-describedby="" placeholder=""></td>';
                  html += '<td><input class="form-control quant" name="quantity[]" id="quantity" type="number" aria-describedby="emailHelp" placeholder=""></td>';
                  html += '<td><input class="form-control total_count" name="total_count[]" type="number"></td>';
                  html += '<td><input class="form-control" name="due[]" id="due" type="number" aria-describedby="emailHelp" placeholder=""></td>';
        if(number > 1)
        {
            html += '<td><button type="button" name="remove" id="" class="btn btn-danger remove">Remove</button></td></tr>';
            $('.new-item').append(html);
        }
        else
        {   
            html += '<td><button type="button" name="add" id="add" class="btn btn-success">New Item</button></td></tr>';
            $('.new-item').html(html);
        }
 }
 var count2 =1;
 dynamicExpense(count2);
 function dynamicExpense(number)
 {
   html = '<tr>';
     html += '<td>';
 html += '<select name="expense[]" class=" expense2 form-control" id="expense" data-live-search="true">';
 html += '<option value="" disabled><option></select></td>';
 html += '<td>';
html += '<input type="number" name="expense_quantity[]"  class="form-control expense_quantity"></td>';
html += '<td>';
html +='<input type="number" id="expense_price[]" name="expense_price[]" class="form-control expense_price"></td>';
html +='<td><input type="number" name="total_expense" id="total_expense" class="form-control total_expense"></td>';
if(number > 1)
{
  html +='<td><button type="button" name="remove" id="" class="btn btn-danger remove2">Remove</button></td>';
 
}
else
{
  html +='<td><button type="button" name="add" id="add2" class="btn btn-success">New Item</button></td>';

}
html +='</tr>';
$('.new_expense').append(html);
 }
   
          
 $(document).on('change','.mat',function(){
   var mat= this.value;
   var con = 1;
   var new_count = $('.hidden_count').val();
  //alert(new_count);
  new_count -= 1;
  //alert(new_count);
  var index = $(this).index();
          
         // alert(index);
  $.ajax({
        url:"fetchDescription",
        type:"GET",
        data:{mat:mat},
        success:function(data)
        {
          /*
          $('.description').each(function(){
            $(this).val(data.mat_description);
          });
          */
          var desc =$(".description");
        
          /*
          $('.description').each(function(i,element){
            $(element).val(data.mat_description);
          })
          */
          //$(this).closest('td').find(".mat").val(data.mat_description);
        //  $(this).next('.mat').val(data.mat_description);
            //var element = ;
         desc.eq(new_count).val(data.mat_description);
          //  var next_class=$(this).closest('td').find(".description");
        //$(next_class).val(data.mat_description);
          
       // alert(data.mat_description);
       // $('.description').val(data.mat_description);
        // $(this).closest('tr').find("td .description").val();
          //alert(data.mat_description);
         // $(this).closest("tr").find("td .description").val(data.)
        // $(this).closest("tr").remove();
          //$(this).closest("tr").find("textarea").val(data.mat_description);
          
        }
       

    });
 });
 $(document).on('click','#add2',function(){

count2++;
dynamicExpense(count2);
//alert(count2);

//$(this).closest('tr').next().find('select').html("<option data-tokens='New Value'>New Value</option><option data-tokens='Extra Value'>Extra Value</option>");

$.ajax({
        url:'fetchExpenses',
        type:'GET',
        contentType: "application/json; charset=utf-8",
        dataType:'json',
        success:function(data)
        {
          //alert("DATA");
          var expense = '';
       //  $('#select-box').html('<option data-tokens="ketchup mustard">Hot Dog, Fries and a Soda</option>');
         
          $.each(data,function(index,element){
            //alert();
            expense +='<option value="' + element.expense_name + '" data-tokens="' + element.expense_name + '">' + element.expense_name + '</option>';
          });
          $('.new_expense tr select').eq(-1).html(expense);
         // $('.new_expense tr select').eq(-1).addClass("selectpicker");
         // $('.new_expense tr select').eq(-1).selectpicker();
         // $(this).closest('tr').next().find('select').html(expense)
        // $('.new_expense tr select').eq(-1).selectpicker('refresh');
        },
        failure:function()
        {
          alert("Failed!");
        }
    });
 });
 $(document).on('click','#add', function(){
   count++;
   dynamic_field(count);
   //fetchMaterials();
   $.ajax({
        url:"fetchMaterials",
        type:"GET",
        dataType:'json',
        success:function(data)
        {
          var materials =" ";
         // var options = $('.mat')
          $.each(data,function(index,element){
           
              //var option= $(this).val();
              materials +='<option value="' + element.material_name + '">' + element.material_name + '</option>'
        // $(this).closest('tr').find(".un_cost").val();
            $('.mat').append(materials);
          
          
            
              
          });
         

        }
    });
 });
$(document).on('click','.remove',function(){
  count--;
  $(this).closest("tr").remove();
});
$(document).on('click','.remove2',function(){
  count2--;
 // dynamicExpense(count2);
  $(this).closest("tr").remove();
});

$(document).on('click','.pay_total',function(){
  var total = $('.total_amount').val();
  if(total == "")
  {
    alert("Select Amount To Pay First By Checking The Checkbox");
    //$("#confirmPayment").modal('toggle');
  }
  else if(total < 1)
  {
    alert("Select Amount To Pay First By Checking The Checkbox");

  }
  else
  { 
      var prompt="add_payment";
    $.ajax({
      url:"checkpassword",
      method:"POST",
      data:{prompt:prompt},
      success:function(data)
      {
        if(data=="ok")
         {
          $('#reverseModal').modal('show');
          $('#validate_password').click(function(){
              var password = $('#revert_password').val();
            $.ajax({
              url:"confirm_password",
              method:"POST",
              data:{password:password,prompt:prompt},
              success:function(data)
              {
                if(data=="ok")
                {
                  $('#reverseModal').modal('toggle');
                  $('#password_check_error').html('');
                  $('#revert_password').val('');
                  $("#confirmPayment").modal('show');
  var data_show = "";
  $(":checkbox:checked").each(function(i){
var amount = $(this).closest('td').find(".change-amount").val();
var supplier = $(this).closest('td').find(".change-sup").val();
var ref_no = $(this).closest('td').find(".change-ref").val();
///alert(num);
$(".change-amount").each(function(){
  var value = $(this).val();
//  alert(value);
});

data_show +='<tr>' +
                    '<td>' +
                  '<span>' + supplier + '</span>' +
              '<input type="hidden" name="supplier-pay-name" class="form-control ">' +
                    '</td>'+
                    '<td>' +
                    '<span>'+ ref_no +'</span>' +
               '<input type="hidden" name="ref-no-pay" class="form-control ">' +
                    '</td>' +
                    '<td>' +
                    '<span>' + amount + '</span>' +
               '<input type="hidden" name="total" class="form-control ">' +
                    '</td>' +
                   
                    '</tr>' ;


  });
  $('#confirm-data').html(data_show);
                }
                else
                {
                  $('#password_check_error').html('<b id="password_shake" class="text-danger">Wrong Password!!!</b>');
                  $('#password_shake').effect('shake');
                  $('#revert_password').val('');
                }
              }
            });
             });

         }
         else
         {
          $("#confirmPayment").modal('show');
  var data_show = "";
  $(":checkbox:checked").each(function(i){
var amount = $(this).closest('td').find(".change-amount").val();
var supplier = $(this).closest('td').find(".change-sup").val();
var ref_no = $(this).closest('td').find(".change-ref").val();
///alert(num);
$(".change-amount").each(function(){
  var value = $(this).val();
//  alert(value);
});

data_show +='<tr>' +
                    '<td>' +
                  '<span>' + supplier + '</span>' +
              '<input type="hidden" name="supplier-pay-name" class="form-control ">' +
                    '</td>'+
                    '<td>' +
                    '<span>'+ ref_no +'</span>' +
               '<input type="hidden" name="ref-no-pay" class="form-control ">' +
                    '</td>' +
                    '<td>' +
                    '<span>' + amount + '</span>' +
               '<input type="hidden" name="total" class="form-control ">' +
                    '</td>' +
                   
                    '</tr>' ;


  });
  $('#confirm-data').html(data_show);
         }
      }
    });
    
  }
  
});
  $(document).on('click','.add-payment',function(){
       // alert("You Are Good To Go");
        var ids = [];
        var balanc = [];
        var balance = [];
        var total = 0;
        var amount_paid = [];
$(":checkbox:checked").each(function(i){
  //first_balance= $(this).val();
 //first_id= $(this).attr('id');
ids[i]=  $(this).attr('id');
var num = $(this).closest('td').find(".change-amount").val();
var new_value = $('.change-amount').val();
//alert(num);
balance[i]= num;



});


/*

*/
for(var i =0; i<balance.length; i++)
{
  total += balance[i] << 0;
}
//alert(ids);
//alert(balance);
//alert(total);dds

$('.total_amount').val(total);
$('#totals').text(total);
$('.ids').val(ids);
$('.balance').val(balance);
$('.amount_paid').val(amount_paid);
$('')
      });
$("#add_multiple").click(function(){
var total = $('.total_amount').val();
var ids =  $('.ids').val();
var balance = $('.balance').val();
var amount_paid = $('.amount_paid').val();
var date_payment= $('#date_payment').val();
var mode = $('#mode').val();
var posting_date = $('#posting_date').val();
var clearing_date = $('#clearing_date').val();
var mpesa_code = $('#mpesa_code').val();
if(mode=="BANK")
{
  if(posting_date == '')
  {
    alert("Posting Date Required");
  }
  else if(clearing_date =='')
  {
    alert("Clearing Date Required");
  }
  else
  {
    $.ajax({
    url:"paymultiple", 
    method:"GET",
    data:{total:total,ids:ids,balance:balance,amount_paid:amount_paid,
    mode:mode,date_payment:date_payment,posting_date:posting_date,clearing_date:clearing_date,
    mpesa_code:mpesa_code},
success:function(response){
alert("Bills Successfully Updated");
$('#confirmPayment').modal('toggle');
$('#total_amount').val('');
$('.pay-bills').DataTable().ajax.reload();
$('.data-paid').DataTable().ajax.reload();
$('#data_table').DataTable().ajax.reload();
$('.amount_paid').val('');

fetchTotal(); 
    }
  });
  }
}
else
{
  $.ajax({
    url:"paymultiple", 
    method:"GET",
    data:{total:total,ids:ids,balance:balance,amount_paid:amount_paid,
    mode:mode,date_payment:date_payment,posting_date:posting_date,clearing_date:clearing_date,
    mpesa_code:mpesa_code},
success:function(response){
alert("Bills Successfully Updated");
$('.pay-bills').DataTable().ajax.reload();
$('.data-paid').DataTable().ajax.reload();
$('#data_table').DataTable().ajax.reload();
$('#confirmPayment').modal('toggle');
$('#total_amount').val('');
$('.amount_paid').val('');
fetchTotal(); 
    }
  });
}

 
})

  load_paid();
  load_data();
  load_expense();
  load_sites();
  fetchVat();
  fetchTotal();
  fetchUsers();
  fetchSites();
  fetchMaterials();
  fetchExpenses();
  fetchSuppliers();
  fetchSupplier();
  fetchPdfSupplier();
  updateClearance();
  loadNewExpense();
  load_passwords();
  //updateDays();
  fetchNotifications();
    /*
    $('#data_table').on('search.dt',function(){
      
    
    });
    */
    //$('#data_table #data_table_length').addClass('search-data');
   

  
    
    $.ajaxSetup({

headers: {

    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

}

});


$('#filter').click(function(){
  var payment_status = $('#payment_status').val();
  var bill_status = $('#bill_status').val();
var from_date = $('#from_date').val();
var to_date = $('#to_date').val();
var supplier=$('#supplier_all').val();
var users=$('#users_select').val();
var days_due = $('#due_days').val();
var site =  $("#site_select").val();
var material = $("#material_select").val();
if(from_date !='' && to_date !='')
{
  $('#data_table').DataTable().destroy();
  load_data(from_date,to_date,supplier,site,material,payment_status,bill_status,users,days_due);

}
else
{
  alert('Both Date is required');
}
});
$('#due_days').keyup(function(){
  var days_due = $(this).val();
  var payment_status = $('#payment_status').val();
  var bill_status = $('#bill_status').val();
var from_date = $('#from_date').val();
var to_date = $('#to_date').val();
var supplier=$('#supplier_all').val();
var users=$('#users_select').val();
var site =  $("#site_select").val();
var material = $("#material_select").val();
$('#data_table').DataTable().destroy();
  load_data(from_date,to_date,supplier,site,material,payment_status,bill_status,users,days_due);
  
});
$('#refresh').click(function(){
  $('#from_date').val('');
  $('#to_date').val('');
  $('#supplier_all').val('');
  $('#payment_status').val('');
  $('#bill_status').val('');
  $('#users_select').val('');
  $("#site_select").val('');
  $("#material_select").val('');
  $('#due_days').val('');
  $('#data_table').DataTable().destroy();
  load_data();
  
 });
 $(document).on('change','.mode',function(){
var mode = this.value;
//alert(mode);
$(this).closest('tr').find('.posting').prop("type","date");
$(this).closest('tr').find('.clearing').prop("type","date");
if(mode=='MPESA')
{         
  $('.mpesa_code').fadeIn('slow');
  //$('.clearing_date').fadeOut('slow');
  $('.clearing_date').fadeOut('slow');
  $('.posting_date').fadeOut('slow');
 // $('.amount_clear').fadeOut('slow');
}
else if(mode=='BANK')
{
  
  $('.mpesa_code').fadeOut('slow');
 // $('.clearing_date').fadeIn('slow');
  $('.clearing_date').fadeIn('slow');
  $('.posting_date').fadeIn('slow');
  //$('.amount_clear').fadeIn('slow');
}
else if(mode=='CASH')
{
 
  $('.mpesa_code').fadeOut('slow');
  $('.clearing_date').fadeOut('slow');
  //$('.clearing_date').fadeOut('slow');
  $('.posting_date').fadeOut('slow');
  //$('.amount_clear').fadeOut('slow');
}
 });

 $('#select_expense').on('change',function(){
  var expense = $('#select_expense').val();
  var site =    $("#site_select_expense").val();
  var payment_status  = $("#payment_status_expense").val();
 
 var from_date = $('#from_date_expense').val();
 var to_date = $('#to_date_expense').val();
$('.data-table-expenses').DataTable().destroy();

  load_expense(from_date,to_date,expense,site,payment_status);
 
 });
 $('#site_select_expense').on('change',function(){
  var expense = $('#select_expense').val();
  var site =    $("#site_select_expense").val();
  var payment_status  = $("#payment_status_expense").val();
 
 var from_date = $('#from_date_expense').val();
 var to_date = $('#to_date_expense').val();
$('.data-table-expenses').DataTable().destroy();

  load_expense(from_date,to_date,expense,site,payment_status);
 
 });
 $('#payment_status_expense').on('change',function(){
  var expense = $('#select_expense').val();
  var site =    $("#site_select_expense").val();
  var payment_status  = $("#payment_status_expense").val();
 
 var from_date = $('#from_date_expense').val();
 var to_date = $('#to_date_expense').val();
$('.data-table-expenses').DataTable().destroy();

  load_expense(from_date,to_date,expense,site,payment_status);
 
 });
 $('#supplier_all').on('change',function(){
  var from_date = $('#from_date').val();
var to_date = $('#from_date').val();
var supplier=$('#supplier_all').val();
var payment_status = $('#payment_status').val();
var bill_status = $('#bill_status').val();
var users=$('#users_select').val();
var days_due = $('#due_days').val();
var site =  $("#site_select").val();
var material = $("#material_select").val();
$('#data_table').DataTable().destroy();
//$('.data_table').DataTable().destroy();
  //load_paid(supplier);
  load_data(from_date,to_date,supplier,site,material,payment_status,bill_status,users,days_due);
  fetchTotal();
 // load_data()
  //var route = 'dynamic_pdf/' + supplier;
  //var url = "{{ url('dynamic_pdf/') }}" ;
  var route='exportExcel/' + supplier; 
  
  //$(".expo").html('<a href=' + route  +' class="btn btn-success">Export To Excel </a>');
 });
 $('#payment_status').on('change',function(){
  var from_date = $('#from_date').val();
var to_date = $('#from_date').val();
var supplier=$('#supplier_all').val();
var payment_status = $(this).val();
var bill_status = $('#bill_status').val();
var users=$('#users_select').val();
var days_due = $('#due_days').val();
var site =  $("#site_select").val();
var material = $("#material_select").val();
$('#data_table').DataTable().destroy();
  load_data(from_date,to_date,supplier,site,material,payment_status,bill_status,users,days_due);
 });
 $('#bill_status').on('change',function(){
  var from_date = $('#from_date').val();
var to_date = $('#from_date').val();
var supplier=$('#supplier_all').val();
var payment_status = $('#payment_status').val();
var bill_status = $('#bill_status').val();
var users=$('#users_select').val();
var days_due = $('#due_days').val();
var site =  $("#site_select").val();
var material = $("#material_select").val();
$('#data_table').DataTable().destroy();
  load_data(from_date,to_date,supplier,site,material,payment_status,bill_status,users,days_due);
 });
 $('#users_select').on('change',function(){
  var from_date = $('#from_date').val();
var to_date = $('#from_date').val();
var supplier=$('#supplier_all').val();
var payment_status = $('#payment_status').val();
var bill_status = $('#bill_status').val();
var users=$('#users_select').val();
var days_due = $('#due_days').val();
var site =  $("#site_select").val();
var material = $("#material_select").val();
$('#data_table').DataTable().destroy();

  load_data(from_date,to_date,supplier,site,material,payment_status,bill_status,users,days_due);
 
 });
 $('#site_select').on('change',function(){
  var from_date = $('#from_date').val();
var to_date = $('#from_date').val();
var supplier=$('#supplier_all').val();
var payment_status = $('#payment_status').val();
var bill_status = $('#bill_status').val();
var users=$('#users_select').val();
var days_due = $('#due_days').val();
var site =  $("#site_select").val();
var material = $("#material_select").val();
$('#data_table').DataTable().destroy();
  load_data(from_date,to_date,supplier,site,material,payment_status,bill_status,users,days_due);
 });

 $('#material_select').on('change',function(){
  var from_date = $('#from_date').val();
var to_date = $('#from_date').val();
var supplier=$('#supplier_all').val();
var payment_status = $('#payment_status').val();
var bill_status = $('#bill_status').val();
var users=$('#users_select').val();
var days_due = $('#due_days').val();
var site =  $("#site_select").val();
var material = $("#material_select").val();
$('#data_table').DataTable().destroy();
  load_data(from_date,to_date,supplier,site,material,payment_status,bill_status,users,days_due);
 });
 $('#filterp').click(function(){
  var supplierp = $("#supplier_pdf").val();
  var sitep = $("#payment_site").val();
  var materialp = $("#payment_material").val();
  var paymentp = $("#payment_statusp").val();
  var from_datep =$("#from_date_payment").val();
  var to_datep = $("#to_date_payment").val();
if(from_datep !='' && to_datep !='')
{
  $('#data-paid').DataTable().destroy();
  load_paid(supplierp,materialp,sitep,from_datep,to_datep,paymentp);
}
else
{
  alert('Both Dates are required');
}
});
$('#filter_expense').click(function(){
  var expense = $('#select_expense').val();
  var site =    $("#site_select_expense").val();
  var payment_status  = $("#payment_status_expense").val();
 
 var from_date = $('#from_date_expense').val();
 var to_date = $('#to_date_expense').val();

if(from_date !='' && to_date !='')
{
  $('.data-table-expenses').DataTable().destroy();

  load_expense(from_date,to_date,expense,site,payment_status);
}
else
{
  alert('Both Dates are required');
}
});
$('#refreshp').click(function(){
$("#supplier_pdf").val('');
$("#payment_site").val('');
$("#payment_material").val('');
$("#payment_statusp").val('');
$("#from_date_payment").val('');
$("#to_date_payment").val('');
$('#data-paid').DataTable().destroy();
load_paid();
 });
$('#refresh_expense').click(function(){
  $('#select_expense').val('');
  $("#site_select_expense").val('');
 $("#payment_status_expense").val('');
$('#from_date_expense').val('');
$('#to_date_expense').val('');
$('.data-table-expenses').DataTable().destroy();
load_expense();
 });
$('#supplier_pdf').on('change',function(){
  var supplierp = $("#supplier_pdf").val();
  var sitep = $("#payment_site").val();
  var materialp = $("#payment_material").val();
  var paymentp = $("#payment_statusp").val();
  var from_datep =$("#from_date_payment").val();
  var to_datep = $("#to_date_payment").val();
  $('#data-paid').DataTable().destroy();
  load_paid(supplierp,materialp,sitep,from_datep,to_datep,paymentp);
});
$('#payment_site').on('change',function(){
  var supplierp = $("#supplier_pdf").val();
  var sitep = $("#payment_site").val();
  var materialp = $("#payment_material").val();
  var paymentp = $("#payment_statusp").val();
  var from_datep =$("#from_date_payment").val();
  var to_datep = $("#to_date_payment").val();
  $('#data-paid').DataTable().destroy();
  load_paid(supplierp,materialp,sitep,from_datep,to_datep,paymentp);
});
$('#payment_material').on('change',function(){
  var supplierp = $("#supplier_pdf").val();
  var sitep = $("#payment_site").val();
  var materialp = $("#payment_material").val();
  var paymentp = $("#payment_statusp").val();
  var from_datep =$("#from_date_payment").val();
  var to_datep = $("#to_date_payment").val();
  $('#data-paid').DataTable().destroy();
  load_paid(supplierp,materialp,sitep,from_datep,to_datep,paymentp);
});
$('#payment_statusp').on('change',function(){
  var supplierp = $("#supplier_pdf").val();
  var sitep = $("#payment_site").val();
  var materialp = $("#payment_material").val();
  var paymentp = $("#payment_statusp").val();
  var from_datep =$("#from_date_payment").val();
  var to_datep = $("#to_date_payment").val();
  $('#data-paid').DataTable().destroy();
  load_paid(supplierp,materialp,sitep,from_datep,to_datep,paymentp);
});
var pay_bills = $('.pay-bills').DataTable({
        "processing":true,
        "serverSide":true,
        "responsive":true,
        "ajax":"allBills",
        "columns":[
 
                {data:'DT_RowIndex',name: 'DT_RowIndex'},
                {data:'supplier_name',name:'supplier_name'},
                {data:'item',name:'item'},
                {data:'ref_no',name:'ref_no'},
                {data:'total_cost',name:'total_cost',render: $.fn.dataTable.render.number( ',' )},
                {data:'amount_paid',name:'amount_paid',render: $.fn.dataTable.render.number( ',' )},
                {data:'balance',name:'balance',render: $.fn.dataTable.render.number( ',' )},
               
                {data:'created_at',name:'created_at'},
                {data:'edit',name:'edit',orderable:false,searchable:false},
				{data:'delete',name:'delete',orderable:false,searchable:false},
				
            
        ],
        dom: 'lBfrtip',
        buttons: [
    {extend:'excel',footer:true, exportOptions: {
                    columns: ':visible',
                   }
                   
                   },
    {extend:'csv',footer:true,},
    {extend:'pdf',footer:true},
    {extend:'copy',footer:true},
    'colvis'
   ],
   "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ]
    
  
});
$.ajax({
  url:"allBills",
  type:"GET",
  success:function(data)
  {

  }
});
$('#select-suppliers').on('change',function(){
  
  var id=this.value;
  //var html = " ";
//alert(id);
$('table').removeClass('data-table');
$('table').addClass('data-suppliers');
//$('.data-suppliers').fadeIn();
  
});
$('.input-daterange').datepicker({
  todayBtn:'linked',
  format:'yyyy-mm-dd',
  autoclose:true
 });
//Delete Product function
$(document).on('click','.deleteBill',function(){
               var bil_id = $(this).attr('data-id');
							 var id = $(this).attr('id');
               var delete_combine = id + "_" + bil_id;
							 //alert(spare_id);
							 $('#confirmModal').modal('show');
               $('#ok_button').click(function(){
               var prompt= "revert_payment";
    $.ajax({
      url:"checkpassword",
      method:"POST",
      data:{prompt:prompt},
      success:function(data)
      {
         if(data=="ok")
         {
            $('#reverseModal').modal('show');
            $('#validate_password').click(function(){
              var password = $('#revert_password').val();
            $.ajax({
              url:"confirm_password",
              method:"POST",
              data:{password:password,prompt:prompt},
              success:function(data)
              {
                if(data=="ok")
                {
                  $('#reverseModal').modal('toggle');
                  $('#password_check_error').html('');
                  $('#revert_password').val('');
                  $.ajax({
                  url:"bill/"+delete_combine,
                  type:'DELETE',
                  data:{
                    "id":delete_combine
                  },
									beforeSend:function()
									{
										$('#ok_button').text('Deleting...');
									},
									success:function(data)
									{
										swal({
												title:"Success",
												text:"Bill Successfuly Removed",
												icon:"success",
												button:"OK"
											});
                      $('#ok_button').text('Delete');
										setTimeout(function(){
											$('#confirmModal').modal('hide');
											$('#data_table').DataTable().ajax.reload()
										,2000});
                  
            fetchTotal();
									}
								});

                }
                else
                {
                  $('#password_check_error').html('<b id="password_shake" class="text-danger">Wrong Password!!!</b>');
                  $('#password_shake').effect('shake');
                  $('#revert_password').val('');
                }

         }
            });
         });  
        }
         else
         {
          
                $.ajax({
                  url:"bill/"+delete_combine,
                  type:'DELETE',
                  data:{
                    "id":delete_combine
                  },
									beforeSend:function()
									{
										$('#ok_button').text('Deleting...');
									},
									success:function(data)
									{
										swal({
												title:"Success",
												text:"Bill Successfuly Removed",
												icon:"success",
												button:"OK"
											});
                      $('#ok_button').text('Delete');
										setTimeout(function(){
											$('#confirmModal').modal('hide');
											$('#data_table').DataTable().ajax.reload()
										,2000});
                  
            fetchTotal();
									}
								});
						
         }
        });

      });
    });
	});
//End Delete Bill function
 //Delete Expense function
$(document).on('click','.deleteExpenses',function(){
              
							 var id = $(this).attr('id');
               
							 //alert(spare_id);
							 $('#confirmExpenseModal').modal('show');

					
						 $('#ok_expense').click(function(){
                $.ajax({
                  url:"expense/"+id,
                  type:'DELETE',
                  data:{
                    "id":id
                  },
									beforeSend:function()
									{
										$('#ok_expense').text('Deleting...');
									},
									success:function(data)
									{
										swal({
												title:"Success",
												text:"Expense Successfuly Removed",
												icon:"success",
												button:"OK"
											});
                      $('#ok_expense').text('Delete');
										setTimeout(function(){
											$('#confirmExpenseModal').modal('hide');
											$('.data-table-expenses').DataTable().ajax.reload()
										,2000});
                  
            fetchTotal();
									}
								});
						 });
						});
//Delete Supplier function
$(document).on('click','.deleteSupplier',function(){
              // var bil_id = $(this).attr('data-id');
							 var id = $(this).attr('id');
               //var delete_combine = id + "_" + bil_id;
							 //alert(spare_id);
							 $('#confirmModal').modal('show');

					
						 $('#ok_button').click(function(){
                $.ajax({
                  url:"suppliers/"+id,
                  type:'DELETE',
                  data:{
                    "id":id
                  },
									beforeSend:function()
									{
										$('#ok_button').text('Deleting...');
									},
									success:function(data)
									{
										swal({
												title:"Success",
												text:"Bill Successfuly Removed",
												icon:"success",
												button:"OK"
											});
										setTimeout(function(){
											$('#confirmModal').modal('hide');
											$('#data_table').DataTable().ajax.reload()
										,2000});
                  
            fetchTotal();
									}
								});
						 });
						});
                        //Delete Product function
$(document).on('click','.deleteMaterial',function(){
							 var id = $(this).attr('id');
							 //alert(spare_id);
							 $('#confirmModal').modal('show');

					
						 $('#ok_button').click(function(){
                $.ajax({
                  url:"material/"+id,
                  type:'DELETE',
                  data:{
                    "id":id
                  },
									beforeSend:function()
									{
										$('#ok_button').text('Deleting...');
									},
									success:function(data)
									{
										swal({
												title:"Success",
												text:"Material Successfuly Removed",
												icon:"success",
												button:"OK"
											});
										setTimeout(function(){
											$('#confirmModal').modal('hide');
											$('.data-table2').DataTable().ajax.reload()
										,2000});
									}
								});
						 });
            });
            //Edit Bill
            $('body').on('click','.editBill',function(){
	var bill_id=$(this).attr('id');
 // alert(bill_id);
  var item_id = $(this).attr('data-id');
  var combine_id = bill_id + '_' + item_id;
  //alert(item_id);
	$.get("{{route('bills.index')}}" +'/' + combine_id+'/edit',function(data)
	{
    //var dat =  JSON.parse(data);
    //alert(data.item);
		$('#hidden_id').val(bill_id);
    $('#hidden_details').val(item_id);
   $('#matu').val(data.item);
	 $('#supplieru').val(data.supplier_name);
	 $('#quantityu').val(data.quantity);
	 $('#unit_costu').val(data.price);
	 $('#ref_nou').val(data.ref_no);
	 $('#site_nameu').val(data.site_name);
	 $('#descriptionu').val(data.description);
   $('#date_addedu').val(data.date_added);
	 //alert(data.item);
   $('#myModalEdit').modal('show');
   
	});
});
  //Edit Bill
  $('body').on('click','.editExpenses',function(){
	var bill_id=$(this).attr('id');
 // alert(bill_id);
  var item_id = $(this).attr('data-id');
  var combine_id = bill_id + '_' + item_id;
  //alert(item_id);
	$.get("{{route('expense.index')}}" +'/' + combine_id+'/edit',function(data)
	{
    //var dat =  JSON.parse(data);
    //alert(data.item);
		$('#hidden_expense_id').val(data.id);
    //$('#hidden_details').val(item_id);
   $('#expenseu').val(data.expense);
	 $('#site_namee').val(data.site);
	 $('#amount_expenseu').val(data.amount);
	 $('#mode_expenseu').val(data.mode_payment);
	 $('#cheque_nou').val(data.cheque_no);
	 $('#mpesa_codeu').val(data.mpesa_code);
	 $('#date_paidu').val(data.date_paid);
   $('#monthu').val(data.month);
   $('#yearu').val(data.year);
	 //alert(data.item);
   $('#editExpenses').modal('show');
   
	});
});
$('body').on('click','.editPaid',function(){
	var bill_id=$(this).attr('id');
  //alert(bill_id);
  var item_id = $(this).attr('data-id');
  var combine_id = bill_id + '_' + item_id;
 // alert(item_id);
	$.get("{{route('bills.index')}}" +'/' + combine_id+'/edit',function(data)
	{
    //var dat =  JSON.parse(data);
    //alert(data.item);
		$('#hidden_edit_paid_id').val(item_id);

   $('#amount_edit_paid').val(data.amount_paid);
   $('#amount_edit_due').val(data.total_cost);
	 //alert(data.item);
   $('#myModalEditPaid').modal('show');
   
	});
   
	
});
$('body').on('click','.editUser',function(){
	var user_id=$(this).attr('id');
 
  //alert(user_id);
  $.ajax({
  url:"editUser",
  type:"GET",
  dataType:'json',
  data:{user_id:user_id},
  success:function(data)
  {
    //var dat =  JSON.parse(data);
    //alert(data.item);
		$('#hidden_user_id').val(user_id);
   
   $('#user_nameu').val(data.name);
	 $('#user_emailu').val(data.user_email);
	 $('#phone_numberu').val(data.phone_no);

	 //alert(data.item);
   $('#myModalEditUsers').modal('show');
  }
});
	
});
$('body').on('click','.approveBill',function(){
	var approve_id=$(this).attr('data-id');
 
  //alert(approve_id);
  $.ajax({
  url:"showBill",
  type:"GET",
  dataType:'json',
  data:{approve_id:approve_id},
  success:function(data)
  {
    //var dat =  JSON.parse(data);
    //alert(data.item);
   
		$('#td_by').text(data.added_by);
    $('#td_ref').text(data.ref_no);
   $('#td_mat').text(data.item);
	 $('#td_sup').text(data.supplier_name);
	 $('#td_total').text(data.total_cost);

	 //alert(data.item);
   $('#myModalshowBill').modal('show');
   $('#ok_approve').click(function(){
                $.ajax({
                  url:"approveBill",
                  type:'POST',
                  data:{
                    approve_id:approve_id
                  },
									beforeSend:function()
									{
										$('#ok_approve').text('Approving Bill...');
									},
									success:function(data)
									{
										swal({
												title:"Success",
												text:"Bill Successfully Approved",
												icon:"success",
												button:"OK"
											});
                      $('#ok_approve').text('OK');
										setTimeout(function(){
											$('#myModalshowBill').modal('hide');
											$('#data_table').DataTable().ajax.reload()
										,2000});
                  
            fetchTotal();
									}
								});
						 });
  }
});
	
});
$('body').on('click','.changePassword',function(){
	var user_id=$(this).attr('id');
 
  //alert(user_id);
  $.ajax({
  url:"editUser",
  type:"GET",
  dataType:'json',
  data:{user_id:user_id},
  success:function(data)
  {
    //var dat =  JSON.parse(data);
    //alert(data.item);
		$('#hidden_password_id').val(user_id);
   
 

	 //alert(data.item);
   $('#myModalEditUserspassword').modal('show');
  }
});
	
});
//Edit Bill
$('body').on('click','.editSupplier',function(){
	var id=$(this).attr('id');
  //alert(bill_id);
  //var item_id = $(this).attr('data-id');
  //var combine_id = bill_id + '_' + item_id;
  //alert(item_id);
	$.get("{{route('suppliers.index')}}" +'/' + id+'/edit',function(data)
	{
    //var dat =  JSON.parse(data);
    //alert(data.item);
		$('#hidden_sup_edit').val(id);
    $('#hidden_sup_name').val(data.supplier_name);
    $('#supplier_nameu').val(data.supplier_name);
   $('#supplier_emailu').val(data.supplier_email);
	 $('#supplier_phoneu').val(data.supplier_phone);
	 $('#company_nameu').val(data.company_name);
	 

   $('#mySuppliersEdit').modal('show');
   
	});
});
//Pay Biil
$('body').on('click','.payBill',function(){
	var bill_id=$(this).attr('id');
	$.get("{{route('bills.index')}}" +'/' + bill_id+'/edit',function(data)
	{
    $('#hidden_payid').val(data.id);
    $('#hidden_pay').val(data.supplier);
    $('#hidden_refno').val(data.ref_no);
   $('#amount-due').val(data.total_cost);
	 $('#balance').val(data.balance);
	$('#supplier-name').html('Pay Bills For <strong>' + data.supplier + '</strong>');
	 
   $('#myModalPay').modal('show');
   
	});
});
//View Bill

$('body').on('click','.viewBill',function(){
	var ref_no=$(this).attr('id');
$.ajax({
  url:"view",
  type:"POST",
  dataType:'json',
  data:{ref_no:ref_no},
  success:function(data)
  {
    var view ="";
$.each(data,function(index,element){
  //alert(element.supplier_name);
  view = '<tr><td>' + element.supplier_name  +  '</td>' 
+ '<td>' +  element.amount_due +  '</td> <td>' +  element.amount_paid +  '</td>' + '<td>' +  element.balance +  '</td>'
+ '<td>' +  element.mode_payment +  '</td> <td>' +  element.mpesa_code  + '</td> <td>' +  element.date_add + '</td></tr>';
  /*

*/
});
$('#data').append(view);
   
   $('#myModalView').modal('show');
  }
})
});
$(document).on('change','#mode_expense',function(){
                    var value= $(this).val();
                    
                    if(value=="cheque")
                    {
                      $('#bank_expense').fadeIn('slow');
                      $('#cheque_expense').fadeIn('slow');
                      $('#expense_code').fadeOut('slow');
                    
                      $('#mpesa_code_expense').val('');
           

                    }
                    else if(value=="mpesa")
                    {
                      $('#bank_expense').fadeOut('slow');
                      $('#cheque_expense').fadeOut('slow');
                      $('#expense_code').show('slow');
                      $('#cheque_no').val('');
                      $('#expense_bank_name').val('');
                    }
                    else if(value=="cash")
                    {
                      $('#bank_expense').hide('slow');
                      $('#cheque_expense').hide('slow');
                      $('#expense_code').hide('slow');
                      $('#cheque_no').val('');
                      $('#expense_bank_name').val('');
                      $('#mpesa_code_expense').val('');
                    }

                  });
$('.treeview-menu li a').click(function(e){
e.preventDefault();
$('.treeview-menu li a').removeClass("active");
//add the acive state to the clicked link
$(this).addClass("active");
//fade out the current container
$('.profile').fadeOut(600,function(){
    $('#' + profileID).fadeIn(600);
});
var profileID=$(this).attr("data-id");
});
$('#promptPassword').on('submit',(function(e){
  e.preventDefault();
  $.ajax({
    url:"{{ route('passwords.store')}}",
    type:"POST",
    data:new FormData(this),
    contentType:false,
    cache:false,
    processData:false,
    beforeSend:function()
    {
      $('#btn-prompt').html('<i class="fa fa-spin"></i>')
    },
    success : function(response)
    {
      if($.isEmptyObject(response.prompt_errors))
      {
        swal({
          title:"Success",
          text:"Password Successfully Added",
          icon:"success",
          button:"OK"
        })
      }
      else
      {
        $("#prompt_errors").fadeIn(1000,function(){
          printErrorMsg(response.prompt_errors);
          $('#btn-prompt').html("SUBMIT");
        });
      }
    }
  })
}));
$('#changePassword').on('submit',(function(e){
e.preventDefault();
$.ajax({
    url:"resetPassword",
    type:"POST",
    data:new FormData(this),
    contentType:false,
    cache:false,
    processData:false,
    beforeSend:function()
    {
        $('#buttonReset').html('Updating Password');
    },
    success : function(response)
    {
        if($.isEmptyObject(response.error))
        {
          //$('#myModal').modal('toggle');

            swal({
                title:"Success",
                text:"Password Successfully Updated",
                icon:"success",
                button:"OK"
            });
            
        }
        else
        {
            $("#changeError").fadeIn(1000,function(){
                printErrorMsg(response.error);
                $("#buttonReset").html('Update');
            });
        }
    }
});
    }));
    $('#editPaid').on('submit',(function(e){
e.preventDefault();
$.ajax({
    url:"editPaid",
    type:"POST",
    data:new FormData(this),
    contentType:false,
    cache:false,
    processData:false,
    beforeSend:function()
    {
        $('#buttonEditPaid').html('Updating Amount');
    },
    success : function(response)
    {
        if($.isEmptyObject(response.error))
        {
          //$('#myModal').modal('toggle');

            swal({
                title:"Success",
                text:"Amount Successfully Updated",
                icon:"success",
                button:"OK"
            });
            $('.pay-bills').DataTable().ajax.reload();
            $('.data-bills').DataTable().ajax.reload();
            $('#data_table').DataTable().ajax.reload();
        //fetchTotal();
            $('#myModalEditPaid').modal('toggle');
            $('#editPaid').trigger("reset"); 
            $("#buttonEditPaid").html('Update');
            
        }
        else
        {
            $("#editpaidError").fadeIn(1000,function(){
                printErrorMsg(response.error);
                $("#buttonEditPaid").html('Update');
            });
        }
    }
});
    }));
$('#registerUser').on('submit',(function(e){
e.preventDefault();
$.ajax({
    url:"registerUser",
    type:"POST",
    data:new FormData(this),
    contentType:false,
    cache:false,
    processData:false,
    beforeSend:function()
    {
        $('#buttonUser').html('Registering User');
    },
    success : function(response)
    {
        if($.isEmptyObject(response.error))
        {
          //$('#myModal').modal('toggle');

            swal({
                title:"Success",
                text:"User Successfully Registered",
                icon:"success",
                button:"OK"
            });
            $('.data-table-users').DataTable().ajax.reload();
            $('#myModalUsers').modal('toggle');
            $('#registerUser').trigger("reset"); 
        }
        else
        {
            $("#userError").fadeIn(1000,function(){
                printErrorMsg(response.error);
                $("#buttonUser").html('Register');
            });
        }
    }
});
    }));
    $('#addPayment').on('submit',(function(e){
e.preventDefault();
$.ajax({
    url:"registerUser",
    type:"POST",
    data:new FormData(this),
    contentType:false,
    cache:false,
    processData:false,
    beforeSend:function()
    {
        $('#buttonUser').html('Registering User');
    },
    success : function(response)
    {
        if($.isEmptyObject(response.error))
        {
          //$('#myModal').modal('toggle');

            swal({
                title:"Success",
                text:"User Successfully Registered",
                icon:"success",
                button:"OK"
            });
            $('.data-table-users').DataTable().ajax.reload();
            $('#myModalUsers').modal('toggle');
            $('#registerUser').trigger("reset"); 
        }
        else
        {
            $("#userError").fadeIn(1000,function(){
                printErrorMsg(response.error);
                $("#buttonUser").html('Register');
            });
        }
    }
});
    }));
    $('#formBills').on('submit',(function(e){
e.preventDefault();
$.ajax({
    url:"{{ route('bills.store')}}",
    type:"POST",
    data:new FormData(this),
    contentType:false,
    cache:false,
    processData:false,
    beforeSend:function()
    {
        $('#buttonSpare').html('Adding New Bill');
    },
    success : function(response)
    {
        if($.isEmptyObject(response.error))
        {
          //$('#myModal').modal('toggle');

            swal({
                title:"Success",
                text:"Bill Successfully Added",
                icon:"success",
                button:"OK"
            });
            $('.pay-bills').DataTable().ajax.reload();
            $('.data-bills').DataTable().ajax.reload();
            $('#data_table').DataTable().ajax.reload();
            fetchTotal();
           
            //$('#myModal').modal('toggle');
            $('#formBills').trigger("reset");
            $('#grand_total').html('');
            fetchMaterials();
            dynamic_field(1);
        }
        else
        {
            $("#billError").fadeIn(1000,function(){
                printErrorMsg(response.error);
                $("#buttonSpare").html('ADD');
            });
        }
    }
});
    }));
    $('#formExpenses').on('submit',(function(e){
e.preventDefault();
$.ajax({
    url:"{{ route('expense.store') }}",
    type:"POST",
    data:new FormData(this),
    contentType:false,
    cache:false,
    processData:false,
    beforeSend:function()
    {
        $('#buttonExpense').html('Adding New Expense');
    },
    success : function(response)
    {
        if($.isEmptyObject(response.error))
        {
          //$('#myModal').modal('toggle');

            swal({
                title:"Success",
                text:"Expense Successfully Added",
                icon:"success",
                button:"OK"
            });
            /*
            $('.pay-bills').DataTable().ajax.reload();
            $('.data-bills').DataTable().ajax.reload();
            $('#data_table').DataTable().ajax.reload();
            fetchTotal();
            $('#myModal').modal('toggle');
            */
            $('#formExpenses').trigger("reset");
            $('.data-table-expenses').DataTable().ajax.reload()
            /*
            fetchMaterials();
            dynamic_field(1);
            */
        }
        else
        {
            $("#expenseError").fadeIn(1000,function(){
                printErrorMsg(response.error);
                $("#buttonExpense").html('ADD');
            });
        }
    }
});
    }));
    $('#formnewExpenses').on('submit',(function(e){
e.preventDefault();
$.ajax({
    url:"{{ route('exp.store') }}",
    type:"POST",
    data:new FormData(this),
    contentType:false,
    cache:false,
    processData:false,
    beforeSend:function()
    {
        $('#buttonnewExpense').html('Adding New Expense...');
    },
    success : function(response)
    {
        if($.isEmptyObject(response.error_expense))
        {
          //$('#myModal').modal('toggle');

            swal({
                title:"Success",
                text:"Expense Successfully Added",
                icon:"success",
                button:"OK"
            });
            /*
            $('.pay-bills').DataTable().ajax.reload();
            $('.data-bills').DataTable().ajax.reload();
            $('#data_table').DataTable().ajax.reload();
            fetchTotal();
            $('#myModal').modal('toggle');
            */
            $('#formnewExpenses').trigger("reset");
            $('.new-expense').DataTable().ajax.reload()
            /*
            fetchMaterials();
            dynamic_field(1);
            */
        }
        else
        {
            $("#expensenewError").fadeIn(1000,function(){
                printErrorMsg(response.error_expense);
                $("#buttonnewExpense").html('ADD');
            });
        }
    }
});
    }));
    $('#formSites').on('submit',(function(e){
e.preventDefault();
$.ajax({
    url:"{{ route('sites.store') }}",
    type:"POST",
    data:new FormData(this),
    contentType:false,
    cache:false,
    processData:false,
    beforeSend:function()
    {
        $('#buttonSites').html('Adding New Site.....');
    },
    success : function(response)
    {
        if($.isEmptyObject(response.error))
        {
          //$('#myModal').modal('toggle');
          //$('#myModal').modal('toggle');
          $('#sitesModal').removeClass("index");
            swal({
                title:"Success",
                text:"New  Successfully Added",
                icon:"success",
                button:"OK"
            });
            $("#buttonSites").html('ADD Site');
            fetchSites();
            /*
            $('.pay-bills').DataTable().ajax.reload();
            $('.data-bills').DataTable().ajax.reload();
            $('#data_table').DataTable().ajax.reload();
            fetchTotal();
            $('#myModal').modal('toggle');
            */
            $('#sitesModal').modal('toggle');
            $('#formSites').trigger("reset");
            $('.data-sites').DataTable().ajax.reload()
            /*
            fetchMaterials();
            dynamic_field(1);
            */
        }
        else
        {
            $("#siteError").fadeIn(1000,function(){
                printErrorMsg(response.error);
                $("#buttonSites").html('ADD Site');
            });
        }
    }
});
    }));
    $('.cancel_bills').click(function(){
      $('#formBills').trigger("reset");
    });
    $('.cancel_editbills').click(function(){
      $('#formEditBills').trigger("reset");
    });
    $('.cancel_paybills').click(function(){
      $('#formPayBills').trigger("reset");
    });
    $('#formRelease').on('submit',(function(e){
e.preventDefault();
$.ajax({
    url:"",
    type:"POST",
    data:new FormData(this),
    contentType:false,
    cache:false,
    processData:false,
    beforeSend:function()
    {
      
        $('#buttonRelease').html('Release Materials');
    },
    success : function(response)
    {
        if($.isEmptyObject(response.error))
        {
          //$('#myModal').modal('toggle');

            swal({
                title:"Success",
                text:"Material Successfully Released",
                icon:"success",
                button:"OK"
            });
            $('.data-table2').DataTable().ajax.reload();
            $('#myModalRelease').modal('toggle');
            $('#formRelease').reset();
        }
        else
        {
            $("#releaseError").fadeIn(1000,function(){
                printErrorMsg(response.error);
                $("#buttonRelease").html('ADD');
            });
        }
    }
});
    }));
    $('#formMaterials').on('submit',(function(e){
e.preventDefault();
$.ajax({
    url:"{{ route('materials.store')}}",
    type:"POST",
    data:new FormData(this),
    contentType:false,
    cache:false,
    processData:false,
    beforeSend:function()
    {
        $('#buttonMaterial').html('Adding New Material');
    },
    success : function(response)
    {
        if($.isEmptyObject(response.error))
        {
          //$('#myModal').modal('toggle');

            swal({
                title:"Success",
                text:"Material Successfully Added",
                icon:"success",
                button:"OK"
            });
            $('.data-tableM').DataTable().ajax.reload();
            $('#myMaterials').modal('toggle');
            $('#formMaterials').trigger('reset');
            fetchMaterials();
        }
        else
        {
            $("#supMat").fadeIn(1000,function(){
                printErrorMsg(response.error);
                $("#buttonMaterial").html('ADD');
            });
        }
    }
});
    }));$('#formSuppliersEdit').on('submit',(function(e){
e.preventDefault();
$.ajax({
    url:"updateSupplier",
    type:"POST",
    data:new FormData(this),
    contentType:false,
    cache:false,
    processData:false,
    beforeSend:function()
    {
        $('#buttonSupplier').html('Editing Supplier Details');
    },
    success : function(response)
    {
        if($.isEmptyObject(response.error))
        {
          //$('#myModal').modal('toggle');

            swal({
                title:"Success",
                text:"Supplier Successfully Updated",
                icon:"success",
                button:"OK"
            });
            $('.data-tableS').DataTable().ajax.reload();
            $('#mySuppliersEdit').modal('toggle');
            $('#formSuppliersEdit').trigger("reset");
            $('#supplier').val('');
            
          $('#supplier').trigger('reset');
            fetchSuppliers();
            fetchPdfSupplier();
            fetchSupplier();
            $('.pay-bills').DataTable().ajax.reload();
            $('.data-bills').DataTable().ajax.reload();
            $('#data_table').DataTable().ajax.reload();
            
        }
        else
        {
            $("#supError").fadeIn(1000,function(){
                printErrorMsg(response.error);
                $("#buttonSupplier").html('ADD');
            });
        }
    }
});
    }));

    $('#formSuppliers').on('submit',(function(e){
e.preventDefault();
$.ajax({
    url:"{{ route('suppliers.store')}}",
    type:"POST",
    data:new FormData(this),
    contentType:false,
    cache:false,
    processData:false,
    beforeSend:function()
    {
        $('#buttonSupplier').html('Adding New Supplier');
    },
    success : function(response)
    {
        if($.isEmptyObject(response.error))
        {
          //$('#myModal').modal('toggle');

            swal({
                title:"Success",
                text:"Supplier Successfully Added",
                icon:"success",
                button:"OK"
            });
            $('.data-tableS').DataTable().ajax.reload();
            $('#mySuppliers').modal('toggle');
            $('#formSuppliers').trigger("reset");
            $('#supplier').val('');
          $('#supplier').trigger('reset');
            fetchSuppliers();
            fetchPdfSupplier();
            
        }
        else
        {
            $("#supError").fadeIn(1000,function(){
                printErrorMsg(response.error);
                $("#buttonSupplier").html('ADD');
            });
        }
    }
});
    }));
    $("#formEditBills").on('submit',(function(e)
					 {
			
						 e.preventDefault();
                 //alert("You Are Good To Go");
								//var product_id=$('#hidden_id').val();
								 //alert(vehicle_id)
                $.ajax({
									url:"updateBill",
									type:"POST",
									data:new FormData(this),
									contentType:false,
									cache:false,
									processData:false,
									beforeSend:function()
									{
                      //$("#vehicleError").fadeOut();
                      
											$("#buttonEditBills").html('Updating Details....');
									},
									success : function(response)
									{
										if($.isEmptyObject(response.error))
										{
											swal({
												title:"Success",
												text:"Bill Details Successfully Updated",
												icon:"success",
												button:"OK"
                      });
                      //load_data();
                      $("#buttonEditBills").html('Update');
                   $('#myModalEdit').modal('toggle');
									 $('#data_table').DataTable().ajax.reload();
                   $('.data-paid').DataTable().ajax.reload();
                   $('.pay-bills').DataTable().ajax.reload();
                   fetchTotal();
										}
									
									else
									
									{
																			
					$("#siteErroru").fadeIn(1000, function(){						
						printErrorMsg(response.error);
						$("#buttonEditBills").html('Update Details');
					});
									}	
                  }
                  
								});
					 }));
    $("#formEditExpenses").on('submit',(function(e)
					 {
			
						 e.preventDefault();
                 //alert("You Are Good To Go");
								//var product_id=$('#hidden_id').val();
								 //alert(vehicle_id)
                $.ajax({
									url:"updateExpense",
									type:"POST",
									data:new FormData(this),
									contentType:false,
									cache:false,
									processData:false,
									beforeSend:function()
									{
                      //$("#vehicleError").fadeOut();
                      
											$("#buttonEditExpense").html('Updating Details....');
									},
									success : function(response)
									{
										if($.isEmptyObject(response.error))
										{
											swal({
												title:"Success",
												text:"Expenses Details Successfully Updated",
												icon:"success",
												button:"OK"
                      });
                      //load_data();
                      $("#buttonEditBills").html('Update');
                   $('#editExpenses').modal('toggle');
                   $('#formEditExpenses').trigger("reset");
            $('.data-table-expenses').DataTable().ajax.reload()
										}
									
									else
									
									{
																			
					$("#siteErroru").fadeIn(1000, function(){						
						printErrorMsg(response.error);
						$("#buttonEditBills").html('Update Details');
					});
									}	
                  }
                  
								});
					 }));
           $("#registerEditUser").on('submit',(function(e)
					 {
			
						 e.preventDefault();
                 //alert("You Are Good To Go");
								//var product_id=$('#hidden_id').val();
								 //alert(vehicle_id)
                $.ajax({
									url:"updateUser",
									type:"POST",
									data:new FormData(this),
									contentType:false,
									cache:false,
									processData:false,
									beforeSend:function()
									{
                      //$("#vehicleError").fadeOut();
                      
											$("#buttonUserEdit").html('Updating Details....');
									},
									success : function(response)
									{
										if($.isEmptyObject(response.error))
										{
											swal({
												title:"Success",
												text:"User Details Successfully Updated",
												icon:"success",
												button:"OK"
                      });
                      //load_data();
                      $("#buttonUserEdit").html('Update');
                   $('#myModalEditUsers').modal('toggle');
									 $('.data-table-users').DataTable().ajax.reload();
                   
										}
									
									else
									
									{
																			
					$("#edituserError").fadeIn(1000, function(){						
						printErrorMsg(response.error);
						$("#buttonUserEdit").html('EDIT');
					});
									}	
                  }
                  
								});
					 }));
    $("#registerEditPassword").on('submit',(function(e)
					 {
			
						 e.preventDefault();
                 //alert("You Are Good To Go");
								//var product_id=$('#hidden_id').val();
								 //alert(vehicle_id)
                $.ajax({
									url:"updatePassword",
									type:"POST",
									data:new FormData(this),
									contentType:false,
									cache:false,
									processData:false,
									beforeSend:function()
									{
                      //$("#vehicleError").fadeOut();
                      
											$("#buttonPasswordEdit").html('Updating Details....');
									},
									success : function(response)
									{
										if($.isEmptyObject(response.error))
										{
											swal({
												title:"Success",
												text:"Password Successfully Updated",
												icon:"success",
												button:"OK"
                      });
                      //load_data();
                      $("#buttonPasswordEdit").html('Update');
                   $('#myModalEditUserspassword').modal('toggle');
									 $('.data-table-users').DataTable().ajax.reload();
                   
										}
									
									else
									
									{
																			
					$("#editpasswordError").fadeIn(1000, function(){						
						printErrorMsg(response.error);
						$("#buttonPasswordEdit").html('Update');
					});
									}	
                  }
                  
								});
					 }));
    $("#formPayBills").on('submit',(function(e)
					 {
			
						 e.preventDefault();
                 //alert("You Are Good To Go");
								 var pay_id=$('#hidden_pay').val();
								 //alert(vehicle_id)
                $.ajax({
									url:"addPayment",
									type:"POST",
									data:new FormData(this),
									contentType:false,
									cache:false,
									processData:false,
									beforeSend:function()
									{
                      //$("#vehicleError").fadeOut();
                      
											$("#buttonPayBills").html('Adding Payments....');
									},
									success : function(response)
									{
										if($.isEmptyObject(response.error))
										{ 
                      if(response=="Paid")
                      {
                        alert("PAYMENT ALREADY FULLY PAID");
                      }
                      else
                      {
                        swal({
												title:"Success",
												text:"Payment Successfully Added",
												icon:"success",
												button:"OK"
                      });
                      }
                      //load_data();
                   $('#myModalPay').modal('toggle');
									 $('.pay-bills').DataTable().ajax.reload();
										}
									
									else
									
									{
																			
					$("#siteErroru").fadeIn(1000, function(){						
						printErrorMsg(response.error);
						$("#buttonPayBills").html('Update Details');
					});
									}	
                  }
                  
								});
					 }));
 
    var table2 = $('.data-table2').DataTable({
        "processing":true,
        "serverSide":true,
        "ajax":"{{route('materials.index')}}",
        "columns":[
            
                {data:'DT_RowIndex',name: 'DT_RowIndex'},
                {data:'material_name',name:'site_name'},
                {data:'package',name:'location'},
                {data:'price',name:'owner'},
                {data:'quantity',name:'phone'},
                {data:'created_at',name:'created_at'},
                {data:'edit',name:'edit',orderable:false,searchable:false},
				{data:'delete',name:'delete',orderable:false,searchable:false},
				{data:'more',name:'more',orderable:false,searchable:false}
            
        ]
    });
    var table_suppliers = $('.data-tableS').DataTable({
        "processing":true,
        "serverSide":true,
        "ajax":"{{route('suppliers.index')}}",
        "columns":[
            
                {data:'DT_RowIndex',name: 'DT_RowIndex'},
                {data:'supplier_name',name:'supplier_name'},
                {data:'supplier_email',name:'supplier_email'},
                {data:'supplier_phone',name:'supplier_phone'},
                {data:'company_name',name:'company_name'},
               
                {data:'created_at',name:'created_at'},
                {data:'edit',name:'edit',orderable:false,searchable:false},
				{data:'delete',name:'delete',orderable:false,searchable:false},

            
        ]
    });
    var table_users = $('.data-table-users').DataTable({
        "processing":true,
        "serverSide":true,
        "ajax":"fetchUsers",
        "columns":[
            
                {data:'DT_RowIndex',name: 'DT_RowIndex'},
                {data:'name',name:'name'},
                {data:'user_email',name:'user_email'},
                {data:'phone_no',name:'phone_no'},
              
               
                {data:'created_at',name:'created_at'},
                {data:'edit',name:'edit',orderable:false,searchable:false},
				{data:'delete',name:'delete',orderable:false,searchable:false},
        {data:'change',name:'change',orderable:false,searchable:false},
				
            
        ]
    });
    var table_materials = $('.data-tableM').DataTable({
        "processing":true,
        "serverSide":true,
        "ajax":"{{route('materials.index')}}",
        "columns":[
            
                {data:'DT_RowIndex',name: 'DT_RowIndex'},
                {data:'material_name',name:'material_name'},
                {data:'mat_description',name:'mat_description'},
               
                {data:'created_at',name:'created_at'},
                {data:'edit',name:'edit',orderable:false,searchable:false},
			

            
        ]
    });
});

function printErrorMsg(msg)
					 {
						 $(".print-error-msg").find("ul").html('');
						 $(".print-error-msg").css('display','block');
						 $.each(msg,function(key,value){
              $(".print-error-msg").find('ul').append('<li>' + value + '</li>');
						 });
					 }
      
       
</script>
</body>
