<?php include '../view/header.php'; ?>
    <title>Say Word!</title>

    <script type="text/javascript" src="../scripts/utility.js"></script>

    <link rel="stylesheet" href="../main.css">
</head>

<!-- the body section -->
<body class="container">
  <div class="h-100 d-flex align-items-center justify-content-center col-12">
    <div class="container">
      <div class="col-10 col-md-6 container">
        <nav class="nav">
        <a type="submit" class="btn btn-lg btn-outline-primary col-4" name="action" value="whats_the_word" href="../index.php" method="post">What's the Word</a>
          <a type="submit" class="btn btn-lg btn-outline-success disabled col-4" name="action" value="say_word" aria-current="page" href="#">Say Word</a>
          <a type="submit" class="btn btn-lg btn-outline-primary col-4" name="action" value="word_up" href="../word_up/index.php" method="post">Word Up</a>
        </nav>
      </div>
      <div class="col-10 col-md-6 container text-center">
        <header><h1>Say Word!</h1></header>
        <h2>Create a New Password</h2>
      </div>
      <div class="col-10 col-md-6 py-5 container">
        <form class="form-floating mb-6 col-12" action="index.php" method="post">
          <input type="hidden" name="action" value="pass_gen" />
          <div class="input-group mb-3">
            <input type="text" class="form-control border-secondary" <?php echo $message; ?> aria-label="gen" aria-describedby="button-addon2" id="gen" name="gen" <?php echo $disabled; ?>>
            <button class="btn btn-outline-primary" type="submit" id="button-addon2"><img class="icon" src="../images/cog.png" alt="Search"></button>
          </div>
      </div>
          <div class="accordion col-10 col-md-6 container" id="accordionBasic">
            <div class="accordion-item border-primary">
              <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  <img class="icon" src="../images/list.png" alt="List of"> Password Options:
                </button>
              </h2>
              <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionBasic">
                <div class="accordion-body">
                  <i class="subtle">&emsp;&emsp;&emsp;At least one Letter type must be selected.</i>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="lower" <?php echo $low_checked; ?> name="lower" onchange="check()">
                      <label class="form-check-label" for="lower">Include Lower-Case Letters</label>
                    </div>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="upper" <?php echo $up_checked; ?> name="upper" onchange="check()">
                      <label class="form-check-label" for="upper">Include Upper-Case Letters</label>
                    </div>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="number" <?php echo $num_checked; ?> name="number">
                      <label class="form-check-label" for="number">Include Numbers</label>
                    </div>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="special" <?php echo $spec_checked; ?> name="special">
                      <label class="form-check-label" for="special">Include Special Characters</label>
                    </div>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="similar" <?php echo $sim_checked; ?> name="similar">
                      <label class="form-check-label" for="similar">Exclude 'I', 'L', 'O', 'S', & 'Z' (Easily confused with other characters)</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="flexRadioDefault" id="long_string" <?php echo $ls_checked; ?> value="long_string">
                      <label class="form-check-label" for="long_string">
                        One Long String
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="flexRadioDefault" id="three_word" <?php echo $tw_checked; ?> value="three_word">
                      <label class="form-check-label" for="three_word">
                        Three Unrelated Words
                      </label>
                    </div>
                </div>
              </div>
            </div>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript">
      let hint1 = '<?php echo $hint_1; ?>';
      let hint2 = '<?php echo $hint_2; ?>';
      let hint3 = '<?php echo $hint_3; ?>';
  </script>  
  <script type="text/javascript" src="../scripts/say_word.js"></script>
<?php include '../view/footer.php'; ?>