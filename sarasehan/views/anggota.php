<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anggota Kelas - Sarasehan</title>
    <style>
        :root { --primary: #3b82f6; --success: #10b981; --danger: #ef4444; --bg: #f8fafc; --border: #e2e8f0; --muted: #64748b; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', system-ui, sans-serif; }
        body { background: var(--bg); color: #1e293b; min-height: 100vh; display: flex; flex-direction: column; }
        .hidden { display: none !important; }

        .navbar { background: #fff; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border); }
        .nav-links { display: flex; list-style: none; gap: 8px; }
        .nav-btn { background: transparent; border: none; padding: 8px 18px; border-radius: 20px; font-weight: 600; color: var(--muted); text-decoration: none; }
        .nav-btn.active { background: var(--primary); color: #fff; }

        .container { max-width: 1100px; margin: 2rem auto; padding: 0 1.5rem; flex: 1; width: 100%; }
        .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
        .category-heading { font-size: 1.1rem; color: var(--muted); margin: 1.5rem 0 1rem; border-left: 4px solid var(--primary); padding-left: 10px; font-weight: 700; }
        
        .btn { padding: 8px 16px; border-radius: 8px; font-weight: 600; cursor: pointer; border: none; }
        .btn-success { background: var(--success); color: #fff; }
        .btn-primary { background: var(--primary); color: #fff; }
        .btn-action { padding: 4px 10px; font-size: 0.8rem; border-radius: 6px; border: none; cursor: pointer; font-weight: 600; }
        .btn-edit { background: #e0f2fe; color: #0284c7; }
        .btn-del { background: #fee2e2; color: #dc2626; }

        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(230px, 1fr)); gap: 1.5rem; }
        .teacher-box { display: flex; justify-content: center; margin-bottom: 2rem; }
        
        .card-teacher { background: linear-gradient(145deg, #ffffff 0%, #f0f7ff 100%); border: 2px solid #3b82f6; border-radius: 16px; padding: 2rem; width: 100%; max-width: 420px; display: flex; flex-direction: column; }
        .card-member { background: #fff; border-radius: 12px; border: 1px solid var(--border); padding: 1.5rem 1rem; display: flex; flex-direction: column; justify-content: space-between; min-height: 250px; }
        .card-officer { background: linear-gradient(160deg, #ffffff 0%, #f0fdf4 100%); border: 1.5px solid #10b981; }
        
        /* FOTO KUNCI 1:1 DENGAN PRESET WAJAH UTUH (TOP CENTER POSITIONING) */
        .photo-std { 
            width: 100px;
            height: 100px;
            aspect-ratio: 1 / 1; 
            object-fit: cover; 
            object-position: top center; /* Memasukkan area kepala & wajah secara penuh */
            border-radius: 12px; 
            border: 3px solid #fff; 
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); 
            margin-bottom: 0.8rem; 
            transition: all 0.2s ease; 
        }

        .card-teacher .photo-std {
            width: 120px;
            height: 120px;
        }

        .align-left { align-items: flex-start; text-align: left; }
        .align-center { align-items: center; text-align: center; }
        .align-right { align-items: flex-end; text-align: right; }

        .role-badge { display: inline-block; padding: 4px 12px; border-radius: 14px; font-size: 0.75rem; font-weight: 700; margin-top: 4px; }
        .role-officer { background: #10b981; color: #fff; }
        .role-student { background: #e2e8f0; color: var(--muted); }

        .modal { position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); display: flex; justify-content: center; align-items: center; z-index: 200; }
        .modal-content { background: #fff; padding: 2rem; border-radius: 16px; width: 90%; max-width: 480px; position: relative; max-height: 90vh; overflow-y: auto; }
        .close-modal { position: absolute; top: 16px; right: 20px; font-size: 1.5rem; cursor: pointer; color: var(--muted); }
        .form-group { margin-bottom: 1rem; text-align: left; }
        .form-group label { display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.4rem; }
        .form-group input, .form-group select { width: 100%; padding: 10px; border: 1.5px solid var(--border); border-radius: 8px; }

        .admin-badge { background: #fef3c7; color: #b45309; padding: 4px 12px; border-radius: 12px; font-size: 0.8rem; font-weight: 700; }
        footer { text-align: center; padding: 2rem; color: var(--muted); font-size: 0.85rem; border-top: 1px solid var(--border); background: #fff; }

        @keyframes popUp {
            from { opacity: 0; transform: translateY(15px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
    </style>
</head>
<body>

    <header class="navbar">
        <h2>Informasi Kelas</h2>
        <nav>
            <ul class="nav-links">
                <li><a href="home" class="nav-btn">Home & Kegiatan</a></li>
                <li><a href="anggota" class="nav-btn active">Anggota Kelas</a></li>
                <li><a href="gallery" class="nav-btn">Gallery</a></li>
            </ul>
        </nav>
        <div id="admin-status-area"></div>
    </header>

    <main class="container">
        <div class="section-header">
            <h2>Struktur & Anggota Kelas</h2>
            <button class="btn btn-success admin-only hidden" onclick="openModal()">+ Tambah Anggota</button>
        </div>

        <div class="category-heading">Wali Kelas</div>
        <div id="teacher-grid" class="teacher-box"></div>

        <div class="category-heading">Pengurus Inti Kelas</div>
        <div id="officers-grid" class="grid"></div>

        <div class="category-heading">Anggota Siswa</div>
        <div id="students-grid" class="grid"></div>
    </main>

    <!-- Modal Form Admin -->
    <div id="modal-member" class="modal hidden">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal()">&times;</span>
            <h3 id="modal-title">Tambah Anggota Kelas</h3>
            <form id="form-member" enctype="multipart/form-data">
                <input type="hidden" id="m-id">
                
                <div class="form-group">
                    <label>Kategori Peran</label>
                    <select id="m-kategori" onchange="handleKategoriChange()" required>
                        <option value="pengurus">Pengurus Kelas</option>
                        <option value="siswa">Anggota Siswa</option>
                        <option value="wali">Wali Kelas</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" id="m-nama" required placeholder="Nama Lengkap">
                </div>

                <div class="form-group">
                    <label>Jabatan</label>
                    <select id="m-jabatan-select" onchange="handleJabatanChange()" required>
                        <option value="Siswa">Siswa</option>
                        <option value="Wali Kelas">Wali Kelas</option>
                        <option value="Ketua Kelas">Ketua Kelas</option>
                        <option value="Wakil Ketua Kelas">Wakil Ketua Kelas</option>
                        <option value="Sekretaris">Sekretaris</option>
                        <option value="Bendahara">Bendahara</option>
                        <option value="Seksi Kerohanian">Seksi Kerohanian</option>
                        <option value="Seksi Kebersihan">Seksi Kebersihan</option>
                        <option value="Seksi Humas">Seksi Humas</option>
                        <option value="custom">-- Input Jabatan Lainnya --</option>
                    </select>
                    <input type="text" id="m-jabatan-custom" class="hidden" placeholder="Ketik Jabatan Khusus..." style="margin-top: 8px;">
                </div>

                <div class="form-group">
                    <label>Posisi Tata Letak Foto (Rasio 1:1)</label>
                    <select id="m-layout-align">
                        <option value="center">Tengah (Center Alignment)</option>
                        <option value="left">Kiri (Left Alignment)</option>
                        <option value="right">Kanan (Right Alignment)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Upload Foto dari Folder Perangkat</label>
                    <input type="file" id="m-foto-file" accept="image/*">
                </div>

                <div class="form-group">
                    <label>Atau Gunakan URL Foto</label>
                    <input type="text" id="m-foto-url" placeholder="https://via.placeholder.com/150">
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">Simpan Anggota & Layout</button>
            </form>
        </div>
    </div>

    <!-- ================= WIDGET ADMIN AI ASSISTANT (HANYA MUNCUL DI DASHBOARD ADMIN) ================= -->
    <div id="ai-widget-container" class="admin-only hidden" style="position: fixed; bottom: 25px; right: 25px; z-index: 999;">
        <button id="ai-toggle-btn" onclick="toggleAiChat()" style="background: linear-gradient(135deg, #0f172a, #1e293b); color: #fff; border: 2px solid #3b82f6; padding: 10px 18px; border-radius: 50px; font-weight: 700; cursor: pointer; box-shadow: 0 10px 25px rgba(0,0,0,0.3); display: flex; align-items: center; gap: 10px; font-size: 0.9rem;">
            <div style="width: 28px; height: 28px; background: #3b82f6; border-radius: 50%; display: flex; justify-content: center; align-items: center; font-size: 1rem;">🤖</div>
            <span>Admin AI Assistant</span>
        </button>

        <div id="ai-chat-box" class="hidden" style="position: absolute; bottom: 65px; right: 0; width: 360px; height: 460px; background: #fff; border: 1px solid var(--border); border-radius: 16px; display: flex; flex-direction: column; box-shadow: 0 20px 35px rgba(0, 0, 0, 0.2); overflow: hidden; animation: popUp 0.25s ease;">
            <div style="background: linear-gradient(135deg, #0f172a, #1e293b); color: #fff; padding: 14px 16px; display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #3b82f6;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 36px; height: 36px; background: #3b82f6; border-radius: 50%; display: flex; justify-content: center; align-items: center; font-size: 1.3rem;">🤖</div>
                    <div>
                        <h4 style="font-size: 0.95rem; margin: 0; font-weight: 700;">Jarvis (Asisten Anggota)</h4>
                        <span style="font-size: 0.72rem; color: #f59e0b;">⚡ Dashboard Admin Mode</span>
                    </div>
                </div>
                <span onclick="toggleAiChat()" style="cursor: pointer; font-size: 1.4rem; color: #94a3b8;">&times;</span>
            </div>

            <div id="ai-messages" style="flex: 1; padding: 14px; overflow-y: auto; font-size: 0.85rem; display: flex; flex-direction: column; gap: 10px; background: #f8fafc;">
                <div style="background: #fff; padding: 10px 14px; border-radius: 12px; border: 1px solid var(--border); max-width: 88%; align-self: flex-start; line-height: 1.4; color: #1e293b;">
                    Halo Bos Admin! 🫡 Siap bantu kelola anggota kelas. Perintahkan saya seperti:<br>
                    • <i>"tambah anggota Andi - Ketua Kelas"</i>
                </div>
            </div>

            <form id="ai-form" style="display: flex; padding: 10px; border-top: 1px solid var(--border); background: #fff; gap: 6px;">
                <input type="text" id="ai-input" placeholder="Perintahkan Jarvis..." style="flex: 1; padding: 10px 12px; border: 1.5px solid var(--border); border-radius: 8px; font-size: 0.85rem; outline: none;" required>
                <button type="submit" class="btn btn-primary" style="padding: 8px 14px; font-size: 0.85rem;">Kirim</button>
            </form>
        </div>
    </div>

    <footer><p>&copy; 2026 Informasi Kelas. All Rights Reserved.</p></footer>

    <script>
        let members = <?php echo json_encode($members); ?>;
        let isAdmin = localStorage.getItem('is_admin') === 'true';

        function handleKategoriChange() {
            const kategori = document.getElementById('m-kategori').value;
            const selectJabatan = document.getElementById('m-jabatan-select');
            
            if (kategori === 'wali') {
                selectJabatan.value = 'Wali Kelas';
            } else if (kategori === 'siswa') {
                selectJabatan.value = 'Siswa';
            } else if (kategori === 'pengurus' && (selectJabatan.value === 'Siswa' || selectJabatan.value === 'Wali Kelas')) {
                selectJabatan.value = 'Ketua Kelas';
            }
            handleJabatanChange();
        }

        function handleJabatanChange() {
            const selectVal = document.getElementById('m-jabatan-select').value;
            const customInput = document.getElementById('m-jabatan-custom');
            
            if (selectVal === 'custom') {
                customInput.classList.remove('hidden');
                customInput.required = true;
            } else {
                customInput.classList.add('hidden');
                customInput.required = false;
            }
        }

        function updateAdminUI() {
            const statusArea = document.getElementById('admin-status-area');
            const adminOnlyElements = document.querySelectorAll('.admin-only');
            
            if (isAdmin) {
                statusArea.innerHTML = `<span class="admin-badge">Admin Mode Active</span>`;
                adminOnlyElements.forEach(el => el.classList.remove('hidden'));
            } else {
                statusArea.innerHTML = ``;
                adminOnlyElements.forEach(el => el.classList.add('hidden'));
            }
            render();
        }

        function render() {
            const tGrid = document.getElementById('teacher-grid');
            const oGrid = document.getElementById('officers-grid');
            const sGrid = document.getElementById('students-grid');

            const wali = members.find(m => m.kategori === 'wali');
            
            if (wali) {
                const alignClass = wali.align ? `align-${wali.align}` : 'align-center';

                tGrid.innerHTML = `
                    <div class="card-teacher ${alignClass}">
                        <img src="${wali.foto}" class="photo-std">
                        <h3>${wali.nama}</h3>
                        <span class="role-badge role-officer">⭐ ${wali.jabatan}</span>
                        ${isAdmin ? `<button class="btn-action btn-edit" style="margin-top:10px" onclick="editMember(${wali.id})">Edit Wali Kelas</button>` : ''}
                    </div>
                `;
            } else {
                tGrid.innerHTML = '';
            }

            oGrid.innerHTML = '';
            sGrid.innerHTML = '';

            members.filter(m => m.kategori !== 'wali').forEach(m => {
                const isOfficer = m.kategori === 'pengurus';
                const alignClass = m.align ? `align-${m.align}` : 'align-center';

                const card = document.createElement('div');
                card.className = `card-member ${isOfficer ? 'card-officer' : ''} ${alignClass}`;
                card.innerHTML = `
                    <img src="${m.foto}" class="photo-std">
                    <div>
                        <h4 style="font-size:0.95rem">${m.nama}</h4>
                        <span class="role-badge ${isOfficer ? 'role-officer' : 'role-student'}">${isOfficer ? '✨ ' : ''}${m.jabatan}</span>
                    </div>
                    ${isAdmin ? `
                        <div style="display:flex; gap:6px; margin-top:10px;">
                            <button class="btn-action btn-edit" onclick="editMember(${m.id})">Edit</button>
                            <button class="btn-action btn-del" onclick="deleteMember(${m.id})">Hapus</button>
                        </div>
                    ` : ''}
                `;
                if (isOfficer) oGrid.appendChild(card);
                else sGrid.appendChild(card);
            });
        }

        function openModal() {
            document.getElementById('form-member').reset();
            document.getElementById('m-id').value = '';
            document.getElementById('modal-title').textContent = 'Tambah Anggota Kelas';
            document.getElementById('m-layout-align').value = 'center';
            handleJabatanChange();
            document.getElementById('modal-member').classList.remove('hidden');
        }
        function closeModal() { document.getElementById('modal-member').classList.add('hidden'); }

        function editMember(id) {
            const m = members.find(i => i.id == id);
            if (m) {
                document.getElementById('m-id').value = m.id;
                document.getElementById('m-kategori').value = m.kategori;
                document.getElementById('m-nama').value = m.nama;
                document.getElementById('m-foto-url').value = m.foto;
                document.getElementById('m-layout-align').value = m.align || 'center';

                const selectJabatan = document.getElementById('m-jabatan-select');
                const customInput = document.getElementById('m-jabatan-custom');
                
                const options = Array.from(selectJabatan.options).map(o => o.value);
                if (options.includes(m.jabatan)) {
                    selectJabatan.value = m.jabatan;
                    customInput.value = '';
                } else {
                    selectJabatan.value = 'custom';
                    customInput.value = m.jabatan;
                }

                handleJabatanChange();
                document.getElementById('modal-title').textContent = 'Edit Data Anggota';
                document.getElementById('modal-member').classList.remove('hidden');
            }
        }

        async function deleteMember(id) {
            if (confirm('Hapus anggota ini?')) {
                try {
                    const res = await fetch(`index.php?url=anggota/delete/${id}`);
                    const result = await res.json();
                    if (result.success) {
                        alert('Anggota berhasil dihapus!');
                        location.reload();
                    } else {
                        alert('Gagal menghapus anggota');
                    }
                } catch (e) {
                    alert('Terjadi kesalahan server.');
                }
            }
        }

        document.getElementById('form-member').onsubmit = async (e) => {
            e.preventDefault();
            const id = document.getElementById('m-id').value;
            
            const selectVal = document.getElementById('m-jabatan-select').value;
            const customVal = document.getElementById('m-jabatan-custom').value;
            const finalJabatan = selectVal === 'custom' ? customVal : selectVal;

            const formData = new FormData();
            formData.append('nama', document.getElementById('m-nama').value);
            formData.append('kategori', document.getElementById('m-kategori').value);
            formData.append('jabatan', finalJabatan);
            formData.append('foto_url', document.getElementById('m-foto-url').value);
            formData.append('align', document.getElementById('m-layout-align').value);

            const fileInput = document.getElementById('m-foto-file');
            if (fileInput.files.length > 0) {
                formData.append('foto_file', fileInput.files[0]);
            }

            const endpoint = id ? `index.php?url=anggota/update/${id}` : 'index.php?url=anggota/store';
            
            try {
                const res = await fetch(endpoint, { method: 'POST', body: formData });
                const result = await res.json();
                if (result.success) {
                    alert('Data anggota berhasil disimpan!');
                    closeModal();
                    location.reload();
                } else {
                    alert('Gagal menyimpan data anggota');
                }
            } catch (e) {
                alert('Gagal menyimpan data, periksa koneksi.');
            }
        };

        // --- SKRIP JARVIS AI ---
        function toggleAiChat() {
            document.getElementById('ai-chat-box').classList.toggle('hidden');
        }

        document.getElementById('ai-form').onsubmit = async (e) => {
            e.preventDefault();
            const input = document.getElementById('ai-input');
            const msgBox = document.getElementById('ai-messages');
            const userText = input.value.trim();

            if (!userText) return;

            msgBox.innerHTML += `
                <div style="background: var(--primary); color: #fff; padding: 10px 14px; border-radius: 12px; max-width: 85%; align-self: flex-end;">
                    ${escapeHtml(userText)}
                </div>
            `;
            input.value = '';
            msgBox.scrollTop = msgBox.scrollHeight;

            const loadingId = 'loading-' + Date.now();
            msgBox.innerHTML += `
                <div id="${loadingId}" style="background: #fff; padding: 10px 14px; border-radius: 12px; border: 1px solid var(--border); max-width: 85%; align-self: flex-start; font-style: italic; color: var(--muted);">
                    Jarvis memproses...
                </div>
            `;
            msgBox.scrollTop = msgBox.scrollHeight;

            try {
                const res = await fetch('index.php?url=ai/ask', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ prompt: userText, is_admin: true })
                });
                
                const result = await res.json();
                document.getElementById(loadingId).remove();

                let formattedReply = result.reply.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>').replace(/\n/g, '<br>');
                msgBox.innerHTML += `
                    <div style="background: #fff; padding: 10px 14px; border-radius: 12px; border: 1px solid var(--border); max-width: 88%; align-self: flex-start;">
                        ${formattedReply}
                    </div>
                `;

                if (result.action === 'reload') setTimeout(() => location.reload(), 1500);
            } catch (err) {
                document.getElementById(loadingId).remove();
            }
            msgBox.scrollTop = msgBox.scrollHeight;
        };

        function escapeHtml(text) {
            return text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;");
        }

        updateAdminUI();
    </script>
</body>
</html>