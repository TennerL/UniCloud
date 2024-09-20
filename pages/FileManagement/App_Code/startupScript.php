    var modal = document.getElementById("myModal");
    var btn = document.getElementById("view-source");
    var span = document.getElementsByClassName("close")[0];

    btn.onclick = function() {
    modal.style.display = "block";
    }
    span.onclick = function() {
    modal.style.display = "none";
    }
    window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }

    }

    $(document).ready(function() {
        $("#uploadButton").click(function() {
            var formData = new FormData();
            var fileInput = document.getElementById("fileInput").files[0];
            var folderInput = document.getElementById("DdlFolders").value;

    
            formData.append("fileInput", fileInput);
            formData.append("DdlFolders", folderInput); 

            console.log(formData);
    
            var progressBar = document.getElementById("uploadProgress");
    
            $.ajax({
                url: "Script/upload.php",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
    
                    // Überwache den Upload-Fortschritt
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = (evt.loaded / evt.total) * 100;
                            progressBar.value = percentComplete;
                        }
                    }, false);
    
                    return xhr;
                },
                success: function(response) {
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    });

    const fileNames = [];
    const keyDir = [];
    const folderID = [];

    const folders = [];

    var $URL = "../../uploads/";

    $(document).ready(function() {
    var token = '<?php echo $_SESSION["id"]; ?>'
    var authData = {"token": token}
    
    $.ajax({
        url: "https://nihonsaba.net/TokenApi/api/Auth",
        type: "POST",
        data: JSON.stringify(authData),
        processData: false, 
        contentType: "application/json", 
        success: function(response) {
            var jsonData = JSON.parse(response);
            console.log(jsonData);
            jsonData.files.forEach(file => {
                fileNames.push(file.FileName);
                keyDir.push(file.KeyDir);
                folderID.push(file.FolderName)
            });
            var renonseContainer = document.getElementById("response");
            var renonseContainer1 = document.getElementById("response1");

            jsonData.folders.forEach(file => {
                folders.push(file);
            })
                                  
            jsonData.folders.forEach(folder => {
                var folderContent = "";

                for (var i = 0; i < fileNames.length; i++) {
                    if (folderID[i] == folder) {
                        folderContent += "<a class='links1' href='" + $URL + keyDir[i] + "/" + fileNames[i] + "'>" + fileNames[i] + "</a><br />";
                    }
                }

                if (folderContent !== "") {
                    var folderElement = document.createElement("div");
                    folderElement.className = "mdl-grid folderElement";

                    var details = document.createElement("details");
                    var summary = document.createElement("summary");
                    summary.textContent = folder;
                    details.appendChild(summary);
                    details.innerHTML += folderContent;

                    renonseContainer.appendChild(details);
                    renonseContainer.appendChild(folderElement);

                    $(folderElement).droppable();
                }
            });

            for (i = 0; i < fileNames.length; i++){
                if (folderID[i] == "") {
                    var fileElement = document.createElement("div");
                    fileElement.className = "mdl-grid fileElement"; // Adding class name
                    fileElement.style = "background-color:#444; border-radius: 5px; margin-right: 10px; margin-left:10px; margin-bottom:10px; display: flex; justify-content: space-between; align-items: center; padding: 0px !important;";
                    fileElement.innerHTML = "<div id='response1' class='mdl-cell mdl-cell--11-col' style='height: 40px; display: flex; align-items: center;'>" +
                        "<ul style='margin: 0; padding: 0; list-style-type: none;'><li><a style='text-decoration: none; color: white;' href='" + $URL + keyDir[i] + "/" + fileNames[i] + "'>" + fileNames[i] + "</a></li></ul></div>" +
                        "<div class='mdl-cell mdl-cell--1-col' style=' display: flex; justify-content: flex-end; align-items: center; padding-right: 8px;'>" +
                        "<button class='mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon download id='btnDownload'>"+
                        "<i class='material-icons'>download</i>" +
                        "<button class='mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon actions' id='actions" + i + "'>" +
                        "<i class='material-icons'>more_vert</i>" +
                        "</button>" +
                        "<ul class='mdl-menu mdl-js-menu mdl-js-ripple-effect mdl-menu--bottom-right' for='actions" + i + "'>" +
                        "<li class='mdl-menu__item' onclick='DeleteFile(\"" + fileNames[i] + "\", \"" + keyDir[i] + "\")'>Delete " + fileNames[i] + "</li>"
                        "</ul>" +
                        "</div></div>";
                    renonseContainer1.appendChild(fileElement);
                    $(fileElement).draggable({axis: "y"});
                }
            }
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
});

    function DeleteFile(fileName, keyDir) {
        var formData = new FormData();
    
        formData.append("FileName", fileName);
        formData.append("KeyDir", keyDir);
    
        var xhr = new XMLHttpRequest();
    
        $.ajax({
            url: "Script/delete.php",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,

            success: function(response) {
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    };

    $(function() {
        $("#fileElement").draggable();
    });
    $(function() {
        $("#folderElement").droppable({
            drop: function(event, ui) {
                console.log("Element wurde in den Ordner abgelegt");
            }
        });
    });