<style>
    #dd_body {
       background: url('/images/content-bg.png') top left repeat-y;
       min-height: 300px;
       width: 1000px;
    }
    #dd_body_bear {
        float: right;
        position: relative;
        top: 0px;
        left: -80px;
        height: 350px;
    }
    #dd_body_col_left {
        float: left;
        width: 475px;
        padding: 0px 5px 0px 50px;
    }
    #dd_body_col_right {
        float: left;
        width: 195px;
    }
</style>
<div id='dd_body'>
    <img id='dd_body_bear' src='/images/bear.png' />
    <div id='dd_body_col_left'>
        <?php echo($this->_template['BodyColumnLeft']); ?>
    </div>
    <div id='dd_body_col_right'>
        <?php echo($this->_template['LoginStatus']); ?>
    </div>
</div>