<?php
session_start();

// Si déjà connecté, rediriger vers l'espace membre
if (isset($_SESSION['connecte']) && $_SESSION['connecte'] === true) {
    header('Location: index.html');
    exit();
}

$bdd = new PDO(
    'mysql:host=localhost;dbname=we_tube;charset=utf8',
    'root',
    '',
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

$erreur = '';

if (isset($_POST['connexion'])) {
    if (!empty($_POST['email']) && !empty($_POST['mdp'])) {
        
        $email = htmlspecialchars($_POST['email']);
        $mdp = sha1($_POST['mdp']); // Même hash que l'inscription
        
        // Vérifier les identifiants
        $requete = $bdd->prepare("SELECT * FROM users WHERE email = ? AND mdp = ?");
        $requete->execute([$email, $mdp]);
        
        if ($requete->rowCount() > 0) {
            $user = $requete->fetch(PDO::FETCH_ASSOC);
            
            // Création de la session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_nom'] = $user['nom'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['connecte'] = true;
            
            // Redirection vers l'espace membre
            header('Location: index.html');
            exit();
        } else {
            $erreur = "Email ou mot de passe incorrect";
        }
        
    } else {
        $erreur = "Veuillez remplir tous les champs";
    }
}
?>


<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
		<link rel="stylesheet"  href="login.css">
   </head>
	<body>
 		
		<div class="wrapper">
			<form action="">
				  <h1>Se connecter</h1>
				
				  <div class="input-box">
                <i class="fa-regular fa-envelope"></i>
					   <input name="email" type="email" placeholder="adresse e-mail" required>
						<img src="" width="20rem"/>
                  </div>
                   
                  <div class="input-box">
                <i class="fa-solid fa-lock"></i>
					   <input name="mdp" type="password" placeholder="mot de passe" required>
                  </div>
                  
                  <div class="remember-forgot">
					   <label><input type="checkbox">Se souvenir de moi</label>
					  <a href="#">Mot de passe oublié?</a>
				  </div>
					
					<button type="submit" class="btn"><a href="index.html">Connexion</a></button>
				
               	<div class="register-link">
               	     <p>Ou voulez vous créer un compte?<a href="register.php">S'inscrire</a></p>
                   </div>
            </form>
           </div>
        </div>
    </body>
</html>