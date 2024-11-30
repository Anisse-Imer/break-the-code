// Fonction pour activer/désactiver l'état barré d'une case
function toggleStrikeThrough(tile) {
    tile.classList.toggle("strikethrough");
}

// Ajout d'un gestionnaire d'événements aux cases de la classe "opponent-tiles"
document.addEventListener("DOMContentLoaded", function () {
    const opponentTiles = document.querySelectorAll(".opponent-tile");

    opponentTiles.forEach((tile) => {
        tile.addEventListener("click", function () {
            toggleStrikeThrough(tile);
        });
    });
});

// Fonction pour valider la saisie
function validateInput(input) {
    const value = input.value;

    if (value.length > 1) {
        input.value = value.charAt(value.length - 1);
    }

    if (value !== "" && !/^[0-9]$/.test(value)) {
        input.value = "";
    }
}

// Gestionnaire d'événement pour les carrés de couleur
document.addEventListener("DOMContentLoaded", function () {
    for (let i = 1; i <= 5; i++) {
        const colorSquares = document.getElementById(`color-squares-${i}`);
        colorSquares.addEventListener("click", function (event) {
            const clickedSquare = event.target;
            handleColorSquareClick(clickedSquare);
        });
    }
});

// Fonction pour gérer le clic sur un carré de couleur
function handleColorSquareClick(square) {
    const input = square.closest('.color-squares').nextElementSibling.querySelector('input');

    if (square.classList.contains('green')) {
        input.style.backgroundColor = 'green';
    } else if (square.classList.contains('black')) {
        input.style.backgroundColor = 'black';
    } else if (square.classList.contains('white')) {
        input.style.backgroundColor = 'white';
    }
}

// Fonction pour générer un chiffre aléatoire entre 0 et 9
function generateRandomNumber() {
    return Math.floor(Math.random() * 10);
}

// Fonction pour remplir les cases avec des chiffres aléatoires
function fillPlayerTiles() {
    const playerTiles = document.querySelectorAll(".player-tile");

    playerTiles.forEach((tile) => {
        const randomNumber = generateRandomNumber();
        //tile.textContent = randomNumber;
    });
}

// Appel de la fonction pour remplir les cases au chargement de la page
document.addEventListener("DOMContentLoaded", function () {
    fillPlayerTiles();
});

document.addEventListener("DOMContentLoaded", function () {
    // Get the modal and buttons
    var modal = document.getElementById("confirmationModal");
    var settingsBtn = document.getElementById("settingsBtn");
    var confirmBtn = document.getElementById("confirmBtn");
    var cancelBtn = document.getElementById("cancelBtn");

    settingsBtn.addEventListener("click", function () {
        modal.style.display = "block";
    });

    cancelBtn.addEventListener("click", function () {
        modal.style.display = "none";
    });

    confirmBtn.addEventListener("click", function () {
        // Add your logic to redirect to the homepage
        window.location.href = "/accueil    ";
    });
});

document.querySelectorAll('.form-control').forEach(input => {
    input.addEventListener('focus', function () {
        this.previousElementSibling.style.transform = 'translateY(-20px) scale(0.8)';
    });

    input.addEventListener('blur', function () {
        if (this.value === '') {
            this.previousElementSibling.style.transform = '';
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    // Récupérez la référence du compteur
    var counterElement = document.querySelector('.cards-counter');

    // Récupérez tous les boutons dans la classe "question-card"
    var questionCardsButtons = document.querySelectorAll('.question-card button');

    // Initialisez le compteur à partir de localStorage ou à 15 s'il n'existe pas
    var currentCount = parseInt(localStorage.getItem('counterValue')) || 15;
    counterElement.textContent = currentCount.toString();

    // Ajoutez un gestionnaire d'événement à chaque bouton
    questionCardsButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            // Décrémentez le compteur de 1
            if (currentCount > 0) {
                currentCount--;
                counterElement.textContent = currentCount.toString();

                // Stockez la nouvelle valeur du compteur dans localStorage
                localStorage.setItem('counterValue', currentCount.toString());
            }
        });
    });
});
