<?php
// pre populate data in post-back and edit secreen.
$student_id         = (isset($student[0]->student_id) && $student[0]->student_id != '0') ? $student[0]->student_id : (isset($_POST['student_id']) ? $_POST['student_id'] : '0');
$first_name         = (isset($student[0]->first_name) && $student[0]->first_name != '') ? $student[0]->first_name : (isset($_POST['first_name']) ? $_POST['first_name'] : '');
$active             = (isset($student[0]->active)) ? $student[0]->active : (isset($_POST['active']) ? $_POST['active'] : '1');
$last_name          = (isset($student[0]->last_name) && $student[0]->last_name != '') ? $student[0]->last_name : (isset($_POST['last_name']) ? $_POST['last_name'] : '');
$email              = (isset($student[0]->last_name) && $student[0]->email != '') ? $student[0]->email : (isset($_POST['email']) ? $_POST['email'] : '');
$admission_number   = (isset($student[0]->admission_number) && $student[0]->admission_number != '') ? $student[0]->admission_number : (isset($_POST['admission_number']) ? $_POST['admission_number'] : '');
$admission_date     = (isset($student[0]->admission_date) && $student[0]->admission_date != '') ? $student[0]->admission_date : (isset($_POST['admission_date']) ? $_POST['admission_date'] : '');
$contact_number1    = (isset($student[0]->contact_number1) && $student[0]->contact_number1 != '') ? $student[0]->contact_number1 : (isset($_POST['contact_number1']) ? $_POST['contact_number1'] : '');
$contact_number2     = (isset($student[0]->contact_number2) && $student[0]->contact_number2 != '') ? $student[0]->contact_number2 : (isset($_POST['contact_number2']) ? $_POST['contact_number2'] : '');
$gender             = (isset($student[0]->gender) && $student[0]->gender != '') ? $student[0]->gender : (isset($_POST['gender']) ? $_POST['gender'] : '');
$hostal_dayscholor  = (isset($student[0]->hostal_dayscholor) && $student[0]->hostal_dayscholor != '') ? $student[0]->hostal_dayscholor : (isset($_POST['hostal_dayscholor']) ? $_POST['hostal_dayscholor'] : '');
$physically_disabled = (isset($student[0]->physically_disabled) && $student[0]->physically_disabled != '') ? $student[0]->physically_disabled : (isset($_POST['physically_disabled']) ? $_POST['physically_disabled'] : '');
$birth_date = (isset($student[0]->birth_date) && $student[0]->birth_date != '') ? $student[0]->birth_date : (isset($_POST['birth_date']) ? $_POST['birth_date'] : '');
$disabled_description = (isset($student[0]->disabled_description) && $student[0]->disabled_description != '') ? $student[0]->disabled_description : (isset($_POST['disabled_description']) ? $_POST['disabled_description'] : '');


$address_line1         = (isset($student_address[0]->address_line1) && $student_address[0]->address_line1 != '') ? $student_address[0]->address_line1 : (isset($_POST['address_line1']) ? $_POST['address_line1'] : '');
$address_line2         = (isset($student_address[0]->address_line2) && $student_address[0]->address_line2 != '') ? $student_address[0]->address_line2 : (isset($_POST['address_line2']) ? $_POST['address_line2'] : '');
$city         = (isset($student_address[0]->city) && $student_address[0]->city != '') ? $student_address[0]->city : (isset($_POST['city']) ? $_POST['city'] : '');
$state_id         = (isset($student_address[0]->state_id) && $student_address[0]->state_id != '') ? $student_address[0]->state_id : (isset($_POST['state_id']) ? $_POST['state_id'] : '');
$country_id         = (isset($student_address[0]->country_id) && $student_address[0]->country_id != '') ? $student_address[0]->country_id : (isset($_POST['country_id']) ? $_POST['country_id'] : '');
$address_type         = (isset($student_address[0]->address_type) && $student_address[0]->address_type != '') ? $student_address[0]->address_type : (isset($_POST['address_type']) ? $_POST['address_type'] : '');


?>
<script>
    $(function(){
        $('#admission_date').datepicker({ format: 'yyyy-dd-mm' });
        $('#birth_date').datepicker({ format: 'yyyy-dd-mm' });
        
    });
</script>
<!-- Page Heading BEGINS -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Student <small><?php echo $title;?></small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <a href="<?php echo BASE_MODULE_URL; ?>student/index" class="btn btn-success btn-xs">Students</a>
            </li>
        </ol>
    </div>
