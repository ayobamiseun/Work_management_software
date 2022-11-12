<?php session_start() ?>
<?php 
	if(!isset($_SESSION['login_id']))
	    header('location:login.php');
    include 'db_connect.php';
    ob_start();
  if(!isset($_SESSION['system'])){

    $system = $conn->query("SELECT * FROM system_settings")->fetch_array();
    foreach($system as $k => $v){
      $_SESSION['system'][$k] = $v;
    }
  }
  ob_end_flush();

	include 'header.php'
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
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
<body>
 <?php include 'sidebar.php' ?>
  <?php include 'topbar.php' ?>
<form id="helpdeskform" action="process.php" method="post" class="container-fluid">
    <fieldset class="field1 current">
         <h2>(Placeholder) Title of Form heading level 2</h2>

        <p>
            <!-- <label class="form-label first-name" for="fname">Name Of Owner:</label> -->
            <input type="text" value="<?php echo isset($name) ? $name : '' ?>"  name="fname" id="fname" placeholder="Name Of Task" />
        </p>
        <p>
            <!-- <label class="form-label last-name" for="lname">Last Name:</label>
            <input type="text" name="lname" id="lname" placeholder="Last Name" /> -->
        </p>
        <p>
            <!-- <label class="form-label" for="phone-field">Start Date:</label> -->
            <input type="date" name="start_date" autocomplete="off" name="start_date" value="<?php echo isset($start_date) ? date("Y-m-d",strtotime($start_date)) : '' ?>" id="phone-field" placeholder="Phone Number" />
        </p>
        <p>
            <!-- <label class="form-label" for="email-field">E-mail:</label> -->
            <input type="text" name="email" id="email-field" placeholder="E-mail" />
        </p>
        <hr>
        <p>
            <!-- <label for="classify">Type of Request:</label> -->
            <select name="classify" id="classify">
                <option value="select">Please select an option..</option>
                <option value="maintainence">Maintainence of Site</option>
                <option value="troubleshoot">Troubleshoot/Error</option>
                <option value="new">Create new content</option>
            </select>
        </p>
        <p>
            <!-- <label for="subject">Short Description: <span class="counter-field"><span id="counter"></span> characters left.</span> -->
            </label>
            <input type="text" name="subject" id="subject" placeholder="Subject" />
        </p>
        <p>
            <!-- <label for="desc">Additional Comments:</label> -->
            <textarea style="font-family: Arial, Veranda, Sans serif" name="desc" id="desc" cols="30" rows="10" placeholder="Short Description"></textarea>
        </p>
        <p>
            <label for="review">
                <input type="button" name="review" class="review action-button" value="Review" />
            </label>
        </p>
    </fieldset>
    <fieldset class="field2">
        <!-- @TODO PREVIEW ALL FORM INPUTS -->
        <p>First Name:
            <input type="text" class="show_fname" style="background-color:red;" readonly="readonly" />
        </p>
        <p>Last Name:
            <input type="text" class="show_lname" readonly="readonly" />
        </p>
        <p>Phone:
            <input type="text" class="show_phone" readonly="readonly" />
        </p>
        <p>E-mail:
            <input type="text" class="show_email" readonly="readonly" />
        </p>
        <p>Type of Request:
            <input type="text" class="show_type_of_request" readonly="readonly" />
        </p>
        <p>Short Description:
            <input type="text" class="show_subject" readonly="readonly" />
        </p>
        <p>Additional Comments:
            <input type="text" class="show_comments" readonly="readonly" />
        </p>
        <p style="float:left;">
            <label for="previous">
                <input type="button" name="previous" class="previous action-button" value="Previous" />
            </label>
        </p>
        <p style="float:left; padding-left: 10px;">
            <label for="Submit">
                <input type="submit" value="Submit" name="submit" class="action-button" />
            </label>
        </p>
    </fieldset>
</form>
<div>
 <h1 class="show_comments"></h1>
</div>
<script>
 $(document).ready(function () {
    $('.show_fname').after($('#fname').val());
    $('.show_lname').after($('#lname').val());
                $('.review').click(function () {
                    var formValues = [];
                    // get values from inputs in first fieldset
                    $('.field1 :input').each(function () {
                        formValues.push($(this).val());
                    });
                    
                    formValues.pop(); //remove the button from input values
                    console.log(formValues);
                    
                    // set values in second fieldset
                    $('.field2 :input').each(function (index) {
                        if (formValues[index]) {
                            $(this).val(formValues[index]);  
                        }
                    });
                    
                    $('.current').removeClass('current').hide().next().show().addClass('current');

                });

                $('.previous').click(function () {
                    $('.current').removeClass('current').hide().prev().show().addClass('current');

                });


                
            });
</script>
</body>
</html>