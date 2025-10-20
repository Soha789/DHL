<?php /* index.php */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>CNN Clone — Home</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<style>
body{margin:0;font-family:Arial;background:#0a0e18;color:#fff}
header{background:#0b1222;padding:14px;display:flex;align-items:center;gap:14px}
.brand{background:#e50914;color:#fff;padding:6px 10px;border-radius:6px;font-weight:bold;cursor:pointer}
nav a{color:#ccc;text-decoration:none;margin-right:10px;padding:6px 10px;border-radius:6px}
nav a:hover{background:#1a1f33;color:#fff}
button.addBtn{margin-left:auto;background:#e50914;border:none;color:#fff;padding:8px 14px;border-radius:8px;cursor:pointer}
.grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:16px;padding:20px}
.card{background:#10182b;padding:14px;border-radius:12px;cursor:pointer;transition:.3s}
.card:hover{transform:translateY(-3px);background:#18213a}
.card h3{margin:6px 0}
footer{text-align:center;padding:10px;color:#999}
</style>
</head>
<body>
<header>
  <div class="brand" onclick="location.href='index.php'">CNN Clone</div>
  <nav>
    <a href="#" onclick="filterCat('World')">World</a>
    <a href="#" onclick="filterCat('Tech')">Tech</a>
    <a href="#" onclick="filterCat('Business')">Business</a>
    <a href="#" onclick="filterCat('Sports')">Sports</a>
    <a href="#" onclick="filterCat('Entertainment')">Entertainment</a>
  </nav>
  <button class="addBtn" onclick="location.href='add_article.php'">Add Article</button>
</header>

<div class="grid" id="newsGrid"></div>

<footer>© 2025 CNN Clone — Demo</footer>

<script>
const sample=[
{id:1,title:"Global markets rally as inflation eases",cat:"Business",author:"A. Farooq",blurb:"Stocks jump after data shows cooling prices.",img:"Business"},
{id:2,title:"Breakthrough battery tech promises faster EV charging",cat:"Tech",author:"Sara Khan",blurb:"New anode design cuts charge time.",img:"Tech"},
{id:3,title:"Historic peace talks resume amid fragile ceasefire",cat:"World",author:"David Lee",blurb:"Negotiators aim to solidify a lasting framework.",img:"World"},
{id:4,title:"Title race heats up after dramatic late winner",cat:"Sports",author:"Imran Malik",blurb:"League leaders snatch victory in stoppage time.",img:"Sports"}
];
if(!localStorage.news){localStorage.setItem("news",JSON.stringify(sample));}

function render(list){
 const grid=document.getElementById("newsGrid");
 grid.innerHTML="";
 list.forEach(n=>{
   const c=document.createElement("div");
   c.className="card";
   c.onclick=()=>location.href='article.php?id='+n.id;
   c.innerHTML=`<div style="font-size:12px;color:#bbb">${n.cat}</div>
                <h3>${n.title}</h3>
                <div style="color:#9fb0d0">${n.author}</div>
                <p style="color:#ccc">${n.blurb}</p>`;
   grid.appendChild(c);
 });
}
function loadAll(){render(JSON.parse(localStorage.news||"[]"));}
function filterCat(cat){
 const data=JSON.parse(localStorage.news||"[]");
 render(data.filter(a=>a.cat===cat));
}
loadAll();
</script>
</body>
</html>