</div>
<!-- Page Heading ENDS -->

    
<!-- Content Begin -->
<?php echo form_open(BASE_MODULE_URL.'student/'.$action); ?>
    <input type="hidden" id="student_id" name="student_id" value="<?php echo $student_id; ?>">
    <div class="panel panel-primary">

        <div class="panel-heading">
            <h3 class="panel-title"><?php echo $title;?> Student</h3>
        </div>

        <div class="panel-body">
            <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="admission_number">Admission No</label>
                    <input type="text" class="form-control" id="admission_number" name="admission_number" 
                           placeholder="Admission No" value="<?php echo $admission_number; ?>">
                    <?php echo form_error('admission_number'); ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="admission_date">Admission Date</label>
                    <input type="text" class="form-control" id="admission_date" name="admission_date" 
                           placeholder="Admission Date" value="<?php echo $admission_date; ?>">
                    <?php echo form_error('admission_date'); ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" 
                           placeholder="First Name" value="<?php echo $first_name; ?>">
                    <?php echo form_error('first_name'); ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" 
                           placeholder="Last Name" value="<?php echo $last_name; ?>">
                    <?php echo form_error('last_name'); ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email" name="email" 
                           placeholder="Email" value="<?php echo $email; ?>">
                    <?php echo form_error('email'); ?>
                </div>
            </div>  
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="contact_number1">Contact No</label>
                    <input type="text" class="form-control" id="contact_number1" name="contact_number1" 
                           placeholder="Contact No" value="<?php echo $contact_number1; ?>">
                    <?php echo form_error('contact_number1'); ?>
                </div>
            </div> 
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="contact_number2">Alternate Contact No</label>
                    <input type="text" class="form-control" id="contact_number2" name="contact_number2" 
                           placeholder="Alternate Contact No" value="<?php echo $contact_number2; ?>">
                    <?php echo form_error('contact_number2'); ?>
                </div>
            </div> 
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select class="form-control" id="gender" name="gender" >
                        <option value="">Select</option>
                        <option value="M" <?php if($gender=='M'){ echo "selected='selected'"; } ?> >Male</option>
                        <option value="F" <?php if($gender=='F'){ echo "selected='selected'"; } ?>>Female</option>
                    </select>
                    <?php echo form_error('gender'); ?>
                </div>
            </div> 
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="birth_date">Date Of Birth</label>
                    <input type="text" class="form-control" id="birth_date" name="birth_date" 
                           placeholder="Date of birth" value="<?php echo $birth_date; ?>">
                    <?php echo form_error('birth_date'); ?>
                </div>
            </div>     
            <div class="col-lg-4">
                <div class="form-group">
                    <label>Hostal / Day Sholor</label>
                    <div class="radio">
                        <label>
                <input type="radio" name="hostal_dayscholor" id="hostal_dayscholor1" value="1" <?php if($hostal_dayscholor=='1'){ echo "checked='checked'"; } ?> >Hostal
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="hostal_dayscholor" id="hostal_dayscholor2" value="0" <?php if($hostal_dayscholor=='0'){ echo "checked='checked'"; } ?>>Day Scholor
                        </label>
                    </div>
                </div>
            </div>  
            <div class="col-lg-4">
                <div class="form-group">
                    <label>Physically Disabled</label>
                    <div class="radio">
                        <label>
                            <input type="radio" name="physically_disabled" id="physically_disabled" value="1" <?php if($physically_disabled=='1'){ echo "checked='checked'"; } ?>>Yes
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="physically_disabled" id="physically_disabled1" value="0" <?php if($physically_disabled=='0'){ echo "checked='checked'"; } ?> >No
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label>Description (If Physically Disabled is YES)</label>
                    <textarea class="form-control" rows="3" id="disabled_description" name="disabled_description"><?php echo $disabled_description; ?></textarea>
                </div>
            </div>    
                
            <div class="col-lg-4">
                <div class="form-group">
                    <label>Address Type</label>
                    <br>
                    <label>
                        <input type="radio" name="address_type" id="address_type" value="PERMNENT" <?php if($address_type=='PERMNENT'){ echo "checked='checked'"; } ?> >&nbsp;PERMNENT
                    </label>
                    <label>
                        <input type="radio" name="address_type" id="address_type" value="PRESENT" <?php if($address_type=='PRESENT'){ echo "checked='checked'"; } ?>>&nbsp;PRESENT
                    </label>
                </div>
            </div> 
            <!-- Address Line -->
           
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="address_line1">Address Line1</label>
                    <input type="text" class="form-control" id="address_line1" name="address_line1" 
                           placeholder="Address Line1" value="<?php echo $address_line1; ?>">
                    <?php echo form_error('address_line1'); ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="address_line2">Address Line2</label>
                    <input type="text" class="form-control" id="address_line2" name="address_line2" 
                           placeholder="Address Line2" value="<?php echo $address_line2; ?>">
                    <?php echo form_error('address_line2'); ?>
                </div>
            </div>    
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" class="form-control" id="city" name="city" 
                           placeholder="City" value="<?php echo $city; ?>">
                    <?php echo form_error('city'); ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="gender">State</label>
                    <select class="form-control" id="state_id" name="state_id" >
                        <option value="">Select State</option>
                        <option value="1" <?php if($state_id=='1'){ echo "selected='selected'"; } ?> >Tamil Nadu</option>
                        <option value="2" <?php if($state_id=='2'){ echo "selected='selected'"; } ?>>Karnataka</option>
                    </select>
                    <?php echo form_error('state_id'); ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="country_id">Country</label>
                    <select class="form-control" id="country_id" name="country_id" >
                        <option value="">Select Country</option>
                        <option value="1" selected="selected">India</option>
                    </select>
                    <?php echo form_error('country_id'); ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group <?php if($action == 'create') echo 'hidden_coumn'; ?>">
                    <label for="first_name">Active</label>
                    <select class="form-control" id="active" name="active" >
                        <option value="1" <?php if($active == '1') echo "selected='selected'" ?> >Yes</option>
                        <option value="0" <?php if($active == '0') echo "selected='selected'" ?> >No</option>
                    </select>
                    
                </div>
            </div>            
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="first_name">&nbsp;</label>
                    <div class="clearfix">
                        <button type="submit" id="btn_save" name="btn_save" class="btn btn-success"><?php echo $action_button_text;?></button>
                    </div>
                </div>
            </div>

        </div>
        </div>

    </div>    
<?php echo form_close(); ?>




<!-- Content End -->


