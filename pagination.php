<?php
$dir_path = "uploads/";
require_once('include/getimages.php');

if (isset($_GET["page"])) {
	$page  = $_GET["page"]; 
} else {
	$page = 1;
};  

$start_from = ($page - 1) * $per_page;  //$limit
$row = array_slice($newarray, $start_from, $per_page);

for ($j = 0; $j < count($row); $j++) {
?>  
	<tr>  
		<td><img src="uploads/<?=$row[$j]['path']?>" style="max-width:60px;"  alt=""></td>
		<td><?php if (strlen($row[$j]['name']) > 60) {
					$newName = substr($row[$j]['name'], 0, 45) . '  . . .  ' . substr($row[$j]['name'], -5);
					echo $newName;
				} else {
					echo $row[$j]['name'];
				};
		?></td>
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
