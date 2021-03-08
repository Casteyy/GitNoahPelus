var score = 0;
var total = 9; // total de points
var points = 1; // points par question
var max = total * points;


function init() {
  //définit les bonnes réponses
  sessionStorage.setItem('a1', 'b');
  sessionStorage.setItem('a2', 'a');
  sessionStorage.setItem('a3', 'a');
  sessionStorage.setItem('a4', 'c');
  sessionStorage.setItem('a5', 'a');
  sessionStorage.setItem('a6', 'b');
  sessionStorage.setItem('a7', 'b');
  sessionStorage.setItem('a8', 'd');
  sessionStorage.setItem('a9', 'd');

}

$(document).ready(function() {
  // cacher les questions
  $(".questionForm").hide();

  // afficher la 1ere question
  $("#q1").show();

  //soumettre les réponses
  $('.questionForm #submit').click(function() {
    //avoir les attribut du data
    current = $(this).parents('form:first').data('question');
    next = $(this).parents('form:first').data('question') + 1;
    // cacher les questions
    $(".questionForm").hide();
    //montrer la question suivante
    $('#q' + next + '').fadeIn(300);
    process('' + current + '');
    return false;
  });

}); 

// Traiter les réponses
function process(n) {

  // Obtenir la réponse choisit
  var submitted = $('input[name=q' + n + ']:checked').val();
  if (submitted == sessionStorage.getItem('a' + n + '')) {
    score = score + points;
  }

  if (n == total) {
    $('#results').html('<h3>Votre score final est de: ' + score + ' sur ' + max );

  }
  return false;
} 

