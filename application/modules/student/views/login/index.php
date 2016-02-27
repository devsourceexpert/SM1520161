<?php
    // pre populate data in post-back and edit secreen.
    echo $username   =  isset($_POST['username']) ? $_POST['username'] : '';
    
?>

<!-- Page Heading BEGINS -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Student Login
        </h1>
    </div>
</div>
<!-- Page Heading ENDS -->

    
<!-- Content Begin -->
  
<?php echo form_open(BASE_MODULE_URL.'login/index'); ?>
<div class="col-lg-6">
    <div class="panel panel-primary">

        <div class="panel-heading">
            <h3 class="panel-title">Student Login</h3>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="username">User Name *</label>
                        <input type="text" class="form-control" id="username" name="username" 
                               placeholder="User Name" value="<?php echo $username; ?>">
                        <?php //echo form_error('username'); ?>
                    </div>
                </div>
            </div>    
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label>Password *</label>
                        <input type="password" class="form-control" id="password" name="password" value="" placeholder="Password">
                        <?php echo validation_errors(); ?>
                    </div>
                </div>
            </div>
            

            <div class="col-lg-2">
                <div class="form-group">
                    <label for="section_name">&nbsp;</label>
                    <div class="clearfix">
                        <button type="submit" id="btn_login" name="btn_login" class="btn btn-success">Login</button>
                    </div>
                </div>
            </div>

        </div>
        </div>
</div>
    </div>    
<?php echo form_close(); ?>




<!-- Content End -->


