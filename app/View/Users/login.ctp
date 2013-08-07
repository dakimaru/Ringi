<div id="login"; class="users form">
<form action="/Ringi/Users/login" id="UserLoginForm" method="post" accept-charset="utf-8">
    <div style="display:none;">
        <input type="hidden" name="_method" value="POST"/>
    </div>
    <fieldset class="control-group">
        <div class="input text required">
            <label for="UserUsername">Username</label>
            <input name="data[User][username]" maxlength="255" type="text" id="UserUsername" required="required"/></div><div class="input password required">
            <label for="UserPassword">Password</label>
            <input name="data[User][password]" type="password" id="UserPassword" required="required"/>
            </div>
    </fieldset>
    <div class="submit">
        <input  type="submit" value="Login"/>
    </div>
</form>
</div>
