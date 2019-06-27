<?php
include 'authenticate.php';
?>
<!DOCTYPE html>
<html lang="en">
	
<head> 
<title>Login</title>
<meta charset="utf-8">
<style type="text/css" media="screen">
html {
	background-image: url("code.jpg");
	background-repeat: no-repeat;
	background-attachment: fixed;
	background-position: center;
	background-size: cover;
	background-color: black;
}
	
body {
	font-family: sans-serif;
	background-color: black;
	width: 700px;
	height: 650px;
	border: 1px solid black;
	box-shadow: 5px 5px 0 0;
	margin-top: 25px;
	margin-left: auto;
	margin-right: auto;
	opacity: 0.8;
	}

.content {
	width:500px;
	margin-left: 100px;
	text-align: center;
	color: white;
	text-align: center;
	}
	

input {
	font-family: sans-serif;
	font-weight: bold;
	text-align: center;
	}

#textbox {
	margin-left: 50px;
	}
	
button {
	border-radius: 3px;
	border: 1px solid black;
	background-color: white;
	}
	
input[type=submit] {
	border-radius: 3px;
	border: 1px solid black;
	background-color: white;
	}
	
label {
	color: white;
	}

#buttons {
	margin-top: 20px;
	width: 700px;
	text-align: center;
}
</style>
</head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/core.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/sha1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script>


<script>
function submit() {
	document.getElementById('button').innerHTML = "<input style='font-size:16pt;height:30px;width:150px;font-weight:bold;' type='Submit' value='Send' onkeypress='return event.keyCode != 13;'></input>";
}

function get_pass() {
	var pass_key = document.getElementById('key').value.trim();
	return pass_key;

}

function en() {
	if (document.input.text.value.trim() == "") {
		document.getElementById('span').innerHTML = "Error";
		return; }
	if (document.getElementById('key').value.trim() == "") {
		document.getElementById('span').innerHTML = "Error";
		return; }
	document.getElementById('span').innerHTML = "Ok";
	var text = document.input.text.value.trim();
	var pass = get_pass();
	var t_len = text.length;
	var p_len = pass.length;
	//document.getElementById('pl_size').innerHTML = text.length;
	//document.getElementById('p_size').innerHTML = pass.length;
	if (document.getElementById('otp').checked) {
		var ascii_pass = [];
		var ascii_text = [];
		var array = [];
		while (pass.length < text.length) {
			pass += pass; }
		var count = 0;
		while (pass.length > count) {
			ascii_pass.push(pass[count].charCodeAt(0));
			count ++;
		}
		count = 0;
		while (text.length > count) {
			ascii_text.push(text[count].charCodeAt(0));
			count ++;
		}
		count = 0;
		var num;
		while (text.length > count){
			num = ascii_text[count] ^ ascii_pass[count];
			array.push(num);
			count ++;
		}
		document.input.text.value = btoa(unescape(encodeURIComponent(array.join("|"))));
	}
	if (document.getElementById('aes').checked) {
		var encrypted = CryptoJS.AES.encrypt(text, pass);
		document.input.text.value = encrypted;
	}
	if (p_len >= t_len) {
		document.getElementById('span').innerHTML = "Message should be unbreakable if key is only used once."; }
	submit();

}

function clear_all() {
	document.input.text.value = "";
	document.getElementById('span').innerHTML = "Ok";
	document.getElementById('button').innerHTML = "<button style='font-size:16pt;height:30px;width:150px;font-weight:bold;' type='button' onclick='en()'>Encrypt</button>";

}

</script>
<main>
<body>
<form action="handle_message.php" method="post" name="input"><br>
<div class='content'>
<label>Encryption Type:</label>
<input type="radio" name="type" id="aes" value="aes" onkeypress="return event.keyCode != 13;" checked>AES
<input type="radio" name="type" id="otp" value="otp" onkeypress="return event.keyCode != 13;">One Time Pad
<br>
<label>Status:&nbsp;</label><span id="span">Go</span><br>
<br>
<label>Message:</label><br>
</div>
<div id="textbox">
<textarea name="text" style="width:600px;height:300px;font-weight:bold;font-size:14pt;"></textarea>
</div>
<br>
<div class="content">
<label>Key:</label><br>
<input name="pass" id="key" type="text" autocomplete="off" style="font-size:16pt;height:25px;width:350px;" onkeypress="return event.keyCode != 13;"><br><br>
<span id='button'><button style="font-size:16pt;height:30px;width:150px;font-weight:bold;" type="button" onclick="en()">Encrypt</button></span>
<button style="font-size:16pt;height:30px;width:150px;font-weight:bold;" type="button" onclick="clear_all()">Clear</button>
</div>
</form>	
<div id='buttons'><br>
<form action="home.php">
    <input type="submit" value="Home" style="font-size:20pt;height:35px;width:250px;"/>
</form>
</div>
</body>
</main>
</html>