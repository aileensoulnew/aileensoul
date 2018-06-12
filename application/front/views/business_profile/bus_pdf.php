<html>
    <head>
        <title><?php echo $title; ?></title>
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">   
    <?php $this->load->view('adsense'); ?>
</head>
<style>
    body{margin: 0;}
    </style>
    
<embed src="<?php echo BUS_POST_MAIN_UPLOAD_URL.$bus_data[0]['file_name']; ?>" width="100%" height="100%" style="scroll:">
</html>