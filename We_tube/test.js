// Hamburger Menu Toggle
const hamburger = document.getElementById('hamburger');
const menu = document.getElementById('menu');

if (hamburger) {
  hamburger.addEventListener('click', () => {
    menu.classList.toggle('active');
  });

  // Fermer le menu quand on clique sur un lien
  menu.addEventListener('click', (e) => {
    if (e.target.tagName === 'A') {
      menu.classList.remove('active');
    }
  });

  // Fermer le menu quand la fenêtre est redimensionnée au-dessus de 768px
  window.addEventListener('resize', () => {
    if (window.innerWidth > 768) {
      menu.classList.remove('active');
    }
  });
}

const videos = document.querySelectorAll(".preview-video");
const header = document.querySelector('header');
const footer = document.querySelector('footer');
const corps = document.querySelector('.corps');

function adjustLayoutSpacing() {
  if (!header || !corps) return;

  const headerHeight = header.offsetHeight;
  const footerHeight = footer ? footer.offsetHeight : 0;

  corps.style.paddingTop = `${headerHeight + 20}px`;
  corps.style.paddingBottom = `${footerHeight + 20}px`;
}

window.addEventListener('load', adjustLayoutSpacing);
window.addEventListener('resize', adjustLayoutSpacing);

videos.forEach(video => {
  video.addEventListener("mouseenter", () => {
    video.play();
  });

  video.addEventListener("mouseleave", () => {
    video.pause();
    video.currentTime = 0; // remet au début
  });
});

function downloadVideo(btn) {
  const container = btn.closest(".video1");
  const video = container.querySelector("video");
  const source = video.querySelector("source").src;

  let downloads = JSON.parse(localStorage.getItem("downloads")) || [];

  if (!downloads.includes(source)) {
    downloads.push(source);
    localStorage.setItem("downloads", JSON.stringify(downloads));
    alert("Ajouté aux téléchargements !");
  }
}


// barre de recherche
// Récupère ce que l'utilisateur entre
const input = document.querySelector('input');
const video1  = document.querySelectorAll('.video1');

input.addEventListener('input',(e)=>{
    let content = e.target.value;
video1.forEach((vide)=>{
    if(vide.textContent.indexOf(content)>=0){
      vide.style.display="";
    }
    else{
      vide.style.display="none";

    }
})

})

// Modal pour lecture vidéo en plein écran
const modal = document.getElementById('videoModal');
const modalVideo = document.getElementById('modalVideo');
const modalVideoSource = document.getElementById('modalVideoSource');
const closeBtn = document.querySelector('.close');

// Ouvrir le modal quand on clique sur une vidéo
document.querySelectorAll('.video1').forEach(container => {
    const video = container.querySelector('video');
    const downloadBtn = container.querySelector('.btn');

    // Cliquer sur la vidéo (pas sur le bouton de téléchargement)
    video.addEventListener('click', (e) => {
        if (!e.target.closest('.btn')) {
            e.preventDefault();
            const source = video.querySelector('source').src;

            // Mettre à jour le modal
            modalVideoSource.src = source;
            modalVideo.load();

            // Afficher le modal (sidebar)
            modal.classList.add('active');
            corps.classList.add('sidebar-active');
            document.body.style.overflow = 'hidden'; // Empêcher le scroll

            // Démarrer la lecture
            modalVideo.play();
        }
    });

    // Cliquer sur le conteneur texte (pas sur le bouton)
    container.querySelector('.texte').addEventListener('click', (e) => {
        if (!e.target.closest('.btn')) {
            const source = video.querySelector('source').src;

            // Mettre à jour le modal
            modalVideoSource.src = source;
            modalVideo.load();

            // Afficher le modal (sidebar)
            modal.classList.add('active');
            corps.classList.add('sidebar-active');
            document.body.style.overflow = 'hidden'; // Empêcher le scroll

            // Démarrer la lecture
            modalVideo.play();
        }
    });
});

// Fermer le modal
closeBtn.addEventListener('click', closeModal);
modal.addEventListener('click', (e) => {
    if (e.target === modal) {
        closeModal();
    }
});

// Fermer avec la touche Échap
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && modal.classList.contains('active')) {
        closeModal();
    }
});

function closeModal() {
    modal.classList.remove('active');
    corps.classList.remove('sidebar-active');
    document.body.style.overflow = 'auto'; // Réactiver le scroll
    modalVideo.pause();
    modalVideo.currentTime = 0;
}
