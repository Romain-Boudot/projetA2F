<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/cdn/main.css">
    <link rel="stylesheet" href="main.css">
    <script src="/cdn/Popup.js"></script>
    <title>Recherche</title>
</head>
<body>
    
    <header>
        <div class="header-left">
            <img id="logo-a2f" src="/images/logo-a2f-blanc-02.svg" height="46">
        </div>
        <div class="header-right">
            <div class="btn bold">Déconnexion</div>
        </div>
        <div class="header-right">
            <div>Bienvenue, <span>romain.boudot</span></div>
        </div>
    </header>

    <div class="main-wrapper">

        <div class="search">
            <input type="text" class="searchBar" placeholder="nom consultant">
            <label for="archive">
                <input type="checkbox" name="archive" value="archive" id="archive">
                <div for="archive" class="checkbox">✔</div>
                archive
            </label>

            <div class="filterGrid">
    
                <div class="filterGridLeft borderRight">

                    Pôles : <br>
                    <label for="poleIndus" class="pole">
                        <input type="checkbox" name="poleIndus" id="poleIndus">
                        <div class="checkbox">✔</div>
                        Indus
                    </label>
                    <label for="poleDatabase" class="pole">
                        <input type="checkbox" name="poleDatabase" id="poleDatabase">
                        <div class="checkbox">✔</div>
                        Database
                    </label>
                    <label for="poleSi" class="pole">
                        <input type="checkbox" name="poleSi" id="poleSi">
                        <div class="checkbox">✔</div>
                        Si
                    </label>

                </div>
                
                <div class="filterGridRight">
                    Disponibilités :
                    <label for="dispMtn" class="disp">
                        <input type="checkbox" name="dispMtn" id="dispMtn">
                        <div class="checkbox">✔</div>
                        Maintenant
                    </label>
                    <label for="disp1M" class="disp">
                        <input type="checkbox" name="disp1M" id="disp1M">
                        <div class="checkbox">✔</div>
                        Dans 1 mois
                    </label> <br>
                    <label for="disp2M" class="disp">
                        <input type="checkbox" name="disp2M" id="disp2M">
                        <div class="checkbox">✔</div>
                        Dans 2 mois
                    </label>
                    <label for="disp3M" class="disp">
                        <input type="checkbox" name="disp3M" id="disp3M">
                        <div class="checkbox">✔</div>
                        Dans 3 mois et plus
                    </label>
                </div>
                
                <div class="filterGridLarge borderTop">

                    <div class="btn fakeComp">Selection des clients</div>
                    
                    <div class="comp">test<div class="closeBtn">&times;</div></div>
                    <div class="comp">test<div class="closeBtn">&times;</div></div>
                    <div class="comp">test<div class="closeBtn">&times;</div></div>
                    <div class="comp">test<div class="closeBtn">&times;</div></div>
                    <div class="comp">test<div class="closeBtn">&times;</div></div>
                    <div class="comp">test<div class="closeBtn">&times;</div></div>

                </div>
                
                <div class="filterGridLarge borderTop">
                    
                    <div class="btn fakeComp" onclick="Popup.open('popupComp')">Selection des competences</div>
                    
                    <div class="comp">test - 2 <div class="closeBtn">&times;</div></div>
                    <div class="comp">test - 1 <div class="closeBtn">&times;</div></div>
                    <div class="comp">test - 0 <div class="closeBtn">&times;</div></div>
                    <div class="comp">test - 3 <div class="closeBtn">&times;</div></div>
                    <div class="comp">test - 1 <div class="closeBtn">&times;</div></div>
                    <div class="comp">test - 2 <div class="closeBtn">&times;</div></div>
                    
                </div>
                
            </div>
            
        </div>
        
    </div>

    <div class="popup" id="popupComp">

        <div class="compSelect">
            ceci est un test
            <div class="btn close" onclick="Popup.close('popupComp')">close</div>
        </div>

    </div>

</body>
</html>