<style>
    #dd_accountForm {
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
    #dd_accountForm table {
        margin: 0px auto;
    }
    #dd_accountForm input {
        font: 11px arial, sans-serif;
        padding: 0px 5px;
        -moz-border-radius: 10px;
        -webkit-border-radius: 10px;
        -khtml-border-radius: 10px;
        border-radius: 10px;
        behavior: url('/css/PIE.htc');
    }
</style>
<div id='dd_accountForm'>
    <form action='/Account/Persist' method='POST'>
        <table>
            <tr>
                <td colspan='2' style='text-align: center;'>
                    DenDad Account Management
                </td>
            </tr>
            <?php if($this->_data['function'] != 'new'): ?>
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
                    <label for='dd_password'>Password:</label>
                </td>
                <td>
                    <input type='password' name='password' id='dd_password' maxlength='255' />
                </td>
            </tr>
            <tr>
                <td>
                    <label for='dd_password_retype'>Re-type<br />Password:</label>
                </td>
                <td>
                    <input type='password' name='passwordRetype' id='dd_password_retype' maxlength='255' />
                </td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <?php endif; ?>
            <tr>
                <td>
                    <label for='dd_firstName'>First Name:</label>
                </td>
                <td>
                    <input type='text' name='firstName' id='dd_firstName' maxlength='255' 
                           value='<?php echo($this->_data['firstName']); ?>' />
                </td>
            </tr>
            <tr>
                <td>
                    <label for='dd_lastName'>Last Name:</label>
                </td>
                <td>
                    <input type='text' name='lastName' id='dd_lastName' maxlength='255' 
                           value='<?php echo($this->_data['lastName']); ?>' />
                </td>
            </tr>
            
            
            <tr>
                <td>
                    <label for='dd_phone'>Phone:</label>
                </td>
                <td>
                    <input type='text' name='phone' id='dd_phone' maxlength='255' 
                           value='<?php echo($this->_data['phone']); ?>' />
                </td>
            </tr>
            <tr>
                <td>
                    <label for='dd_email'>Email:</label>
                </td>
                <td>
                    <input type='text' name='email' id='dd_email' maxlength='255' 
                           value='<?php echo($this->_data['email']); ?>' />
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