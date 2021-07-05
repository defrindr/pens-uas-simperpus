<p>

Hello <?=$this->user->get('name')?>
</p>
<?php if($this->user->get('name')!=null){?>
    <table class="table table-responsive table-borderless">
        <tr>
            <td>
                Last Login
            </td>
            <td>
                <?=$this->user->get('last_login')?>
            </td>
        </tr>
    </table>
<?php }else{ ?>

    <a href="https://accounts.google.com/o/oauth2/v2/auth?client_id=793113128601-f5d7ro24m6ktd2sbdue1t44b834f8o27.apps.googleusercontent.com&redirect_uri=https://perpus.azisek.dev/authorize/google&scope=profile email openid&response_type=code&access_type=offline&include_granted_scopes=true">
    Login dengan GOOGLE
</a>
<?php } ?>