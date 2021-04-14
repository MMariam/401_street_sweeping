<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-csv/0.71/jquery.csv-0.71.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="papaparse.js"></script>
  <style>
    .container-fluid {
      max-width: 30%;
    }
    .fill{
      background-color:rgba(0,0,0,0.6)!important; 
      padding: 15px;
    }
    .press, h1{
      font-family: sans-serif;
      text-align: center;
    }
    body{
      width: 100%;
      color: black;
      background: url('LA.jpg') no-repeat center center fixed; 
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover;
      z-index: -1;
      font-family: sans-serif;
    }


    label{
      font-size:20px;
      color: white;
    }


  </style>

  <title>Los Angeles City Street Sweeping Project</title>

</head>
<body>
  <br><br>
  <h1>Los Angeles City Street Sweeping Project</h1>
  <br><br><br><br>
  <div class="container-fluid fill">
    <form action="directions.php" id="form" method="POST">

      <label for="customRange3" id="Debris" class="form-label">Debris Factor</label>
      <input type="range" class="form-range" id="d" name="d" min="0" max="5" step="0.5" onchange="updateTextInput(this.value);">

      <label for="customRange3" id="Socio" class="form-label">Socioeconomic Factor</label>
      <input type="range" class="form-range" id="s" name="s" min="0" max="5" step="0.5" onchange="updateTextInput(this.value);">

      <label for="customRange3" id="Foliage" class="form-label">Tree Foliage Factor</label>
      <input type="range" class="form-range"id="f" name="f" min="0" max="5" step="0.5" onchange="updateTextInput(this.value);">
      <br>   <br>
      <input type="file" id="files"  class="form-control" accept=".csv" required>
    </div>
    <br>
    <div class="container-fluid press">
      <button type="submit" class="btn btn-dark">Generate</button>
<!--       onclick="loadPage();
 -->    </form>
  </div>

  <div id="parsed_csv_list">

  </div>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>

  <script>

    const inputs = document.getElementById('files');


    function displayHTMLTable(routes){
      var table = "<table class='table'>";
      for(i=0;i<routes.size;i++){
        table+= "<tr>";
        console.log(routes.values().next().value);
        for(j=0;j<routes.values().next().value.length;j++){
          table+= "<td>";
          table+= routes.values().next().value[j];
          table+= "</th>";
        }
        table+= "</tr>";
      }
      table+= "</table>";
      $("#parsed_csv_list").html(table);
    }



    function printCSV(a)
    {
     let route=-1, segment=-1, order=-1;
     let init_route=-1;
     let routes = new Map();
      //routes.set(a[i][j],
      for(let j=0; j<a[0].length; j++)
        { if(a[0][j]== "ROUTE")
      {
       route=j;
       if(a[1][route]!= null)
         init_route=a[1][route];
     }
     else
      if(a[0][j]=="ASSETID")//segment id
       segment=j;
     else
      if(a[0][j]=="ORDER")
       order=j;
   }
   let segments=[];

   for(let i=1; i<a.length; i++) {
    if(a[i][route]==init_route){
      segments[a[i][order]]=a[i][segment];
    }
    else
    {
      routes.set(a[i][route], segments);
      init_route=a[i][route];
      segments=[];
    }

  }

console.log(routes);
var x = document.createElement("input");
// x.setAttribute("type", "hidden");
x.setAttribute("name", "routes");
x.setAttribute("style", "display: none;");

// x.style.visibility="hidden";
// x.style.display="none";
// x.value=routes;
// document.getElementById('form').innerHTML+=x;

let jsonObject = JSON.stringify(a);  
// routes.forEach((value, key) => {  
//     jsonObject[key] = value  
// }); 

//   x.value = JSON.stringify(jsonObject);

x.value=jsonObject;

console.log(x.value);
  document.getElementById('form').appendChild(x);
 }



inputs.addEventListener('change', e => {
  const fileList = inputs.files;
  const theFile = fileList[0];
  Papa.parse(theFile, {
    complete: function(results) {
    //console.log("Finished:", results);
    printCSV(results.data);
  }
});
});


function updateTextInput(val) {
  if(document.getElementById("d").value==val)
    document.getElementById("Debris").innerHTML="Debris Factor: "+val;
  if(document.getElementById("s").value==val)
    document.getElementById("Socio").innerHTML="Socioeconomic Factor: "+val;
  if(document.getElementById("f").value==val)
    document.getElementById("Foliage").innerHTML="Tree Foliage Factor: "+val;
}


function loadPage()
{
 window.location="directions.php";

}




</script>

</body>
</html>