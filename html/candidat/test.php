<style>
    .alertContainer {
        width: 80vw;
        text-align: center;
        font-family: 'Roboto', sans-serif;
    }
    .imgPole {
        display: inline-block;
        margin: 10px 20px;
        border: 2px solid rgba(0, 0, 0, .1);
        padding: 10px;
        border-radius: 7px;
        filter: grayscale(1);
        -webkit-filter: grayscale(1);
        -moz-filter: grayscale(1);
        -o-filter: grayscale(1);
        -ms-filter: grayscale(1);
        transition: .2s filter ease;
        cursor: pointer;
    }
    .imgPole:hover {
        filter: grayscale(0);
        -webkit-filter: grayscale(0);
        -moz-filter: grayscale(0);
        -o-filter: grayscale(0);
        -ms-filter: grayscale(0);
    }

</style>



<div class="alertContainer">
    <div class="mainText">
        <h3>Choix du pôle</h3>    
    </div>

    <div class="imgPole" id="Indus">
        <img src="/images/schema-industrie-15.svg" alt="logo a2f industrie" height="100" width="100">
    </div>

    <div class="imgPole" id="SI">
        <img src="/images/visuel-si.svg" alt="logo a2f SI" height="100" width="100">
    </div>

    <div class="imgPole" id="Database">
        <img src="/images/schema-database-17.svg" alt="logo a2f database" height="100" width="100">
    </div>

    <div class="btnTransfer">Transférer</div> 

</div>