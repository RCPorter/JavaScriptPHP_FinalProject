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
        <header><h1>Word Up!</h1></header>
        <h2>Save some hints for your new password!</h2>
        <h3 class="error" <?php echo $error; ?>><?php echo $message; ?></h3>
      </div>
      <div class="col-10 col-md-6 py-5 container">
        <form class="form-floating mb-6 col-12" action="." method="post">
          <input class="form-control" type="hidden" name="action" value="add_hint">
          <div class="mb-3">
            <label class="form-label">Username:</label>
            <input class="form-control" type="text" name="username"><br>
          </div>
          <div class="mb-3">
            <label class="form-label">Pin:</label>
            <input class="form-control" type="text" name="pin"><br>
          </div>
          <div class="mb-3">
            <label class="form-label">Hint 1:</label>
            <input class="form-control" type="text" name="hint_1" id="hint_1" />
          </div>
          <div class="mb-3">
            <label class="form-label">Hint 2:</label>
            <input class="form-control" type="text" name="hint_2" id="hint_2" />
          </div>
          <div class="mb-3">
            <label class="form-label">Hint 3:</label>
            <input class="form-control" type="text" name="hint_3" id="hint_3"/>
          </div>
          <div class="mb-3">
            <label>&nbsp;</label>
            <input class="btn btn-primary" type="submit" value="Add Hint" /><br>
          </div>
        </form>
        <form action="." method="post">
        <input class="form-control" type="hidden" name="action" value="load_hints">
        <input class="btn btn-primary" type="submit" value="Load Hints" /><br>
        </form>
      </div>
    </div>
  </div>
</body>  
<?php include '../view/footer.php'; ?>
