<?php session_start();
if(isset($_GET['action']) && $_GET['action'] === 'replay'){
    header('Location: /');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>😵 Mastermind</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font/bootstrap-icons.css" rel="stylesheet">
    <link href="css/master.css" rel="stylesheet">

</head>

<body>

<div class="d-flex justify-content-center mt-5 mb-4">
    <h1>😵 Mastermind</h1>
</div>

<?php
$availableColors = ['black', 'red', 'white', 'yellow', 'green', 'pink'];

$secretCombinationKeys = array_rand($availableColors, 4); 
shuffle($secretCombinationKeys);
$secretCombination = array_map(function ($colorKey) use ($availableColors) { 
    return $availableColors[$colorKey];
}, $secretCombinationKeys);

if (false) { 
    echo '<pre>';
    print_r($_SESSION['secret_combination']);
    echo '</pre>';
}
?>
<?php
if(!isset($_SESSION['progression'])){
    $_SESSION['progression'] = 0;
}
if(!isset($_SESSION['score'])){
    $_SESSION['score'] = 0;
}
if(!isset($_SESSION['secret_combination']) || isset($_GET['action']) && $_GET['action'] === 'replay'){
    $_SESSION['score'] = 0;
    $_SESSION['progression'] = 0;
    $_SESSION['secret_combination'] = $secretCombination;
    $_SESSION['player_combination'] = [];
}
if(isset($_GET['color']) && $_SESSION['progression'] < 4){
    if(in_array($_GET['color'], $_SESSION['secret_combination'])){
        if(array_search($_GET['color'], $_SESSION['secret_combination']) === $_SESSION['progression']){
            echo "<p class='alert alert-primary text-center container h3' role='alert'>
            Cette couleur fait partie de la combinaison et est à la bonne place.</p>";      
            array_push($_SESSION['player_combination'], $_GET['color']);
            $_SESSION['progression']++;
        }else{
            echo "<p class='alert alert-warning text-center container h3' role='alert'>
            Cette couleur fait partie de la combinaison mais n'est pas à la bonne place.</p>";
        }

    }else{
        echo "<p class='alert alert-danger text-center container h3' role='alert'>
        Cette couleur n'est pas dans la combinaison.</p>";
    }
    $_SESSION['score']++;
}

?>
<div class="d-flex justify-content-center mb-3">
    <div class="d-flex justify-content-around col-5 col-md-3">
        <div class="try col-5">
            <i class="bi bi-hand-index"></i>
            <?= $_SESSION['score'] ?> 
        </div>
        <div class="try col-5">
            <i class="bi bi-hand-thumbs-up"></i>
            <?php if(isset($_SESSION['best-score'])){ echo $_SESSION['best-score']; }else { echo "-"; } ?> 
        </div>
    </div>
</div>
<?php if ($_SESSION['progression'] === 4){ ?>
<p class="alert alert-success text-center container h1" role="alert">
  Félicitations ! Vous avez trouvé la combinaison secrète !
</p>

 <?php if(!isset($_SESSION['best-score'])){
     $_SESSION['best-score'] = $_SESSION['score'];
 }elseif($_SESSION['best-score'] > $_SESSION['score']){
    $_SESSION['best-score'] = $_SESSION['score'];
 } 
}
if(!empty($_SESSION['player_combination'])){ ?> 
    <div class="d-flex justify-content-center"> <?php
    foreach ($_SESSION['player_combination'] as $key => $color) {?>
        <div class="box <?= $color ?>"></div>
   <?php } ?> 
   </div> 
   <?php } ?>
<div class="d-flex justify-content-center">
<?php foreach ($availableColors as $key => $color) {
    if(!in_array($color ,$_SESSION['player_combination'])){ ?>
    <a href="?color=<?= $color ?>"  class="box <?= $color ?>"></a>
    <?php }
} ?>

</div>
<div class="text-center">
<a type="button" class="mt-2 btn btn-info" href="?action=replay">Rejouer</a>
</div>
<!-- Bootstrap core JavaScript -->
<script src="js/jquery.min.js"></script>
<script src="js/index.js"></script>

</body>

</html>