<?php /* category.php — Category & Search results (all inline) */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>CNN Clone — Category</title>
<style>
  :root{ --bg:#0b0f19; --card:#10182b; --muted:#a9b4c7; --text:#ecf1ff; --accent:#e50914; --chip:#1f2740; --shadow:0 10px 30px rgba(0,0,0,.35); --radius:16px; --max:1100px; }
  *{box-sizing:border-box}
  body{margin:0; font-family:system-ui,Inter,Arial; background:linear-gradient(180deg,#0a0e18 0%, #0e1424 100%); color:var(--text)}
  .top{ position:sticky; top:0; z-index:5; background:rgba(10,14,24,.85); backdrop-filter:blur(8px); border-bottom:1px solid #1f2740 }
  .wrap{ max-width:var(--max); margin:0 auto; padding:14px 18px; display:flex; gap:12px; align-items:center }
  .brand{ display:flex; gap:10px; align-items:center; cursor:pointer; font-weight:800 }
  .badge{background:var(--accent); color:#fff; width:32px; height:26px; border-radius:6px; display:grid; place-items:center}
  .crumbs{ margin-left:auto; color:var(--muted); font-size:13px }
  .container{ max-width:var(--max); margin:18px auto; padding:0 18px }
  h1{ margin:8px 0 6px }
  .note{ color:#9fb0d0; margin-bottom:14px }
  .grid{ display:grid; grid-template-columns:repeat(3,1fr); gap:16px }
  @media (max-width:900px){ .grid{ grid-template-columns:1fr 1fr } }
  @media (max-width:620px){ .grid{ grid-template-columns:1fr } }
  .card{ background:var(--card); border:1px solid #1f2740; border-radius:var(--radius); overflow:hidden; display:flex; flex-direction:column }
  .thumb{ aspect-ratio:16/9; background:#0b1222 center/cover no-repeat }
  .pad{ padding:12px }
  .chip{ display:inline-block; background:var(--chip); color:#c6d1e8; padding:6px 10px; border-radius:999px; font-size:12px; margin-bottom:8px }
  .meta{ color:#8ea0c1; font-size:12px; margin-top:8px }
  .btn{ margin-top:10px; padding:10px 14px; border-radius:10px; border:1px solid #2a3453; background:#0b1222; color:#fff; cursor:pointer }
  .toolbar{ display:flex; gap:8px; flex-wrap:wrap; margin-bottom:12px }
  .toolbar .chip{ cursor:pointer }
  .toolbar .chip.active{ outline:2px solid var(--accent) }
  .back{ color:#fff; text-decoration:none; border:1px solid #2a3453; padding:8px 12px; border-radius:10px }
</style>
</head>
<body>
<header class="top">
  <div class="wrap">
    <div class="brand" onclick="location.href='index.php'"><div class="badge">CN</div><div>CNN Clone</div></div>
    <div class="crumbs" id="crumbs">Home ▸ Category</div>
  </div>
</header>

<main class="container">
  <a class="back" href="index.php">← Back to Home</a>
  <h1 id="heading"></h1>
  <div class="note" id="note"></div>

  <div class="toolbar">
    <span class="chip" data-cat="World">World</span>
    <span class="chip" data-cat="Politics">Politics</span>
    <span class="chip" data-cat="Business">Business</span>
    <span class="chip" data-cat="Tech">Tech</span>
    <span class="chip" data-cat="Sports">Sports</span>
    <span class="chip" data-cat="Entertainment">Entertainment</span>
  </div>

  <section class="grid" id="list"></section>
</main>

<script>
  // Same data as index (kept inline by requirement)
  const IMG = (t)=>`url('data:image/svg+xml;utf8,${encodeURIComponent(`<svg xmlns="http://www.w3.org/2000/svg" width="1200" height="675"><defs><linearGradient id="g" x1="0" y1="0" x2="1" y2="1"><stop stop-color="%23131a2a"/><stop offset="1" stop-color="%230b1222"/></linearGradient></defs><rect width="100%" height="100%" fill="url(%23g)"/><text x="50%" y="54%" font-family="Arial" font-size="48" fill="%23ffffff" text-anchor="middle">${t}</text></svg>`)}')`;
  const articles = [
    {id:1,title:"Global markets rally as inflation eases",cat:"Business",author:"A. Farooq",date:"2025-10-10",blurb:"Stocks jump after fresh data shows cooling prices.",image:IMG("Business")},
    {id:2,title:"Breakthrough battery tech promises faster EV charging",cat:"Tech",author:"Sara Khan",date:"2025-10-11",blurb:"New anode design cuts charge time to 10 minutes.",image:IMG("Tech")},
    {id:3,title:"Historic peace talks resume amid fragile ceasefire",cat:"World",author:"David Lee",date:"2025-10-09",blurb:"Negotiators aim to solidify a lasting framework.",image:IMG("World")},
    {id:4,title:"Title race heats up after dramatic late winner",cat:"Sports",author:"Imran Malik",date:"2025-10-12",blurb:"League leaders snatch victory in stoppage time.",image:IMG("Sports")},
    {id:5,title:"Blockbuster sequel sets opening-weekend record",cat:"Entertainment",author:"Nadia Rizvi",date:"2025-10-08",blurb:"Fans flock as critics give strong reviews.",image:IMG("Entertainment")},
    {id:6,title:"New small-business grants target startups",cat:"Business",author:"S. Ahmed",date:"2025-10-07",blurb:"Program focuses on female and youth founders.",image:IMG("Business")},
    {id:7,title:"Wearable health patch tracks glucose non-invasively",cat:"Tech",author:"Maha Yousuf",date:"2025-10-06",blurb:"Pilot shows accuracy comparable to finger-prick tests.",image:IMG("Tech")},
    {id:8,title:"Parliament opens with reform-heavy agenda",cat:"Politics",author:"Z. Iqbal",date:"2025-10-11",blurb:"Debate centers on transparency and digital governance.",image:IMG("Politics")}
  ];
  const fmt = d => new Date(d).toLocaleDateString(undefined,{year:'numeric',month:'short',day:'2-digit'});

  const params = new URLSearchParams(location.search);
  const activeCat = params.get('name');
  const q = params.get('search');

  const heading = document.getElementById('heading');
  const note = document.getElementById('note');
  const list = document.getElementById('list');

  function toArticle(id){ location.href = `article.php?id=${id}`; }

  function render(items, label){
    heading.textContent = label;
    note.textContent = `${items.length} result(s)`;
    list.innerHTML = '';
    items.forEach(a=>{
      const card = document.createElement('article');
      card.className = 'card';
      card.innerHTML = `
        <div class="thumb" style="background-image:${a.image}"></div>
        <div class="pad">
          <span class="chip">${a.cat}</span>
          <h3 style="margin:6px 0 8px">${a.title}</h3>
          <div class="meta">${a.author} • ${fmt(a.date)}</div>
          <button class="btn" onclick="toArticle(${a.id})">Read</button>
        </div>`;
      list.appendChild(card);
    });
  }

  if(q){
    const needle = q.toLowerCase();
    const results = articles.filter(a=> a.title.toLowerCase().includes(needle) || a.blurb.toLowerCase().includes(needle));
    render(results, `Search: “${q}”`);
    document.getElementById('crumbs').textContent = `Home ▸ Search`;
  }else{
    const results = activeCat ? articles.filter(a=> a.cat===activeCat) : articles;
    render(results, activeCat ? `${activeCat}` : 'All');
    document.getElementById('crumbs').textContent = `Home ▸ ${activeCat||'All'}`;
  }

  // Toolbar quick filter
  document.querySelectorAll('.toolbar .chip').forEach(c=>{
    if(c.dataset.cat===activeCat) c.classList.add('active');
    c.onclick = ()=> location.href = `category.php?name=${encodeURIComponent(c.dataset.cat)}`;
  });
</script>
</body>
</html>
