"use strict";

const dev = false;

function ajaxRequest(
  type,
  url,
  successCallback,
  errorCallback,
  data = null,
  auth = false,
) {
  if (dev) {
    url = "/ProjetNantes/" + url;
  }

  let xhr;
  // Create XML HTTP request.
  xhr = new XMLHttpRequest();
  if (type == "GET" && data != null) url += "?" + data;
  xhr.open(type, url);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  if (auth && localStorage.getItem("session_id")) {
    xhr.setRequestHeader(
      "Authorization",
      "Bearer " + localStorage.getItem("session_id"),
    );
  }

  xhr.onload = () => {
    switch (xhr.status) {
      case 200:
      case 201:
        let data = JSON.parse(xhr.responseText);
        data = avoidXSS(data);
        successCallback(data);
        break;
      default:
        errorCallback(xhr.status);
    }
  };

  // Send XML HTTP request.
  xhr.send(data);
}

// pour éviter les attaques XSS des petits malins de la classe
function avoidXSS(data) {
  for (let key in data) {
    if (typeof data[key] === "string") {
      try {
        //remplace juste les < et >
        data[key] = data[key].replace(/</g, "&lt;").replace(/>/g, "&gt;");
      } catch (e) {
        continue;
      }
    } else if (typeof data[key] === "object") {
      data[key] = avoidXSS(data[key]);
    }
  }
  return data;
}
