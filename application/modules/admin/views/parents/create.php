<?php
// pre populate data in post-back and edit secreen.
$parent_id         = (isset($parent[0]->parent_id) && $parent[0]->parent_id != '0') ? $parent[0]->parent_id : (isset($_POST['parent_id']) ? $_POST['parent_id'] : '0');
$first_name         = (isset($parent[0]->first_name) && $parent[0]->first_name != '') ? $parent[0]->first_name : (isset($_POST['first_name']) ? $_POST['first_name'] : '');
$active             = (isset($parent[0]->active)) ? $parent[0]->active : (isset($_POST['active']) ? $_POST['active'] : '1');
$last_name          = (isset($parent[0]->last_name) && $parent[0]->last_name != '') ? $parent[0]->last_name : (isset($_POST['last_name']) ? $_POST['last_name'] : '');
$email              = (isset($parent[0]->last_name) && $parent[0]->email != '') ? $parent[0]->email : (isset($_POST['email']) ? $_POST['email'] : '');
$contact_number1    = (isset($parent[0]->contact_number1) && $parent[0]->contact_number1 != '') ? $parent[0]->contact_number1 : (isset($_POST['contact_number1']) ? $_POST['contact_number1'] : '');
$contact_number2     = (isset($parent[0]->contact_number2) && $parent[0]->contact_number2 != '') ? $parent[0]->contact_number2 : (isset($_POST['contact_number2']) ? $_POST['contact_number2'] : '');
$relationship  = (isset($parent[0]->relationship) && $parent[0]->relationship != '') ? $parent[0]->relationship : (isset($_POST['relationship']) ? $_POST['relationship'] : '');
$primary_account  = (isset($parent[0]->primary_account) && $parent[0]->primary_account != '') ? $parent[0]->primary_account : (isset($_POST['primary_account']) ? $_POST['primary_account'] : '');

$address_line1         = (isset($parent_address[0]->address_line1) && $parent_address[0]->address_line1 != '') ? $parent_address[0]->address_line1 : (isset($_POST['address_line1']) ? $_POST['address_line1'] : '');
$address_line2         = (isset($parent_address[0]->address_line2) && $parent_address[0]->address_line2 != '') ? $parent_address[0]->address_line2 : (isset($_POST['address_line2']) ? $_POST['address_line2'] : '');
$city         = (isset($parent_address[0]->city) && $parent_address[0]->city != '') ? $parent_address[0]->city : (isset($_POST['city']) ? $_POST['city'] : '');
$state_id         = (isset($parent_address[0]->state_id) && $parent_address[0]->state_id != '') ? $parent_address[0]->state_id : (isset($_POST['state_id']) ? $_POST['state_id'] : '');
$country_id         = (isset($parent_address[0]->country_id) && $parent_address[0]->country_id != '') ? $parent_address[0]->country_id : (isset($_POST['country_id']) ? $_POST['country_id'] : '');
$address_type         = (isset($parent_address[0]->address_type) && $parent_address[0]->address_type != '') ? $parent_address[0]->address_type : (isset($_POST['address_type']) ? $_POST['address_type'] : '');

?>
<!-- Page Heading BEGINS -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Parent <small><?php echo $title;?></small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <a href="<?php echo BASE_MODULE_URL; ?>parents/index" class="btn btn-success btn-xs">Parents</a>
            </li>
        </ol>
    </div>
</div>
<!-- Page Heading ENDS -->

    
<!-- Content Begin -->
<?php echo form_open(BASE_MODULE_URL.'parents/'.$action); ?>
    <input type="hidden" id="parent_id" name="parent_id" value="<?php echo $parent_id; ?>">
    <div class="panel panel-primary">

        <div class="panel-heading">
            <h3 class="panel-title"><?php echo $title;?> Student</h3>
        </div>

        <div class="panel-body">
            <div class="row">
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
                    <label for="gender">Relationship</label>
                    <select class="form-control" id="relationship" name="relationship" >
                        <option value="">Select</option>
                        <option value="FATHER" <?php if($relationship=='FATHER'){ echo "selected='selected'"; } ?> >Father</option>
                        <option value="MOTHER" <?php if($relationship=='MOTHER'){ echo "selected='selected'"; } ?>>Mother</option>
                        <option value="GUARDIAN" <?php if($relationship=='GUARDIAN'){ echo "selected='selected'"; } ?>>Guardian</option>
                    </select>
                    <?php echo form_error('relationship'); ?>
                </div>
            </div> 
                
            <div class="col-lg-4">
                <div class="form-group">
                    <label>Primary Account</label>
                    <br>
                    <label>
                        <input type="radio" name="primary_account" id="primary_account" value="1" <?php if($primary_account=='1'){ echo "checked='checked'"; } ?> >&nbsp;Yes
                    </label>
                    <label>
                        <input type="radio" name="primary_account" id="primary_account1" value="0" <?php if($primary_account=='0'){ echo "checked='checked'"; } ?>>&nbsp;No
                    </label>
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


