{{-- Floating "Chat Us" — asisten AI Conweb (ala Kodee Hostinger) --}}
@php
    $cwLogo = $logo ?? null;
    $cwMark = $defaultMark ?? '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="5" r="2.4"/><circle cx="5" cy="18" r="2.4"/><circle cx="19" cy="18" r="2.4"/><path d="M10.3 6.6 6.7 15.4M13.7 6.6l3.6 8.8M7.4 18h9.2"/></svg>';
@endphp
<div id="cw-chat" class="cw" aria-live="polite">
  {{-- Tombol launcher --}}
  <button type="button" id="cw-launcher" class="cw-launcher" aria-label="Buka Chat Us" aria-expanded="false">
    <svg class="cw-ic-chat" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
    <svg class="cw-ic-close" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
  </button>

  {{-- Panel --}}
  <div id="cw-panel" class="cw-panel" role="dialog" aria-label="Chat Us" hidden>
    <header class="cw-head">
      <div class="cw-head-l">
        <span class="cw-avatar">
          @if($cwLogo)<img src="{{ asset('storage/'.$cwLogo) }}" alt="Logo">@else{!! $cwMark !!}@endif
        </span>
        <div>
          <strong class="cw-title">Chat Us</strong>
          <span class="cw-status"><i></i> Asisten Conweb · online</span>
        </div>
      </div>
      <button type="button" class="cw-min" id="cw-min" aria-label="Tutup">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M5 12h14"/></svg>
      </button>
    </header>

    <div class="cw-body" id="cw-body">
      <div class="cw-hello">
        <div class="cw-logo">
          @if($cwLogo)<img src="{{ asset('storage/'.$cwLogo) }}" alt="Logo">@else{!! $cwMark !!}@endif
        </div>
        <h4>Halo! 👋</h4>
        <p>Saya asisten <strong>Conweb</strong>. Tanya apa saja seputar website — layanan, harga, template, domain, sampai cara pesan.</p>
      </div>
      <div class="cw-chips">
        <button type="button" class="cw-chip">Berapa harga paketnya?</button>
        <button type="button" class="cw-chip">Ada template apa saja?</button>
        <button type="button" class="cw-chip">Bagaimana cara pesan?</button>
        <button type="button" class="cw-chip">Apakah dapat domain?</button>
      </div>
    </div>

    <form class="cw-foot" id="cw-form" autocomplete="off">
      @csrf
      <input type="text" id="cw-input" class="cw-input" placeholder="Tanya apa saja ke Conweb…" maxlength="2000" required>
      <button type="submit" class="cw-send" aria-label="Kirim">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2 11 13M22 2l-7 20-4-9-9-4z"/></svg>
      </button>
    </form>
    <p class="cw-note">Chat Us bisa keliru. Cek ulang info penting ya.</p>
  </div>
</div>

