<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home & Kegiatan Sarasehan</title>
    <!-- Google Font Pixel Retro -->
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #2563eb; --success: #10b981; --danger: #ef4444; --bg: #f8fafc; --border: #e2e8f0; --muted: #64748b; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', system-ui, sans-serif; }
        body { background: var(--bg); color: #1e293b; min-height: 100vh; display: flex; flex-direction: column; }
        .hidden { display: none !important; }

        .navbar { background: #fff; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border); position: sticky; top: 0; z-index: 100; }
        .nav-links { display: flex; list-style: none; gap: 8px; }
        .nav-btn { background: transparent; border: none; padding: 8px 18px; border-radius: 20px; font-weight: 600; color: var(--muted); text-decoration: none; }
        .nav-btn.active { background: var(--primary); color: #fff; }

        .container { max-width: 1000px; margin: 2rem auto; padding: 0 1.5rem; flex: 1; width: 100%; }

        .hero-card { background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: #fff; border-radius: 14px; padding: 2rem; margin-bottom: 2rem; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .hero-card h2 { font-size: 1.6rem; margin: 0.6rem 0; }
        .hero-desc { color: #cbd5e1; font-size: 0.9rem; line-height: 1.6; margin-bottom: 1.2rem; }
        .hero-meta { display: flex; gap: 16px; font-size: 0.82rem; color: #94a3b8; border-top: 1px solid rgba(255, 255, 255, 0.1); padding-top: 0.8rem; }

        .section-header { display: flex; justify-content: space-between; align-items: center; margin: 1.8rem 0 1rem; }
        .btn { padding: 8px 16px; border-radius: 8px; font-weight: 600; cursor: pointer; border: none; }
        .btn-primary { background: var(--primary); color: #fff; }
        .btn-success { background: var(--success); color: #fff; }
        .btn-danger { background: var(--danger); color: #fff; }
        .btn-action { padding: 4px 10px; font-size: 0.78rem; border-radius: 6px; border: none; cursor: pointer; font-weight: 600; }
        .btn-edit { background: #e0f2fe; color: #0284c7; }
        .btn-del { background: #fee2e2; color: #dc2626; }

        /* TABEL RUNDOWN */
        .rundown-block { background: #fff; border-radius: 12px; border: 1px solid var(--border); overflow: hidden; margin-bottom: 1.5rem; box-shadow: 0 2px 5px rgba(0,0,0,0.03); }
        .rundown-title { padding: 0.9rem 1.2rem; color: #fff; font-weight: 700; font-size: 0.98rem; display: flex; justify-content: space-between; align-items: center; }
        .rundown-title.day-1 { background: #2563eb; }
        .rundown-title.day-2 { background: #059669; }
        
        .table-rundown { width: 100%; border-collapse: collapse; text-align: left; }
        .table-rundown th { background: #f1f5f9; color: #475569; font-weight: 700; font-size: 0.82rem; text-transform: uppercase; letter-spacing: 0.5px; padding: 10px 1.2rem; border-bottom: 1.5px solid var(--border); }
        .table-rundown td { padding: 10px 1.2rem; border-bottom: 1px solid #f1f5f9; font-size: 0.88rem; color: #334155; }
        .table-rundown tbody tr:nth-child(even) { background: #fafafa; }
        .table-rundown tbody tr:hover { background: #f8fafc; }
        .table-rundown tr:last-child td { border-bottom: none; }
        
        .time-badge { display: inline-flex; align-items: center; gap: 5px; background: #e0f2fe; color: #0369a1; font-weight: 700; font-size: 0.8rem; padding: 4px 10px; border-radius: 6px; white-space: nowrap; }

        .modal { position: fixed; inset: 0; background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(6px); display: flex; justify-content: center; align-items: center; z-index: 200; }
        .modal-content { background: #fff; padding: 2rem; border-radius: 16px; width: 90%; max-width: 520px; position: relative; max-height: 90vh; overflow-y: auto; }
        .close-modal { position: absolute; top: 16px; right: 20px; font-size: 1.5rem; cursor: pointer; color: var(--muted); }
        .form-group { margin-bottom: 1rem; text-align: left; }
        .form-group label { display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.4rem; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 10px; border: 1.5px solid var(--border); border-radius: 8px; }

        .time-picker-box { display: flex; gap: 12px; align-items: center; background: #f8fafc; border: 1.5px solid var(--border); padding: 12px; border-radius: 10px; margin-bottom: 10px; }
        .time-select-group { flex: 1; display: flex; flex-direction: column; gap: 4px; }
        .time-select-group label { font-size: 0.75rem; color: var(--muted); font-weight: 700; }
        .time-scroll-select { padding: 8px; border: 1px solid var(--border); border-radius: 6px; background: #fff; outline: none; font-weight: 600; color: var(--primary); cursor: pointer; }

        .admin-badge { background: #fef3c7; color: #b45309; padding: 4px 12px; border-radius: 12px; font-size: 0.8rem; font-weight: 700; }
        footer { text-align: center; padding: 2rem; color: var(--muted); font-size: 0.85rem; border-top: 1px solid var(--border); background: #fff; }

        /* ================= GUARDIAN TALES ANIME CHARACTERS STYLING ================= */
        .gt-pixel-font { font-family: 'Press Start 2P', monospace; }

        @keyframes gtFloat {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }
        @keyframes gtTalkHop {
            0%, 100% { transform: translateY(0px) scale(1); }
            50% { transform: translateY(-14px) scale(1.1); }
        }
        @keyframes gtShakeError {
            0%, 100% { transform: translateX(0px); }
            20%, 60% { transform: translateX(-6px); }
            40%, 80% { transform: translateX(6px); }
        }

        .gt-avatar-standalone {
            cursor: pointer;
            width: 80px;
            height: 80px;
            filter: drop-shadow(0 10px 12px rgba(0,0,0,0.45));
            transition: transform 0.2s;
            animation: gtFloat 2.5s steps(4) infinite;
        }
        .gt-avatar-standalone:hover {
            transform: scale(1.1);
        }
        .talking .gt-avatar-standalone {
            animation: gtTalkHop 0.4s steps(4) infinite;
        }
        .error-state .gt-avatar-standalone {
            animation: gtShakeError 0.4s ease-in-out;
        }

        /* BUBBLE CHAT MELAYANG (GAME DIALOGUE BOX) */
        .gt-dialogue-bubble {
            position: absolute;
            bottom: 95px;
            right: 0;
            width: 320px;
            background: #111827;
            border: 3px solid #f59e0b;
            border-radius: 10px;
            padding: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.5);
            color: #f8fafc;
            z-index: 1000;
        }

        .gt-dialogue-bubble::after {
            content: '';
            position: absolute;
            bottom: -10px;
            right: 32px;
            width: 0;
            height: 0;
            border-left: 10px solid transparent;
            border-right: 10px solid transparent;
            border-top: 10px solid #f59e0b;
        }

        .gt-input-field {
            background: #1f2937;
            color: #fff;
            border: 1px solid #4b5563;
            padding: 6px 10px;
            border-radius: 4px;
            font-size: 0.6rem;
            width: 100%;
            outline: none;
        }
        .gt-input-field:focus {
            border-color: #f59e0b;
        }
    </style>
</head>
<body>

    <header class="navbar">
        <h2>Informasi Kelas</h2>
        <nav>
            <ul class="nav-links">
                <li><a href="home" class="nav-btn active">Home & Kegiatan</a></li>
                <li><a href="anggota" class="nav-btn">Anggota Kelas</a></li>
                <li><a href="gallery" class="nav-btn">Gallery</a></li>
            </ul>
        </nav>
        <div id="admin-status-area"></div>
    </header>

    <main class="container">
        <!-- CARD PENJELASAN SARASEHAN -->
        <div class="hero-card">
            <span style="background: var(--primary); padding: 3px 10px; border-radius: 12px; font-size: 0.72rem; font-weight: 700;">KEGIATAN UTAMA</span>
            <h2>Sarasehan Kelas: Kebersamaan & Kepedulian Sosial</h2>
            <p class="hero-desc">
                Sarasehan adalah kegiatan tahunan menginap di sekolah selama 2 hari 1 malam. Kegiatan ini bertujuan untuk mempererat tali persaudaraan antaranggota kelas melalui dinamika kelompok di sekolah pada hari pertama, serta menumbuhkan rasa empati dan kepedulian sosial melalui kunjungan bakti sosial ke Panti Jati Adulam Ministry Surakarta pada hari kedua.
            </p>
            <div class="hero-meta">
                <span>📅 Durasi: 2 Hari 1 Malam</span>
                <span>📍 Lokasi: Sekolah & Panti Jati Adulam Ministry Surakarta</span>
            </div>
        </div>

        <!-- TABEL RUNDOWN KEGIATAN -->
        <div class="section-header">
            <h3 style="font-size: 1.2rem;">Jadwal & Agenda Kegiatan</h3>
            <button class="btn btn-success admin-only hidden" onclick="openRundownModal()">+ Tambah Agenda Sesi</button>
        </div>

        <div id="rundown-container"></div>
    </main>

    <!-- MODAL FORM RUNDOWN -->
    <div id="modal-rundown" class="modal hidden">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal('modal-rundown')">&times;</span>
            <h3 id="modal-rundown-title">Kelola Sesi Rundown</h3>
            <form id="form-rundown">
                <input type="hidden" id="r-id">
                
                <div class="form-group">
                    <label>Tema Warna Sesi</label>
                    <select id="r-daytype">
                        <option value="day-1">Biru (Hari Ke-1 / Sesi Utama)</option>
                        <option value="day-2">Hijau (Hari Ke-2 / Bakti Sosial)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Judul Sesi / Hari</label>
                    <input type="text" id="r-judul" required placeholder="Contoh: HARI PERTAMA: Dinamika Kelas">
                </div>

                <div class="form-group">
                    <label>Tambah Item Agenda Baru</label>
                    <div class="time-picker-box">
                        <div class="time-select-group">
                            <label>JAM MULAI</label>
                            <select id="select-jam-mulai" class="time-scroll-select"></select>
                        </div>
                        <span style="font-weight: bold; color: var(--muted); margin-top: 15px;">s/d</span>
                        <div class="time-select-group">
                            <label>JAM SELESAI</label>
                            <select id="select-jam-selesai" class="time-scroll-select"></select>
                        </div>
                    </div>

                    <div style="display: flex; gap: 8px; margin-bottom: 10px;">
                        <input type="text" id="input-kegiatan-item" placeholder="Nama Kegiatan (contoh: Registrasi & Check-In)" style="flex: 1;">
                        <button type="button" onclick="addAgendaRow()" class="btn btn-success" style="white-space: nowrap;">+ Sisipkan</button>
                    </div>
                </div>

                <div class="form-group">
                    <label>Daftar Kegiatan Terurut (Dapat Diedit Manual)</label>
                    <textarea id="r-items" rows="6" required placeholder="Format per baris: 14.00 - 15.00: Nama Kegiatan"></textarea>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">Simpan Sesi Rundown</button>
            </form>
        </div>
    </div>

    <!-- ================= ANIME PIXEL CHARACTER AI DENGAN DYNAMIC EXPRESSION ================= -->
    <div id="ai-widget-container" class="admin-only hidden" style="position: fixed; bottom: 25px; right: 25px; z-index: 999; display: flex; flex-direction: column; align-items: flex-end;">
        
        <!-- DIALOGUE BUBBLE MELAYANG DI ATAS ANIME CHARACTER -->
        <div id="ai-dialogue-bubble" class="gt-dialogue-bubble hidden">
            <!-- HEADER DIALOG -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px; border-bottom: 1px solid #374151; padding-bottom: 4px;">
                <span id="ai-char-name-tag" class="gt-pixel-font" style="font-size: 0.65rem; color: #f59e0b;">Megumin</span>
                <div>
                    <button type="button" onclick="toggleHeroSelector()" class="gt-pixel-font" style="background: #374151; border: none; color: #fff; padding: 2px 6px; border-radius: 3px; font-size: 0.5rem; cursor: pointer;">SWAP</button>
                    <span onclick="toggleAiDialogue()" style="cursor: pointer; font-size: 1rem; color: #9ca3af; margin-left: 6px;">&times;</span>
                </div>
            </div>

            <!-- PANEL GANTI CHARACTER ANIME -->
            <div id="gt-hero-selector" class="hidden" style="background: #1f2937; padding: 8px; border-radius: 6px; margin-bottom: 8px;">
                <label class="gt-pixel-font" style="font-size: 0.5rem; color: #9ca3af; display: block; margin-bottom: 4px;">PILIH ANIME CHAR:</label>
                <select id="select-gt-char" onchange="changeGTChar()" class="gt-pixel-font" style="width: 100%; padding: 4px; background: #111827; color: #f59e0b; border: 1px solid #f59e0b; font-size: 0.55rem; margin-bottom: 6px;">
                    <option value="megumin">Megumin (KonoSuba) 💥</option>
                    <option value="mikasa">Mikasa Ackerman (AoT) ⚔️</option>
                </select>

                <label class="gt-pixel-font" style="font-size: 0.5rem; color: #9ca3af; display: block; margin-bottom: 4px;">NAMA CHARACTER:</label>
                <input type="text" id="input-char-name" value="Megumin" oninput="changeGTChar()" class="gt-input-field gt-pixel-font" placeholder="Nama Character...">
            </div>

            <!-- TEKS RESPONS DIALOG -->
            <div id="ai-response-text" style="font-size: 0.82rem; line-height: 1.4; color: #e2e8f0; margin-bottom: 10px; max-height: 180px; overflow-y: auto;">
                Wagaha wa Megumin! 💥 Penyihir nomor satu Archwizard siap mengeksekusi perintah Admin!
            </div>

            <!-- FORM PERINTAH DENGAN INPUT SIMPEL -->
            <form id="ai-form" style="display: flex; gap: 4px;">
                <input type="text" id="ai-input" placeholder="Perintah..." class="gt-input-field gt-pixel-font" required>
                <button type="submit" class="gt-pixel-font" style="background: #f59e0b; color: #111827; border: none; padding: 6px 10px; border-radius: 4px; font-size: 0.55rem; font-weight: bold; cursor: pointer;">KIRIM</button>
            </form>
        </div>

        <!-- TAMPILAN STANDALONE ANIME CHARACTER SPRITE -->
        <div onclick="clickAiChar()" title="Klik untuk bicara dengan Character Anime AI">
            <svg id="svg-standalone-char" class="gt-avatar-standalone" viewBox="0 0 16 16" style="image-rendering: pixelated;">
                <!-- Rendered dynamically by JS -->
            </svg>
        </div>

    </div>

    <footer>
        <p>&copy; 2026 Informasi Kelas. All Rights Reserved.</p>
    </footer>

    <script>
        let rundowns = <?php echo json_encode($rundowns); ?>;
        let isAdmin = localStorage.getItem('is_admin') === 'true';

        const placeholderRundowns = [
            {
                id: null,
                day_type: 'day-1',
                judul: 'HARI PERTAMA: Dinamika Kelompok & Kebersamaan',
                items: [
                    '14.00 - 15.00: Registrasi & Check-in Peserta',
                    '15.00 - 16.30: Pembukaan & Dinamika Kelompok',
                    '16.30 - 19.00: Istirahat, Mandi & Makan Malam',
                    '19.00 - 22.00: Malam Keakraban & Api Unggun'
                ]
            },
            {
                id: null,
                day_type: 'day-2',
                judul: 'HARI KEDUA: Bakti Sosial & Penutupan',
                items: [
                    '06.00 - 07.30: Olahraga Pagi & Sarapan',
                    '08.00 - 11.30: Kunjungan Bakti Sosial ke Panti Jati Adulam Ministry Surakarta',
                    '11.30 - 13.00: Makan Siang, Refleksi & Penutupan'
                ]
            }
        ];

        function initTimeScrollBars() {
            const selectMulai = document.getElementById('select-jam-mulai');
            const selectSelesai = document.getElementById('select-jam-selesai');
            
            selectMulai.innerHTML = '';
            selectSelesai.innerHTML = '';

            for (let h = 0; h < 24; h++) {
                for (let m = 0; m < 60; m += 15) {
                    let jamStr = (h < 10 ? '0' + h : h) + '.' + (m < 10 ? '0' + m : m);
                    
                    let opt1 = document.createElement('option');
                    opt1.value = jamStr;
                    opt1.textContent = jamStr + ' WIB';
                    selectMulai.appendChild(opt1);

                    let opt2 = document.createElement('option');
                    opt2.value = jamStr;
                    opt2.textContent = jamStr + ' WIB';
                    selectSelesai.appendChild(opt2);
                }
            }
            selectMulai.value = "14.00";
            selectSelesai.value = "15.00";
        }

        function addAgendaRow() {
            const jamMulai = document.getElementById('select-jam-mulai').value;
            const jamSelesai = document.getElementById('select-jam-selesai').value;
            const namaKegiatan = document.getElementById('input-kegiatan-item').value.trim();

            if (!namaKegiatan) {
                alert('Silakan isi nama kegiatan terlebih dahulu!');
                return;
            }

            const formattedLine = `${jamMulai} - ${jamSelesai}: ${namaKegiatan}`;
            const textarea = document.getElementById('r-items');

            if (textarea.value.trim() === '') {
                textarea.value = formattedLine;
            } else {
                textarea.value += '\n' + formattedLine;
            }

            document.getElementById('input-kegiatan-item').value = '';
        }

        function updateAdminUI() {
            const statusArea = document.getElementById('admin-status-area');
            const adminButtons = document.querySelectorAll('.admin-only');

            if (isAdmin) {
                statusArea.innerHTML = `
                    <span class="admin-badge">Admin Mode Active</span>
                    <button onclick="logoutAdmin()" class="btn btn-danger" style="font-size: 0.8rem; padding: 4px 10px; margin-left: 8px;">Logout Admin</button>
                `;
                adminButtons.forEach(btn => btn.classList.remove('hidden'));
            } else {
                statusArea.innerHTML = ``;
                adminButtons.forEach(btn => btn.classList.add('hidden'));
            }
            renderRundowns();
        }

        function renderRundowns() {
            const container = document.getElementById('rundown-container');
            const displayData = (rundowns && rundowns.length > 0) ? rundowns : placeholderRundowns;

            container.innerHTML = displayData.map(r => {
                let rowsHtml = '';
                if (Array.isArray(r.items)) {
                    r.items.forEach(item => {
                        const parts = item.split(':');
                        let jam = parts.length > 1 ? parts.shift().trim() : '-';
                        let kegiatan = parts.join(':').trim();

                        rowsHtml += `
                            <tr>
                                <td style="width: 170px;">
                                    <span class="time-badge">⏱️ ${jam}</span>
                                </td>
                                <td style="font-weight: 500;">${kegiatan}</td>
                            </tr>
                        `;
                    });
                }

                return `
                    <div class="rundown-block">
                        <div class="rundown-title ${r.day_type || 'day-1'}">
                            <span>📌 ${r.judul}</span>
                            ${isAdmin && r.id ? `
                                <div>
                                    <button class="btn-action btn-edit" onclick="editRundown(${r.id})">Edit</button>
                                    <button class="btn-action btn-del" onclick="deleteRundown(${r.id})">Hapus</button>
                                </div>
                            ` : ''}
                        </div>
                        <table class="table-rundown">
                            <thead>
                                <tr>
                                    <th>Waktu Kegiatan</th>
                                    <th>Detail Agenda</th>
                                </tr>
                            </thead>
                            <tbody>${rowsHtml}</tbody>
                        </table>
                    </div>
                `;
            }).join('');
        }

        function closeModal(id) { document.getElementById(id).classList.add('hidden'); }

        function logoutAdmin() {
            localStorage.removeItem('is_admin');
            isAdmin = false;
            updateAdminUI();
        }

        function openRundownModal() {
            document.getElementById('form-rundown').reset();
            document.getElementById('r-id').value = '';
            document.getElementById('modal-rundown-title').textContent = 'Tambah Agenda Rundown';
            initTimeScrollBars();
            document.getElementById('modal-rundown').classList.remove('hidden');
        }

        function editRundown(id) {
            const r = rundowns.find(i => i.id == id);
            if (r) {
                document.getElementById('r-id').value = r.id;
                document.getElementById('r-daytype').value = r.day_type || 'day-1';
                document.getElementById('r-judul').value = r.judul;
                document.getElementById('r-items').value = Array.isArray(r.items) ? r.items.join('\n') : '';
                document.getElementById('modal-rundown-title').textContent = 'Edit Agenda Rundown';
                initTimeScrollBars();
                document.getElementById('modal-rundown').classList.remove('hidden');
            }
        }

        async function deleteRundown(id) {
            if (confirm('Hapus agenda rundown ini?')) {
                try {
                    const res = await fetch(`index.php?url=rundown/delete/${id}`);
                    const result = await res.json();
                    if (result.success) {
                        alert('Berhasil dihapus!');
                        location.reload();
                    } else {
                        alert('Gagal menghapus: ' + (result.message || 'Error server'));
                    }
                } catch (e) {
                    alert('Terjadi kesalahan koneksi server.');
                }
            }
        }

        document.getElementById('form-rundown').onsubmit = async (e) => {
            e.preventDefault();
            const id = document.getElementById('r-id').value;
            const items = document.getElementById('r-items').value.split('\n').map(i => i.trim()).filter(i => i !== '');
            
            const data = {
                day_type: document.getElementById('r-daytype').value,
                judul: document.getElementById('r-judul').value,
                items: items
            };

            const endpoint = id ? `index.php?url=rundown/update/${id}` : 'index.php?url=rundown/store';
            
            try {
                const res = await fetch(endpoint, { 
                    method: 'POST', 
                    headers: { 'Content-Type': 'application/json' }, 
                    body: JSON.stringify(data) 
                });
                
                const result = await res.json();
                if (result.success) {
                    alert('Data kegiatan berhasil disimpan!');
                    closeModal('modal-rundown');
                    location.reload();
                } else {
                    alert('Gagal menyimpan: ' + (result.message || 'Periksa inputan'));
                }
            } catch (e) {
                alert('Gagal menghubungi server.');
            }
        };

        // --- MESIN EKSPRESI PIXEL ANIME (MEGUMIN & MIKASA) ---
        let currentExpression = 'idle'; // idle | surprised | thinking | success | error

        function toggleAiDialogue() {
            document.getElementById('ai-dialogue-bubble').classList.toggle('hidden');
        }

        function toggleHeroSelector() {
            document.getElementById('gt-hero-selector').classList.toggle('hidden');
        }

        function clickAiChar() {
            toggleAiDialogue();
            // Saat karakter diklik, tampilkan ekspresi Surprised sementara
            setAiExpression('surprised');
            setTimeout(() => {
                if (currentExpression === 'surprised') setAiExpression('idle');
            }, 1800);
        }

        function setAiExpression(expressionState) {
            currentExpression = expressionState;
            const charType = document.getElementById('select-gt-char').value;
            document.getElementById('svg-standalone-char').innerHTML = renderAnimePixelSprite(charType, expressionState);
        }

        // GENERATOR PIXEL SPRITE DENGAN OPSI EKSPRESI DINAMIS
        function renderAnimePixelSprite(charType, mood = 'idle') {
            if (charType === 'mikasa') {
                // MIKASA ACKERMAN (AOT) PIXEL SPRITE
                let eyePixels = `<rect x="5" y="7" width="2" height="2" fill="#1e293b"/><rect x="9" y="7" width="2" height="2" fill="#1e293b"/><rect x="6" y="7" width="1" height="1" fill="#ffffff"/><rect x="10" y="7" width="1" height="1" fill="#ffffff"/>`;
                let mouthPixel = `<rect x="7" y="9" width="2" height="1" fill="#991b1b"/>`;

                if (mood === 'surprised') {
                    eyePixels = `<rect x="5" y="6" width="2" height="3" fill="#020617"/><rect x="9" y="6" width="2" height="3" fill="#020617"/><rect x="6" y="6" width="1" height="1" fill="#ffffff"/><rect x="10" y="6" width="1" height="1" fill="#ffffff"/>`;
                    mouthPixel = `<rect x="7" y="9" width="2" height="2" fill="#020617"/>`;
                } else if (mood === 'thinking') {
                    eyePixels = `<rect x="5" y="7" width="2" height="1" fill="#020617"/><rect x="9" y="7" width="2" height="1" fill="#020617"/>`;
                    mouthPixel = `<rect x="6" y="9" width="2" height="1" fill="#451a03"/>`;
                } else if (mood === 'success') {
                    eyePixels = `<rect x="5" y="6" width="2" height="2" fill="#0284c7"/><rect x="9" y="6" width="2" height="2" fill="#0284c7"/><rect x="6" y="6" width="1" height="1" fill="#ffffff"/><rect x="10" y="6" width="1" height="1" fill="#ffffff"/>`;
                    mouthPixel = `<rect x="6" y="9" width="4" height="1" fill="#b91c1c"/>`;
                } else if (mood === 'error') {
                    eyePixels = `<polygon points="5,6 7,8" stroke="#dc2626" stroke-width="1"/><polygon points="7,6 5,8" stroke="#dc2626" stroke-width="1"/><polygon points="9,6 11,8" stroke="#dc2626" stroke-width="1"/><polygon points="11,6 9,8" stroke="#dc2626" stroke-width="1"/>`;
                    mouthPixel = `<rect x="6" y="9" width="4" height="1" fill="#dc2626"/>`;
                }

                return `
                    <!-- Rambut Hitam Short Bob Mikasa -->
                    <rect x="3" y="2" width="10" height="5" fill="#0f172a"/>
                    <rect x="2" y="4" width="2" height="6" fill="#020617"/>
                    <rect x="12" y="4" width="2" height="6" fill="#020617"/>
                    <!-- Wajah -->
                    <rect x="4" y="5" width="8" height="5" fill="#ffedd5"/>
                    ${eyePixels}
                    ${mouthPixel}
                    <!-- Syal Merah Ikonik Mikasa -->
                    <rect x="3" y="10" width="10" height="3" rx="1" fill="#b91c1c"/>
                    <rect x="9" y="12" width="3" height="3" fill="#991b1b"/>
                    <!-- Seragam Scout Regiment -->
                    <rect x="4" y="12" width="8" height="4" fill="#78350f"/>
                    <rect x="6" y="13" width="4" height="3" fill="#f8fafc"/>
                    <rect x="4" y="14" width="8" height="1" fill="#451a03"/>
                `;
            } else {
                // MEGUMIN (KONOSUBA) PIXEL SPRITE
                let eyeLeft = `<rect x="5" y="8" width="2" height="2" fill="#dc2626"/>`; // Eyepatch
                let eyeRight = `<rect x="9" y="8" width="2" height="2" fill="#dc2626"/><rect x="10" y="8" width="1" height="1" fill="#ffffff"/>`;
                let mouthPixel = `<rect x="7" y="10" width="2" height="1" fill="#451a03"/>`;

                if (mood === 'surprised') {
                    eyeRight = `<rect x="9" y="7" width="2" height="3" fill="#dc2626"/><rect x="10" y="7" width="1" height="1" fill="#ffffff"/>`;
                    mouthPixel = `<rect x="7" y="10" width="2" height="2" fill="#451a03"/>`;
                } else if (mood === 'thinking') {
                    eyeRight = `<rect x="9" y="8" width="2" height="1" fill="#dc2626"/>`;
                    mouthPixel = `<rect x="6" y="10" width="2" height="1" fill="#451a03"/>`;
                } else if (mood === 'success') {
                    // Explosion Smug Smile!
                    eyeRight = `<rect x="9" y="7" width="2" height="2" fill="#f59e0b"/><rect x="10" y="7" width="1" height="1" fill="#ffffff"/>`;
                    mouthPixel = `<rect x="6" y="10" width="4" height="1" fill="#dc2626"/><rect x="9" y="9" width="1" height="1" fill="#dc2626"/>`;
                } else if (mood === 'error') {
                    eyeRight = `<polygon points="9,7 11,9" stroke="#dc2626" stroke-width="1"/><polygon points="11,7 9,9" stroke="#dc2626" stroke-width="1"/>`;
                    mouthPixel = `<rect x="6" y="10" width="4" height="1" fill="#dc2626"/>`;
                }

                return `
                    <!-- Topi Penyihir Lebar Megumin -->
                    <polygon points="8,0 4,4 12,4" fill="#451a03"/>
                    <rect x="7" y="1" width="2" height="2" fill="#f59e0b"/>
                    <rect x="1" y="4" width="14" height="2" fill="#3b0764"/>
                    <!-- Rambut Cokelat Pendek -->
                    <rect x="3" y="5" width="10" height="3" fill="#78350f"/>
                    <rect x="2" y="6" width="2" height="5" fill="#451a03"/>
                    <rect x="12" y="6" width="2" height="5" fill="#451a03"/>
                    <!-- Wajah & Eyepatch Merah Ikonik Megumin -->
                    <rect x="4" y="6" width="8" height="5" fill="#ffedd5"/>
                    ${eyeLeft}
                    <rect x="4" y="7" width="4" height="1" fill="#991b1b"/>
                    ${eyeRight}
                    ${mouthPixel}
                    <!-- Jubah Merah Marun Megumin -->
                    <rect x="3" y="11" width="10" height="5" fill="#991b1b"/>
                    <rect x="6" y="11" width="4" height="2" fill="#f59e0b"/>
                    <rect x="7" y="13" width="2" height="3" fill="#fef08a"/>
                `;
            }
        }

        function changeGTChar() {
            const charType = document.getElementById('select-gt-char').value;
            let defaultName = (charType === 'mikasa') ? 'Mikasa Ackerman' : 'Megumin';
            const charName = document.getElementById('input-char-name').value.trim() || defaultName;

            document.getElementById('ai-char-name-tag').textContent = charName;
            
            const respBox = document.getElementById('ai-response-text');
            if (charType === 'mikasa') {
                respBox.innerHTML = `Eren... Maksudku Admin! ⚔️ Mikasa siap mengawal & mengeksekusi sistem web ini!`;
            } else {
                respBox.innerHTML = `Wagaha wa Megumin! 💥 Penyihir nomor satu Archwizard siap mengeksekusi perintah Admin!`;
            }

            document.getElementById('ai-input').placeholder = `Perintah untuk ${charName}...`;

            localStorage.setItem('gt_anime_char', charType);
            localStorage.setItem('gt_anime_name', charName);

            setAiExpression('idle');
        }

        function loadGTCharCustomization() {
            const savedChar = localStorage.getItem('gt_anime_char');
            const savedName = localStorage.getItem('gt_anime_name');

            if (savedChar) document.getElementById('select-gt-char').value = savedChar;
            if (savedName) document.getElementById('input-char-name').value = savedName;

            changeGTChar();
        }

        document.getElementById('ai-form').onsubmit = async (e) => {
            e.preventDefault();
            const input = document.getElementById('ai-input');
            const responseText = document.getElementById('ai-response-text');
            const userText = input.value.trim();
            const charName = localStorage.getItem('gt_anime_name') || 'Megumin';

            if (!userText) return;

            const container = document.getElementById('ai-widget-container');
            container.classList.remove('error-state');
            container.classList.add('talking');
            
            // 1. Ganti Ekspresi Ke THINKING
            setAiExpression('thinking');

            responseText.innerHTML = `<span style="color:#f59e0b;">[${charName}]</span> Memproses perintah... ⏱️`;
            input.value = '';

            try {
                const res = await fetch('index.php?url=ai/ask', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ 
                        prompt: userText,
                        is_admin: true,
                        ai_name: charName
                    })
                });
                
                const result = await res.json();
                container.classList.remove('talking');

                let formattedReply = result.reply
                    .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                    .replace(/\*(.*?)\*/g, '<i>$1</i>')
                    .replace(/\n/g, '<br>');

                responseText.innerHTML = formattedReply;

                // 2. Ganti Ekspresi Ke SUCCESS saat respons berhasil
                setAiExpression('success');
                setTimeout(() => { setAiExpression('idle'); }, 4000);

                if (result.action === 'reload') {
                    setTimeout(() => location.reload(), 1500);
                } else if (result.action === 'logout_admin') {
                    localStorage.removeItem('is_admin');
                    setTimeout(() => location.reload(), 1200);
                }

            } catch (err) {
                container.classList.remove('talking');
                container.classList.add('error-state');

                // 3. Ganti Ekspresi Ke ERROR saat gagal
                setAiExpression('error');
                responseText.innerHTML = `<span style="color:#ef4444;">Gagal menghubungi server.</span>`;
                
                setTimeout(() => {
                    container.classList.remove('error-state');
                    setAiExpression('idle');
                }, 3000);
            }
        };

        updateAdminUI();
        loadGTCharCustomization();
    </script>
</body>
</html>