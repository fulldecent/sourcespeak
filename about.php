<?php
  include('config.php');
?>
<html>
<head>
  <title>Help</title>
  <link rel="stylesheet" href="common.css" type="text/css">
</head>
<body>
  <table class="main-table" width="100%">
    <tr> 
      <td colspan=2 align=center>
        <img src="images/logo.png">
        <font style="font-size:x-large;font-family:courier">Help</font>
    <tr valign=top>
      <td width="66%" rowspan=2>
        <table width="100%">
          <tr>
            <td class="Section">
              About:
          <tr>
            <td class="content-left">
              <p>
                This site was developed using Source Speak, a simple PHP website that dynamically
                highlights source using the vim engine. You can throw your own stylesheets on 
                top of the code to make it look however you want.
              </p>
          <tr><td>
          <tr>
            <td class="Section">
              Faq:
          <tr>
            <td class="content-left">
              <p><i><b>Can I get my project posted?</b></i></p>
              <p>You can e-mail the webmaster and request your project to be posted.
              </p>
              <p><i><b>I want to set up a site just like this...</b></i></p>
              <p>Check out the Project Page and download Source Speak.</p>
        </table>

      <td align=right>
        <table width="100%">
          <tr>
            <td align=right class="Section">Links
          <tr>
            <td class="content-right" align=right>
              <a href="index.php"><img src="images/link.png"> Home</a><br>
              <a href="http://sourcespeak.sourceforge.net/"><img src="images/link.png"> Project Page</a><br>
              <a href="mailto:<?= $admin_email ?>"><img src="images/link.png"> E-mail Webmaster</a><br>
        </table>

  </table>
</body>
</html>
