<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<!-- Page Heading BEGINS -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Courses <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                 <a href="<?php echo BASE_MODULE_URL; ?>academic_course/create" class="btn btn-success btn-xs">Create Academic Course</a>
            </li>
        </ol>
    </div>
</div>
<!-- Page Heading ENDS -->

<!-- Content Begin -->

    <div class="row">
        <div class="col-lg-12">
            <table id="academic_course_grid" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Start Month</th>
                        <th>End Month</th>
                        <th>Subjects</th>
                        <th>Group Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>    
        </div>
    </div>




<!-- Content End -->
<!-- Subject Mapping POPUP -->
<div class="modal fade" tabindex="-1" role="dialog" id="subjectModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Map Subjects to Course '<span id="course_name" ></span>'</h4>
            </div>
            <div class="modal-body">
                <table id="academic_subject_grid" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th></th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($subjects) >0 ) :
                                foreach($subjects as $subject) : 
                        ?>
                            <tr>
                                <td><?php echo $subject->subject_name; ?></td>
                                <td><input type="checkbox" class="form-control" id="chk_<?php echo $subject->academic_subject_id;?>"/></td>
                            </tr>
                        <?php endforeach; 
                            endif;
                        ?>    
                    </tbody>
                </table>    
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="btn_save" name="btn_save">Save</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
    
    
<script type="text/javascript">
    $(document).ready(function() {
        var course_id = 0;
        var dataTable = $('#academic_course_grid').DataTable( {
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "pageLength": 5,
            "lengthChange": false,
            "aoColumnDefs": [
                { 'bSortable': false, 'aTargets': [ 1,2 ] }
            ],
            "ajax":{
                url :"<?php echo BASE_MODULE_URL; ?>academic_course/load_academic_courses", 
                type: "post",  
                error: function(){  
                    $(".academic_course_grid-error").html("");
                    $("#academic_course_grid").append('<tbody class="academic_course_grid-error">\n\
                                                <tr><th colspan="3">No data found in the server</th></tr></tbody>');
                    $("#academic_course_grid_processing").css("display","none");
                },
            }
        });
        
        var dataTableCourse = $('#academic_subject_grid').DataTable( {
            "responsive": true,
            "processing": false,
            "serverSide": false,
            "pageLength": 100,
            "lengthChange": false,
            "paging":   false,
            "ordering": false,
            "info":     false,
            "searching": false
        });
        
        $('body').on('click', 'a[id*="academic_course_id_"]', function() {
            $('#subjectModal').modal('show');
            $('input[id*="chk_"]').prop('checked',false);
            $('#course_name').html($('#'+this.id).attr('class'));
            course_id = this.id.replace('academic_course_id_','');
            $.ajax({
               url: '<?php echo BASE_MODULE_URL; ?>academic_course/load_course_subjects',
               type: 'POST',
               data: 'academic_course_id='+course_id,
               'async':true,
                success: function(data) {
                    var response_json = jQuery.parseJSON(data);
                    $.each(response_json, function(index, value){
                        $('#chk_'+value.academic_subject_id).prop('checked',true);
                    });
                    
                },
                error: function(e) {
                }
            });
        });
        
        $('#btn_save').click(function() {
            var subject_ids = '';
            $("input:checked").each(function() {
                subject_ids += this.id.replace('chk_','_');
            });
            $.ajax({
               url: '<?php echo BASE_MODULE_URL; ?>academic_course/save_course_subjects',
               type: 'POST',
               data: 'academic_course_id='+course_id+'&subject_ids='+subject_ids,
               'async':true,
                success: function(data) {
                    $('#subjectModal').modal('hide');
                    $('#academic_course_grid').DataTable().ajax.reload();
                    $('.top-right').notify({
                            message: { text: 'Subjects added successfully' }
                        }).show();    
                },
                error: function(e) {
                }
            });
            
        });
        
    });
</script>