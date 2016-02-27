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
            Education Board <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                 <a href="<?php echo BASE_MODULE_URL; ?>education_board/create" class="btn btn-success btn-xs">Create Education Board</a>
            </li>
        </ol>
    </div>
</div>
<!-- Page Heading ENDS -->

<!-- Content Begin -->

    <div class="row">
        <div class="col-lg-12">
            <table id="board_grid" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Education Board</th>
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

        var dataTable = $('#board_grid').DataTable( {
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "pageLength": 5,
            "lengthChange": false,
            "aoColumnDefs": [
                { 'bSortable': false, 'aTargets': [ 1,2 ] }
            ],
            "ajax":{
                url :"<?php echo BASE_MODULE_URL; ?>education_board/load_boards", 
                type: "post",  
                error: function(){  
                    $(".board_grid-error").html("");
                    $("#board_grid").append('<tbody class="board_grid-error">\n\
                                                <tr><th colspan="3">No data found in the server</th></tr></tbody>');
                    $("#board_grid_processing").css("display","none");
                },
            }
        });
        
        
    });
</script>