<?php
$dir_path = "uploads/";
require_once('include/getimages.php');

//for total count data 
$total_records = count($newarray);  
$total_pages = ceil($total_records / $per_page);//$limit

//for first time load data
if (isset($_GET["page"])) {
	$page  = $_GET["page"];
} else {
	$page = 1;
}

$start_from = ($page - 1) * $per_page;  //$limit
$row = array_slice($newarray, $start_from, $per_page);
?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="dist/simplePagination.css" />
	<script src="dist/jquery.simplePagination.js"></script>
	<title>Advanced Pagination with PHP AJAX jQuery MySQL</title>
</head>
<body>
	<div class="container" style="padding-top:20px;">
	<form action="include/upload.php" method="POST" enctype="multipart/form-data">
			<input type="file" name="file">
			<button type="submit" name="submit">Upload Image</button>
		</form>
		<table class="table table-bordered table-striped">  
			<thead>  
				<tr>
					<th>Image</th>
					<th>Name</th>
					<th>Size</th>
					<th>Open</th>
					<th>Delete</th>
				</tr>
			</thead>
			<tbody id="target-content">
				<?php
				for ($j = 0; $j < count($row); $j++) {
				?>
					<tr>
						<td><img src="uploads/<?=$row[$j]['path']?>" style="max-width:60px;"  alt=""></td>
						<td>
							<?php if (strlen($row[$j]['name']) > 60) {
								$newName = substr($row[$j]['name'], 0, 45) . '  . . .  ' . substr($row[$j]['name'], -5);
								echo $newName; 
							} else {
								echo $row[$j]['name'];
							};
							?>
						</td>
						<td><?= $row[$j]['size'] / 1024 . ' Kb.' ?></td>
						<td>
							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal<?=$j?>">Open</button>
							<!-- The Modal -->
							<div class="modal" id="myModal<?=$j?>">
								<div class="modal-dialog">
									<div class="modal-content">
										<!-- Modal Header -->
										<div class="modal-header">
											<form method="POST" action="include/rename.php?page=<?=$page?>&&id=<?=$j?>">
												<input class="form-control" type="text" name="newName" id="" value="<?=$row[$j]['name']?>"">
												<button type="submit" class="btn btn-warning" value="submit" name="submit">Rename</button>
											</form>
											<button type="button" class="close" data-dismiss="modal">&times;</button>
										</div>
										<!-- Modal body -->
										<div class="modal-body">
											<img class="img-fluid" src="uploads/<?=$row[$j]['path']?>">
										</div>
										<!-- Modal footer -->
										<div class="modal-footer">
											<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
										</div>
									</div>
								</div>
							</div>
						</td>
						<td>
							<form method="POST" action="include/delete.php">
								<button class="btn btn-danger" name="delete" value="<?=$row[$j]['path']?>">Delete</button>
							</form>
						</td>
					</tr>
				<?php
				};
				?>
			</tbody>
		</table>
		<nav>
			<ul class="pagination">
				<?php
				if(!empty($total_pages)):for($i=1; $i<=$total_pages; $i++):
				if($i == 1):
				?>
					<li class='active'  id="<?= $i ?>">
						<a href='pagination.php?page=<?= $i ?>'><?= $i ?></a>
					</li>
					<?php
					else:
					?>
						<li id="<?= $i;?>">
							<a href='pagination.php?page=<?= $i;?>'>
								<?= $i;?>
							</a>
						</li>
					<?php
					endif;
					endfor;
					endif;
					?>
			</ul>
		</nav>
	</div>
</body>

<script>
$(document).ready(function() {
	$('.pagination').pagination({
		items: <?= $total_records;?>,
		itemsOnPage: <?= $per_page;?>,//$limit
		cssStyle: 'light-theme',
		currentPage : 1,
		onPageClick : function(pageNumber) {
			jQuery("#target-content").html('loading...');
			jQuery("#target-content").load("pagination.php?page=" + pageNumber);
		}
	});
});
</script>