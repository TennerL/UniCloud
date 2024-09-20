

<style>
.modal {
  display: none; 
  position: fixed; 
  z-index: 1; 
  padding-top: 100px; 
  left: 100px;
  top: 0;
  width: 100%; 
  height: 100%; 
  overflow: auto; 
  background-color: rgb(0,0,0); 
  background-color: rgba(0,0,0,0.4); 
}

.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 20%;
  text-align:left;
}

.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
details {
  border:2px solid;
  border-radius: 5px;
  padding: 10px;
  background-color: #444;
}
.links1 {
  color: white;
  margin: 10px;

}
.links {
  width: 100%;
  padding: 1px;
  background-color:#444;
  color:white;
  border-radius: 5px;
  height:44.5px;

  display: flex;
  flex-direction: column; 
}
.response {
  margin:10px;
}

.response1 {
  margin:10px;
 
}
summary {
  color:white;
}
</style>



<div class="mdl-grid">
<div style="" class="mdl-cell mdl-cell--12-col mdl-cell--8-col-tablet">
<div id="response" class="content mdl-typography--text-left response">
</div>
<!-- <div style="" class="mdl-cell mdl-cell--12-col mdl-cell--8-col-tablet">
<div id="response1" class="content mdl-typography--text-left response1"> 

</div> -->
</div>
</div>


<!-- <div class="mdl-grid" style="background-color:#444; border-radius: 5px; margin: 20px; display: flex; justify-content: space-between; align-items: center; padding: 0px !important;">
  <div id="response1" class="mdl-cell mdl-cell--11-col" style="height: 40px; display: flex; align-items: center;">
</div>
<div class="mdl-cell mdl-cell--1-col" style=" display: flex; justify-content: flex-end; align-items: center; padding-right: 8px;">
    <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="actions">
      <i class="material-icons">more_vert</i>
    </button>
    <ul class="mdl-menu mdl-js-menu mdl-js-ripple-effect mdl-menu--bottom-right" for="actions">
      <li class="mdl-menu__item">Delete</li>
    </ul>
  </div>
</div> -->


<div id="response1">
</div>

<button id="view-source" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored mdl-color-text--white">Upload</button>

<div id="myModal" class="modal">
<div class="modal-content" style="text-align:center;">
<span class="close">&times;</span>
<div class="content mdl-typography--text-center"><b>Neuer Upload</b></div>    
<form method="POST">
    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
      <input class="mdl-textfield__input" type="file" id="fileInput" name="fileInput">
      <label class="mdl-textfield__label" for="fileInput"></label>
    </div><br />
    <select name="DdlFolders" id="DdlFolders">
    <option value="0">Kein Ordner</option>
    <option value="1005">BS</option>
    </select>
    <br />
    <progress id="uploadProgress" value="0" max="100"></progress>
    <button style="display:flex; margin:auto;" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" type="button" id="uploadButton">Hochladen</button>
  </form>
</div>
</div> 
</div>


