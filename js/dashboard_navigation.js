const urlParams = new URLSearchParams(window.location.search);

const scriptsToLoad = ["js/displaytables.js"];

let isLoading = false;
const slideAnimationDuration = 200;

scriptsToLoad.forEach((script) => {
  $.getScript(script)
    .done(function (script, textStatus) {
      console.log(textStatus);
    })
    .fail(function (jqxhr, settings, exception) {
      console.log("Triggered ajaxError handler.");
    });
});

var selected_page = urlParams.get("page") ? parseInt(urlParams.get("page")) : 2; // the current selected page :3

// Setup the routes :)
var pages = [
  {
    name: "Profils",
    auth: true,
    file: "profils.html",
    script: "profils.js",
    icon: "fa-user",
  },
  {
    name: "Vos plongées",
    auth: true,
    file: "plongees.html",
    script: "plongees.js",
    icon: "fa-ship",
  },
  {
    name: "Nouvelle plongée",
    auth: false,
    file: "nouvelle_plongee.html",
    script: "nouvelle_plongee.js",
    icon: "fa-plus",
  },
  {
    name: "Découvrez",
    auth: false,
    file: "plongees.html",
    script: "decouvrez.js",
    icon: "fa-search",
  },
  {
    name: "Table mn90",
    auth: false,
    file: "table.html",
    script: "table.js",
    icon: "fa-table",
  },
];

function loadNavBar() {
  for (let i = 0; i < pages.length; i++) {
    if (pages[i].auth && !localStorage.getItem("session_id")) {
      continue;
    }
    if ($("#nav-item-" + i).length > 0) {
      $("#nav-item-" + i).attr(
        "class",
        i == selected_page
          ? "bg-blue-900 transform scale-110 bg-opacity-40 flex flex-row items-center justify-center gap-2 hover:opacity-75 transition duration-300 ease-in-out  text-white font-bold py-2 px-4 rounded-full"
          : "flex flex-row items-center justify-center gap-2 hover:opacity-75 transition duration-300 ease-in-out  text-white font-bold py-2 px-4 rounded-full"
      );
      continue;
    }

    $("#bottom-nav-ul").append(
      `<button class="${
        i == selected_page
          ? "bg-blue-900 bg-opacity-40 transform scale-110"
          : ""
      } flex flex-row items-center justify-center gap-2 hover:opacity-75 transition duration-300 ease-in-out  text-white font-bold py-2 px-4 rounded-full" 
      id="nav-item-${i}"          
      onclick="loadPage(${i})">
      <span class="title text-sm">${pages[i].name}</span>
      <i class="fas ${pages[i].icon}"></i>
      </button>`
    );
  }
}

async function loadContent(direction = "right") {
  isLoading = true;
  $("#content").addClass(`slide_out_${direction}`);
  await new Promise((resolve) => setTimeout(resolve, slideAnimationDuration));

  $("#content").removeClass(`slide_out_${direction}`);
  $("#content").empty();
  $("#content").load("templates/" + pages[selected_page].file, function () {
    $("#content").addClass(`slide_in_${direction}`);
    setTimeout(() => {
      $("#content").removeClass(`slide_in_${direction}`);
    }, slideAnimationDuration);

    console.log(`templates/${pages[selected_page].file}`);
    console.log("loading script");

    $.getScript("js/dashboard/" + pages[selected_page].script)
      .done(function (script, textStatus) {
        console.log(textStatus);
        isLoading = false;
      })
      .fail(function (jqxhr, settings, exception) {
        console.log("Triggered ajaxError handler.");
        isLoading = false;
      });
  });
}

function loadPage(page,init=false) {
  if (isLoading || (selected_page == page && !init)) {
    return;
  }

  let direction = page > selected_page ? "left" : "right";

  selected_page = page;
  if (pages[page].auth && !localStorage.getItem("session_id")) {
    loadPage(2);
    return;
  }
  if (page < 0 || page >= pages.length) {
    selected_page = 2;
  }

  loadNavBar();
  updatePageInQuery(page);
  loadContent(direction);
}

function updatePageInQuery(page) {
  let url = new URL(window.location.href);
  url.searchParams.set("page", page);
  window.history.pushState({}, "", url);
}

loadPage(selected_page,true);
