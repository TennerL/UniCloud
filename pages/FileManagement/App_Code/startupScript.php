    
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
            var folderInput = 0;

    
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

            var fileContainer = document.getElementById("response1");

            jsonData.folders.forEach(file => {
                folders.push(file);
            })
                                  
            jsonData.folders.forEach(folder => {
                let folderContainer = document.getElementById("folderContainer");
                // Container IM Container für die Ordner
                let folderElement = document.createElement("div");
                folderElement.setAttribute("id","folderElement");
                folderElement.style= "background-color:#444; border-radius: 5px; margin-right: 10px; margin-left:10px; margin-bottom:10px; margin-top:10px; display: flex; justify-content: space-between; align-items: center; padding: 0px !important;"
                let folderInnerContent = document.createElement("div")
                folderInnerContent.className = "mdl-cell mdl-cell--11-col"
                folderInnerContent.style = "height: 40px; display: flex; align-items: center;"
                folderInnerContent.innerHTML = "<span class='material-icons'>folder</span>"+folder;

                folderContainer.appendChild(folderElement);
                folderElement.appendChild(folderInnerContent);
            });

            jsonData.files.forEach(files => {
                var fileElement = document.createElement("div");
                fileElement.className = "mdl-grid"; // Adding class name
                fileElement.setAttribute("id","fileElement"+files.ID);
                fileElement.style = "background-color:#444; border-radius: 5px; margin-right: 10px; margin-left:10px; margin-bottom:10px; display: flex; justify-content: space-between; align-items: center; padding: 0px !important;";
                fileElement.innerHTML = "<div id='response1' class='mdl-cell mdl-cell--11-col' style='height: 40px; display: flex; align-items: center;'>" +
                    "<ul style='margin: 0; padding: 0; list-style-type: none;'><li><a style='text-decoration: none; color: white;' href='" + $URL + files.KeyDir + "/" + files.FileName + "'>" + files.FileName + "</a></li></ul></div>" +
                    "<div class='mdl-cell mdl-cell--1-col' style=' display: flex; justify-content: flex-end; align-items: center; padding-right: 8px;'>" +
                    "<button class='mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon download id='btnDownload'>"+
                    "<button onclick='DeleteFile(\"" + files.FileName + "\", \"" + files.KeyDir + "\")'>delete</button>"+
                    "</div></div>";
                            
                fileContainer.appendChild(fileElement);
                $(fileElement).draggable({axis: "y"});

                $(function() {
                    $("#folderElement").droppable({
                        drop: function(event, ui) {
                            moveFile(files.FileName,"")
                        }
                    });
                });
                
            }); 

        
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
});


    function moveFile(filename, foldername){
        console.log(filename + foldername);
    }



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






