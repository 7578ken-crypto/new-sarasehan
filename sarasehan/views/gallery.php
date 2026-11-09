<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Media - Sarasehan</title>
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
        
        .btn { padding: 8px 16px; border-radius: 8px; font-weight: 600; cursor: pointer; border: none; }
        .btn-success { background: var(--success); color: #fff; }
        .btn-primary { background: var(--primary); color: #fff; }
        .btn-action { padding: 4px 10px; font-size: 0.8rem; border-radius: 6px; border: none; cursor: pointer; font-weight: 600; }
        .btn-edit { background: #e0f2fe; color: #0284c7; }
        .btn-del { background: #fee2e2; color: #dc2626; }

        .gallery-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem; }
        .gallery-card { height: 230px; border-radius: 12px; border: 1px solid var(--border); overflow: hidden; position: relative; background: #0f172a; }
        .gallery-card img, .gallery-card video { width: 100%; height: 100%; object-fit: cover; display: block; }
        .gallery-badge { position: absolute; top: 12px; left: 12px; background: rgba(15, 23, 42, 0.8); color: #fff; font-size: 0.72rem; font-weight: 700; padding: 4px 10px; border-radius: 20px; z-index: 2; }
        .gallery-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(15, 23, 42, 0.85), transparent); display: flex; justify-content: center; align-items: flex-end; padding: 15px; opacity: 0; transition: 0.3s; z-index: 3; }
        .gallery-card:hover .gallery-overlay { opacity: 1; }

        .modal { position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); display: flex; justify-content: center; align-items: center; z-index: 200; }
        .modal-content { background: #fff; padding: 2rem; border-radius: 16px; width: 90%; max-width: 450px; position: relative; }
        .close-modal { position: absolute; top: 16px; right: 20px; font-size: 1.5rem; cursor: pointer; color: var(--muted); }
        .form-group { margin-bottom: 1rem; text-align: left; }
        .form-group label { display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.4rem; }
        .form-group input, .form-group select { width: 100%; padding: 10px; border: 1.5px solid var(--border); border-radius: 8px; }
        
        .preview-box { width: 100%; height: 150px; border: 2px dashed var(--border); border-radius: 8px; margin-top: 8px; display: flex; justify-content: center; align-items: center; overflow: hidden; background: #f8fafc; }
        .preview-box img, .preview-box video { max-width: 100%; max-height: 100%; object-fit: contain; }

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
                <li><a href="anggota" class="nav-btn">Anggota Kelas</a></li>
                <li><a href="gallery" class="nav-btn active">Gallery</a></li>
            </ul>
        </nav>
        <div id="admin-status-area"></div>
    </header>

    <main class="container">
        <div class="section-header">
            <h2>Galeri Foto & Video</h2>
            <button class="btn btn-success admin-only hidden" onclick="openModal()">+ Tambah Media</button>
        </div>
        <div id="gallery-grid" class="gallery-grid"></div>
    </main>

    <!-- Modal Form Upload Galeri -->
    <div id="modal-media" class="modal hidden">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal()">&times;</span>
            <h3 id="modal-title">Tambah Media Galeri</h3>
            <form id="form-media" enctype="multipart/form-data">
                <input type="hidden" id="g-id">
                
                <div class="form-group">
                    <label>Tipe Media</label>
                    <select id="g-tipe" onchange="handleTypeChange()">
                        <option value="image">Foto (Gambar)</option>
                        <option value="video">Video (MP4)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Upload dari Folder Perangkat</label>
                    <input type="file" id="g-file" accept="image/*" onchange="previewMedia(this)">
                </div>

                <div class="preview-box hidden" id="preview-box"></div>

                <div class="form-group" style="margin-top: 1rem;">
                    <label>Atau Gunakan URL Media (Opsional)</label>
                    <input type="text" id="g-src-url" placeholder="https://example.com/foto.jpg">
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">Simpan ke Folder images/</button>
            </form>
        </div>
    </div>

    <!-- ================= WIDGET ADMIN AI ASSISTANT ================= -->
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
                        <h4 style="font-size: 0.95rem; margin: 0; font-weight: 700;">Jarvis (Asisten Galeri)</h4>
                        <span style="font-size: 0.72rem; color: #f59e0b;">⚡ Dashboard Admin Mode</span>
                    </div>
                </div>
                <span onclick="toggleAiChat()" style="cursor: pointer; font-size: 1.4rem; color: #94a3b8;">&times;</span>
            </div>

            <div id="ai-messages" style="flex: 1; padding: 14px; overflow-y: auto; font-size: 0.85rem; display: flex; flex-direction: column; gap: 10px; background: #f8fafc;">
                <div style="background: #fff; padding: 10px 14px; border-radius: 12px; border: 1px solid var(--border); max-width: 88%; align-self: flex-start; line-height: 1.4; color: #1e293b;">
                    Halo Bos Admin! 🫡 Saya <b>Jarvis AI</b>, siap membantu pengelolaan media galeri.
                </div>
            </div>

            <form id="ai-form" style="display: flex; padding: 10px; border-top: 1px solid var(--border); background: #fff; gap: 6px;">
                <input type="text" id="ai-input" placeholder="Tanyakan atau berikan perintah..." style="flex: 1; padding: 10px 12px; border: 1.5px solid var(--border); border-radius: 8px; font-size: 0.85rem; outline: none;" required>
                <button type="submit" class="btn btn-primary" style="padding: 8px 14px; font-size: 0.85rem;">Kirim</button>
            </form>
        </div>
    </div>

    <footer><p>&copy; 2026 Informasi Kelas. All Rights Reserved.</p></footer>

    <script>
        let gallery = <?php echo json_encode($gallery); ?>;
        let isAdmin = localStorage.getItem('is_admin') === 'true';

        function handleTypeChange() {
            const tipe = document.getElementById('g-tipe').value;
            const fileInput = document.getElementById('g-file');
            if (tipe === 'video') {
                fileInput.accept = 'video/mp4,video/webm,video/ogg';
            } else {
                fileInput.accept = 'image/*';
            }
        }

        function previewMedia(input) {
            const box = document.getElementById('preview-box');
            box.innerHTML = '';
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                const file = input.files[0];
                const isVideo = file.type.startsWith('video/');

                reader.onload = function(e) {
                    box.classList.remove('hidden');
                    if (isVideo) {
                        box.innerHTML = `<video src="${e.target.result}" controls></video>`;
                    } else {
                        box.innerHTML = `<img src="${e.target.result}">`;
                    }
                }
                reader.readAsDataURL(file);
            } else {
                box.classList.add('hidden');
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
            const gGrid = document.getElementById('gallery-grid');
            gGrid.innerHTML = gallery.map(g => `
                <div class="gallery-card">
                    <span class="gallery-badge">${g.tipe === 'video' ? '📹 Video' : '📷 Foto'}</span>
                    ${g.tipe === 'video' ? `<video controls src="${g.src}"></video>` : `<img src="${g.src}">`}
                    ${isAdmin ? `
                        <div class="gallery-overlay">
                            <button class="btn-action btn-edit" onclick="editMedia(${g.id})">Edit</button>
                            <button class="btn-action btn-del" onclick="deleteMedia(${g.id})">Hapus</button>
                        </div>
                    ` : ''}
                </div>
            `).join('');
        }

        function openModal() {
            document.getElementById('form-media').reset();
            document.getElementById('g-id').value = '';
            document.getElementById('modal-title').textContent = 'Tambah Media Galeri';
            document.getElementById('preview-box').classList.add('hidden');
            document.getElementById('modal-media').classList.remove('hidden');
        }
        function closeModal() { document.getElementById('modal-media').classList.add('hidden'); }

        function editMedia(id) {
            const g = gallery.find(i => i.id == id);
            if (g) {
                document.getElementById('g-id').value = g.id;
                document.getElementById('g-tipe').value = g.tipe;
                document.getElementById('g-src-url').value = g.src;
                document.getElementById('modal-title').textContent = 'Edit Media Galeri';
                document.getElementById('preview-box').classList.add('hidden');
                document.getElementById('modal-media').classList.remove('hidden');
            }
        }

        async function deleteMedia(id) {
            if (confirm('Hapus media ini dari galeri?')) {
                try {
                    const res = await fetch(`index.php?url=gallery/delete/${id}`);
                    const result = await res.json();
                    if (result.success) {
                        alert('Media berhasil dihapus!');
                        location.reload();
                    } else {
                        alert('Gagal menghapus media');
                    }
                } catch (e) {
                    alert('Terjadi kesalahan server.');
                }
            }
        }

        document.getElementById('form-media').onsubmit = async (e) => {
            e.preventDefault();
            const id = document.getElementById('g-id').value;
            
            const formData = new FormData();
            formData.append('tipe', document.getElementById('g-tipe').value);
            formData.append('src_url', document.getElementById('g-src-url').value);

            const fileInput = document.getElementById('g-file');
            if (fileInput.files.length > 0) {
                formData.append('media_file', fileInput.files[0]);
            }

            const endpoint = id ? `index.php?url=gallery/update/${id}` : 'index.php?url=gallery/store';
            
            try {
                const res = await fetch(endpoint, { method: 'POST', body: formData });
                const result = await res.json();
                if (result.success) {
                    alert('Media galeri berhasil disimpan ke folder images/!');
                    closeModal();
                    location.reload();
                } else {
                    alert('Gagal menyimpan media');
                }
            } catch (e) {
                alert('Gagal menghubungi server.');
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