/* 
 * Developer : Saravanan.S 
 * Date : 26 JAN 2016
 * Description : generic functionalities
 */

/*
 *  gloabal - delete confirmation popup
 */

$(document).ready(function() {
    
    // Anchar tag must contains the attribute data-bb="confirm" and class to open up the confirmation popup.
    // In class attribute attach the item title of the deleting row.
    $('body').on('click','a[data-bb="confirm"]',function(e) {

        e.preventDefault();
        var href = $(this).attr('href');
        bootbox.confirm("Are you sure want to delete "+$(this).attr('class')+"?" , function(result) {
            if(result)
            {
                window.location.href = href;
            }
        }); 
        
    });
    
});

