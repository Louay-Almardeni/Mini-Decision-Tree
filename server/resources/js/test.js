//--------------- Player ---------------

function loadFile() {
    var file_name = $("#files").children(":selected").val();

    $.get(loadFileUrl, {file: file_name}, function (data) {
        createSection(data);
    });

}

function createSection(data) {

    var panel = document.createElement("div");
    panel.className = "panel panel-default";

    var list = document.createElement("ul");

    data.forEach(function (a) {
        var li = document.createElement("li");
        var txt = document.createTextNode(a.name);
        li.appendChild(txt);
        li.onclick = function () {
            createSection(a.sub);
            this.className = "selected";
        };
        list.appendChild(li);
    });

    panel.appendChild(list);

    document.body.appendChild(panel);
}

//--------------- Builder ---------------

function preventDoubleSubmission() {
    $('#builder').click(function (e) {
        e.preventDefault();
    });
}

function addAlternative() {

    alternatives_count += 1;

    var row = document.createElement("div");
    row.className = "row";

    var label = document.createElement("label");
    label.appendChild(document.createTextNode("Alternative:"));
    row.appendChild(label);

    var input = document.createElement("input");
    input.name = "alternative_" + alternatives_count;
    row.appendChild(input);

    $("#alternatives").append(row);
}

function generateXml() {

    if (!$("#file-name").val()) {
        alert("Cannot generate file without name!");
        return;
    }

    if (!$("#map-name").val()) {
        alert("Map name is required field!");
        return;
    }

    if (!$("#map-to").val()) {
        alert("Map to is required field!");
        return;
    }

    if (!$("#alternative").val()) {
        alert("Must have at least one alternative!");
        return;
    }

    $('#builder').submit();
}