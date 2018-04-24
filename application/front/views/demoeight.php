<!DOCTYPE html>
<html>
<head>
    <title>Demo 8</title>
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="<?php echo base_url('8/ninja-slider.css'); ?>" rel="stylesheet" type="text/css" />
    <script src="<?php echo base_url('8/ninja-slider.js');?>" type="text/javascript"></script>
    <script>
        function lightbox(idx) {
            //show the slider's wrapper: this is required when the transitionType has been set to "slide" in the ninja-slider.js
            var ninjaSldr = document.getElementById("ninja-slider");
            ninjaSldr.parentNode.style.display = "block";

            nslider.init(idx);

            var fsBtn = document.getElementById("fsBtn");
            fsBtn.click();
        }

        function fsIconClick(isFullscreen, ninjaSldr) { //fsIconClick is the default event handler of the fullscreen button
            if (isFullscreen) {
                ninjaSldr.parentNode.style.display = "none";
            }
        }
    </script>
    <style>
        body {font: normal 0.9em Arial;margin:0;background:#f5f5f5;}
        a {color:#1155CC;}
        ul li {padding: 10px 0;}
        header {display:block;padding:60px 0 10px;background-color:#191919;text-align:center;}
        header a {
            font-family: sans-serif;
            font-size: 24px;
            line-height: 24px;
            padding: 8px 13px 7px;
            color: #4d5256;
            text-decoration:none;
            transition: color 0.7s;
        }
        header a.active {
            font-weight:bold;
            width: 24px;
            height: 24px;
            padding: 4px;
            text-align: center;
            display:inline-block;
            border-radius: 50%;
            background: #4d5256;
            color: #191919;
        }
        .gallery img{
            width:179px;
            cursor:pointer;
        }
    </style>
</head>
<body>
    <header>
        <a href="demo1.html">1</a>
        <a href="demo2.html">2</a>
        <a href="demo3.html">3</a>
        <a href="demo4.html">4</a>
        <a href="demo5.html">5</a>
        <a href="demo6.html">6</a>
        <a href="demo7.html">7</a>
        <a href="demo8.html" class="active">8</a>
        <a href="demo9.html">9</a>
        <a href="demo10.html">10</a>
    </header>
    <!--start-->
    <div style="display:none;">
        <div id="ninja-slider">
            <div class="slider-inner">
                <ul>
                    <li>
                        <a class="ns-img" href="<?php echo base_url() . 'assets/image8/abc.jpg'; ?>"></a>
                        <div class="caption">
                            <h3>Dummy Caption 1</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus accumsan purus.</p>
                        </div>
                    </li>
                    <li>
                        <a class="ns-img" href="<?php echo base_url() . 'assets/image8/a.jpg'; ?>"></a>
                        <div class="caption">
                            <h3>Dummy Caption 2</h3>
                            <p>Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet</p>
                        </div>
                    </li>
                    <li>
                        <span class="ns-img" style="background-image:url(<?php echo base_url() . 'assets/image8/b.jpg' ?>);"></span>
                        <div class="caption">
                            <h3>Dummy Caption 3</h3>
                            <p>Duis fringilla arcu convallis urna commodo, et tempus velit posuere.</p>
                        </div>
                    </li>
                    <li>
                        <a class="ns-img" href="<?php echo base_url() . 'assets/image8/c.jpg'; ?>"></a>
                        <div class="caption">
                            <h3>Dummy Caption 4</h3>
                            <p>Quisque semper dolor sed neque consequat scelerisque at sed ex. Nam gravida massa.</p>
                        </div>
                    </li>
                    <li>
                        <a class="ns-img" href="<?php echo base_url() . 'assets/image8/d.jpg'; ?>"></a>
                        <div class="caption">
                            <h3>Dummy Caption 5</h3>
                            <p>Proin non dui at metus suscipit bibendum.</p>
                        </div>
                    </li>
                </ul>
                <div id="fsBtn" class="fs-icon" title="Expand/Close"></div>
            </div>
        </div>
    </div>
    <div style="max-width:700px;margin:90px auto;">
        <h2>DEMO: Click Gallery Images to Popup Lightbox</h2>
        <br /><br />
        <div class="gallery">
            <img src="<?php echo base_url() . 'assets/image8/abc.jpg';?>" onclick="lightbox(0)" style="width:auto; height:140px;" />
            <img src="<?php echo base_url() . 'assets/image8/a_s.jpg';?>" onclick="lightbox(1)" style="width:auto; height:140px;" /><br />
            <img src="<?php echo base_url() . 'assets/image8/b_s.jpg';?>" onclick="lightbox(2)" />
            <img src="<?php echo base_url() . 'assets/image8/c_s.jpg';?>" onclick="lightbox(3)" />
            <img src="<?php echo base_url() . 'assets/image8/d_s.jpg';?>" onclick="lightbox(4)" />
        </div>
    </div>
    <!--end-->
    <div style="max-width:700px;margin:0 auto;">
        <p>Ninja Slider can be used as a lightbox, the image slideshow in a modal popup window.</p>
        <p>The lightbox will take advantage of all the Ninja Slider's rich features: responsive, touch device friendly, video support, etc.</p>
        <p>
            For detailed instructions please visit <a href="http://www.menucool.com/slider/show-image-gallery-on-modal-popup">show image gallery on modal popup</a>.
        </p>
    </div>
</body>
</html>
