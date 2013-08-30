<style>
    #dd_errorMessage {
        padding: 5px 5px;
        text-align: center;
        box-shadow: -1px 1px 10px 0px rgba(0,0,0,.5);
        -moz-border-radius: 10px;
        -webkit-border-radius: 10px;
        -khtml-border-radius: 10px;
        border-radius: 10px;
        behavior: url('/css/PIE.htc');
    }
    #dd_errorMessage_note {
        font: 10px arial,sans-serif;
        color: red;
    }
</style>
<div id='dd_errorMessage'>
    <?php echo($this->get('errorMessage')); ?>
    <div id='dd_errorMessage_note'>
        Please note, all errors are logged and reviewed by administrators.
    </div>
</div>