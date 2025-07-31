<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="dark">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Gerenciador de Filmes</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    :root{
      --bg-0: #0b0d10;
      --bg-1: #11161b;
      --bg-2: #151b22;
      --line: #202832;
      --txt:  #e6f1ee;
      --muted:#96a3a1;
      --accent:#00e676;
      --accent-2:#2df598;

      --bs-body-bg: var(--bg-0);
      --bs-body-color: var(--txt);
      --bs-border-color: var(--line);
      --bs-primary: var(--accent);
      --bs-link-color: var(--accent);

      --radius: 14px;
      --radius-pill: 999px;
      --shadow-1: 0 10px 30px rgba(0,0,0,.45);
      --shadow-2: 0 16px 44px rgba(0,0,0,.6);
      --glow: 0 0 0 .25rem rgba(0, 230, 118, .18);
    }

    html, body { height: 100%; }
    body{
  margin: 0;
  padding-top: 0;
  background:
    radial-gradient(1200px 800px at 20% -10%, rgba(0,230,118,.06), transparent 60%),
    radial-gradient(1000px 700px at 110% 10%, rgba(0,230,118,.05), transparent 60%),
    radial-gradient(900px 700px at 50% 120%, rgba(0,230,118,.05), transparent 65%),
    var(--bg-0);
  background-attachment: fixed, fixed, fixed, fixed;
  color: var(--txt);
}

    #titulo{
      font-weight: 800;
      letter-spacing: .3px;
      margin-bottom: 1.25rem !important;
      background: linear-gradient(180deg, #fff, #cfe9e3 70%, #a8cdbf);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
    }

    .cadastro-wrapper{ max-width: 720px; margin: 0 auto; }
    #form-cadastro{
      border-radius: var(--radius);
      box-shadow: var(--shadow-1);
      transition: box-shadow .2s ease, transform .2s ease, border-color .2s ease;
      background: var(--bg-1);
      border: 1px solid var(--line);
    }
    #form-cadastro:hover{ box-shadow: var(--shadow-2); transform: translateY(-1px); }

    #aviso-edicao{
      margin-bottom: 12px;
      border-left: 3px solid var(--accent);
      background: linear-gradient(90deg, rgba(0,230,118,.12), transparent);
      color: var(--txt);
    }
    .editando{
      border: 1px solid rgba(0,230,118,.35);
      background: linear-gradient(180deg, rgba(0,230,118,.03), rgba(0,0,0,.0));
    }

    .form-control, .form-select{
      border-radius: 12px;
      background: var(--bg-2);
      border: 1px solid #1c232c;
      color: var(--txt);
    }
    .form-control:focus, .form-select:focus{
      border-color: var(--accent);
      box-shadow: var(--glow);
    }
    .input-group .btn{ border-radius: 12px; }
    .input-group .btn:hover{ filter: brightness(1.02); }

    .btn-success, .btn-primary{
      --bs-btn-bg: var(--accent);
      --bs-btn-border-color: var(--accent);
      --bs-btn-hover-bg: #00d46e;
      --bs-btn-hover-border-color: #00d46e;
      --bs-btn-color: #0b120f;
      border: none;
      border-radius: 12px;
      box-shadow: 0 8px 24px rgba(0,230,118,.18);
      transition: transform .06s ease, box-shadow .2s ease, filter .2s ease;
    }
    .btn-success:hover, .btn-primary:hover{ box-shadow: 0 12px 28px rgba(0,230,118,.28); }
    .btn-success:active, .btn-primary:active{ transform: translateY(1px); }

    .btn-outline-primary{
      --bs-btn-color: var(--accent);
      --bs-btn-border-color: var(--accent);
      --bs-btn-hover-color: #0b120f;
      --bs-btn-hover-bg: var(--accent);
      --bs-btn-hover-border-color: var(--accent);
      border-radius: 12px;
    }

    #grupo-busca{
      width: clamp(26ch, 32ch + 2vw, 40ch);
      margin: 0;
      margin-right: auto;
      background: var(--bg-1);
      border-radius: var(--radius-pill);
      border: 1px solid var(--line);
    }
    #grupo-busca .form-control{
      border-radius: var(--radius-pill) 0 0 var(--radius-pill) !important;
      background: transparent;
      border: none;
    }
    #grupo-busca .btn{
      border-radius: 0 var(--radius-pill) var(--radius-pill) 0 !important;
    }
    #grupo-busca:focus-within{
      box-shadow: var(--glow);
    }

    #tabela-filmes{ border-radius: 12px; overflow: hidden; background: var(--bg-1); }
    #tabela-filmes thead{
      position: sticky; top: 0; z-index: 1;
      background: var(--bg-2);
      color: var(--txt);
      border-bottom: 1px solid var(--line);
    }
    #tabela-filmes tbody tr{
      transition: background-color .15s ease, transform .12s ease;
      border-color: var(--line);
    }
    #tabela-filmes tbody tr:hover{
      background: rgba(0,230,118,.06);
      transform: translateY(-1px);
    }
    #tabela-filmes td, #tabela-filmes th{ border-color: var(--line); }
    #tabela-filmes td:last-child .btn{ border-radius: 10px; }

    .grid-filmes{ display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 16px; }
    .card-filme{
      border: 1px solid var(--line);
      border-radius: 14px;
      overflow: hidden;
      box-shadow: var(--shadow-1);
      background: var(--bg-1);
      transition: transform .15s ease, box-shadow .2s ease, border-color .2s ease;
    }
    .card-filme:hover{ transform: translateY(-2px); box-shadow: var(--shadow-2); border-color: rgba(0,230,118,.3); }
    .card-filme img{ width: 100%; height: 320px; object-fit: cover; background: #0f1317; }
    .card-filme .card-body{ padding: 12px 14px; }
    .card-filme .titulo{ font-weight: 700; margin: 0; font-size: 1rem; color: #e8f7f1; }
    .card-filme .meta{ font-size: .9rem; color: var(--muted); }
    .card-filme .acoes{ display: flex; gap: .5rem; margin-top: 8px; }

    .thumb{
      width: 52px; height: 72px; object-fit: cover; border-radius: 8px;
      background: #0f1317; border: 1px solid var(--line);
    }
    #poster-preview{
      width: 120px; height: 160px; object-fit: cover; border-radius: 10px;
      border: 1px solid var(--line); background: #0f1317;
    }

    #mensagem .alert{ border: 1px solid var(--line); }
    .alert-success{ background: rgba(0,230,118,.08); border-color: rgba(0,230,118,.35); color: #b7fbd7; }
    .alert-danger{ background: rgba(214, 71, 80, .08); border-color: rgba(214,71,80,.35); }

    .toolbar{ display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; }

    .empty{
      text-align:center; color: var(--muted);
      padding:24px; border:1px dashed var(--line); border-radius:12px; background: var(--bg-1);
    }

    .is-valid{ border-color: #19ffa1 !important; box-shadow: 0 0 0 .15rem rgba(25,255,161,.15) !important; }
    .is-invalid{ border-color: #ff4d6d !important; box-shadow: 0 0 0 .15rem rgba(255,77,109,.15) !important; }

    .modal-content{ background: var(--bg-1); color: var(--txt); border: 1px solid var(--line); }
    .modal-header{ border-bottom-color: var(--line); }
    .modal-footer{ border-top-color: var(--line); }

    #div-botao-cancelar .btn{ border-radius: 12px; }

    *::-webkit-scrollbar{ height: 10px; width: 10px; }
    *::-webkit-scrollbar-thumb{ background: #26313d; border-radius: 999px; }
    *::-webkit-scrollbar-thumb:hover{ background: #2f3d4b; }

.card-filme{
  display: flex;
  flex-direction: column;
}

.card-filme .card-body{
  display: flex;
  flex-direction: column;
  min-height: 150px;           
}

.card-filme .acoes{
  margin-top: auto;            
  display: flex;
  gap: .5rem;
}
.card-filme .titulo{
  --lh: 1.25;                 
  line-height: var(--lh);
  display: block;
  overflow: hidden;
  max-height: calc(var(--lh) * 2em);  
}

@supports (-webkit-line-clamp: 2) {
  .card-filme .titulo{
    display: -webkit-box;
    -webkit-box-orient: vertical;
    line-clamp: 2;
    max-height: none;         
  }
}

#tabela-filmes .titulo{
  max-width: 260px;          
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

#tabela-filmes td:last-child{
  white-space: nowrap;         
  vertical-align: middle;      
}

#tabela-filmes .thumb{
  display: block;
}

  </style>
</head>
<body>

<section style="
  background: linear-gradient(180deg, rgba(0,230,118,.08), transparent);
  border-bottom: 1px solid #202832;
">
  <div class="container py-3 d-flex align-items-center gap-3">
    <i class="bi bi-film" style="font-size:1.6rem;color:#00e676"></i>
    <div>
      <div style="font-weight:700;letter-spacing:.3px">Nozama</div>
      <div style="font-size:.9rem;color:#96a3a1">Crie sua lista de filmes!</div>
    </div>
  </div>
</section>

<div class="container">
  <h1 class="text-center mb-4" id="titulo">Gerenciador de Filmes</h1>

  <div class="cadastro-wrapper">

    <div id="aviso-edicao" class="alert alert-warning text-center d-none">
      Você está editando um filme.
    </div>

    <form id="form-cadastro" class="p-4 rounded shadow-sm">
      <input type="hidden" id="id" name="id" />

      <div class="mb-3 row">
        <label for="tituloFilme" class="col-sm-2 col-form-label text-end">Título: *</label>
        <div class="col-sm-10">
          <div class="input-group">
            <input type="text" class="form-control" id="tituloFilme" name="title" required autofocus placeholder="Ex.: Cidade de Deus" />
            <button type="button" class="btn btn-outline-primary" id="btn-autofill" title="Preencher automaticamente">
              <i class="bi bi-magic"></i> Auto
            </button>
          </div>
          <div class="form-text">Digite o título e clique em <b>Auto</b> para preencher diretor/ano/pôster/sinopse.</div>
        </div>
      </div>

      <div class="mb-3 row">
        <label for="diretor" class="col-sm-2 col-form-label text-end">Diretor:</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" id="diretor" name="director" />
        </div>
        <label for="ano" class="col-sm-2 col-form-label text-end">Ano:</label>
        <div class="col-sm-4">
          <input type="number" class="form-control" id="ano" name="year" min="1888" max="2100" />
        </div>
      </div>

      <div class="mb-3 row">
        <label for="poster_url" class="col-sm-2 col-form-label text-end">Pôster (URL):</label>
        <div class="col-sm-7">
          <input type="url" class="form-control" id="poster_url" name="poster_url" placeholder="https://...jpg" />
          <div class="form-text">Cole a URL da imagem do pôster (TMDb/OMDb/link direto).</div>
        </div>
        <div class="col-sm-3 d-flex align-items-center">
          <img id="poster-preview" alt="Prévia do pôster">
        </div>
      </div>

      <div class="mb-3 row">
        <label for="sinopse" class="col-sm-2 col-form-label text-end">Sinopse:</label>
        <div class="col-sm-10">
          <textarea class="form-control" id="sinopse" name="synopsis" rows="3" placeholder="Opcional"></textarea>
        </div>
      </div>

  <div class="botoes-direita d-flex justify-content-end align-items-center gap-2 flex-wrap">
        <button type="submit" class="btn btn-success" id="btn-submit">
          <i class="bi bi-check-circle"></i> Salvar
        </button>
        <div id="div-botao-cancelar"></div>
      </div>
    </form>
  </div>

  <div id="mensagem" class="mt-3"></div>

  <div class="toolbar mt-4">
    <div id="grupo-busca" class="input-group">
      <input type="text" id="busca" class="form-control" placeholder="Buscar por título ou diretor">
      <button class="btn btn-outline-primary" type="button" id="btn-buscar">
        <i class="bi bi-search"></i> Buscar
      </button>
    </div>

    <div class="btn-group" role="group" aria-label="Trocar visualização">
      <input type="radio" class="btn-check" name="view" id="viewCards" autocomplete="off" checked>
      <label class="btn btn-outline-secondary" for="viewCards"><i class="bi bi-grid-3x3-gap"></i> Cartões</label>

      <input type="radio" class="btn-check" name="view" id="viewTable" autocomplete="off">
      <label class="btn btn-outline-secondary" for="viewTable"><i class="bi bi-table"></i> Tabela</label>
    </div>
  </div>

  <table id="tabela-filmes" class="table table-bordered table-striped table-hover mt-4" style="display: none;">
    <thead class="table-secondary">
      <tr>
        <th>ID</th>
        <th>Pôster</th>
        <th>Título</th>
        <th>Diretor</th>
        <th>Ano</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>

  <div id="grid-filmes" class="grid-filmes mt-4"></div>

  <div id="empty-state" class="empty mt-4 d-none">
    <i class="bi bi-film" style="font-size:2rem;color:#00e676"></i>
    <p class="mt-2 mb-0">Nenhum filme cadastrado ainda.</p>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<div class="modal fade" id="modalSinopse" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="bi bi-card-text me-2"></i>Sinopse</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body" id="modalSinopseBody"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

<script>
  const TEMPO_VALIDACAO = 300;
  const ENDPOINTS = {
    create: 'filmes_create.php',
    update: 'filmes_update.php',
    read:   'filmes_read.php',
    delete: 'filmes_delete.php',
    get:    'buscar_filme.php'
  };

  const OMDB_API_KEY = 'f4ac82ce';
  const TMDB_API_KEY = 'de27963ee72f2724f984f43dcb8a0559';

  const PLACEHOLDER_POSTER =
    'data:image/svg+xml;utf8,' + encodeURIComponent(`
      <svg xmlns="http://www.w3.org/2000/svg" width="400" height="600">
        <defs>
          <linearGradient id="g" x1="0" x2="1">
            <stop offset="0" stop-color="#10161b"/>
            <stop offset="1" stop-color="#0b0d10"/>
          </linearGradient>
        </defs>
        <rect width="100%" height="100%" fill="url(#g)"/>
        <rect x="20" y="20" width="360" height="560" rx="10" ry="10" stroke="#202832" fill="none"/>
        <text x="50%" y="52%" dominant-baseline="middle" text-anchor="middle"
              font-family="Arial" font-size="22" fill="#8fb6a9"
              style="letter-spacing:1px">SEM IMAGEM</text>
        <circle cx="200" cy="280" r="2" fill="#00e676"/>
      </svg>
    `);

  function sanitize(str) {
    return String(str ?? '').replace(/[&<>"']/g, s =>
      ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[s])
    );
  }

  function limparValidacoes() {
    ['tituloFilme','diretor','ano','poster_url','sinopse'].forEach(id => {
      const el = document.getElementById(id);
      el?.classList.remove('is-valid','is-invalid');
    });
  }

  function limparFormulario() {
    document.getElementById('form-cadastro').classList.remove('editando');
    document.getElementById('aviso-edicao').classList.add('d-none');
    document.getElementById('id').value = '';
    document.getElementById('tituloFilme').value = '';
    document.getElementById('diretor').value = '';
    document.getElementById('ano').value = '';
    document.getElementById('poster_url').value = '';
    document.getElementById('sinopse').value = '';
    document.getElementById('poster-preview').src = PLACEHOLDER_POSTER;
    document.querySelector('button[type="submit"]').innerHTML = '<i class="bi bi-check-circle"></i> Salvar';
    document.querySelector('#div-botao-cancelar').innerHTML = '';
    limparValidacoes();
    document.getElementById('titulo').textContent = 'Gerenciador de Filmes';

  }

  function mostrarMensagem(texto, sucesso = true) {
    const msgDiv = document.getElementById('mensagem');
    msgDiv.className = `alert ${sucesso ? 'alert-success' : 'alert-danger'} fade show`;
    msgDiv.setAttribute('role', 'alert');
    msgDiv.innerHTML = `
      <i class="bi ${sucesso ? 'bi-check-circle' : 'bi-exclamation-triangle'} me-2"></i>
      ${texto}
    `;
    setTimeout(() => {
      msgDiv.classList.remove('show');
      setTimeout(() => { msgDiv.className = ''; msgDiv.innerHTML = ''; }, 150);
    }, 4000);
  }

  function mostrarBotaoCancelar() {
    document.querySelector('#div-botao-cancelar').innerHTML = `
      <button type="button" onclick="cancelarEdicao()" class="btn btn-outline-primary">
        <i class="bi bi-x-circle"></i> Cancelar
      </button>
    `;
  }
  function cancelarEdicao() { limparFormulario(); }

  function atualizarPreviewPoster(url) {
    const img = document.getElementById('poster-preview');
    img.src = url?.trim() ? url.trim() : PLACEHOLDER_POSTER;
    img.onerror = () => { img.onerror = null; img.src = PLACEHOLDER_POSTER; };
  }
  document.getElementById('poster_url').addEventListener('input', e => {
    atualizarPreviewPoster(e.target.value);
  });

  async function buscarOMDbPorTitulo(titulo, ano) {
    if (!titulo || !OMDB_API_KEY || OMDB_API_KEY === 'SUA_CHAVE_OMDB') return null;
    try {
      const u = new URL('https://www.omdbapi.com/');
      u.searchParams.set('t', titulo);
      u.searchParams.set('plot', 'short');
      u.searchParams.set('apikey', OMDB_API_KEY);
      if (ano) u.searchParams.set('y', ano);
      const res = await fetch(u.toString());
      const data = await res.json();
      if (data && data.Response === 'True') {
        return {
          title:   data.Title || '',
          director: (data.Director && data.Director !== 'N/A') ? data.Director : '',
          year:     (String(data.Year || '').match(/\d{4}/)?.[0] || ''),
          poster:   (data.Poster && data.Poster !== 'N/A') ? data.Poster : '',
          plot:     (data.Plot && data.Plot !== 'N/A') ? data.Plot : ''
        };
      }
    } catch(e) {
      console.warn('OMDb erro:', e);
    }
    return null;
  }

  function normalizarTMDbDetalhe(d) {
    let director = '';
    if (d.credits && Array.isArray(d.credits.crew)) {
      const dir = d.credits.crew.find(c => c.job === 'Director');
      director = dir ? dir.name : '';
    }
    const poster = d.poster_path ? `https://image.tmdb.org/t/p/w500${d.poster_path}` : '';
    const yearOnly = (d.release_date || '').slice(0,4);
    return {
      title:    d.title || '',
      director: director,
      year:     yearOnly,
      poster:   poster,
      plot:     d.overview || ''
    };
  }

  async function buscarTMDbPorTitulo(titulo, ano) {
    if (!TMDB_API_KEY || TMDB_API_KEY === 'SUA_CHAVE_TMDB') return null;
    try {
      const urlS = new URL('https://api.themoviedb.org/3/search/movie');
      urlS.searchParams.set('api_key', TMDB_API_KEY);
      urlS.searchParams.set('language', 'pt-BR');
      urlS.searchParams.set('query', titulo);
      urlS.searchParams.set('include_adult', 'false');
      if (ano) urlS.searchParams.set('year', ano);

      let res = await fetch(urlS.toString());
      let data = await res.json();
      if (!data || !Array.isArray(data.results) || data.results.length === 0) return null;

      let pick = data.results[0];
      if (ano) {
        const exato = data.results.find(r => (r.release_date || '').startsWith(String(ano)));
        if (exato) pick = exato;
      }

      const urlD = new URL(`https://api.themoviedb.org/3/movie/${pick.id}`);
      urlD.searchParams.set('api_key', TMDB_API_KEY);
      urlD.searchParams.set('language', 'pt-BR');
      urlD.searchParams.set('append_to_response', 'credits');

      const resD = await fetch(urlD.toString());
      const det = await resD.json();
      if (!det || det.status_code) return null;

      return normalizarTMDbDetalhe(det);
    } catch (e) {
      console.warn('TMDb erro:', e);
      return null;
    }
  }

  async function autoPreencher() {
    const tituloEl = document.getElementById('tituloFilme');
    const diretorEl = document.getElementById('diretor');
    const anoEl     = document.getElementById('ano');
    const posterEl  = document.getElementById('poster_url');
    const sinopseEl = document.getElementById('sinopse');

    const titulo = tituloEl.value.trim();
    const ano    = anoEl.value.trim();
    if (!titulo) return;

    let info = await buscarTMDbPorTitulo(titulo, ano);
    //if (!info) info = await buscarOMDbPorTitulo(titulo, ano);
    if (!info) {
      mostrarMensagem('Não foi possível preencher automaticamente.', false);
      return;
    }

    if (!tituloEl.value.trim() && info.title) tituloEl.value = info.title;
    if (info.director && !diretorEl.value.trim()) diretorEl.value = info.director;
    if (info.year && !anoEl.value.trim()) anoEl.value = info.year;
    if (info.poster && !posterEl.value.trim()) posterEl.value = info.poster;
    if (info.plot && !sinopseEl.value.trim()) sinopseEl.value = info.plot;

    atualizarPreviewPoster(posterEl.value);                        
    mostrarMensagem(`Preenchido automaticamente pela ${info.poster?.includes('image.tmdb.org') ? 'TMDb' : 'OMDb'}.`, true);
  }

  document.getElementById('btn-autofill').addEventListener('click', autoPreencher);
  document.getElementById('tituloFilme').addEventListener('blur', () => {
    if (!document.getElementById('diretor').value && !document.getElementById('ano').value) {
      autoPreencher();
    }
  });

  async function buscarFilme(id) {
    try {
      const res = await fetch(`${ENDPOINTS.get}?id=${id}`);
      const data = await res.json();
      if (data.erro) { alert(data.erro); return; }

      document.getElementById('id').value = id;
      document.getElementById('tituloFilme').value = data.title || '';
      document.getElementById('diretor').value     = data.director || '';
      document.getElementById('ano').value         = data.year || '';
      document.getElementById('poster_url').value  = data.poster_url || '';
      document.getElementById('sinopse').value     = data.synopsis || '';
      atualizarPreviewPoster(data.poster_url || '');

      document.getElementById('form-cadastro').classList.add('editando');
      document.getElementById('aviso-edicao').classList.remove('d-none');
      document.querySelector('button[type="submit"]').innerHTML = '<i class="bi bi-save"></i> Atualizar';
      document.getElementById('titulo').textContent = 'Editando Filme';
      mostrarBotaoCancelar();
      limparValidacoes();
      window.scrollTo({ top: 0, behavior: 'smooth' });
    } catch (e) {
      console.error('Erro:', e);
      alert('Erro ao buscar filme.');
    }
  }

  async function deletarFilme(id) {
    if (!confirm('Tem certeza que deseja deletar este filme?')) return;
    const formData = new FormData();
    formData.append('id', id);
    try {
      const res = await fetch(ENDPOINTS.delete, { method: 'POST', body: formData });
      const msg = await res.text();
      mostrarMensagem(msg, msg.includes('sucesso'));
      if (msg.includes('sucesso')) {
        limparFormulario();
        listarFilmes();
      }
    } catch (e) {
      console.error('Erro:', e);
      alert('Erro ao tentar deletar o filme.');
    }
  }

  async function listarFilmes() {
    try {
      const res = await fetch(ENDPOINTS.read, { headers: { 'X-Requested-With': 'XMLHttpRequest' }});
      const filmes = await res.json();
      renderTabela(filmes);
      renderCards(filmes);
      aplicarFiltroAtual();
      document.getElementById('empty-state').classList.toggle('d-none', !!(filmes && filmes.length));
    } catch (e) {
      console.error('Erro ao listar filmes:', e);
      alert('Erro ao carregar filmes.');
    }
  }

  function renderTabela(filmes) {
    const tabela = document.getElementById('tabela-filmes');
    const tbody = tabela.querySelector('tbody');
    tbody.innerHTML = '';

    if (!filmes || filmes.length === 0) {
      tabela.style.display = 'none';
      return;
    }

    filmes.forEach((f) => {
      const row = document.createElement('tr');
      const poster = f.poster_url?.trim() ? f.poster_url.trim() : PLACEHOLDER_POSTER;
      row.innerHTML = `
        <td>${f.id}</td>
        <td><img src="${poster}" class="thumb" alt="Poster"></td>
        <td class="titulo">${sanitize(f.title)}</td>
        <td class="diretor">${sanitize(f.director || '')}</td>
        <td class="ano">${sanitize(f.year || '')}</td>
        <td class="text-nowrap">
          <button type="button" class="btn btn-sm btn-secondary me-1" title="Ver sinopse" data-id="${f.id}" data-action="ver">
            <i class="bi bi-card-text"></i>
          </button>
          <button type="button" class="btn btn-sm btn-warning me-1" onclick="buscarFilme(${f.id})" title="Editar">
            <i class="bi bi-pencil-square"></i>
          </button>
          <button type="button" class="btn btn-sm btn-danger" onclick="deletarFilme(${f.id})" title="Excluir">
            <i class="bi bi-trash"></i>
          </button>
        </td>
      `;
      const img = row.querySelector('img');
      img.onerror = () => { img.onerror = null; img.src = PLACEHOLDER_POSTER; };
      tbody.appendChild(row);
    });
    document.getElementById('tabela-filmes').style.display =
      document.getElementById('viewTable').checked ? 'table' : 'none';

    tbody.querySelectorAll('button[data-action="ver"]').forEach(btn => {
      btn.addEventListener('click', async () => {
        const id = btn.getAttribute('data-id');
        const res = await fetch(`${ENDPOINTS.get}?id=${id}`);
        const data = await res.json();
        document.getElementById('modalSinopseBody').textContent = data.synopsis || 'Sem sinopse.';
        new bootstrap.Modal(document.getElementById('modalSinopse')).show();
      });
    });
  }

  function renderCards(filmes) {
    const grid = document.getElementById('grid-filmes');
    grid.innerHTML = '';

    if (!filmes || filmes.length === 0) return;

    filmes.forEach(f => {
      const poster = f.poster_url?.trim() ? f.poster_url.trim() : PLACEHOLDER_POSTER;
      const card = document.createElement('div');
      card.className = 'card-filme';
      card.innerHTML = `
        <img src="${poster}" alt="Pôster">
        <div class="card-body">
          <h3 class="titulo">${sanitize(f.title)}</h3>
          <div class="meta">${sanitize(f.director || '—')} ${f.year ? ' • ' + sanitize(f.year) : ''}</div>
          <div class="acoes">
            <button type="button" class="btn btn-sm btn-secondary" title="Ver sinopse" data-id="${f.id}" data-action="ver">
              <i class="bi bi-card-text"></i> Ver
            </button>
            <button type="button" class="btn btn-sm btn-outline-primary" onclick="buscarFilme(${f.id})">
              <i class="bi bi-pencil-square"></i> Editar
            </button>
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletarFilme(${f.id})">
              <i class="bi bi-trash"></i> Excluir
            </button>
          </div>
        </div>
      `;
      const img = card.querySelector('img');
      img.onerror = () => { img.onerror = null; img.src = PLACEHOLDER_POSTER; };
      grid.appendChild(card);
    });

    document.getElementById('grid-filmes').style.display =
      document.getElementById('viewCards').checked ? 'grid' : 'none';

    grid.querySelectorAll('button[data-action="ver"]').forEach(btn => {
      btn.addEventListener('click', async () => {
        const id = btn.getAttribute('data-id');
        const res = await fetch(`${ENDPOINTS.get}?id=${id}`);
        const data = await res.json();
        document.getElementById('modalSinopseBody').textContent = data.synopsis || 'Sem sinopse.';
        new bootstrap.Modal(document.getElementById('modalSinopse')).show();
      });
    });
  }

  function filtrarFilmesTermo(termo) {
    termo = termo.toLowerCase();

    document.querySelectorAll('#tabela-filmes tbody tr').forEach((linha) => {
      const titulo = linha.querySelector('.titulo').textContent.toLowerCase();
      const diretor = linha.querySelector('.diretor').textContent.toLowerCase();
      const visivel = !termo || titulo.includes(termo) || diretor.includes(termo);
      linha.style.display = visivel ? '' : 'none';
    });

    document.querySelectorAll('#grid-filmes .card-filme').forEach((card) => {
      const titulo = card.querySelector('.titulo').textContent.toLowerCase();
      const meta = card.querySelector('.meta').textContent.toLowerCase();
      const visivel = !termo || titulo.includes(termo) || meta.includes(termo);
      card.style.display = visivel ? '' : 'none';
    });
  }

  function aplicarFiltroAtual() {
    const termo = document.getElementById('busca').value.trim().toLowerCase();
    filtrarFilmesTermo(termo);
  }

  document.getElementById('btn-buscar').addEventListener('click', aplicarFiltroAtual);
  document.getElementById('busca').addEventListener('keydown', (e) => {
    if (e.key === 'Enter') {
      e.preventDefault();
      aplicarFiltroAtual();
    }
  });

  document.getElementById('form-cadastro').addEventListener('submit', async function (e) {
    console.log('ENVIANDO FORMULÁRIO');
    e.preventDefault();
    const titulo   = document.getElementById('tituloFilme');
    const diretor  = document.getElementById('diretor');
    const ano      = document.getElementById('ano');
    const posterUrl= document.getElementById('poster_url');
    const sinopse  = document.getElementById('sinopse');
    const botao    = document.getElementById('btn-submit');

    titulo.classList.toggle('is-valid', titulo.value.trim().length > 1);
    posterUrl.classList.toggle('is-valid', !!posterUrl.value.trim());
    setTimeout(limparValidacoes, TEMPO_VALIDACAO);

    const dados = new URLSearchParams();
    dados.append('title', titulo.value.trim());
    dados.append('director', diretor.value.trim());
    dados.append('year', ano.value.trim());
    dados.append('poster_url', posterUrl.value.trim());
    dados.append('synopsis', sinopse.value.trim());

    let url = ENDPOINTS.create;
    if (document.getElementById('id').value) {
      url = ENDPOINTS.update;
      dados.append('id', document.getElementById('id').value);
    }

    botao.disabled = true;
    const originalHTML = botao.innerHTML;
    botao.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Salvando...`;

    try {
      const res = await fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: dados.toString(),
      });
      const mensagem = await res.text();
      mostrarMensagem(mensagem, mensagem.includes('sucesso'));
      setTimeout(() => {
        limparFormulario();
        listarFilmes();
      }, TEMPO_VALIDACAO);
    } catch (error) {
      console.error('Erro:', error);
      mostrarMensagem('Erro ao salvar filme.', false);
    } finally {
      botao.disabled = false;
      botao.innerHTML = originalHTML;
    }
  });

  document.getElementById('viewCards').addEventListener('change', () => {
    document.getElementById('grid-filmes').style.display = 'grid';
    document.getElementById('tabela-filmes').style.display = 'none';
  });
  document.getElementById('viewTable').addEventListener('change', () => {
    document.getElementById('grid-filmes').style.display = 'none';
    document.getElementById('tabela-filmes').style.display = 'table';
  });

  document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('poster-preview').src = PLACEHOLDER_POSTER;
    listarFilmes();
  });

  window.buscarFilme  = buscarFilme;
  window.deletarFilme = deletarFilme;
  window.cancelarEdicao = cancelarEdicao;
</script>
  
</body>
</html>
