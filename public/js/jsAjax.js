function getTricks(){
  var user;

  if (document.getElementById("user") != null) {
    user = true;
  } else {
    user = false;
  }

  const requeteAjax = new XMLHttpRequest();

  var url = "/figures/"+offset;
  requeteAjax.open("GET", url);
  offset += 4;
  requeteAjax.onload = function(){
    const resultat = JSON.parse(requeteAjax.responseText);
    const html = resultat.map(function(trick) {
    var content =`
      <div class="col-lg-3 col-md-4 col-sm-6 portfolio-item">
          <div class="trick-card">
          <div class="card h-100">`;
    if (typeof trick.trickImages[0] !== 'undefined') {
      content += `<img src="uploads/images/${trick.trickImages[0].url}" alt="" style="width:100%">`;
    } else {
      content += `<img src="images/no-image.jpg" alt="" style="width:100%">`;
    }
    content += `
                <div class="card-body">
              <div class="card-title">
                <a href="/figure/${trick.id}">${ trick.name }</a>
              </div>`;
    if (user) {
      content += `
      <div class="icons">
        <a href="wiki/${trick.id}/modifier"> <img src="images/pencil.png"></a>
        <a href="wiki/${trick.id}/supprimer" onclick="return confirm('Etes-vous sûr ?');"> <img src="images/trash.png"></a>
      </div>`;
    }
    content += `
            </div>
          </div>
        </div>
        </div>`;

      return content;
    }).join('');

    const tricks = document.querySelector('.tricks');

    tricks.innerHTML += html;
    //messages.scrollTop = messages.scrollHeight;
    }
    requeteAjax.send();
  }
  var offset = 0;
  getTricks();
  document.getElementById("more").addEventListener('click', function(e) {
    e.preventDefault();//Annuller le comportement par defaut de l'event
    getTricks();
});
