<style>
    #dd_body {
       background: url('/includes/images/content-bg.png') top left repeat-y;
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
    <img id='dd_body_bear' src='/includes/images/bear.png' />
    <div id='dd_body_col_left'>
        <?php echo($this->template['BodyColumnLeft']); ?>
    </div>
    <div id='dd_body_col_right'>
        <?php echo($this->template['LoginStatus']); ?>
    </div>
</div>