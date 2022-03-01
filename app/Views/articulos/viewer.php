<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>CodeIgniter 4 Image Upload with File Validation Example</title>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<style>
		.container {
			max-width: 400px;
			margin-top: 50px;
		}
	</style>
</head>

<body>
	<div class="container">


		<form action="<?php echo base_url('articulos/uploadImage');?>" method="post" enctype="multipart/form-data">
			<div class="form-group mb-3">
				<input name="file" type="file" class="form-control" accept="image/*">
			</div>

			<div class="form-group">
				<button type="submit" class="btn btn-dark">Submit</button>
			</div>
		</form>


	</div>
</body>


</html>