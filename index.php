<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Font Awesome -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- Bootstrap core CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
<!-- Material Design Bootstrap -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.11/css/mdb.min.css" rel="stylesheet">
<!-- Custom CSS -->
<link rel="stylesheet" href="custom.css">

    <title>Hello, world!</title>
  </head>
  <body>

    <div class="container">
      <div class="col-sm-6">
        <h1>Hello, world!</h1>
          <form action="">
            <div class="md-form">
                <input class="select-dropdown" placeholder="Placeholder" type="text" id="search" class="form-control" autocomplete="off">
                <label for="inputPlaceholderEx">Placeholder</label>
                <ul id="results" class="select-options">
              
                </ul>
            </div>
            
            <button type="button" class="btn btn-success">Success</button>
          </form>

      </div>
    </div>

    <!-- JQuery -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.11/js/mdb.min.js"></script>
    
    <script>
      (function() {
    
  var searchElement = document.getElementById('search'),
      results = document.getElementById('results'),
      selectedResult = -1, // Permet de savoir quel résultat est sélectionné : -1 signifie "aucune sélection"
      previousRequest, // On stocke notre précédente requête dans cette variable
      previousValue = searchElement.value; // On fait de même avec la précédente valeur
  
  
  
  function getResults(keywords) { // Effectue une requête et récupère les résultats
  
      var xhr = new XMLHttpRequest();
      xhr.open('GET', './search.php?s='+ encodeURIComponent(keywords));
  
      xhr.addEventListener('readystatechange', function() {
          if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
  
              displayResults(xhr.responseText);
  
          }
      });
  
      xhr.send(null);
  
      return xhr;
  
  }
  
  function displayResults(response) { // Affiche les résultats d'une requête
  
      results.style.display = response.length ? 'block' : 'none'; // On cache le conteneur si on n'a pas de résultats
  
      if (response.length) { // On ne modifie les résultats que si on en a obtenu
  
          response = response.split('|');
          var responseLen = response.length;
  
          results.innerHTML = ''; // On vide les résultats
  
          for (var i = 0, div ; i < responseLen ; i++) {

  
              div = results.appendChild(document.createElement('li'));
              div.innerHTML = response[i];
  
              div.addEventListener('click', function(e) {
                  chooseResult(e.target);
              });
  
          }
  
      }
  
  }
  
  function chooseResult(result) { // Choisi un des résultats d'une requête et gère tout ce qui y est attaché
  
      searchElement.value = previousValue = result.innerHTML; // On change le contenu du champ de recherche et on enregistre en tant que précédente valeur
      results.style.display = 'none'; // On cache les résultats
      result.className = ''; // On supprime l'effet de focus
      selectedResult = -1; // On remet la sélection à "zéro"
      searchElement.focus(); // Si le résultat a été choisi par le biais d'un clique alors le focus est perdu, donc on le réattribue
  
  }
  
  
  
  searchElement.addEventListener('keyup', function(e) {
  
      var divs = results.getElementsByTagName('div');
  
      if (e.keyCode == 38 && selectedResult > -1) { // Si la touche pressée est la flèche "haut"
  
          divs[selectedResult--].className = '';
  
          if (selectedResult > -1) { // Cette condition évite une modification de childNodes[-1], qui n'existe pas, bien entendu
              divs[selectedResult].className = 'result_focus';
          }
  
      }
  
      else if (e.keyCode == 40 && selectedResult < divs.length - 1) { // Si la touche pressée est la flèche "bas"
  
          results.style.display = 'block'; // On affiche les résultats
  
          if (selectedResult > -1) { // Cette condition évite une modification de childNodes[-1], qui n'existe pas, bien entendu
              divs[selectedResult].className = '';
          }
  
          divs[++selectedResult].className = 'result_focus';
  
      }
  
      else if (e.keyCode == 13 && selectedResult > -1) { // Si la touche pressée est "Entrée"
  
          chooseResult(divs[selectedResult]);
  
      }
  
      else if (searchElement.value != previousValue) { // Si le contenu du champ de recherche a changé
  
          previousValue = searchElement.value;
  
          if (previousRequest && previousRequest.readyState < XMLHttpRequest.DONE) {
              previousRequest.abort(); // Si on a toujours une requête en cours, on l'arrête
          }
  
          previousRequest = getResults(previousValue); // On stocke la nouvelle requête
  
          selectedResult = -1; // On remet la sélection à "zéro" à chaque caractère écrit
  
      }
  
  });
  
})();
    </script>
  </body>
</html>