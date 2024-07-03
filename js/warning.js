function showWarning(text) {
  //add a div in full screen with the text (bg-red)
  $("body").append('<div class="warning">' + text + "</div>");
  $(".warning").css({
    position: "fixed",
    top: "0",
    left: "0",
    width: "100%",
    height: "100%",
    "background-color": "rgba(255, 0, 0, 0.5)",
    color: "white",
    "font-size": "2em",
    "text-align": "center",
    "padding-top": "20%",
  });

  newConfettiScreen("red");
  newConfettiScreen("red");
  newConfettiScreen("red");

  //remove the div after 2 seconds
  setTimeout(function () {
    $(".warning").remove();
  }, 2000);
}

function isHTMLElement(input) {
  return input.includes("<") || input.includes(">");
}
