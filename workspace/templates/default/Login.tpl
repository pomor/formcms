<div id="anm_form">
<span style="color: #FF0000">{$error}</span>
{if !$actUser->isLogin()}
{literal}
<form onsubmit="fg_AjaxLoad('#anm_form','/login',$(this).serialize()); return false;">
{/literal}

Login:<br />
<input type="text" name="login" tabindex="101" class="logform"><br /><br />
Password:<br />
<input type="password" name="pass" tabindex="102" class="logform"><br /><br />
<input type="submit" value="Login"  tabindex="103" class="logbutton">

</form>
{else}
{menu id=5 template='cd_top_menu' path='menustyles/'}
{/if}
</div>