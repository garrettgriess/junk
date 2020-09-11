<!DOCTYPE html> 
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Temp Files</title>
  <style>
    body {
      background-color: #333333;
      color: #999999;
      font-family: sans-serif;
      font-size: 18px;
    }
    main {
      width: 100%;
      max-width: 800px;
      margin: 0 auto;
      overflow-x: hidden;
    }
    article {
      padding: 5vh 1vw;
    }
    h1 {
      border-bottom: 2px solid #444444;
    }
    a {
      color: #ACE7F8;
    }
    a:visited,
    a:hover {
      color: #82D1F1;
    }
  </style>
</head>
<body>
  <main>
    <article>
      <h1>Temp Files</h1>
      <?
        $dir = '/home3/garrettg/public_html/tmp/';
        $files = scandir($dir);
        $ignore = array(".","..",".well-known","error_log","index.php");
        foreach ($files as $file) {
          if (!in_array($file, $ignore)) {
            ?><a href="https://tmp.pig.blue/<?=$file?>"><?=$file?><br><?
          }
        }
      ?>
    </article>
  </main>
</body>
</html>
