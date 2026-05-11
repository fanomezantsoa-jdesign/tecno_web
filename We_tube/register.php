<?php
session_start();

$bdd = new PDO(
    'mysql:host=localhost;dbname=we_tube;charset=utf8',
    'root',
    '',
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);


if (isset($_POST['envoi'])){
    if (
        !empty($_POST['nom']) &&
        !empty($_POST['email']) &&
        !empty($_POST['mdp']) &&
        !empty($_POST['mdpconfirm'])
    )
{
    //Verifier que les mdp correspondent
    if ($_POST['mdp'] === $_POST['mdpconfirm']) {
        $nom = htmlspecialchars(trim($_POST['nom']));
        $email = htmlspecialchars($_POST['email']);
        $mdp = sha1($_POST['mdp']); // je garde TON sha1
        
    //Vérifier si l'email existe deja
    $checkUser = $bdd->prepare("SELECT * FROM users WHERE email = ?");
    $checkUser->execute([$email]);

    if ($checkUser->rowCount() == 0) {
        //insertion de l'utilisateur
        $insertUser = $bdd->prepare("INSERT INTO users(nom, email, mdp) VALUES (?, ?, ?)");
        $insertUser->execute([$nom, $email, $mdp]);

        $userId = $bdd->lastInsertId();

        $_SESSION['user_id'] = $userId;
        $_SESSION['user_nom'] = $nom;
        $_SESSION['user_email'] = $email;
        $_SESSION['connecte'] = $true;


        header('Location: index.html');
        exit();

    } else {
        $erreur = "Cet email est dejà utilisé ";

    }

    }else {
        $erreur = "mot de passe incorrect";
    }


}else{
    $erreur = "veuillez remplir tout les champs!";
}
}
        
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Inscription</title>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
		<link rel="stylesheet"  href="register.css">
   </head>
	<body>

    <!-- //<//?php 
    //if (isset($erreur)): ?>
    <p style="color: red;"><//?=// $erreur ?></p>
     <//?php //endif; ?>  -->
		<form action="" method="POST">
		<div class="wrapper">
				  <h1>S'inscrire</h1>
				
				  <div class="input-box">
                <i class="fa-regular fa-user"></i>
					   <input name="nom" type="text" placeholder="nom d'utilisateur"required>
						<img src="" width="20rem"/>
                  </div>

                  <div class="input-box">
                <i class="fa-regular fa-envelope"></i>
					   <input name="email" type="text" placeholder="adresse e-mail"required>
						<img src="" width="20rem"/>
                  </div>
                   
                  <div class="input-box">
                <i class="fa-solid fa-lock"></i>
					   <input name="mdp" type="password" placeholder="mot de passe" required>
                  </div>

                   <div class="input-box">
                <i class="fa-solid fa-lock"></i>
					   <input name="mdpconfirm" type="password" placeholder="mot de passe" required>
                  </div>
                  
                  <div class="remember-forgot">
					   <label><input type="checkbox">Se souvenir de moi</label>
				  </div>
					
					<button name="envoi" type="submit" class="btn"><a href="index.html">S'inscrire</a></button>
				
               	<div class="register-link">
               	     <p>Ou avez-vous déjà un compte?<a href="login.php">Se connecter</a></p>
                   </div>
            </form>
           </div>
        </div>
    </body>
</html>