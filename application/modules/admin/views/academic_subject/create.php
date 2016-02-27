<?php
    // pre populate data in post-back and edit secreen.
    $academic_subject_id    = (isset($subject[0]->academic_subject_id) && $subject[0]->academic_subject_id != '0') ? $subject[0]->academic_subject_id : (isset($_POST['academic_subject_id']) ? $_POST['academic_subject_id'] : '0');
    $subject_name           = (isset($subject[0]->subject_name) && $subject[0]->subject_name != '') ? $subject[0]->subject_name : (isset($_POST['subject_name']) ? $_POST['subject_name'] : '');
    $active                 = (isset($subject[0]->active)) ? $subject[0]->active : (isset($_POST['active']) ? $_POST['active'] : '1');
?>

<!-- Page Heading BEGINS -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Subject <small><?php echo $title;?></small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <a href="<?php echo BASE_MODULE_URL; ?>academic_subject/index" class="btn btn-success btn-xs">Academic Subjects</a>
            </li>
        </ol>
    </div>
</div>
<!-- Page Heading ENDS -->

    
<!-- Content Begin -->
<?php echo form_open(BASE_MODULE_URL.'academic_subject/'.$action); ?>
    <input type="hidden" id="academic_subject_id" name="academic_subject_id" value="<?php echo $academic_subject_id; ?>">
    <div class="panel panel-primary">

        <div class="panel-heading">
            <h3 class="panel-title"><?php echo $title;?> Subject</h3>
        </div>

        <div class="panel-body">
            <div class="row">

            <div class="col-lg-6">
                <div class="form-group">
                    <label for="subject_name">Subject</label>
                    <input type="text" class="form-control" id="subject_name" name="subject_name" 
                           placeholder="subject Name" value="<?php echo $subject_name; ?>">
                    <?php echo form_error('subject_name'); ?>
                </div>
            </div>

            <div class="col-lg-4" >
                <div class="form-group <?php if($action == 'create') echo 'hidden_coumn'; ?>">
                    <label for="subject_name">Active</label>
                    <select class="form-control" id="active" name="active" >
                        <option value="1" <?php if($active == '1') echo "selected='selected'" ?> >Yes</option>
                        <option value="0" <?php if($active == '0') echo "selected='selected'" ?> >No</option>
                    </select>
                    
                </div>
            </div>

            <div class="col-lg-2">
                <div class="form-group">
                    <label for="subject_name">&nbsp;</label>
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


