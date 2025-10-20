<?php /* article.php */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Article — CNN Clone</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<style>
body{margin:0;font-family:Arial;background:#0a0e18;color:#fff}
.container{max-width:800px;margin:30px auto;padding:20px;background:#10182b;border-radius:12px}
h1{margin-bottom:6px}
.meta{color:#aaa;margin-bottom:20px}
.commentBox{margin-top:30px}
textarea{width:100%;padding:10px;border:none;border-radius:8px;background:#0b1222;color:#fff}
button{margin-top:10px;background:#e50914;border:none;color:#fff;padding:10px 16px;border-radius:8px;cursor:pointer}
.comment{background:#0b1222;margin-top:12px;padding:10px;border-radius:8px}
</style>
</head>
<body>
<div class="container" id="wrap"></div>

<script>
const qs=new URLSearchParams(location.search);
const id=Number(qs.get("id"));
const data=JSON.parse(localStorage.news||"[]");
const article=data.find(a=>a.id===id);
const w=document.getElementById("wrap");

if(!article){w.innerHTML="<h2>Article not found.</h2>";}
else{
 w.innerHTML=`
 <a href='index.php' style='color:#fff'>← Back</a>
 <h1>${article.title}</h1>
 <div class='meta'>${article.author} — ${article.cat}</div>
 <p>${article.content||article.blurb}</p>
 <div class='commentBox'>
   <h3>Comments</h3>
   <textarea id='txt' placeholder='Write a comment...'></textarea>
   <button onclick='addComment()'>Post</button>
   <div id='comments'></div>
 </div>`;
 loadComments();
}

function loadComments(){
 const c=document.getElementById("comments");
 const arr=JSON.parse(localStorage["comments_"+id]||"[]");
 c.innerHTML=arr.map(x=>`<div class='comment'>${x}</div>`).join("")||"<p>No comments yet.</p>";
}
function addComment(){
 const t=document.getElementById("txt").value.trim();
 if(!t)return alert("Write something first!");
 const arr=JSON.parse(localStorage["comments_"+id]||"[]");
 arr.unshift(t);
 localStorage["comments_"+id]=JSON.stringify(arr);
 document.getElementById("txt").value="";
 loadComments();
}
</script>
</body>
</html>
