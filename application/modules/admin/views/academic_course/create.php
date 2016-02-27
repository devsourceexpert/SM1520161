<?php
    // pre populate data in post-back and edit secreen.
    $academic_course_id = (isset($academic_course[0]->academic_course_id) && $academic_course[0]->academic_course_id != '0') ? $academic_course[0]->academic_course_id : (isset($_POST['academic_course_id']) ? $_POST['academic_course_id'] : '0');
    $from_month         = (isset($academic_course[0]->from_month) && $academic_course[0]->from_month != '0') ? $academic_course[0]->from_month : (isset($_POST['from_month']) ? $_POST['from_month'] : '0');
    $to_month           = (isset($academic_course[0]->to_month) && $academic_course[0]->to_month != '0') ? $academic_course[0]->to_month : (isset($_POST['to_month']) ? $_POST['to_month'] : '0');
    $course_name       = (isset($academic_course[0]->course_name) && $academic_course[0]->course_name != '') ? $academic_course[0]->course_name : (isset($_POST['course_name']) ? $_POST['course_name'] : '');
    $group_name         = (isset($academic_course[0]->group_name) && $academic_course[0]->group_name != '') ? $academic_course[0]->group_name : (isset($_POST['group_name']) ? $_POST['group_name'] : '');
            
               
?>

<!-- Page Heading BEGINS -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Academic Course <small><?php echo $title;?></small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <a href="<?php echo BASE_MODULE_URL; ?>academic_course/index" class="btn btn-success btn-xs">Academic Courses</a>
            </li>
        </ol>
    </div>
</div>
<!-- Page Heading ENDS -->

    
<!-- Content Begin -->
<?php  echo form_open(BASE_MODULE_URL.'academic_course/'.$action); ?>
    <input type="hidden" id="academic_course_id" name="academic_course_id" value="<?php echo $academic_course_id; ?>">
    <div class="panel panel-primary">

        <div class="panel-heading">
            <h3 class="panel-title"><?php echo $title;?> Academic Course</h3>
        </div>

        <div class="panel-body">
            <div class="row">

                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="course_name">Course *</label>
                        <input type="text" class="form-control" id="course_name" name="course_name" 
                               placeholder="Course Name" value="<?php echo $course_name; ?>">
                        <?php echo form_error('course_name'); ?>
                    </div>
                </div>

                <div class="col-lg-4" >
                    <div class="form-group">
                        <label for="from_month">Start Month *</label>
                        <select class="form-control" id="from_month" name="from_month" >
                            <option value="">Select Month</option>
                            <?php for($year = 1; $year <= 12; $year++ ) : ?>
                                <option value="<?php echo $year; ?>" <?php if($from_month == $year) echo "selected='selected'" ?> >
                                    <?php echo date("F", mktime(0, 0, 0, $year, 10)); ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                        <?php echo form_error('from_month'); ?>

                    </div>
                </div>
                <div class="col-lg-4" >
                    <div class="form-group">
                        <label for="to_month">End Month *</label>
                        <select class="form-control" id="to_month" name="to_month" >
                            <option value="">Select Month</option>
                            <?php for($year = 1; $year <= 12; $year++ ) : ?>
                                <option value="<?php echo $year; ?>" <?php if($to_month == $year) echo "selected='selected'" ?> >
                                    <?php echo date("F", mktime(0, 0, 0, $year, 10)); ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                        <?php echo form_error('to_month'); ?>

                    </div>
                </div>    
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="group_name">Group Name(if any)</label>
                        <input type="text" class="form-control" id="group_name" name="group_name" 
                               placeholder="Group Name" value="<?php echo $group_name; ?>">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="btn_save">&nbsp;</label>
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


