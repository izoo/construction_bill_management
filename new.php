<script>
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
    </script>