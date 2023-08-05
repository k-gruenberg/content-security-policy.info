<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Content Security Policy (CSP)</title>
		<meta http-equiv="Content-Security-Policy" content="script-src 'nonce-abcd' 'nonce-wxyz' 'sha256-mbUqeqrWHlx2EmgPldmAK0AOTRUtEmMtKOZY9SUKId8=' 'strict-dynamic'; img-src 'self' http://*.google.com;" />
		<!-- Note: ‘frame-ancestors’ (Not supported when delivered via meta element). -->
		<style>
			.footer {
				position: fixed;
				left: 0;
				bottom: 0;
				width: 100%;
				background-color: #eeeeee;
				color: black;
				text-align: center;
			}
		</style>
	</head>
	<body>
		<h1>Content Security Policy (CSP)</h1>

		<p>
			<b>CSP</b> is a <b>mitigation technique</b> <i>preventing unwanted scripts from being executed</i> in case of an <b>XSS</b> vulnerability on a website.<br/>
		</p>

		<p>
			CSP may be defined via a the <tt>Content-Security-Policy</tt> HTTP response header, or alternatively using the HTML <tt>&lt;meta&gt;</tt> tag as done on this site (note that not all features are supported when using the <tt>&lt;meta&gt;</tt> tag).
		</p>

		<p>
			The CSP for this website is:<br/>
			<tt><span id="xmlhttprequest_get_self"></span></tt><br/>
			<script nonce="abcd">
				function xml_http(method, url, output) {
					// from https://de.wikipedia.org/wiki/XMLHttpRequest#Codebeispiele_(JavaScript):
					var xmlHttp = null;
					try {
					    xmlHttp = new XMLHttpRequest();
					} catch(e) {
					    output.innerText = "XMLHttpRequest " + method + " " + url + " failed: &lt;error: " + e + "&gt;";
					}
					if (xmlHttp) {
					    xmlHttp.open(method, url, true);
					    xmlHttp.onreadystatechange = function () {
					        if (xmlHttp.readyState == 4) {
					        	let response = xmlHttp.responseText;
					            output.innerText = response.substr(response.indexOf("\u003Cmeta http-equiv=\"Content-Security-Policy\"")).split("\u003E")[0] + "\u003E";
					        }
					    };
					    xmlHttp.send(null);
					}
				}
				xml_http('GET', 'index.php', xmlhttprequest_get_self);
			</script>
		</p>

		<p>
			Your input will get printed here, unescaped (suppose this was some sort of <b>XSS</b> vulnerability): <?php echo $_POST["xss"]; ?><br/>
			Your input:<br/>
			<form action="index.php" method="POST">
				<textarea id="xss" name="xss" rows="5" cols="125"><?php echo htmlentities($_POST["xss"]); ?></textarea><br/>
				<input type="submit" value="Print!" /> <!-- onclick="..." doesn't work due to CSP ^^ -->
			</form>
		</p>

		<p>
			Here are some things you might wanna try out:<br/>
			<ul>
				<li><span style="color:green">&lt;b&gt;Hello World&lt;/b&gt;</span></li>
				<li><span style="color:red  ">&lt;script&gt;alert("will not work!")&lt;/script&gt;</span></li>
				<li><span style="color:green">&lt;script&gt;alert("works due to correct hash!")&lt;/script&gt;</span></li>
				<li><span style="color:green">&lt;script nonce="abcd"&gt;alert("works!")&lt;/script&gt;</span></li>
				<li><span style="color:green">&lt;script nonce="wxyz"&gt;alert("works too!")&lt;/script&gt;</span></li>
				<li><span style="color:red  ">&lt;script nonce="foo"&gt;alert("will not work!")&lt;/script&gt;</span></li>
				<li><span style="color:red  ">&lt;img src="" onerror="alert('will not work!')"&gt;</span></li>
				<li><span style="color:green">&lt;img src="http://www.google.com/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png" /&gt;</span></li>
				<li><span style="color:green">&lt;img src="https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png" /&gt;</span></li>
				<li><span style="color:red  ">&lt;img src="http://de.wikipedia.org/static/images/project-logos/dewiki-2x.png" /&gt;</span></li>
				<li><span style="color:red  ">&lt;img src="https://de.wikipedia.org/static/images/project-logos/dewiki-2x.png" /&gt;</span></li>
				<li>This works only because <tt>'strict-dynamic'</tt> is set: <span style="color:green">&lt;script nonce="wxyz"&gt;s=document.createElement("script");s.innerText="alert('works!')";document.body.appendChild(s);&lt;/script&gt;</span></li>
			</ul>
		</p>

		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<div class="footer" style="font-family:Arial,Helvetica,sans-serif;">
  			<p>© 2023 Kendrick Grünberg | <a href="https://github.com/k-gruenberg/content-security-policy.info">View source code</a> | <a href="" id="contact_link">Contact</a> | See also: <a href="http://same-origin-policy.info">same-origin-policy.info</a> ; <a href="http://set-cookie.info/">set-cookie.info</a></p>
		</div>
		<script nonce="abcd">
			contact_link.href = atob('bWFpbHRvOmNvbnRhY3RAY29udGVudC1zZWN1cml0eS1wb2xpY3kuaW5mbw==');
		</script>
	</body>
</html>