<style>
  .cw{position:fixed;right:22px;bottom:22px;z-index:1200;font-family:var(--sans)}
  .cw-launcher{width:60px;height:60px;border-radius:50%;border:none;cursor:pointer;
    background:linear-gradient(135deg,var(--brand),var(--brand-d));color:#fff;
    box-shadow:0 12px 30px rgba(37,99,235,.45);display:grid;place-items:center;
    transition:transform .3s var(--ease),box-shadow .3s var(--ease)}
  .cw-launcher:hover{transform:translateY(-3px) scale(1.04)}
  .cw-launcher svg{width:26px;height:26px;position:absolute;transition:opacity .25s,transform .25s}
  .cw-ic-close{opacity:0;transform:rotate(-90deg) scale(.6)}
  .cw.open .cw-ic-chat{opacity:0;transform:rotate(90deg) scale(.6)}
  .cw.open .cw-ic-close{opacity:1;transform:none}

  .cw-panel{position:absolute;right:0;bottom:78px;width:380px;max-width:calc(100vw - 32px);
    height:560px;max-height:calc(100vh - 120px);background:var(--bg);border:1px solid var(--line);
    border-radius:var(--radius-lg);box-shadow:var(--shadow-lg);display:flex;flex-direction:column;
    overflow:hidden;transform-origin:bottom right;animation:cwIn .32s var(--ease)}
  .cw-panel[hidden]{display:none}
  @keyframes cwIn{from{opacity:0;transform:translateY(14px) scale(.96)}to{opacity:1;transform:none}}

  .cw-head{display:flex;align-items:center;justify-content:space-between;gap:10px;padding:14px 16px;
    background:linear-gradient(135deg,var(--brand),var(--brand-d));color:#fff}
  .cw-head-l{display:flex;align-items:center;gap:11px}
  .cw-avatar{width:38px;height:38px;border-radius:12px;display:grid;place-items:center;overflow:hidden;
    background:rgba(255,255,255,.16)}
  .cw-avatar svg{width:20px;height:20px}
  .cw-avatar img{width:100%;height:100%;object-fit:contain;padding:5px}
  .cw-title{display:block;font-family:var(--display);font-size:15px;line-height:1.2}
  .cw-status{display:flex;align-items:center;gap:6px;font-size:11.5px;color:rgba(255,255,255,.7)}
  .cw-status i{width:7px;height:7px;border-radius:50%;background:var(--ok);box-shadow:0 0 0 3px rgba(34,197,94,.25)}
  .cw-min{background:rgba(255,255,255,.12);border:none;color:#fff;width:30px;height:30px;border-radius:9px;
    cursor:pointer;display:grid;place-items:center}
  .cw-min svg{width:18px;height:18px}

  .cw-body{flex:1;overflow-y:auto;padding:18px 16px;background:var(--soft);display:flex;flex-direction:column;gap:12px}
  .cw-hello{text-align:center;padding:8px 4px 2px}
  .cw-logo{width:48px;height:48px;border-radius:14px;margin:0 auto 10px;display:grid;place-items:center;
    background:var(--brand-tint);color:var(--brand)}
  .cw-logo svg{width:26px;height:26px}
  .cw-logo img{width:30px;height:30px;object-fit:contain}
  .cw-hello h4{font-family:var(--display);color:var(--ink);font-size:18px}
  .cw-hello p{font-size:13px;color:var(--body);margin-top:4px}
  .cw-chips{display:flex;flex-wrap:wrap;gap:8px;margin-top:4px}
  .cw-chip{border:1px solid var(--line-2);background:var(--bg);color:var(--ink-2);font-size:12.5px;
    padding:8px 12px;border-radius:999px;cursor:pointer;transition:.2s}
  .cw-chip:hover{border-color:var(--brand);color:var(--brand);background:var(--brand-tint)}

  .cw-msg{max-width:84%;padding:10px 13px;border-radius:14px;font-size:13.5px;line-height:1.55;white-space:pre-wrap;word-wrap:break-word}
  .cw-msg.user{align-self:flex-end;background:var(--brand);color:#fff;border-bottom-right-radius:4px}
  .cw-msg.bot{align-self:flex-start;background:var(--bg);color:var(--ink-2);border:1px solid var(--line);border-bottom-left-radius:4px}
  .cw-typing{align-self:flex-start;display:flex;gap:4px;padding:12px 14px;background:var(--bg);border:1px solid var(--line);border-radius:14px}
  .cw-typing span{width:7px;height:7px;border-radius:50%;background:var(--muted);animation:cwBlink 1.2s infinite}
  .cw-typing span:nth-child(2){animation-delay:.2s}.cw-typing span:nth-child(3){animation-delay:.4s}
  @keyframes cwBlink{0%,60%,100%{opacity:.25;transform:translateY(0)}30%{opacity:1;transform:translateY(-3px)}}

  .cw-foot{display:flex;align-items:center;gap:8px;padding:12px 14px 6px;background:var(--bg);border-top:1px solid var(--line)}
  .cw-input{flex:1;border:1px solid var(--line-2);border-radius:999px;padding:11px 15px;font-size:13.5px;
    font-family:var(--sans);color:var(--ink);outline:none;transition:.2s}
  .cw-input:focus{border-color:var(--brand);box-shadow:0 0 0 3px var(--brand-tint)}
  .cw-send{width:42px;height:42px;flex:0 0 42px;border:none;border-radius:50%;cursor:pointer;
    background:linear-gradient(135deg,var(--brand),var(--brand-d));color:#fff;display:grid;place-items:center;transition:.2s}
  .cw-send:hover{transform:scale(1.06)}.cw-send:disabled{opacity:.5;cursor:not-allowed;transform:none}
  .cw-send svg{width:18px;height:18px}
  .cw-note{text-align:center;font-size:10.5px;color:var(--muted);padding:2px 0 10px;background:var(--bg)}

  @media (max-width:480px){
    .cw{right:14px;bottom:14px}
    .cw-panel{position:fixed;right:0;left:0;bottom:0;top:0;width:100%;max-width:100%;
      height:100%;max-height:100%;border-radius:0;border:none;animation:cwInMob .3s var(--ease)}
  }
  @keyframes cwInMob{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:none}}
</style>

<script>
(function(){
  const root = document.getElementById('cw-chat');
  const launcher = document.getElementById('cw-launcher');
  const panel = document.getElementById('cw-panel');
  const body = document.getElementById('cw-body');
  const form = document.getElementById('cw-form');
  const input = document.getElementById('cw-input');
  const sendBtn = form.querySelector('.cw-send');
  const minBtn = document.getElementById('cw-min');
  const token = form.querySelector('input[name="_token"]').value;
  const endpoint = @json(route('chat.send'));

  let history = [];
  let busy = false;

  function open(){ root.classList.add('open'); panel.hidden = false; launcher.setAttribute('aria-expanded','true'); setTimeout(()=>input.focus(),120); }
  function close(){ root.classList.remove('open'); panel.hidden = true; launcher.setAttribute('aria-expanded','false'); }
  launcher.addEventListener('click', ()=> root.classList.contains('open') ? close() : open());
  minBtn.addEventListener('click', close);

  function scroll(){ body.scrollTop = body.scrollHeight; }

  function addMsg(text, who){
    const el = document.createElement('div');
    el.className = 'cw-msg ' + who;
    el.textContent = text;
    body.appendChild(el); scroll();
    return el;
  }
  function typing(on){
    let t = document.getElementById('cw-typing');
    if(on){
      if(t) return;
      t = document.createElement('div'); t.id='cw-typing'; t.className='cw-typing';
      t.innerHTML = '<span></span><span></span><span></span>';
      body.appendChild(t); scroll();
    } else if(t){ t.remove(); }
  }

  async function ask(message){
    if(busy || !message.trim()) return;
    busy = true; sendBtn.disabled = true;
    const chips = body.querySelector('.cw-chips'); if(chips) chips.remove();
    const hello = body.querySelector('.cw-hello'); if(hello) hello.remove();

    addMsg(message, 'user');
    history.push({role:'user', content:message});
    input.value=''; typing(true);

    try{
      const res = await fetch(endpoint, {
        method:'POST',
        headers:{'Content-Type':'application/json','X-CSRF-TOKEN':token,'Accept':'application/json'},
        body: JSON.stringify({ message, history: history.slice(-12) })
      });
      typing(false);
      if(!res.ok) throw new Error('HTTP '+res.status);
      const data = await res.json();
      const reply = data.reply || 'Maaf, terjadi kendala. Coba lagi ya.';
      addMsg(reply, 'bot');
      history.push({role:'assistant', content:reply});
    }catch(e){
      typing(false);
      addMsg('Maaf, koneksi ke asisten sedang bermasalah. Coba lagi sebentar ya 🙏', 'bot');
    }finally{
      busy = false; sendBtn.disabled = false; input.focus();
    }
  }

  form.addEventListener('submit', e=>{ e.preventDefault(); ask(input.value); });
  body.querySelectorAll('.cw-chip').forEach(c=> c.addEventListener('click', ()=> ask(c.textContent)));
})();
</script>
