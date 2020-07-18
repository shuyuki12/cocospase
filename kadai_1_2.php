<html>
  <head>
    <title>PHP</title>  
  </head>
  <body>
    <?php 
      $fp = fopen("kadai_1_2.txt", "w");
      fwrite($fp, "Hello New World!");
      fclose($fp)
      // chmod("./kadai_1_2.txt", 0750);
    ?>
  </body>

</html>



