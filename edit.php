<?php
  include('config.php');

  $project = $_REQUEST['name'];

  if ($_POST)
  {
    if ($_POST['password'] != $admin_password)
      die ('Invalid admin password, go back... try again');
    
    foreach ($_POST as $field => $data)
    {
      if ($field == 'password') continue;
      $metadata[$field] = $data;
    }
    
    $fp = fopen("metadata/$project.txt", 'w+');
    fwrite($fp, serialize($metadata));
    fclose($fp);
    
    header("Location: project.php?name=$project");
  }

  if (file_exists("metadata/$project.txt"))
    $metadata = unserialize(file_get_contents("metadata/$project.txt"));
    
    
?>
<html>
<head>
  <title><?= $project ?></title>
  <link rel="stylesheet" href="common.css" type="text/css">
</head>
<body>
<form method="post">
  <table class="main-table" width="100%">
    <tr> 
      <td colspan=2 align=center>
        <img src="images/project-64.png">
        <font style="font-size:x-large; font-family:courier">
          Editing metadata for <?= $project ?>
        </font>
    <tr valign=top>
      <td align=right>
        <table width="100%">
          <tr>
            <td class="Section">Project info:
          <tr><td class="content-right">
            <table>
            
<?php
      foreach ($metadata_fields as $field)
      {
        echo "<tr><td>";
        echo $field[0].": ";
        echo "<td><input type=\"text\" name=\"".$field[0]."\" value=\"".$metadata[$field[0]]."\">";
      }
?>
              <tr><Td>&nbsp;
              <tr>
                <td>
                  Admin Password:
                <td>
                  <input name="password" type="password">
              <tr>
                <td><td><input type="submit" value="Save Changes">
            <table>
        </table>
  </table>
</form>
</body>
</html>
