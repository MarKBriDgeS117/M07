<?php session_start();
if (isset($_SESSION['LAST_ACTIVITY']) && ($_SERVER['REQUEST_TIME'] - $_SESSION['LAST_ACTIVITY']) > 60) session_unset();
if (isset($_SESSION['Usuari'])) header("Location: hola.php", true, 302); ?>
<!DOCTYPE html>
<html lang="ca">

<head>
    <title>Accés</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">
</head>

<body>
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="process.php" method="post">
                <h1>Registra't</h1>
                <span>crea un compte d'usuari</span>
                <input type="hidden" name="method" value="signup" />
                <input type="text" name="Nom" placeholder="Nom" />
                <input type="email" name="email" placeholder="Correu electronic" />
                <input type="password" name="password" placeholder="Contrasenya" />
                <button type="submit">Registra't</button>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form action="process.php" method="post">
                <h1>Inicia la sessió</h1>
                <span>introdueix les teves credencials</span>
                <input type="hidden" name="method" value="signin" />
                <input type="email" name="email" placeholder="Correu electronic" />
                <input type="password" name="password" placeholder="Contrasenya" />
                <button type="submit">Inicia la sessió</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Ja tens un compte?</h1>
                    <p>Introdueix les teves dades per connectar-nos de nou</p>
                    <button class="ghost" id="signIn">Inicia la sessió</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Primera vegada per aquí?</h1>
                    <p>Introdueix les teves dades i crea un nou compte d'usuari</p>
                    <button class="ghost" id="signUp">Registra't</button>
                </div>
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