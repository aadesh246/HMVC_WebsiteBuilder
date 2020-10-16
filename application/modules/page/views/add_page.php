<?php
if(isset($page)){
   $safitext = preg_replace('/<db>(.+?)<.info>/', '', $page->original);
    $safitext = preg_replace('/<.div><.db>/', '', $safitext);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Add Pages To Your DataBase</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url(); ?>/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php echo base_url(); ?>/assets/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="<?php echo base_url(); ?>/assets/vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="<?php echo base_url(); ?>/assets/vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_url(); ?>assets/dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/jquery.windoze.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/vendor/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/dist/keditor/css/keditor-1.1.4.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/dist/keditor/keditor-components-1.1.4.min.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/libs/fileuploader/jquery.fileuploader.css" type="text/css" />



    <!-- Custom Fonts -->
    <link href="<?php echo base_url(); ?>/assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link href="<?php echo base_url(); ?>assets/css/app.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
    <div class="form-group col-md-8">
        <label>Page Title</label>
        <input type="text" class="form-control" name="title" id="title" value="<?php echo (isset($page))? $page->title : ""; ?>" required>
    </div>
    <div id="content-area"><info>Drag Element here to edit. Add containers first then add components into the containers</info> <?php echo (isset($page))? $safitext : ""; ?></div>

<!-- jQuery -->
<script src="<?php echo base_url(); ?>/assets/vendor/jquery/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="<?php echo base_url(); ?>/assets/vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="<?php echo base_url(); ?>/assets/vendor/metisMenu/metisMenu.min.js"></script>

<!-- DataTables JavaScript -->
<script src="<?php echo base_url(); ?>assets/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/datatables-responsive/dataTables.responsive.js"></script>


<!-- Custom Theme JavaScript -->
<script src="<?php echo base_url(); ?>/assets/dist/js/sb-admin-2.js"></script>

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <!--<script src="plugins/jquery-1.11.3/jquery-1.11.3.min.js"></script>
       <script src="../examples/plugins/bootstrap-3.3.6/js/bootstrap.min.js"></script>-->
    <script type="text/javascript">
        var bsTooltip = $.fn.tooltip;
        var bsButton = $.fn.button;
    </script>
    <?php $GLOBALS['snippets_url'] = base_url();?>
    <script src="<?php echo base_url(); ?>/assets/vendor/jquery-ui-1.11.4/jquery-ui.min.js"></script>
    <script type="text/javascript">
        $.widget.bridge('uibutton', $.ui.button);
        $.widget.bridge('uitooltip', $.ui.tooltip);
        $.fn.tooltip = bsTooltip;
        $.fn.button = bsButton;
        var snippetsurl = "<?php echo base_url()."/assets/snippets/default/snippets.php";?>" ;
    </script>
    <script src="<?php echo base_url(); ?>assets/vendor/jquery.nicescroll-3.6.6/jquery.nicescroll.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/ckeditor-4.5.6/ckeditor.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/ckeditor-4.5.6/adapters/jquery.js"></script>
    <script src="<?php echo base_url(); ?>assets/dist/keditor/js/keditor-1.1.4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/dist/keditor/js/keditor-components-1.1.4.min.js"></script>
    <script type="text/javascript">
        $(function() {
            $('#content-area').keditor();
        });
    </script>

    <div class="col-md-10 text-center" style="background-color:#f8f8f8;  bottom:0; padding:10px;margin-top:400px">
        <div class="form-group">
                <a class="btn btn-primary center-block" style="width: 120px;" <?php echo (isset($page))? "id='edit_page' rel='".$page->id."'" : "id='save_page'" ?>>
                    Save page
                </a>
        </div>
    </div>
    <script type="text/javascript">
            $(document).on('click', '#save_page', function() {
            var page = $('#content-area').html();
            var title = $("#title").val()
            var gurl = '<?php echo base_url()?>';
                $.ajax({
                    type: "POST",
                    url: gurl + 'page/save_page/',
                    data: "page=" + page + "&title=" + title,
                    success: function() {
                    //redirect

                    window.location.href = gurl + 'page';
                    }
                });

            });

            $(document).on('click', '#edit_page', function() {

                var rel = this.rel;
                var page = $('#content-area').html();
                var title = $("#title").val();
                var gurl = '<?php echo base_url()?>';
                $.ajax({
                    type: "POST",
                    url: gurl + 'page/update_page/' + rel,
                    data: "page=" + page + "&title=" + title,
                    success: function() {
                        //redirect

                        window.location.href = gurl + 'page';
                    }
                });

            });
    </script>

</body>

</html>
