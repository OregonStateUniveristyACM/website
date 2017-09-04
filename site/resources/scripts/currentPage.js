//extend the array class to remove elements that match a string
Array.prototype.clean = function(deleteValue) {
  for (var i = 0; i < this.length; i++) {
    if (this[i] == deleteValue) {
      this.splice(i, 1);
      i--;
    }
  }
  return this;
};
//extend the string class to remove characters that match a regex
String.prototype.strip = function(removeCharacters) {
    var regex = new RegExp(removeCharacters, "gi")
    return this.replace(regex, "");
}

/* returns an object containing:
 url: the full url
 protocol: http or https
 path: localhost or the server
 page: if it lists the html page on the url, list the file name
*/
function getURL() {
    var url = {};
    //get our url
    url.path = window.location.href;
    //split it by / and remove all empty string elements
    var splitURL = url.path.split("/").clean("");
    //the protocol is the first element in the array
    url.protocol = splitURL[0].strip(":");
    //our host is the second element
    url.host = splitURL[1];
    //if the url is long enough to have a page, then get that and remove the html
    if (splitURL.length > 2) {
        url.page = splitURL[2];
    }

    return url;
}

function markCurrentNavTabSelected() {
    var url = getURL();
    var nav = document.getElementsByTagName("nav")[0];
    var links = nav.getElementsByTagName("a");
    for (var x = 0; x < links.length; x++) {
        if (links[x].getAttribute("href") === url.page) {
            links[x].id = "selectedTab";
        }
    }
}

window.onload = function() {
    markCurrentNavTabSelected();
}
