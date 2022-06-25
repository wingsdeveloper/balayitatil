<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/card.css">    
</head>
<div class="container">
	<ul class="nav nav-tabs">
	<li class="active"><a data-toggle="tab" href="#tr">TR</a></li>
	<li><a data-toggle="tab" href="#en">EN</a></li>
	</ul>
	<div class="tab-content">
		
	        <div id="tr" class="tab-pane fade in active">
	        	<form action="">	
		        	<h4>{{ $error['tr']['title'] }}</h4>
					<div class="form-group" style="display: flex">
	        			<input type="text" class="form-control" name="code" value="">
	        			<button class="btn btn-success" type="submit">Submit</button>
	            	</div>
	        	</form>
	        </div>
	        <div id="en" class="tab-pane fade">
	        	<form action="">
	            	<h4>{{ $error['en']['title'] }}</h4>
	            	<div class="form-group" style="display: flex">
	        			<input type="text" class="form-control" name="code" value="">
	        			<button class="btn btn-success" type="submit">Submit</button>
	            	</div>
	        	</form>
	        </div>
		</div>
</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>