<?php
    // pre populate data in post-back and edit secreen.
    $institute_id      = (isset($institute[0]->institute_id) && $institute[0]->institute_id != '0') ? $institute[0]->institute_id : (isset($_POST['institute_id']) ? $_POST['institute_id'] : '0');
    $institute_name    = (isset($institute[0]->institute_name) && $institute[0]->institute_name != '') ? $institute[0]->institute_name : (isset($_POST['institute_name']) ? $_POST['institute_name'] : '');
    $active         = (isset($institute[0]->active)) ? $institute[0]->active : (isset($_POST['active']) ? $_POST['active'] : '1');
?>

<!-- Page Heading BEGINS -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Institute <small><?php echo $title;?></small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <a href="<?php echo BASE_MODULE_URL; ?>institute/index" class="btn btn-success btn-xs">Institutes</a>
            </li>
        </ol>
    </div>
</div>
<!-- Page Heading ENDS -->

    
<!-- Content Begin -->
<?php echo form_open(BASE_MODULE_URL.'institute/'.$action); ?>
    <input type="hidden" id="institute_id" name="institute_id" value="<?php echo $institute_id; ?>">
    <div class="panel panel-primary">

        <div class="panel-heading">
            <h3 class="panel-title"><?php echo $title;?> Institute</h3>
        </div>

        <div class="panel-body">
            <div class="row">

            <div class="col-lg-6">
                <div class="form-group">
                    <label for="institute_name">Institute</label>
                    <input type="text" class="form-control" id="institute_name" name="institute_name" 
                           placeholder="Institute Name" value="<?php echo $institute_name; ?>">
                    <?php echo form_error('institute_name'); ?>
                </div>
            </div>

            <div class="col-lg-4" >
                <div class="form-group <?php if($action == 'create') echo 'hidden_coumn'; ?>">
                    <label for="institute_name">Active</label>
                    <select class="form-control" id="active" name="active" >
                        <option value="1" <?php if($active == '1') echo "selected='selected'" ?> >Yes</option>
                        <option value="0" <?php if($active == '0') echo "selected='selected'" ?> >No</option>
                    </select>
                    
                </div>
            </div>

            <div class="col-lg-2">
                <div class="form-group">
                    <label for="institute_name">&nbsp;</label>
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


