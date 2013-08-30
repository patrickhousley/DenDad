<!DOCTYPE HTML PUBLIC '-//W3C//DTD 4.01//EN' 'http://www.w3.org/TR/html4/strict.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
    <head>
        <title>
            Test
        </title>
        <style>
            body {
                background: #FFF url('/images/background.jpg') top left repeat;
            }
            #master_wrapper {
                position: absolute;
                top: 0px;
                left: 0px;
                width: 100%;
            }
            #master_content {
                width: 930px;
                margin: 0px auto;
            }
            #exec_time {
                font: 8px arial, serif;
                color: #FFF;
            }
        </style>
    </head>
    <body>
        <div id='master_wrapper'>
            <div id='master_content'>
                <div id='master_header'>
                    <?php echo($this->_template['MasterHeader']); ?>
                </div>
                <div id='master_body'>
                    <?php echo($this->_template['MasterBody']); ?>
                </div>
                <div id='master_footer'>
                    <?php echo($this->_template['MasterFooter']); ?>
                </div>
            </div>
        </div>
    </body>
</html>