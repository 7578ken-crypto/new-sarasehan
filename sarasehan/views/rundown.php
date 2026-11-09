<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kegiatan & Rundown - Sarasehan</title>
    <style>
        :root { --primary: #3b82f6; --success: #10b981; --bg: #f8fafc; --border: #e2e8f0; --muted: #64748b; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', system-ui, sans-serif; }
        body { background: var(--bg); color: #1e293b; min-height: 100vh; display: flex; flex-direction: column; }
        .hidden { display: none !important; }
        .navbar { background: #fff; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border); }
        .nav-links { display: flex; list-style: none; gap: 8px; }
        .nav-btn { background: transparent; border: none; padding: 8px 18px; border-radius: 20px; font-weight: 600; color: var(--muted); cursor: pointer; text-decoration: none; }
        .nav-btn.active { background: var(--primary); color: #fff; }
        .container { max-width: 1100px; margin: 2rem auto; padding: 0 1.5rem; flex: 1; width: 100%; }
        .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
        .btn { padding: 8px 16px; border-radius: 8px; font-weight: 600; cursor: pointer; border: none; }
        .btn-success { background: var(--success); color: #fff; }
        .btn-primary { background: var(--primary); color: #fff; }
        .btn-action { padding: 4px 10px; font-size: 0.8rem; border-radius: 6px; border: none; cursor: pointer; font-weight: 600; }
        .btn-edit { background: #e0f2fe; color: #0284c7; }
        .btn-del { background: #fee2e2; color: #dc2626; }
        .timeline-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.5rem; }
        .timeline-card { background: #fff; border-radius: 14px; border: 1px solid var(--border); overflow: hidden; display: flex; flex-direction: column; }
        .timeline-header { padding: 1.2rem; color: #fff; font-weight: 700; }
        .timeline-header.day-1 { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
        .timeline-header.day-2 { background: linear-gradient(135deg, #10b981, #047857); }
        .timeline-list { list-style: none; padding: 1.2rem; flex-grow: 1; }
        .timeline-list li { padding: 8px 0; border-bottom: 1px dashed var(--border); font-size: 0.9rem; }
        .timeline-actions { padding: 1rem; background: #f8fafc; border-top: 1px solid var(--border); display: flex; gap: 8px; justify-content: flex-end; }
        .modal { position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); display: flex; justify-content: center; align-items: center; z-index: 200; }
        .modal-content { background: #fff; padding: 2rem; border-radius: 16px; width: 90%; max-width: 480px; position: relative; }
        .close-modal { position: absolute; top: 16px; right: 20px; font-size: 1.5rem; cursor: pointer; color: var(--muted); }
        .form-group { margin-bottom: 1rem; text-align: left; }
        .form-group label { display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.4rem; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 10px; border: 1.5px solid var(--border); border-radius: 8px; }
        footer { text-align: center; padding: 2rem; color: var(--muted); font-size: 0.85rem; border-top: 1px solid var(--border); background: #fff; }
    </style>
</head>
<body>

    <header class="navbar">
        <h2>Informasi Kelas</h2>
        <nav>
            <ul class="nav-links">
                <li><a href="home" class="nav-btn">Home</a></li>
                <li><a href="rundown" class="nav-btn active">Kegiatan</a></li>
                <li><a href="anggota" class="nav-btn">Anggota Kelas</a></li>
                <li><a href="gallery" class="nav-btn">Gallery</a></li>
            </ul>
        </nav>
        <button onclick="toggleRole()" class="btn btn-primary" id="role-btn">Switch Mode Admin</button>
    </header>

    <main class="container">
        <div class="section-header">
            <h2>Rundown Kegiatan Sarasehan</h2>
            <button class="btn btn-success admin-only hidden" onclick="openModal()">+ Tambah Agenda</button>
        </div>
        <div id="rundown-grid" class="timeline-grid"></div>
    </main>

    <!-- Modal Form -->
    <div id="modal-rundown" class="modal hidden">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal()">&times;</span>
            <h3 id="modal-title">Tambah Agenda Rundown</h3>
            <form id="form-rundown">
                <input type="hidden" id="r-id">
                <div class="form-group">
                    <label>Tema Warna Sesi</label>
                    <select id="r-daytype">
                        <option value="day-1">Biru (Hari Ke-1)</option>
                        <option value="day-2">Hijau (Hari Ke-2)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Judul Sesi / Hari</label>
                    <input type="text" id="r-judul" required placeholder="Contoh: HARI PERTAMA: Dinamika Kelas">
                </div>
                <div class="form-group">
                    <label>Daftar Jadwal (Satu baris per kegiatan)</label>
                    <textarea id="r-items" rows="5" required placeholder="14.00 - 15.00: Registrasi"></textarea>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">Simpan Agenda</button>
            </form>
        </div>
    </div>

    <footer><p>&copy; 2026 Informasi Kelas. All Rights Reserved.</p></footer>

    <script>
        let currentRole = 'user';
        let rundowns = <?php echo json_encode($rundowns); ?>;

        function toggleRole() {
            currentRole = currentRole === 'user' ? 'admin' : 'user';
            document.getElementById('role-btn').textContent = currentRole === 'admin' ? 'Mode: Admin' : 'Switch Mode Admin';
            document.querySelectorAll('.admin-only').forEach(el => el.classList.toggle('hidden', currentRole !== 'admin'));
            render();
        }

        function render() {
            const rGrid = document.getElementById('rundown-grid');
            rGrid.innerHTML = rundowns.map(r => {
                const itemsList = Array.isArray(r.items) ? r.items.map(i => `<li>${i}</li>`).join('') : '';
                return `
                    <div class="timeline-card">
                        <div class="timeline-header ${r.day_type || 'day-1'}">
                            <h3>${r.judul}</h3>
                        </div>
                        <ul class="timeline-list">${itemsList}</ul>
                        ${currentRole === 'admin' ? `
                            <div class="timeline-actions">
                                <button class="btn-action btn-edit" onclick="editRundown(${r.id})">Edit</button>
                                <button class="btn-action btn-del" onclick="deleteRundown(${r.id})">Hapus</button>
                            </div>
                        ` : ''}
                    </div>
                `;
            }).join('');
        }

        function openModal() {
            document.getElementById('form-rundown').reset();
            document.getElementById('r-id').value = '';
            document.getElementById('modal-title').textContent = 'Tambah Agenda Rundown';
            document.getElementById('modal-rundown').classList.remove('hidden');
        }
        function closeModal() { document.getElementById('modal-rundown').classList.add('hidden'); }

        function editRundown(id) {
            const r = rundowns.find(i => i.id == id);
            if (r) {
                document.getElementById('r-id').value = r.id;
                document.getElementById('r-daytype').value = r.day_type || 'day-1';
                document.getElementById('r-judul').value = r.judul;
                document.getElementById('r-items').value = Array.isArray(r.items) ? r.items.join('\n') : '';
                document.getElementById('modal-title').textContent = 'Edit Agenda Rundown';
                document.getElementById('modal-rundown').classList.remove('hidden');
            }
        }

        async function deleteRundown(id) {
            if (confirm('Hapus agenda ini?')) {
                await fetch(`RundownController/delete/${id}`);
                location.reload();
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
            const url = id ? `RundownController/update/${id}` : 'RundownController/store';
            await fetch(url, { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(data) });
            location.reload();
        };

        render();
    </script>
</body>
</html>