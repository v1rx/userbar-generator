<?php
function getFiles($directory, $extensions)
{
    $files = [];

    $dir = opendir('./' . $directory);

    if ($dir !== false)
    {
        while (($file = readdir($dir)) !== false)
        {
            $fileExtension = pathinfo($file, PATHINFO_EXTENSION);

            if(in_array($fileExtension, $extensions))
            {
                $files[] = $file;
            }
        }

        closedir($dir);
    }

    return $files;
}
?>
<!DOCTYPE HTML>
<html lang="en">
  <head>

    <title>Scuffed Userbar Generator</title>

    <meta name="title" content="scuffed userbar generator // v1r.eu">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="./style.css">
    <script src="./script.js" defer></script> 
 </head>
<body>
    <div class="container">
        <div class="banner"><img src="banner.png"></div>
        <div class="header">Background:</div>

        <select name="bg" id="bg">
        <?php
          foreach(getFiles('backgrounds', ['png']) as $background)
          {
            echo sprintf("<option value=\"%s\">%s</option>", $background, $background);
          }
        ?>
        </select>

        <div class="header">Text:</div>
        <input type="text" id="text" name="text" value="v1r.eu">

        <div class="header">Prop:</div>
        <select name="prop" id="prop">
        <?php
          foreach(getFiles('props', ['png']) as $prop)
          {
            echo sprintf("<option value=\"%s\">%s</option>", $prop, $prop);
          }
        ?>
        </select>

        <div class="header">Prop Position X:</div>
        <input type="text" id="x" name="x" value="0">

        <div class="header">Prop Position Y:</div>
        <input type="text" id="y" name="y" value="0">

        <input type="submit" value="Submit" id="submit">

        <div class="result">
          <img src="">
          <input onClick="this.select();" value="" type="text" />
        </div>
    </div>
        <div class="foot"><a href="https://five.sh">five.sh</a><span class="not"> - </span><a href="https://v1r.eu">v1r.eu</a><span class="version"> | version 1.2</span></div>
        <!-- by emmycore. https://five.sh/
              made with pure contempt and hatred. -->
</body>
</html>
