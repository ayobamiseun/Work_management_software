<?php if(!isset($conn)){ include 'db_connect.php'; } ?>
<?php
function sanitizeinput($input){

    $input = trim($input);
    
    $input = stripslashes($input);
    
    $input = htmlspecialchars($input);

    return $input;
  
    }  
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['Submit'])) {
            //  if ($ && $checkemail ) {
                $to = sanitizeinput($_POST['email']);
                $name = sanitizeinput($_POST['name']);
                $description = sanitizeinput($_POST['description']);
                
                mail($to, $title, $description);
                
            // }
        }
	} 
	


	

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script> -->
</head>
<style>
/*Hide all except first fieldset*/
#helpdeskform .field2 {
    display: none;
}
/*inputs*/
 #helpdeskform input {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 3px;
    margin-bottom: 10px;
    width: 80%;
    color: #2C3E50;
    font-size: 13px;
}
#helpdeskform textarea {
    padding: 15px;
    border: 1px solid #ccc;
    border-radius: 3px;
    margin-bottom: 10px;
    width: 100%;
    box-sizing: border-box;
    color: #2C3E50;
    font-size: 13px;
}
/*buttons*/
 #helpdeskform .action-button {
    width: 100px;
    font-weight: bold;
    border: 0 none;
    border-radius: 1px;
    cursor: pointer;
    padding: 10px 5px;
    margin: 10px 5px;
}
#helpdeskform .action-button:hover, #helpdeskform .action-button:focus {
    box-shadow: 0 0 0 2px white, 0 0 0 3px #900;
}
/*Form labels*/
 label.form-label {
    text-align: left;
}
/*Phone Label Align*/
 input#phone-field {
    margin-left: 26px;
}
/*E-mail Label Align*/
 input#email-field {
    margin-left: 24px;
}
.counter-field {
    font-size: 10px;
}
/*Divider*/
 hr {
    margin-bottom: 20px;
    padding: 0px;
    border-width: 2px;
    border-style: solid;
    border-color: #ccc;
}
</style>
  
<div class="col-lg-12">
    <div class="card card-outline card-primary">
		<div class="card-body">
			<form action="" id="manage-project">

        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="" class="control-label">Name</label>
					<input type="text" class="form-control form-control-sm" name="name" value="<?php echo isset($name) ? $name : '' ?>">
				</div>
			</div>
          	<div class="col-md-6">
				<div class="form-group">
					<label for="">Importance</label>
					<!-- <select name="status" id="status" class="custom-select custom-select-sm">
						<option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Most Important</option>
						<option value="3" <?php echo isset($status) && $status == 3 ? 'selected' : '' ?>>slightly Important</option>
						<option value="5" <?php echo isset($status) && $status == 5 ? 'selected' : '' ?>>Impotant</option>
					</select> -->
				</div>
			</div>

            
		</div>
		<div class="row">
			<div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Start Date</label>
              <input type="date" class="form-control form-control-sm" autocomplete="off" name="start_date" value="<?php echo isset($start_date) ? date("Y-m-d",strtotime($start_date)) : '' ?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">End Date</label>
              <input type="date" class="form-control form-control-sm" autocomplete="off" name="end_date" value="<?php echo isset($end_date) ? date("Y-m-d",strtotime($end_date)) : '' ?>">
            </div>
          </div>
		</div>
        <!-- email -->
       
        <!-- email -->
        <div class="row">
        	<?php if($_SESSION['login_type'] == 1 ): ?>
           <div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Project Manager</label>
              <select class="form-control form-control-sm select2" name="manager_id">
              	<option></option>
              	<?php 
              	$managers = $conn->query("SELECT *,concat(firstname,' ',lastname) as name FROM users where type = 2 order by concat(firstname,' ',lastname) asc ");
              	while($row= $managers->fetch_assoc()):
              	?>
              	<option value="<?php echo $row['id'] ?>" <?php echo isset($manager_id) && $manager_id == $row['id'] ? "selected" : '' ?>><?php echo ucwords($row['name']) ?></option>
              	<?php endwhile; ?>
              </select>
            </div>
          </div>
      <?php else: ?>
      	<input type="hidden" name="manager_id" value="<?php echo $_SESSION['login_id'] ?>">
      <?php endif; ?>
          <div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Project Team Members</label>
              <select class="form-control form-control-sm select2" multiple="multiple" name="user_ids[]">
              	<option></option>
              	<?php 
              	$employees = $conn->query("SELECT *,concat(firstname,' ',lastname) as name FROM users where type = 3 order by concat(firstname,' ',lastname) asc ");
              	while($row= $employees->fetch_assoc()):
              	?>
              	<option value="<?php echo $row['id'] ?>" <?php echo isset($user_ids) && in_array($row['id'],explode(',',$user_ids)) ? "selected" : '' ?>><?php echo ucwords($row['name']) ?></option>
              	<?php endwhile; ?>
              </select>
            </div>
          </div>
        </div>
		<div class="row">
			<div class="col-md-10">
				<div class="form-group">
					<label for="" class="control-label">Description</label>
					<textarea name="description" id="" cols="30" rows="10" class="summernote form-control">
						<?php echo isset($description) ? $description : '' ?>
					</textarea>
				</div>
			</div>
		</div>
        </form>
    	</div>
        <div class="col-md-6">
				<div class="form-group">
					<label for="" class="control-label">Job Owner Email</label>
                    <select class="form-control form-control-sm select2" multiple="multiple" name="email">
              	<option></option>
              	<?php 
              	$employees = $conn->query("SELECT *, email as name FROM users where type = 3 order by email asc ");
              	while($row= $employees->fetch_assoc()):
              	?>
              	<option value="<?php echo $row['id'] ?>" <?php echo isset($user_ids) && in_array($row['id'],explode(',',$user_ids)) ? "selected" : '' ?>><?php echo ucwords($row['name']) ?></option>
              	<?php endwhile; ?>
              </select>
				</div>
			</div>
    	<div class="card-footer border-top border-info">
    		<div class="d-flex w-100 justify-content-center align-items-center">
    			<button class="btn btn-flat  bg-gradient-primary mx-2" name="Submit" form="manage-project">Save</button>
    			<button class="btn btn-flat bg-gradient-secondary mx-2" type="button" onclick="location.href='index.php?page=project_list'">Cancel</button>
    		</div>
    	</div>
		<!-- Add preview botton -->
<!-- 
		<label for="review">
                <input type="button" name="review" class="review action-button" value="Review" />
            </label> -->
			<!-- End of preview botton -->
	</div>
</div>

</fieldset>
    
<!-- the preview field -->

<script>
	$('#manage-project').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_project',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp == 1){
					alert_toast('Data successfully saved',"success");
					setTimeout(function(){
						location.href = 'index.php?page=project_list'
					},2000)
				}
			}
		})
	})


	// Create a preview botton 

	
</script>