function newConfettiScreen(color = "blue") {
  //Create a canvas confetti
  const canvas = document.createElement("canvas");
  canvas.id = "canvas";
  canvas.style.position = "fixed";
  canvas.style.zIndex = "100";
  canvas.style.pointerEvents = "none";
  canvas.style.top = "0";
  canvas.style.left = "0";
  canvas.style.width = "100%";
  canvas.style.height = "100%";
  canvas.style.zIndex = "1000";
  document.body.appendChild(canvas);
  const myConfetti = confetti.create(canvas, {
    resize: true,
    useWorker: true,
  });

  let colors = ["#00f", "#0ff", "#f0f"];
  switch (color) {
    case "blue":
      colors = ["#00f", "#0ff", "#f0f"];
      break;
    case "red":
      colors = ["#FF0000", "#f5424b", "#63060b"];
      break;
  }

  myConfetti({
    particleCount: 100,
    spread: 160,
    colors: colors,
    origin: { y: 0.6 },
  });
}
