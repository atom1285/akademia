<?php 
include 'assets/functions.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/main.css">

  <title>Prichody studentov</title>
</head>

<body>

  <main class="container">

    <?php
    echo '<h2> Ahoj </h2>';
    ?>

    <form class="form-group" action="prichod.php" method="post">
      <label>
        <input class="form-control" type="text" name="studentName" id="">
      </label>

      <input class="btn btn-sm btn-danger" type="submit" value="zaznamenaj prichod">
    </form>

    <ul class="list-group">
      <?php 
            outputArrivalFile();
        ?>
    </ul>

  </main>
</body>

</html>