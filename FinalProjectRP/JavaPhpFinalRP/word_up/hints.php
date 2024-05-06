<?php include '../view/header.php'; ?>
    <!-- Local Javascript-->
    <script src="../scripts/utility.js"></script>
    <script src="../scripts/word_up.js"></script>
    <!-- Local CSS -->
    <link rel="stylesheet" type="text/css" href="../main.css"> 
    <title>Word Up!</title>
</head>

<!-- the body section -->
<body>

<body class="container">
  <div class="h-100 d-flex align-items-center justify-content-center col-12">
    <div class="container">
      <div class="col-10 col-md-6 container">
          <nav class="nav">
            <a type="submit" class="btn btn-lg btn-outline-primary col-4" name="action" value="whats_the_word" href="../index.php" method="post">What's the Word</a>
            <a type="submit" class="btn btn-lg btn-outline-primary col-4" name="action" value="say_word" href="../say_word/index.php" method="post">Say Word</a>
            <a type="submit" class="btn btn-lg btn-outline-success disabled col-4" name="action" value="say_word" href="#" method="post">Word Up</a>
          </nav>
      </div>
      <div class="col-10 col-md-6 container text-center">
        <header><h1>Your Hints</h1></header>
        <h2><?php echo $username; ?></h2>
      </div>
      <div class="col-10 col-md-6 py-5 container">
        <table class="table table_striped">
            <thead>
                <tr>
                    <th scope="col">Hint 1</th>
                    <th scope="col">Hint 2</th>
                    <th scope="col">Hint 3</th>
                    <th scope="col">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($hints as $hint) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($hint['hint_1']); ?></td>
                    <td><?php echo htmlspecialchars($hint['hint_2']); ?></td>
                    <td><?php echo htmlspecialchars($hint['hint_3']); ?></td>
                    <td><form action="." method="post">
                        <input type="hidden" name="action"
                            value="delete_hint">
                        <input type="hidden" name="hint_1"
                            value="<?php echo htmlspecialchars($hint['hint_1']); ?>">
                        <input type="hidden" name="hint_2"
                            value="<?php echo htmlspecialchars($hint['hint_2']); ?>">
                        <input type="hidden" name="hint_3"
                            value="<?php echo htmlspecialchars($hint['hint_3']); ?>">
                        <input type="hidden" name="username"
                            value="<?php echo htmlspecialchars($username); ?>">
                        <input type="hidden" name="pin"
                            value="<?php echo htmlspecialchars($pin); ?>">
                        <input class='btn btn-primary' type="submit" value="Delete">
                    </form></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <form action="." method="post">
        <input class="form-control" type="hidden" name="action" value="word_up">
        <input class="btn btn-primary" type="submit" value="Add Hint" /><br>
        </form>
      </div>
    </div>
  </div>
</body>  
<?php include '../view/footer.php'; ?>