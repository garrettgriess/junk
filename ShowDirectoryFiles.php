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
    section {
    }
    h1 {
      border-bottom: 2px solid #444444;
    }
    figure {
      float: left;
      width: 100%;
      height: 100%;
      max-width: 212px;
      min-height: 270px;
      margin: 10px;
      padding: 10px;
      text-align: center;
      background-color: #444444;
      transition: all 0.5s;
    }
    figure:hover {
      background-color: #555555;
    }
    figure img {
      width: 100%;
      max-height: 212px;
      width: auto;
      max-width: 212px;
    }
    figure h2 {
      text-align: center;
      padding: 72px 0;
    }
    figcaption {
      font-size: 0.8em;
      text-align: center;
      padding: 0.5em;
    }
    a {
      color: #ACE7F8;
      text-decoration: none;
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
      <h1>Temp Files <small>(deleted after 30 days)</small></h1>
      <section>
        <?
        //Vars
        $dir = "/home3/garrettg/public_html/tmp/files";
        $base = "https://tmp.pig.blue/files/";
        $ignore_files = array(".","..");
        $ignore_types = array("eml");
        $render_types = array("gif", "jpg", "jpeg", "png");

        //Display Files
        $files = scandir($dir);
        foreach ($files as $file) {
          $file_ext = strtolower(substr($file, strrpos($file, '.')+1));
          $file_disp = str_replace("_", " ", trim(substr($file, (strpos($file, '_') + 1))));

          if (!in_array($file, $ignore_files)) {
            if (!in_array($file_ext, $ignore_types)) {
              if (in_array($file_ext, $render_types)) {
                ?>
                <figure>
                  <a href="<?=$base?><?=$file?>">
                    <img src="<?=$base?><?=$file?>" alt="<?=$file?>">
                    <figcaption><?=$file_disp?></figcaption>
                  </a>
                </figure>
              <?
              } else {
                ?>
                <figure>
                  <a href="<?=$base?><?=$file?>">
                    <h2><?=$file_ext?></h2>
                    <figcaption><?=$file_disp?></figcaption>
                  </a>
                </figure>
              <?
              }
            }
          }

        }
        ?>
      </section>
    </article>
  </main>
</body>
</html>
