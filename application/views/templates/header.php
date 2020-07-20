<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- <link rel="shortcut icon" type="image/png" href="<?php echo base_url();?>assets/img/beltraide-logo.png"> -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
   
    <!-- <link rel="stylesheet" href="<?php //echo base_url()?>assets/input-masking-master/css/masking-input.css"/> -->

    <!-- Custom fonts for this template-->
    <!-- <link href="<?php //echo base_url()?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css"> -->
    
    <!-- <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet"> -->

    <!-- Custom styles for this template-->
    <link href="<?php echo base_url()?>assets/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom css for the system-->
    <!-- <link href="<?php echo base_url()?>assets/css/styles.css" rel="stylesheet"> -->
 
    <!-- Custom styles for data tables -->
    <link href="<?php echo base_url()?>assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

     <!--input file management css files  -->
    <link href="<?php echo base_url(); ?>assets/vendor/bootstrap-fileinput-master/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
    <!-- if using RTL (Right-To-Left) orientation, load the RTL CSS file after fileinput.css by uncommenting below -->
    <!-- link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.9/css/fileinput-rtl.min.css" media="all" rel="stylesheet" type="text/css" /-->
    <!-- the font awesome icon library if using with `fas` theme (or Bootstrap 4.x). Note that default icons used in the plugin are glyphicons that are bundled only with Bootstrap 3.x. -->
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous"> -->
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous"> -->
    <!-- Custom fonts for this template-->
    <link href="<?php echo base_url()?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">


    <!-- link is for the column visibility in the report section  -->
    <link href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.bootstrap4.min.css" rel="stylesheet">
    
    <!-- JQuery plugins CSS file for autocomplete feature -->
    <link href="<?php echo base_url()?>assets/css/jquery-ui.css" rel="stylesheet">
  
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    
    <!-- include summernote css -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.css" rel="stylesheet">

    <!-- Styles for fullcalendar -->
    <link href='<?php echo base_url()?>assets/vendor/fullcalendar/core/main.css' rel='stylesheet' />
    <link href='<?php echo base_url()?>assets/vendor/fullcalendar/list/main.css' rel='stylesheet' />
    <link href='<?php echo base_url()?>assets/vendor/fullcalendar/daygrid/main.css' rel='stylesheet' />
    <link href='<?php echo base_url()?>assets/vendor/fullcalendar/timegrid/main.css' rel='stylesheet' />
    <link href='<?php echo base_url()?>assets/vendor/fullcalendar/bootstrap/main.css' rel='stylesheet' />
    
    <!-- scripts are loaded below because some jquery are used within some of the pageContents triggers error if not declared here -->
    <script src="<?php echo base_url()?>assets/vendor/jquery/jquery.min.js"></script>
    
    <!-- script for file input -->
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script> -->
    <!-- piexif.min.js is needed for auto orienting image files OR when restoring exif data in resized images and when you
        wish to resize images before upload. This must be loaded before fileinput.min.js -->
    <script src="<?php echo base_url();?>assets/vendor/bootstrap-fileinput-master/js/plugins/piexif.min.js" type="text/javascript"></script>
    <!-- sortable.min.js is only needed if you wish to sort / rearrange files in initial preview. 
        This must be loaded before fileinput.min.js -->
    <script src="<?php echo base_url();?>assets/vendor/bootstrap-fileinput-master/js/plugins/sortable.min.js" type="text/javascript"></script>
    <!-- purify.min.js is only needed if you wish to purify HTML content in your preview for 
        HTML files. This must be loaded before fileinput.min.js -->
    <script src="<?php echo base_url();?>assets/vendor/bootstrap-fileinput-master/js/plugins/purify.min.js" type="text/javascript"></script>
    <!-- popper.min.js below is needed if you use bootstrap 4.x (for popover and tooltips). You can also use the bootstrap js 
      3.3.x versions without popper.min.js. -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

    <script src="<?php echo base_url()?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    
    <!-- Data Tables custom scripts -->
    <script src="<?php echo base_url()?>assets/js/demo/datatables-demo.js"></script>
    
    <!-- my custom jquery is loaded here because some php files require this custom script to run its
    javascript especially function definitions-->
    <script src="<?php echo base_url()?>assets/js/demo/customJS.js"></script>
    
  <title><?php echo $title; ?></title>
</head>
<body id="page-top" 

>
  <!-- Page Wrapper -->
  <div id="wrapper">