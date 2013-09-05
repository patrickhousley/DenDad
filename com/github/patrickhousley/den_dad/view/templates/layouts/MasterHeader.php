<link href='/includes/css/sprites.css' type='text/css' rel='stylesheet' />
<style>
    #dd_header {
       background: url('/includes/images/page-top-bg.png') top left no-repeat;
       height: 233px;
    }
    #dd_trailPatches {
        float: left;
        z-index: 3;
        width: 315px;
    }
    #dd_header_logo {
        float: left;
        height: 75px;
        position: relative;
        top: 10px;
        left: -200px;
        z-index: 3;
    }
    #dd_header_slide {
        float: left;
        position: relative;
        top: 0px;
        left: -150px;
        z-index: 2;
    }
    #dd_header_pack_numbers {
        <?php
            if (!isset($this->data['packNumber'])) {
                echo('display: none;');
            }
        ?>
        float: left;
        position: relative;
        top: 75px;
        left: -525px;
        z-index: 1;
        height: 5px;
    }
    #dd_header_pack_label {
        position: relative;
    }
    #dd_header_pack_n1 {
        position: relative;
        top: -85px;
        left: 120px;
    }
    #dd_header_pack_n2 {
        <?php
            if (!isset($this->data['packNumberArray'][1])) {
                echo('display: none;');
            }
        ?>
        position: relative;
        top: -165px;
        left: 171px;
    }
    #dd_header_pack_n3 {
        <?php
            if (!isset($this->data['packNumberArray'][2])) {
                echo('display: none;');
            }
        ?>
        position: relative;
        top: -245px;
        left: 222px;
    }
    #dd_header_pack_n4 {
        <?php
            if (!isset($this->data['packNumberArray'][3])) {
                echo('display: none;');
            }
        ?>
        position: relative;
        top: -325px;
        left: 273px;
    }
    #dd_header_nav {
        float: left;
        position: relative;
        top: 54px;
        width: 625px;
    }
    #dd_header_nav a div {
        float: left;
    }
</style>
<div id='dd_header'>
    <div id='dd_trailPatches'>
        <?php echo($this->template['TrailPatches']); ?>
    </div>
    <img id='dd_header_logo' src='/includes/images/logo.png' />
    <img id='dd_header_slide' src='/includes/images/neckerchief_slide.png' />
    <div id='dd_header_pack_numbers'>
        <img id='dd_header_pack_label' class='pack_number_label' src='/includes/images/transparent.png' />
        <div id='dd_header_pack_n1' class='pack_number_bg'>
            <img class='
                 <?php
                    if (isset($this->data['packNumberArray'][0])) {
                        echo('pack_number_' . $this->data['packNumberArray'][0]);
                    }
                 ?>
                 ' src='/includes/images/transparent.png' />
        </div>
        <div id='dd_header_pack_n2' class='pack_number_bg'>
            <img class='<?php
                    if (isset($this->data['packNumberArray'][1])) {
                        echo('pack_number_' . $this->data['packNumberArray'][1]);
                    }
                 ?>
                 ' src='/includes/images/transparent.png' />
        </div>
        <div id='dd_header_pack_n3' class='pack_number_bg'>
            <img class='<?php
                    if (isset($this->data['packNumberArray'][2])) {
                        echo('pack_number_' . $this->data['packNumberArray'][2]);
                    }
                 ?>
                 ' src='/includes/images/transparent.png' />
        </div>
        <div id='dd_header_pack_n4' class='pack_number_bg'>
            <img class='
                 <?php
                    if (isset($this->data['packNumberArray'][3])) {
                        echo('pack_number_' . $this->data['packNumberArray'][3]);
                    }
                 ?>
                 ' src='/includes/images/transparent.png' />
        </div>
    </div>
    <div id='dd_header_nav'>
        <a href='/Index'><div class='menu_home'></div></a>
        <?php if ($this->data['userRole'] != $GLOBALS['DENDAD_CONFIG']['APP_ROLE_ANONYMOUS']): ?>
            <a href='/Index'><div class='menu_manage_den'></div></a>
            <a href='/Index'><div class='menu_events'></div></a>
            <a href='/Index'><div class='menu_discussions'></div></a>
            <a href='/Index'><div class='menu_gallery'></div></a>
       <?php endif; ?>
            <a href='/Index'><div class='menu_support'></div></a>
    </div>
    <div style='clear:both;'></div>
</div>