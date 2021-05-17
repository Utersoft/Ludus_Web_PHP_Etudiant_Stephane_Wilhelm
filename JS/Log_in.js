//Si l'utilisateur veut rentrer plus que 4 chiffres, il sera bloqué
function codeNombre(codeRecup) {
    var loginWindow = document.getElementById("loginSpace");
    
    if(loginWindow.value.length < 4){
        loginWindow.value = loginWindow.value + codeRecup.innerHTML;
    }
}

//Permet au bouton effacer, d'effacer le mot de passe puisqu'il est en lecture seulement
function effacerLogin() {
    var loginWindow = document.getElementById("loginSpace");
    
    loginWindow.value = "";
}

//Une fonction qui prend 10 chiffres (de 0 à 9) et qui les déplacent de manière aléatoires dans un tableau et qui renvoit le tableau ) la fin
function nbAleatoires(array){
    var i = array.length,
        j = 0,
        temp;

    while (i--) {

        j = Math.floor(Math.random() * (i+1));

        temp = array[i];
        array[i] = array[j];
        array[j] = temp;

    }

    return array;
}