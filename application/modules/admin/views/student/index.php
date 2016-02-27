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
            Student <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                 <a href="<?php echo BASE_MODULE_URL; ?>student/create" class="btn btn-success btn-xs">Create Student</a>
            </li>
        </ol>
    </div>
</div>
<!-- Page Heading ENDS -->

<!-- Content Begin -->

    <div class="row">
        <div class="col-lg-12">
            <table id="student_grid" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Admission No</th>
                        <th>Admission Date</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Is Active</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>    
        </div>
    </div>

<!-- Content End -->

    
    
<script type="text/javascript">
    $(document).ready(function() {

        var dataTable = $('#student_grid').DataTable( {
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "pageLength": 5,
            "lengthChange": false,
            "aoColumnDefs": [
                { 'bSortable': false, 'aTargets': [ 1,2 ] }
            ],
            "ajax":{
                url :"<?php echo BASE_MODULE_URL; ?>student/load_students", 
                type: "post",  
                error: function(){  
                    $(".student_grid-error").html("");
                    $("#student_grid").append('<tbody class="student_grid-error">\n\
                                                <tr><th colspan="3">No data found in the server</th></tr></tbody>');
                    $("#student_grid_processing").css("display","none");
                },
            }
        });
        
        
    });
</script>