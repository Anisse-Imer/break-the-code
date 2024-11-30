<div class="game-container">
    <div class="game">
        <div class="questions">
            <h2>Choisissez une question :</h2>
            <div class="question-cards">
                <form method="post" action="">
                    <?php foreach ($_SESSION['partie']->getCartes()->getJeu() as $carte): ?>
                        <div class="question-card">
                            <button type="submit" name="id" value="<?= htmlspecialchars(json_encode($carte)); ?>">
                                <?php echo $carte->question; ?>
                            </button>
                        </div>
                    <?php endforeach; ?>
            </div>
        </div>
        <div id="modal">
            <div id="question"> Vous aves posé la question : <?php if($res["carte"]){echo $res["carte"]->question;}?> </div>
            <div id="reponse"> L'ordinateur a répondu : <?php if($res["reponse"]){echo $res["reponse"];}?> </div>

            <div id="questionOrdi"> L'ordinateur a posé la question : <?php if($res["carteOrdi"]){echo $res["carteOrdi"]->question;}?> </div>
            <div id="reponseOrdi"> Vous avez répondu : <?php if($res["reponseOrdi"]){echo $res["reponseOrdi"];}?> </div>
        </div>
        <div class="opponent-board">
            <div class="opponent-tiles">
                <div class="opponent-tile">0</div>
                <div class="opponent-tile">1</div>
                <div class="opponent-tile">2</div>
                <div class="opponent-tile">3</div>
                <div class="opponent-tile">4</div>
                <div class="opponent-tile">5</div>
                <div class="opponent-tile">6</div>
                <div class="opponent-tile">7</div>
                <div class="opponent-tile">8</div>
                <div class="opponent-tile">9</div>
            </div>
            <div class="opponent-tiles">
                <div class="opponent-tile">0</div>
                <div class="opponent-tile">1</div>
                <div class="opponent-tile">2</div>
                <div class="opponent-tile">3</div>
                <div class="opponent-tile">4</div>
                <div class="opponent-tile">5</div>
                <div class="opponent-tile">6</div>
                <div class="opponent-tile">7</div>
                <div class="opponent-tile">8</div>
                <div class="opponent-tile">9</div>
            </div>
        </div>
        <div class="guess-code">
            <h2>Code secret de l'adversaire :</h2>
            <div class="code-input">
                <input value="<?php if($_POST["code_tile_1"]){echo $_POST["code_tile_1"];} else{echo "1";} ?>" class="code-tile" type="text" name="code_tile_1" maxlength="1" oninput="validateInput(this)" style="background-color: <?php if($_POST["color_1"]){echo $_POST["color_1"];} else{echo "#212121";} ?>">
                <input value="<?php if($_POST["color_1"]){echo $_POST["color_1"];} else{echo "#212121";} ?>" style="display: none" type="text" id="color_1" name="color_1">
                <div class="color-squares" id="color-squares-1">
                    <button type="button" onclick="changeValueColor('1', '#212121')" style="background-color: #212121;" class="color-square black"></button>
                    <button type="button" onclick="changeValueColor('1', '#0FD60B')" style="background-color: #0FD60B;" class="color-square green"></button>
                    <button type="button" onclick="changeValueColor('1', '#FFFFFF')" style="background-color: #FFFFFF;" class="color-square white"></button>
                </div>
                <input value="<?php if($_POST["code_tile_2"]){echo $_POST["code_tile_2"];} else{echo "2";} ?>" class="code-tile" type="text" name="code_tile_2" maxlength="1" oninput="validateInput(this)" style="background-color: <?php if($_POST["color_2"]){echo $_POST["color_2"];} else{echo "#212121";} ?>">
                <input value="<?php if($_POST["color_2"]){echo $_POST["color_2"];} else{echo "#212121";} ?>" style="display: none" type="text" id="color_2" name="color_2">
                <div class="color-squares" id="color-squares-2">
                    <button type="button" onclick="changeValueColor('2', '#212121')" style="background-color: #212121;" class="color-square black"></button>
                    <button type="button" onclick="changeValueColor('2', '#0FD60B')" style="background-color: #0FD60B;" class="color-square green"></button>
                    <button type="button" onclick="changeValueColor('2', '#FFFFFF')" style="background-color: #FFFFFF;" class="color-square white"></button>
                </div>
                <input value="<?php if($_POST["code_tile_3"]){echo $_POST["code_tile_3"];} else{echo "3";} ?>" class="code-tile" type="text" name="code_tile_3" maxlength="1" oninput="validateInput(this)" style="background-color:<?php if($_POST["color_3"]){echo $_POST["color_3"];} else{echo "#212121";} ?>">
                <input value="<?php if($_POST["color_3"]){echo $_POST["color_3"];} else{echo "#212121";} ?>" style="display: none" type="text" id="color_3" name="color_3">
                <div class="color-squares" id="color-squares-3">
                    <button type="button" onclick="changeValueColor('3', '#212121')" style="background-color: #212121;" class="color-square black"></button>
                    <button type="button" onclick="changeValueColor('3', '#0FD60B')" style="background-color: #0FD60B;" class="color-square green"></button>
                    <button type="button" onclick="changeValueColor('3', '#FFFFFF')" style="background-color: #FFFFFF;" class="color-square white"></button>
                </div>
                <input value="<?php if($_POST["code_tile_4"]){echo $_POST["code_tile_4"];} else{echo "4";} ?>" class="code-tile" type="text" name="code_tile_4" maxlength="1" oninput="validateInput(this)" style="background-color:<?php if($_POST["color_4"]){echo $_POST["color_4"];} else{echo "#212121";} ?>">
                <input value="<?php if($_POST["color_4"]){echo $_POST["color_4"];} else{echo "#212121";} ?>" style="display: none" type="text" id="color_4" name="color_4">
                <div class="color-squares" id="color-squares-4">
                    <button type="button" onclick="changeValueColor('4', '#212121')" style="background-color: #212121;" class="color-square black"></button>
                    <button type="button" onclick="changeValueColor('4', '#0FD60B')" style="background-color: #0FD60B;" class="color-square green"></button>
                    <button type="button" onclick="changeValueColor('4', '#FFFFFF')" style="background-color: #FFFFFF;" class="color-square white"></button>
                </div>
                <input value="<?php if($_POST["code_tile_5"]){echo $_POST["code_tile_5"];} else{echo "5";} ?>" class="code-tile" type="text" name="code_tile_5" maxlength="1" oninput="validateInput(this)" style="background-color:<?php if($_POST["color_5"]){echo $_POST["color_5"];} else{echo "#212121";} ?>">
                <input value="<?php if($_POST["color_5"]){echo $_POST["color_5"];} else{echo "#212121";} ?>" style="display: none" type="text" id="color_5" name="color_5">
                <div class="color-squares" id="color-squares-5">
                    <button type="button" onclick="changeValueColor('5', '#212121')" style="background-color: #212121;" class="color-square black"></button>
                    <button type="button" onclick="changeValueColor('5', '#0FD60B')" style="background-color: #0FD60B;" class="color-square green"></button>
                    <button type="button" onclick="changeValueColor('5', '#FFFFFF')" style="background-color: #FFFFFF;" class="color-square white"></button>
                </div>
                <input type="hidden" name="valider" value="TRUE">
                <button type="submit" id="valider">Valider</button>
                </form>
            </div>
        </div>
    </div>
    <div id="note-container">
        <div class="player-board">
            <h2>Votre code secret :</h2>
            <div class="player-tiles">
                <?php foreach ($_SESSION['partie']->getTuiles()->getTuilesJoueur() as $tuile):?>
                    <div class="player-tile" style="background-color: <?php echo $tuile->code_couleur;?>;"> <?php echo $tuile->numero;?> </div>
                <?php endforeach;?>
            </div>
        </div>
        <div class="counter">
            <img src="../src/assets/imgs/cartes.png" alt="paquets">
            <div class="cards-counter">20</div>
        </div>

        <textarea id="note-text" placeholder="Écrivez vos notes ici..."><?php echo $_SESSION['partie']->getNotes()?></textarea>

        <div class="settings" id="settingsBtn">
            <img src="../src/assets/imgs/parametres.png" alt="settings">
        </div>
        <div id="confirmationModal" class="modal">
            <div class="modal-content">
                <p>Voulez-vous vraiment abandonner la partie ?</p>
                <button id="confirmBtn">Confirmer</button>
                <button id="cancelBtn">Annuler</button>
            </div>
        </div>
    </div>
</div>
<script src="../src/include/js/script.js"></script>

<script>
    function changeValueColor(num, newValue) {
        var label = document.getElementById("color_" + num);
        label.value = newValue;
    }
</script>

</body>