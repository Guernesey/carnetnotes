function valider()
{
  /* Test de la note */
  var elt = document.getElementById('note').value;
  if(elt < 0 OR elt > 20)
  {
    alert("Veuillez entrer des notes comprises entre 0 et 20");
    return;
  }
  /* Test de la civilité */
  var elt = document.getElementById('civilite').value;
  if(elt.length < 5)
  {
    alert("Veuillez indiquer la civilit\351");
    return;
  }