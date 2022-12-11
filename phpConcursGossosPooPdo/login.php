<?php session_start();
if (isset($_SESSION['Usuari'])) header("Location: admin.php", true, 302); ?>
<!DOCTYPE html>
<html lang="ca">

<head>
    <title>Accés</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
</head>

<body>
    <div class="container" id="container">
        <div class="form-container sign-in-container">
            <form action="process.php" method="post">
                <h1>Inicia la sessió</h1>
                <span>introdueix les teves credencials</span>
                <input type="hidden" name="method" value="signin" />
                <input type="text" name="email" placeholder="Correu electronic" />
                <input type="password" name="password" placeholder="Contrasenya" />
                <button type="submit">Inicia la sessió</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                
            </div>
        </div>
    </div>
    <div class="container-notifications">
        <?php
        if (isset($_GET['error'])) {
            $error = $_GET['error'];
            switch ($error) {
                case "Jaestasregistrat":
                    echo '<p class="hide" id="message">Ja estas registrat.</p>';
                    break;
                case "noestasregistrat":
                    echo '<p class="hide" id="message">No estas registrat.</p>';
                    break;
                case "passwordIncorrecta":
                    echo '<p class="hide" id="message">El password es incorrecte.</p>';
                    break;
                case "nohasiniciatsesio":
                    echo '<p class="hide" id="message">No has iniciat Sessió o ha caducat.</p>';
                    break;
                case "nohasemplenatelscamps":
                    echo '<p class="hide" id="message">No has emplenat tots els camps.</p>';
                    break;
                case "BaseDeDadesIncorrecta":
                    echo '<p class="hide" id="message">Base de dades Incorrecta.</p>';
                    break;
            }
        }
        ?>
    </div>
</body>

<script>
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const container = document.getElementById('container');
    signUpButton.addEventListener('click', () => {
        container.classList.add("right-panel-active");
    });
    signInButton.addEventListener('click', () => {
        container.classList.remove("right-panel-active");
    });

    
</script>

</html>