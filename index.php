<?php
	
//index.php	

// include('database_connection.php');

// function fill_unit_select_box($connect)
// {
// 	$output = '';

// 	$query = "SELECT * FROM unit_table ORDER BY unit_name ASC";

// 	$result = $connect->query($query);

// 	foreach($result as $row)
// 	{
// 		$output .= '<option value="'.$row["unit_name"].'">'.$row["unit_name"] . '</option>';
// 	}

// 	return $output;
// }
		
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Add or Remove Selectpicker Dropdown Dynamically in PHP using Ajax jQuery</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/css/bootstrap-select.min.css">

		<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>

		<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
	</head>
	<body>
		<br />
		<div class="container">
			<div class="card">
				<div class="card-header">Enter Item Details</div>
				<div class="card-body">

					<form method="post" id="insert_form">

					<div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect02">PON</label>
                            <input type="text" name="PON" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect02">Customer No</label>
                            <input type="text" name="examTitle" placeholder="Enter Exam title" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect02">Currency</label>
                            <input type="text" name="currency" placeholder="Select Currency" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect02">Exchange Rate</label>
                            <input type="number" name="rate" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect02">Quotation No</label>
                            <input type="text" name="quotNo" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect02">Order Date</label>
                            <input type="date" name="date" class="form-control" readonly>
                        </div>
                    </div>
                </div>





						<div class="table-repsonsive">
							<span id="error"></span>
							<table class="table table-bordered" id="item_table">
								<tr>
									
								    <th>ID</th>
                                    <th>Product_Code</th>
                                    <th>Product_Title</th>
                                    <th>Quantity</th>
                                    <th>Prices</th>
                                    <th>Units</th>
                                    <th>Total_Amount</th>
									<th><button type="button" name="add" class="btn btn-success btn-sm add"><i class="fas fa-plus"></i></button></th>
								</tr>
							</table>
							<div align="center">
								<input type="submit" name="submit" id="submit_button" class="btn btn-primary" value="Insert" />
							</div>
						</div>
					</form>
					
				</div>
			</div>
		</div>
	</body>
</html>
<script>

$(document).ready(function(){

	var count = 0;
	
	function add_input_field(count)
	{

		var html = '';

		html += '<tr>';

		html += '<td></td>';
		html += '<td><input type="text" name="code[]" class="form-control item_name" readonly/></td>';
		html += '<td><select name="title[]" class="form-control selectpicker" data-live-search="true"><option value="">Select Unit</option></select></td>';
		html += '<td><input type="number" name="Qty[]" class="form-control item_name"/></td>';
		html += '<td><input type="number" name="price[]" class="form-control item_name" readonly/></td>';
		html += '<td><input type="text" name="unit[]" class="form-control item_name" readonly/></td>';
		html += '<td><input type="text" name="total[]" class="form-control item_name" readonly/></td>';

		var remove_button = '';

		if(count > 0)
		{
			remove_button = '<button type="button" name="remove" class="btn btn-danger btn-sm remove"><i class="fas fa-minus"></i></button>';
		}

		html += '<td>'+remove_button+'</td></tr>';

		return html;

	}

	$('#item_table').append(add_input_field(0));

	$('.selectpicker').selectpicker('refresh');

	$(document).on('click', '.add', function(){

		count++;

		$('#item_table').append(add_input_field(count));

		$('.selectpicker').selectpicker('refresh');

	});

	$(document).on('click', '.remove', function(){

		$(this).closest('tr').remove();

	});
	// =================== to dislpay adding data with buttons function =========================

	$('#insert_form').on('submit', function(event){

		event.preventDefault();

		var error = '';

		count = 1;

		$('.item_name').each(function(){

			if($(this).val() == '')
			{

				error += "<li>Enter Item Name at "+count+" Row</li>";

			}

			count = count + 1;

		});

		count = 1;

		$('.item_quantity').each(function(){

			if($(this).val() == '')
			{

				error += "<li>Enter Item Quantity at "+count+" Row</li>";

			}

			count = count + 1;

		});

		count = 1;

		$("select[name='item_unit[]']").each(function(){

			if($(this).val() == '')
			{

				error += "<li>Select Unit at "+count+" Row</li>";

			}

			count = count + 1;

		});

		var form_data = $(this).serialize();

		if(error == '')
		{

			$.ajax({

				url:"insert.php",

				method:"POST",

				data:form_data,

				beforeSend:function()
	    		{

	    			$('#submit_button').attr('disabled', 'disabled');

	    		},

				success:function(data)
				{

					if(data == 'ok')
					{

						$('#item_table').find('tr:gt(0)').remove();

						$('#error').html('<div class="alert alert-success">Item Details Saved</div>');

						$('#item_table').append(add_input_field(0));

						$('.selectpicker').selectpicker('refresh');

						$('#submit_button').attr('disabled', false);
					}

				}
			})

		}
		else
		{
			$('#error').html('<div class="alert alert-danger"><ul>'+error+'</ul></div>');
		}

	});
	 
});
</script>