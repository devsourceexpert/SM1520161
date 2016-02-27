<?php
    // pre populate data in post-back and edit secreen.
    $module_id      = (isset($module[0]->module_id) && $module[0]->module_id != '0') ? $module[0]->module_id : (isset($_POST['module_id']) ? $_POST['module_id'] : '0');
    $module_name    = (isset($module[0]->module_name) && $module[0]->module_name != '') ? $module[0]->module_name : (isset($_POST['module_name']) ? $_POST['module_name'] : '');
    $active         = (isset($module[0]->active)) ? $module[0]->active : (isset($_POST['active']) ? $_POST['active'] : '1');
?>

<!-- Page Heading BEGINS -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Modules <small><?php echo $title;?></small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <a href="<?php echo BASE_MODULE_URL; ?>module/index" class="btn btn-success btn-xs">Modules</a>
            </li>
        </ol>
    </div>
</div>
<!-- Page Heading ENDS -->

    
<!-- Content Begin -->
<?php echo form_open(BASE_MODULE_URL.'module/'.$action); ?>
    <input type="hidden" id="module_id" name="module_id" value="<?php echo $module_id; ?>">
    <div class="panel panel-primary">

        <div class="panel-heading">
            <h3 class="panel-title"><?php echo $title;?> Module</h3>
        </div>

        <div class="panel-body">
            <div class="row">

            <div class="col-lg-6">
                <div class="form-group">
                    <label for="module_name">Module</label>
                    <input type="text" class="form-control" id="module_name" name="module_name" 
                           placeholder="Module Name" value="<?php echo $module_name; ?>">
                    <?php echo form_error('module_name'); ?>
                </div>
            </div>

            <div class="col-lg-4" >
                <div class="form-group <?php if($action == 'create') echo 'hidden_coumn'; ?>">
                    <label for="module_name">Active</label>
                    <select class="form-control" id="active" name="active" >
                        <option value="1" <?php if($active == '1') echo "selected='selected'" ?> >Yes</option>
                        <option value="0" <?php if($active == '0') echo "selected='selected'" ?> >No</option>
                    </select>
                    
                </div>
            </div>

            <div class="col-lg-2">
                <div class="form-group">
                    <label for="module_name">&nbsp;</label>
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


