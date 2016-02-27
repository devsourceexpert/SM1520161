<?php
    // pre populate data in post-back and edit secreen.
    $academic_year_id      = (isset($academic_year[0]->academic_year_id) && $academic_year[0]->academic_year_id != '0') ? $academic_year[0]->academic_year_id : (isset($_POST['academic_year_id']) ? $_POST['academic_year_id'] : '0');
    $from_year    = (isset($academic_year[0]->from_year) && $academic_year[0]->from_year != '') ? $academic_year[0]->from_year : (isset($_POST['from_year']) ? $_POST['from_year'] : '');
	$to_year    = (isset($academic_year[0]->to_year) && $academic_year[0]->to_year != '') ? $academic_year[0]->to_year : (isset($_POST['to_year']) ? $_POST['to_year'] : '');
    $active         = (isset($academic_year[0]->active)) ? $academic_year[0]->active : (isset($_POST['active']) ? $_POST['active'] : '1');
?>

<!-- Page Heading BEGINS -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Academic Year <small><?php echo $title;?></small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <a href="<?php echo BASE_MODULE_URL; ?>academic_year/index" class="btn btn-success btn-xs">Academic Years</a>
            </li>
        </ol>
    </div>
</div>
<!-- Page Heading ENDS -->

    
<!-- Content Begin -->
<?php echo form_open(BASE_MODULE_URL.'academic_year/'.$action); ?>
    <input type="hidden" id="academic_year_id" name="academic_year_id" value="<?php echo $academic_year_id; ?>">
    <div class="panel panel-primary">

        <div class="panel-heading">
            <h3 class="panel-title"><?php echo $title;?> Academic Years</h3>
        </div>

        <div class="panel-body">
            <div class="row">

            <div class="col-lg-6">
                <div class="form-group">
                    <label for="from_year">From Year</label>
                    <input type="text" class="form-control" id="from_year" name="from_year" 
                           placeholder="From Year" value="<?php echo $from_year; ?>">
                    <?php echo form_error('from_year'); ?>
                </div>
				<div class="form-group <?php if($action == 'create') echo 'hidden_coumn'; ?>">
                    <label for="from_year">Active</label>
                    <select class="form-control" id="active" name="active" >
                        <option value="1" <?php if($active == '1') echo "selected='selected'" ?> >Yes</option>
                        <option value="0" <?php if($active == '0') echo "selected='selected'" ?> >No</option>
                    </select>
                    
                </div>
				
            </div>

            <div class="col-lg-4" >
                <div class="form-group">
                    <label for="from_year">To Year</label>
                    <input type="text" class="form-control" id="to_year" name="to_year" 
                           placeholder="Year Year" value="<?php echo $to_year; ?>">
                    <?php echo form_error('to_year'); ?>
                </div>
            </div>

            <div class="col-lg-2">
                <div class="form-group">
                    <label for="from_year">&nbsp;</label>
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


