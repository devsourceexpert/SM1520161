<?php
    // pre populate data in post-back and edit secreen.
    $section_id      = (isset($section[0]->section_id) && $section[0]->section_id != '0') ? $section[0]->section_id : (isset($_POST['section_id']) ? $_POST['section_id'] : '0');
    $section_name    = (isset($section[0]->section_name) && $section[0]->section_name != '') ? $section[0]->section_name : (isset($_POST['section_name']) ? $_POST['section_name'] : '');
    $active         = (isset($section[0]->active)) ? $section[0]->active : (isset($_POST['active']) ? $_POST['active'] : '1');
?>

<!-- Page Heading BEGINS -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Section <small><?php echo $title;?></small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <a href="<?php echo BASE_MODULE_URL; ?>section/index" class="btn btn-success btn-xs">Sections</a>
            </li>
        </ol>
    </div>
</div>
<!-- Page Heading ENDS -->

    
<!-- Content Begin -->
<?php echo form_open(BASE_MODULE_URL.'section/'.$action); ?>
    <input type="hidden" id="section_id" name="section_id" value="<?php echo $section_id; ?>">
    <div class="panel panel-primary">

        <div class="panel-heading">
            <h3 class="panel-title"><?php echo $title;?> Section</h3>
        </div>

        <div class="panel-body">
            <div class="row">

            <div class="col-lg-6">
                <div class="form-group">
                    <label for="section_name">Section</label>
                    <input type="text" class="form-control" id="section_name" name="section_name" 
                           placeholder="section Name" value="<?php echo $section_name; ?>">
                    <?php echo form_error('section_name'); ?>
                </div>
            </div>

            <div class="col-lg-4" >
                <div class="form-group <?php if($action == 'create') echo 'hidden_coumn'; ?>">
                    <label for="section_name">Active</label>
                    <select class="form-control" id="active" name="active" >
                        <option value="1" <?php if($active == '1') echo "selected='selected'" ?> >Yes</option>
                        <option value="0" <?php if($active == '0') echo "selected='selected'" ?> >No</option>
                    </select>
                    
                </div>
            </div>

            <div class="col-lg-2">
                <div class="form-group">
                    <label for="section_name">&nbsp;</label>
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


