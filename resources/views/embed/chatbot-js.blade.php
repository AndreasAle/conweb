@php
  if (! $template) {
      // Template tidak ditemukan / chatbot nonaktif → skrip tidak melakukan apa-apa.
      echo "/* Conweb chatbot: template tidak aktif */";
      return;
  }
  $biz = $template->chatbot_business_name ?: $template->name;
  $primary = $template->primary_color ?: '#2563eb';
  $cfg = [
      'slug'          => $template->slug,
      'endpoint'      => $endpoint,
      'title'         => $biz,
      'status'        => 'Asisten '.$biz,
      'greetingTitle' => 'Hai! Selamat datang di '.$biz.' 👋',
      'greeting'      => $template->chatbot_greeting ?: 'Tanya apa saja soal produk, harga, jam buka, atau cara pesan ya.',
      'chips'         => ['Ada produk/menu apa?', 'Berapa harganya?', 'Jam buka?', 'Cara pesan?'],
      'primary'       => $primary,
      'placeholder'   => 'Tanya '.$biz.'…',
  ];
@endphp
(function(){
  if (window.__conwebChatLoaded__) return;
  window.__conwebChatLoaded__ = true;

  var CFG = {!! json_encode($cfg, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) !!};
  var history = [];
  var busy = false, panelOpen = false;

  var css = ''
  + '.cwe{position:fixed;right:20px;bottom:20px;z-index:2147483000;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial,sans-serif}'
  + '.cwe *{box-sizing:border-box}'
  + '.cwe-btn{width:60px;height:60px;border-radius:50%;border:none;cursor:pointer;color:#fff;display:flex;align-items:center;justify-content:center;box-shadow:0 12px 30px rgba(0,0,0,.28);transition:transform .25s}'
  + '.cwe-btn:hover{transform:translateY(-3px) scale(1.05)}'
  + '.cwe-btn svg{width:26px;height:26px}'
  + '.cwe-panel{position:absolute;right:0;bottom:76px;width:370px;max-width:calc(100vw - 32px);height:540px;max-height:calc(100vh - 120px);background:#fff;border-radius:20px;box-shadow:0 28px 64px rgba(0,0,0,.28);display:none;flex-direction:column;overflow:hidden;animation:cweIn .3s ease}'
  + '.cwe-panel.on{display:flex}'
  + '@keyframes cweIn{from{opacity:0;transform:translateY(14px) scale(.97)}to{opacity:1;transform:none}}'
  + '.cwe-head{display:flex;align-items:center;justify-content:space-between;gap:10px;padding:14px 16px;color:#fff}'
  + '.cwe-hl{display:flex;align-items:center;gap:11px}'
  + '.cwe-av{width:38px;height:38px;border-radius:11px;background:rgba(255,255,255,.18);display:flex;align-items:center;justify-content:center}'
  + '.cwe-av svg{width:20px;height:20px}'
  + '.cwe-title{font-weight:700;font-size:15px;line-height:1.2}'
  + '.cwe-status{font-size:11.5px;opacity:.85;display:flex;align-items:center;gap:6px}'
  + '.cwe-status i{width:7px;height:7px;border-radius:50%;background:#22c55e;display:inline-block}'
  + '.cwe-min{background:rgba(255,255,255,.15);border:none;color:#fff;width:30px;height:30px;border-radius:9px;cursor:pointer;font-size:18px;line-height:1}'
  + '.cwe-body{flex:1;overflow-y:auto;padding:16px;background:#f5f8ff;display:flex;flex-direction:column;gap:11px}'
  + '.cwe-hello{text-align:center;padding:6px 4px}'
  + '.cwe-hello h4{margin:0 0 4px;font-size:17px;color:#0a1633}'
  + '.cwe-hello p{margin:0;font-size:13px;color:#4b5a78}'
  + '.cwe-chips{display:flex;flex-wrap:wrap;gap:8px;justify-content:center;margin-top:2px}'
  + '.cwe-chip{border:1px solid #d9e2f2;background:#fff;color:#1c2a4a;font-size:12.5px;padding:8px 12px;border-radius:999px;cursor:pointer}'
  + '.cwe-chip:hover{border-color:currentColor}'
  + '.cwe-msg{max-width:84%;padding:10px 13px;border-radius:14px;font-size:13.5px;line-height:1.55;white-space:pre-wrap;word-wrap:break-word}'
  + '.cwe-msg.u{align-self:flex-end;color:#fff;border-bottom-right-radius:4px}'
  + '.cwe-msg.b{align-self:flex-start;background:#fff;color:#1c2a4a;border:1px solid #e6ecf7;border-bottom-left-radius:4px}'
  + '.cwe-typ{align-self:flex-start;display:flex;gap:4px;padding:12px 14px;background:#fff;border:1px solid #e6ecf7;border-radius:14px}'
  + '.cwe-typ span{width:7px;height:7px;border-radius:50%;background:#8190ab;animation:cweBl 1.2s infinite}'
  + '.cwe-typ span:nth-child(2){animation-delay:.2s}.cwe-typ span:nth-child(3){animation-delay:.4s}'
  + '@keyframes cweBl{0%,60%,100%{opacity:.25}30%{opacity:1}}'
  + '.cwe-foot{display:flex;gap:8px;padding:12px 14px;background:#fff;border-top:1px solid #e6ecf7}'
  + '.cwe-in{flex:1;border:1px solid #d9e2f2;border-radius:999px;padding:11px 15px;font-size:13.5px;outline:none;color:#0a1633}'
  + '.cwe-send{width:42px;height:42px;flex:0 0 42px;border:none;border-radius:50%;color:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center}'
  + '.cwe-send svg{width:18px;height:18px}'
  + '.cwe-note{text-align:center;font-size:10px;color:#8190ab;padding:0 0 8px;background:#fff;margin:0}'
  + '@media (max-width:480px){.cwe-panel{position:fixed;inset:0;width:100%;max-width:100%;height:100%;max-height:100%;border-radius:0}}';

  var st = document.createElement('style'); st.textContent = css; document.head.appendChild(st);

  var esc = function(s){ var d=document.createElement('div'); d.textContent=s; return d.innerHTML; };
  var P = CFG.primary;

  var root = document.createElement('div');
  root.className = 'cwe';
  root.innerHTML =
    '<div class="cwe-panel">'
    + '<div class="cwe-head" style="background:linear-gradient(135deg,'+P+',#0a1530)">'
      + '<div class="cwe-hl"><span class="cwe-av"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg></span>'
      + '<div><div class="cwe-title">'+esc(CFG.title)+'</div><div class="cwe-status"><i></i> '+esc(CFG.status)+' · online</div></div></div>'
      + '<button class="cwe-min" aria-label="Tutup">–</button>'
    + '</div>'
    + '<div class="cwe-body"><div class="cwe-hello"><h4>'+esc(CFG.greetingTitle)+'</h4><p>'+esc(CFG.greeting)+'</p></div><div class="cwe-chips"></div></div>'
    + '<div class="cwe-foot"><input class="cwe-in" placeholder="'+esc(CFG.placeholder)+'" maxlength="2000"><button class="cwe-send" style="background:linear-gradient(135deg,'+P+',#0a1530)" aria-label="Kirim"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2 11 13M22 2l-7 20-4-9-9-4z"/></svg></button></div>'
    + '<p class="cwe-note">Ditenagai ConWeb AI · cek ulang info penting</p>'
    + '</div>'
    + '<button class="cwe-btn" style="background:linear-gradient(135deg,'+P+',#0a1530)" aria-label="Chat"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg></button>';

  document.body.appendChild(root);

  var panel = root.querySelector('.cwe-panel');
  var launch = root.querySelector('.cwe-btn');
  var minb = root.querySelector('.cwe-min');
  var body = root.querySelector('.cwe-body');
  var input = root.querySelector('.cwe-in');
  var sendb = root.querySelector('.cwe-send');
  var chipWrap = root.querySelector('.cwe-chips');

  CFG.chips.forEach(function(txt){
    var b = document.createElement('button'); b.className='cwe-chip'; b.style.color=P; b.textContent=txt;
    b.onclick = function(){ ask(txt); };
    chipWrap.appendChild(b);
  });

  function toggle(){ panelOpen=!panelOpen; panel.classList.toggle('on',panelOpen); if(panelOpen) setTimeout(function(){input.focus();},100); }
  launch.onclick = toggle; minb.onclick = toggle;

  function scroll(){ body.scrollTop = body.scrollHeight; }
  function addMsg(t,who){ var e=document.createElement('div'); e.className='cwe-msg '+who; if(who==='u') e.style.background=P; e.textContent=t; body.appendChild(e); scroll(); }
  function typing(on){ var t=root.querySelector('.cwe-typ'); if(on){ if(t)return; t=document.createElement('div'); t.className='cwe-typ'; t.innerHTML='<span></span><span></span><span></span>'; body.appendChild(t); scroll(); } else if(t){ t.remove(); } }

  function ask(msg){
    msg=(msg||'').trim(); if(busy||!msg) return; busy=true; sendb.disabled=true;
    var h=body.querySelector('.cwe-hello'); if(h)h.remove();
    var c=body.querySelector('.cwe-chips'); if(c)c.remove();
    addMsg(msg,'u'); history.push({role:'user',content:msg}); input.value=''; typing(true);
    fetch(CFG.endpoint,{method:'POST',headers:{'Content-Type':'application/json','Accept':'application/json'},
      body:JSON.stringify({template:CFG.slug,message:msg,history:history.slice(-12)})})
    .then(function(r){ return r.json(); })
    .then(function(d){ typing(false); var rep=(d&&d.reply)||'Maaf, terjadi kendala. Coba lagi ya.'; addMsg(rep,'b'); history.push({role:'assistant',content:rep}); })
    .catch(function(){ typing(false); addMsg('Maaf, koneksi bermasalah. Coba lagi sebentar ya 🙏','b'); })
    .then(function(){ busy=false; sendb.disabled=false; input.focus(); });
  }

  sendb.onclick = function(){ ask(input.value); };
  input.addEventListener('keydown', function(e){ if(e.key==='Enter'){ e.preventDefault(); ask(input.value); } });
})();
