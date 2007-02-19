<?php
  include('config.php');
  
  function HTMLinput($name, &$var)
  {
    if ($_POST[$name])
      $var = $_POST[$name];
    echo "<input type=\"text\" name=\"$name\" value=\"".$var."\">\n";
  }
?>
<html>
<head>
  <title>Welcome to <?= $site_name ?></title>
  <link rel="stylesheet" href="common.css" type="text/css">
</head>
<body>
  <form method="POST">
<!--
  Welcome to <?= $site_name ?>!
  This site is maintained by: <?= $admin_email ?>
  This site is powered by Source Speak version <?= $version ?>,
  available at: http://sourcespeak.sourceforge.net
-->
  <table class="main-table" width="100%">
    <tr> 
      <td colspan=2 align=center>
        <img src="images/logo.png">
        <font style="font-size:xx-large;font-family:courier"><?= $site_name ?></font>
    <tr valign=top>
      <td width="66%" rowspan=2>
        <table width="100%">
          <tr>
            <td class="Section">
              Projects:
<?php
  # List each project

  $dir_handle = opendir('projects');
  while ($project = readdir($dir_handle))
  {
    if ($project[0]=='.') continue;
    $project_safe = preg_replace('/[^a-zA-Z]/','',$project);
    if (!$project_safe) continue;
    $project_count++;

    echo '<tr><td class="content-left">';
    echo "<a class=\"content-left\" href=\"project.php&#63;name=$project\">";
    echo '<img src="images/project.png" align=center> ';
    echo $project;
    echo '</a>';

    if ($admin)
    {
      if (file_exists("metadata/$project.txt"))
        $metadata = unserialize(file_get_contents("metadata/$project.txt"));
      else
        $metadata = array();
      
      echo '<p>';
      echo "Author: ";
      HTMLinput("$project_safe-author", $metadata['author']);
      echo "<br>Version: ";
      HTMLinput("$project_safe-version", $metadata['version']);
      echo '</p>';
      
      $fp = fopen("metadata/$project.txt", 'w+');
      fwrite($fp, serialize($metadata));
      fclose($fp);
    
    }
    else if (file_exists("metadata/$project.txt"))
    {
      $metadata = unserialize(implode('',file("metadata/$project.txt")));
      echo "<table>";
      foreach ($metadata_fields as $field)
      {
        if (!$field[2]) continue;
        echo "<tr><td>".$field[0].":<td>".$metadata[$field[0]];
      }
      echo "</table>";
    }
    else
    {
      echo "<p style='color:grey'><i>(no metadata)</i></p>";
    }
  }
  
  if ($admin) echo "<tr><td><input type=\"submit\" value=\"Save Changes\">";
  
  closedir($dir_handle);
?>
        </table>
      <td align=right>
        <table width="100%">
          <tr>
            <td align=right class="Section">Site:
          <tr>
            <td class="content-right" align=right>
              <img src="images/project.png" align=center>
              Hosted projects: <?= $project_count ?>
          <tr>
            <td class="content-right" align=right>
              <a href="about.php">
              <img src="images/link.png" align=center>
              About
              </a>
        </table>
  </table>
</body>
</html>
