<?php  
    include 'view/header.php'; 
    include 'model/database.php';
    if (!isset($result)){
        $hidden_found = 'hidden';
        $hidden_not = 'hidden';
        $hidden_check = ''; //Remember to reset these when no password was entered.
    }
?>

<script type="text/javascript" src="./scripts/utility.js"></script>
<script type="text/javascript" src="./scripts/whats_the_word.js"></script>

<link rel="stylesheet" href="./main.css">
<title>What's the Word?</title>

  </head>

<!-- the body section -->
<body class="container">
<div class="h-100 d-flex align-items-center justify-content-center col-12">
    <div class="container">
        <div class="col-10 col-md-6 container">
            <nav class="nav">
                <a type="submit" class="btn btn-lg btn-outline-success disabled col-4" name="action" value="say_word"aria-current="page" href="#">What's the Word</a>
                <a type="submit" class="btn btn-lg btn-outline-primary col-4" name="action" value="say_word" href="./say_word/index.php" method="post">Say Word</a>
                <a type="submit" class="btn btn-lg btn-outline-primary col-4" name="action" value="word_up" href="./word_up/index.php" method="post">Word Up</a>
            </nav>
        </div>

        <div class="col-10 col-md-6 container text-center">
            <header><h1>What's the Word!?</h1></header>
            <h2>Let's check your Password!</h2>
        </div>
        
        <div class="col-10 col-md-6 py-5 container">
            <form class="form-floating mb-6 col-12" action="./check.php" method="post">
                <div class="input-group mb-3">
                    <input type="password" class="form-control border-secondary" placeholder="Enter your password!" aria-label="pass" aria-describedby="button-addon2" id="pass" name="pass">
                    <button class="btn btn-outline-primary" type="submit" id="button-addon2"><img class="icon" src="./images/search.png" alt="Search"></button>
                </div>
            </form>
        </div>

        <div class="card border-primary bg-transparent col-10 col-md-6 container" <?php echo $hidden_check?>>
            <div class="card-header">
                Password Strength
            </div>
            <div class="card-body">
                <h5 class="card-title">How strong is your password?</h5>
                <p class="card-text">   <span class="col-3"><img class="status" id="upperCheck" src="./images/check.png" hidden><img class="status" id="upperX" src="./images/x.png"> Upper    </span>
                                        <span class="col-3"><img class="status" id="lowerCheck" src="./images/check.png" hidden><img class="status" id="lowerX" src="./images/x.png"> Lower    </span>
                                        <span class="col-3"><img class="status" id="digitCheck" src="./images/check.png" hidden><img class="status" id="digitX" src="./images/x.png"> Number    </span>
                                        <span class="col-3"><img class="status" id="specialCheck" src="./images/check.png" hidden><img class="status" id="specialX" src="./images/x.png"> Special    </span></p>
                <a name="action" value="say_word" href="./word_up/index.php" method="post"class='btn btn-primary'>Save Password Hints!</a>
                <a name="action" value="say_word" href="./say_word/index.php" method="post" class='btn btn-success'>Create a New Password</a>
            </div>
        </div>

        <div class="card border-danger bg-danger col-10 col-md-6 container" <?php echo $hidden_found?>>
            <div class="card-header">
                Oh No!
            </div>
            <div class="card-body">
                <h5 class="card-title">This Password has been compromised!</h5>
                <p class="card-text"><img class="status" src="./images/alert.png" >Your password has been found <?php echo number_format($result) ?> times in known data breaches!</p>
                <a name="action" value="say_word" href="./say_word/index.php" method="post"class='btn btn-warning'>Create New Password</a>
            </div>
        </div>

        <div class="card border-primary bg-success col-10 col-md-6 container" <?php echo $hidden_not?>>
            <div class="card-header">
                Congratulations!
            </div>
            <div class="card-body">
                <h5 class="card-title">Your Password is Secure!</h5>
                <p class="card-text"><img class="status" src="./images/good.png" >Your password has not been found in any known data breaches!</p>
                <a name="action" value="say_word" href="./word_up/index.php" method="post" class='btn btn-primary'>Save Password Hints!</a>
            </div>
        </div>
    </div>
</div>
<?php include 'view/footer.php'; ?>