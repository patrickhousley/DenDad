<style>
    #dd_loginStatus {
        padding: 5px 5px;
        text-align: center;
        box-shadow: -1px 1px 10px 0px rgba(0,0,0,.5);
        -moz-border-radius: 10px;
        -webkit-border-radius: 10px;
        -khtml-border-radius: 10px;
        border-radius: 10px;
        behavior: url('/includes/css/PIE.htc');
    }
    #dd_loginStatus_Actions {
        text-align: center;
        font: 11px arial,sans-serif;
    }
    #dd_loginStatus_Login {
        text-align: center;
        font: 11px arial, sans-serif;
    }
    #dd_loginStatus_Login input {
        font: 11px arial, sans-serif;
        padding: 0px 5px;
        -moz-border-radius: 10px;
        -webkit-border-radius: 10px;
        -khtml-border-radius: 10px;
        border-radius: 10px;
        behavior: url('/includes/css/PIE.htc');
    }
</style>
<div id='dd_loginStatus'>
    <?php if ($this->data['userRole'] != $GLOBALS['DENDAD_CONFIG']['APP_ROLE_ANONYMOUS']): ?>
        Welcome, <?php echo($this->data['userName']); ?>
        <div id='dd_loginStatus_Actions'>
            <a href='/Account'>Manage Account</a>
            <a href='/Logout'>Logout</a>
        </div>
    <?php else: ?>
        <div id='dd_loginStatus_Login'>
            Welcome, Anonymous.
            <form action='/Login' method='POST'>
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
            </form>
        </div>
    <?php endif; ?>
</div>