<?php /* add_article.php */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Add Article — CNN Clone</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<style>
body{margin:0;font-family:Arial;background:#0a0e18;color:#fff}
.container{max-width:600px;margin:40px auto;background:#10182b;padding:20px;border-radius:12px}
h1{text-align:center;margin-bottom:20px}
label{display:block;margin:10px 0 4px}
input,select,textarea{width:100%;padding:10px;border:none;border-radius:8px;background:#0b1222;color:#fff}
button{margin-top:20px;padding:10px 16px;border:none;border-radius:8px;background:#e50914;color:#fff;cursor:pointer}
button:hover{opacity:0.9}
</style>
</head>
<body>
<div class="container">
  <h1>Add New Article</h1>
  <label>Title</label>
  <input id="title" placeholder="Enter article title">
  <label>Category</label>
  <select id="cat">
    <option>World</option><option>Tech</option><option>Business</option>
    <option>Sports</option><option>Entertainment</option>
  </select>
  <label>Author</label>
  <input id="author" placeholder="Enter author name">
  <label>Short Description</label>
  <textarea id="blurb" rows="3" placeholder="Short intro..."></textarea>
  <label>Full Content</label>
  <textarea id="content" rows="6" placeholder="Full article text..."></textarea>
  <button onclick="save()">Publish</button>
</div>

<script>
function save(){
 let title=document.getElementById("title").value.trim();
 let cat=document.getElementById("cat").value;
 let author=document.getElementById("author").value.trim();
 let blurb=document.getElementById("blurb").value.trim();
 let content=document.getElementById("content").value.trim();
 if(!title||!author||!blurb||!content)return alert("Please fill all fields.");
 let data=JSON.parse(localStorage.news||"[]");
 let id=Date.now();
 data.unshift({id,title,cat,author,blurb,content,img:cat});
 localStorage.news=JSON.stringify(data);
 alert("Article added!");
 location.href="index.php";
}
</script>
</body>
</html>
