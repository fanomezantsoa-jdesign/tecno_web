const container = document.getElementById("downloads");

let downloads = JSON.parse(localStorage.getItem("downloads")) || [];

downloads.forEach(src => {
  const video = document.createElement("video");
  video.src = src;
  video.controls = true;
  video.style.width = "300px";

  container.appendChild(video);
});