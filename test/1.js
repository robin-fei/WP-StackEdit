"use strict";

function makeEditButton(el) {
    var div = document.createElement("div");
    div.className = "stackedit-button-wrapper";
    div.innerHTML = '<a href="javascript:void(0)"><img src="icon.svg">Edit with StackEdit</a>';
    el.parentNode.insertBefore(div, el.nextSibling);
    return div.getElementsByTagName("a")[0];
}

var textareaEl = document.querySelector("textarea");
makeEditButton(textareaEl).addEventListener("click", function onClick() {
    var stackedit = new Stackedit();
    stackedit.on("fileChange", function onFileChange(file) {
        textareaEl.value = file.content.text;
    });
    stackedit.openFile({
        name: "Markdown with StackEdit",
        content: {
            text: textareaEl.value
        }
    });
});

var htmlEl = document.querySelector(".html");
var markdown = "Hello **Markdown** writer!";

function doOpen(background) {
    var stackedit = new Stackedit();
    stackedit.on("fileChange", function onFileChange(file) {
        markdown = file.content.text;
        htmlEl.innerHTML = file.content.html;
    });
    stackedit.openFile(
        {
            name: "HTML with StackEdit",
            content: {
                text: markdown
            }
        },
        background
    );
}

doOpen(true);
makeEditButton(htmlEl).addEventListener("click", function onClick() {
    doOpen(false);
});
