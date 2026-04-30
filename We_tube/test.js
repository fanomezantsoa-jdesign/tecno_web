const videos = document.querySelectorAll(".preview-video");

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