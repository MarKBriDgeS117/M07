<?php
if (isset($_POST["refrescar"])) {
    echo "hola";
}
?>


<!DOCTYPE html>
<html lang="ca">
<head>
    <title>PHPògic</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Juga al PHPògic.">
    <link href="//fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body data-joc="2022-10-07">
<form action="process.php" method="post" id="nameform">
<div class="main">
    <h1>
        <a href=""><img src="logo.png" height="54" class="logo" alt="PHPlògic"></a>
    </h1>
    <!--<div class="container-notifications">
        <p class="hide" id="message" style="">MISSATGE D'ERROR</p>
    </div>-->
    <div class="cursor-container">
        <p id="input-word"><span id="test-word"></span><span id="cursor">|</span></p>
        <input type="hidden" id="input" name="resultat"> </input>
    </div>
    <div class="container-hexgrid">
        <ul id="hex-grid">
            <li class="hex">
                <div class="hex-in"><a class="hex-link" data-lletra='e' draggable="false"><p>e</p></a></div>
            </li>
            <li class="hex">
                <div class="hex-in"><a class="hex-link" data-lletra='s' draggable="false"><p>s</p></a></div>
            </li>
            <li class="hex">
                <div class="hex-in"><a class="hex-link" data-lletra='a' draggable="false"><p>a</p></a></div>
            </li>
            <li class="hex">
                <div class="hex-in"><a class="hex-link" data-lletra='u' draggable="false" id="center-letter"><p>u</p></a></div>
            </li>
            <li class="hex">
                <div class="hex-in"><a class="hex-link" data-lletra='i' draggable="false"><p>i</p></a></div>
            </li>
            <li class="hex">
                <div class="hex-in"><a class="hex-link" data-lletra='t' draggable="false"><p>t</p></a></div>
            </li>
            <li class="hex">
                <div class="hex-in"><a class="hex-link" data-lletra='l' draggable="false"><p>l</p></a></div>
            </li>
        </ul>
    </div>
    <div class="button-container">

        </form>
        <form method="post" id="refrescar">
        <input type="hidden" id="input" name="refrescar" value="refrescar"></input>
        </form>
        
        <button id="delete-button" type="button" title="Suprimeix l'última lletra" onclick="suprimeix()"> Suprimeix</button>
        <button id="shuffle-button" type="submit" form="refrescar"class="icon" aria-label="Barreja les lletres" title="Barreja les lletres">
            <svg width="16" aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg"
                 viewBox="0 0 512 512">
                <path fill="currentColor"
                      d="M370.72 133.28C339.458 104.008 298.888 87.962 255.848 88c-77.458.068-144.328 53.178-162.791 126.85-1.344 5.363-6.122 9.15-11.651 9.15H24.103c-7.498 0-13.194-6.807-11.807-14.176C33.933 94.924 134.813 8 256 8c66.448 0 126.791 26.136 171.315 68.685L463.03 40.97C478.149 25.851 504 36.559 504 57.941V192c0 13.255-10.745 24-24 24H345.941c-21.382 0-32.09-25.851-16.971-40.971l41.75-41.749zM32 296h134.059c21.382 0 32.09 25.851 16.971 40.971l-41.75 41.75c31.262 29.273 71.835 45.319 114.876 45.28 77.418-.07 144.315-53.144 162.787-126.849 1.344-5.363 6.122-9.15 11.651-9.15h57.304c7.498 0 13.194 6.807 11.807 14.176C478.067 417.076 377.187 504 256 504c-66.448 0-126.791-26.136-171.315-68.685L48.97 471.03C33.851 486.149 8 475.441 8 454.059V320c0-13.255 10.745-24 24-24z"></path>
            </svg>
        </button>
        <button id="submit-button" form="nameform" type="submit" title="Introdueix la paraula">Introdueix</button>

        
    </div>
    <div class="scoreboard">
        <div>Has trobat <span id="letters-found">0</span> <span id="found-suffix">funcions</span><span id="discovered-text">.</span>
        </div>
        <div id="score"></div>
        <div id="level"></div>
    </div>
</div>
<script>
    
    function amagaError(){
        if(document.getElementById("message"))
            document.getElementById("message").style.opacity = "0"
    }
    function afegeixLletra(lletra){
        document.getElementById("test-word").innerHTML += lletra
        document.getElementById("input").value += lletra
    }
    function suprimeix(){
        document.getElementById("test-word").innerHTML = document.getElementById("test-word").innerHTML.slice(0, -1)
        document.getElementById("input").value = document.getElementById("input").value.slice(0, -1)
    }
    window.onload = () => {
        // Afegeix funcionalitat al click de les lletres
        Array.from(document.getElementsByClassName("hex-link")).forEach((el) => {
            el.onclick = ()=>{afegeixLletra(el.getAttribute("data-lletra"))}
        })
        setTimeout(amagaError, 2000)
        //Anima el cursor
        let estat_cursor = true;
        setInterval(()=>{
            document.getElementById("cursor").style.opacity = estat_cursor ? "1": "0"
            estat_cursor = !estat_cursor
        }, 500)
    }
</script>
</body>
</html>