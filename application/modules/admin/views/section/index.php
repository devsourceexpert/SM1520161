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
            Section <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                 <a href="<?php echo BASE_MODULE_URL; ?>section/create" class="btn btn-success btn-xs">Create Section</a>
            </li>
        </ol>
    </div>
</div>
<!-- Page Heading ENDS -->

<!-- Content Begin -->

    <div class="row">
        <div class="col-lg-12">
            <table id="section_grid" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Section Name</th>
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

        var dataTable = $('#section_grid').DataTable( {
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "pageLength": 5,
            "lengthChange": false,
            "aoColumnDefs": [
                { 'bSortable': false, 'aTargets': [ 1,2 ] }
            ],
            "ajax":{
                url :"<?php echo BASE_MODULE_URL; ?>section/load_sections", 
                type: "post",  
                error: function(){  
                    $(".section_grid-error").html("");
                    $("#section_grid").append('<tbody class="section_grid-error">\n\
                                                <tr><th colspan="3">No data found in the server</th></tr></tbody>');
                    $("#section_grid_processing").css("display","none");
                },
            }
        });
        
        
    });
</script>