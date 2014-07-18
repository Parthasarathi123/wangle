
<!--<![endif]--><head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Admin page</title>
	<link rel="stylesheet" id="buttons-css" href="http://localhost/wordpress/wp-includes/css/buttons.min.css?ver=3.9.1" type="text/css" media="all">
<link rel="stylesheet" id="open-sans-css" href="//fonts.googleapis.com/css?family=Open+Sans%3A300italic%2C400italic%2C600italic%2C300%2C400%2C600&amp;subset=latin%2Clatin-ext&amp;ver=3.9.1" type="text/css" media="all">
<link rel="stylesheet" id="dashicons-css" href="http://localhost/wordpress/wp-includes/css/dashicons.min.css?ver=3.9.1" type="text/css" media="all">
<link rel="stylesheet" id="login-css" href="http://localhost/wordpress/wp-admin/css/login.min.css?ver=3.9.1" type="text/css" media="all">
<meta name="robots" content="noindex,follow">
	</head>
        <body class="login login-action-login wp-core-ui  locale-en-us" >
            <h1 style="margin-top: 30px">Hexwhale</h1>
            <div id="login" style="padding: 4% 0px 0px">
		
	



<?php echo form_open('login/success') ?>
	<p>
		<label for="user_login">Username<br>
		<input name="username" id="user_login" class="input" value="" size="20" type="text"></label>
	</p>
	<p>
		<label for="user_pass">Password<br>
		<input name="password" id="user_pass" class="input" value="" size="20" type="password"></label>
	</p>
		<p class="forgetmenot"><label for="rememberme"><input name="rememberme" id="rememberme" value="forever" type="checkbox"> Remember Me</label></p>
	<p class="submit">
		
                <button type="submit" id="wp-submit" name="submit" class="button button-primary button-large">Sign in</button>
      </form>  
	</p>
</form>



<script type="text/javascript">
function wp_attempt_focus(){
setTimeout( function(){ try{
d = document.getElementById('user_login');
d.focus();
d.select();
} catch(e){}
}, 200);
}

wp_attempt_focus();
if(typeof wpOnload=='function')wpOnload();
</script>

	
	
	</div>

	
		<div class="clear"></div>
	
	
	</body>
</html>
