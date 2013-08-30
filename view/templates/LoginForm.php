<style>
    #dd_loginForm {
        padding: 5px 5px;
        margin: 0px auto;
        box-shadow: -1px 1px 10px 0px rgba(0,0,0,.5);
        -moz-border-radius: 10px;
        -webkit-border-radius: 10px;
        -khtml-border-radius: 10px;
        border-radius: 10px;
        behavior: url('/css/PIE.htc');
        width: 250px;
        
        font: 11px arial, sans-serif;
        text-align: center;
    }
    #dd_loginForm table {
        margin: 0px auto;
    }
    #dd_loginForm input {
        font: 11px arial, sans-serif;
        padding: 0px 5px;
        -moz-border-radius: 10px;
        -webkit-border-radius: 10px;
        -khtml-border-radius: 10px;
        border-radius: 10px;
        behavior: url('/css/PIE.htc');
    }
</style>
<div id='dd_loginForm'>
    <form action='/Login/Auth' method='POST'>
        <table>
            <tr>
                <td colspan='2' style='text-align: center;'>
                    DenDad Login
                </td>
            </tr>
            <tr>
                <td>
                    <label for='dd_login_id'>Login ID:</label>
                </td>
                <td>
                    <input type='text' name='login' id='dd_login_id' maxlength='255' />
                </td>
            </tr>
            <tr>
                <td>
                    <label for='dd_login_pass'>Password:</label>
                </td>
                <td>
                    <input type='password' name='password' id='dd_login_pass' maxlength='255' />
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td>
                    <a href='/Account/Create'><input type='button' value='Create Account' style='width:90px;' /></a>
                </td>
                <td>
                    <input type='submit' value='Login' style='width:90px;' />
                </td>
            </tr>
        </table>
        <span style='color: red;'>
            <?php echo($this->_data['authError']); ?>
        </span>
        <input type='text' name='secKey' id='dd_login_secKey' 
               style='display:hidden;position:absolute;top:-150px'
               value='<?php echo($this->_data['secKey']); ?>' />
    </form>
</div>
<script type='text/javascript'>
    var f = document.getElementById('dd_login_id');
    f.focus();
</script>