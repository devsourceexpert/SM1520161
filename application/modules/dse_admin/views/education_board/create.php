<?php
    // pre populate data in post-back and edit secreen.
    $board_id      = (isset($board[0]->board_id) && $board[0]->board_id != '0') ? $board[0]->board_id : (isset($_POST['board_id']) ? $_POST['board_id'] : '0');
    $board_name    = (isset($board[0]->board_name) && $board[0]->board_name != '') ? $board[0]->board_name : (isset($_POST['board_name']) ? $_POST['board_name'] : '');
    $active         = (isset($board[0]->active)) ? $board[0]->active : (isset($_POST['active']) ? $_POST['active'] : '1');
?>

<!-- Page Heading BEGINS -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Education Boards <small><?php echo $title;?></small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <a href="<?php echo BASE_MODULE_URL; ?>education_board/index" class="btn btn-success btn-xs">Education Boards</a>
            </li>
        </ol>
    </div>
</div>
<!-- Page Heading ENDS -->

    
<!-- Content Begin -->
<?php echo form_open(BASE_MODULE_URL.'education_board/'.$action); ?>
    <input type="hidden" id="board_id" name="board_id" value="<?php echo $board_id; ?>">
    <div class="panel panel-primary">

        <div class="panel-heading">
            <h3 class="panel-title"><?php echo $title;?> Education Board</h3>
        </div>

        <div class="panel-body">
            <div class="row">

            <div class="col-lg-6">
                <div class="form-group">
                    <label for="board_name">Board Name</label>
                    <input type="text" class="form-control" id="board_name" name="board_name" 
                           placeholder="board Name" value="<?php echo $board_name; ?>">
                    <?php echo form_error('board_name'); ?>
                </div>
            </div>

            <div class="col-lg-4" >
                <div class="form-group <?php if($action == 'create') echo 'hidden_coumn'; ?>">
                    <label for="board_name">Active</label>
                    <select class="form-control" id="active" name="active" >
                        <option value="1" <?php if($active == '1') echo "selected='selected'" ?> >Yes</option>
                        <option value="0" <?php if($active == '0') echo "selected='selected'" ?> >No</option>
                    </select>
                    
                </div>
            </div>

            <div class="col-lg-2">
                <div class="form-group">
                    <label for="board_name">&nbsp;</label>
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


