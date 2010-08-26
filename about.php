<?php
  require 'config.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
  <title>Help</title>
  <link rel="stylesheet" href="common.css" type="text/css" />
</head>
<body>
  <h1><img src="images/logo.png" alt="logo" /> Help</h1>
  <div id="leftcolumn">
    <h2>About:</h2>
    <ul>
      <li>
        This site was developed using Source Speak, a simple PHP website that dynamically
        highlights source using the vim engine. You can throw your own stylesheets on 
        top of the code to make it look however you want.
      </li>
      <li>
        <strong>Can I get my project posted?</strong>
        <p>You can e-mail the webmaster and request your project to be posted.</p>
      </li>
      <li>
        <strong>How do I set up a site just like this?</strong>
        <p>Check out the Project Page and download Source Speak.</p>
      </li>
    </ul>
  </div>
  <div id="rightcolumn">
    <h2>Links</h2>
    <ul>
      <li>
        <a href="index.php"><img src="images/logo-small.png" alt="link" /> Home</a>
      </li>
      <li>
        <a href="http://sourcespeak.sourceforge.net/"><img src="images/logo-small.png" alt="link" /> Project Page</a>
      </li>
      <li>
        <a href="mailto:<?= $admin_email ?>"><img src="images/logo-small.png" alt="link" /> Email Webmaster</a>
      </li>
    </ul>
  </div>
</body>
</html>
