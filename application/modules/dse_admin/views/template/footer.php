            <!-- Notification Begins -->
            <div class='notifications top-right'></div>
            <?php if(isset($message) ) : ?>
                <script type="text/javascript">
                    $(document).ready(function() {
                        $('.top-right').notify({
                            message: { text: '<?php echo $message; ?>' }
                        }).show();    
                    });
                </script>

            <?php endif; ?>
            <!-- Notification Ends -->    
       
        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
 <footer class="footer">
    <div class="container">
      <p class="text-muted"><a title="Web and Mobile application development" href="http://devsourceexpert.com" target="_blank" style="color:#fff; font-weight:bold;">Devsource Expert @ 2016</a></p>
    </div>
</footer>


</body>

</html>
