document.addEventListener('DOMContentLoaded', () => {

    /**
     * ===================================================================
     * SETUP CSRF TOKEN & HEADERS
     * Ini penting agar setiap request AJAX/Fetch ke Laravel aman.
     * ===================================================================
     */
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const apiHeaders = {
        "Content-Type": "application/json",
        "Accept": "application/json",
        "X-CSRF-TOKEN": csrfToken,
        "X-Requested-With": "XMLHttpRequest"
    };

    /**
     * ===================================================================
     * LOGIKA UNTUK MENAMPILKAN FORM LOGIN / REGISTER
     * Logika ini tidak berubah, hanya untuk beralih tampilan.
     * ===================================================================
     */
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    const showRegisterLink = document.getElementById('showRegister');
    const showLoginLink = document.getElementById('showLogin');

    if (showRegisterLink) {
        showRegisterLink.addEventListener('click', (e) => {
            e.preventDefault();
            loginForm.classList.add('hidden');
            registerForm.classList.remove('hidden');
        });
    }

    if (showLoginLink) {
        showLoginLink.addEventListener('click', (e) => {
            e.preventDefault();
            registerForm.classList.add('hidden');
            loginForm.classList.remove('hidden');
        });
    }

    /**
     * ===================================================================
     * LOGIKA SUBMIT FORM PROYEK (CREATE & EDIT)
     * Mengirim data ke API endpoint menggunakan Fetch.
     * ===================================================================
     */
    const projectForm = document.getElementById('projectForm');
    if (projectForm) {
        projectForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = new FormData(projectForm);
            // Ambil semua nilai checkbox pic_user_id[]
            const picUserIds = [];
            projectForm.querySelectorAll('input[name="pic_user_id[]"]:checked').forEach(cb => {
                picUserIds.push(cb.value);
            });

            // Ambil data lain
            const data = {
                name: formData.get('name'),
                description: formData.get('description'),
                start_date: formData.get('start_date'),
                deadline_date: formData.get('deadline_date'),
                priority: formData.get('priority'),
                status: formData.get('status'),
                pic_user_id: picUserIds
            };

            // Jika ada _method (PUT/PATCH)
            let method = 'POST';
            if (formData.get('_method')) {
                method = formData.get('_method');
            }

            const submitButton = projectForm.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.textContent = 'Menyimpan...';

            try {
                const response = await fetch(projectForm.action, {
                    method: method,
                    headers: apiHeaders,
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (!response.ok) {
                    if (response.status === 422) {
                        const errors = Object.values(result.errors).map(err => err.join(', ')).join('\n');
                        alert(`Gagal menyimpan. Harap periksa input Anda:\n\n${errors}`);
                    } else {
                        throw new Error(result.message || 'Terjadi kesalahan pada server.');
                    }
                } else {
                    alert(result.message);
                    window.location.href = '/';
                }
            } catch (error) {
                console.error('Error submitting project form:', error);
                alert('Terjadi kesalahan: ' + error.message);
            } finally {
                submitButton.disabled = false;
                submitButton.textContent = 'Simpan Proyek';
            }
        });
    }


    /**
     * ===================================================================
     * LOGIKA TOMBOL HAPUS PROYEK
     * Mengirim request DELETE ke API.
     * ===================================================================
     */
    const deleteButton = document.getElementById('deleteButton');
    if (deleteButton) {
        deleteButton.addEventListener('click', async (e) => {
            const projectId = deleteButton.dataset.projectId;
            const url = `/api/projects/${projectId}`;

            if (confirm('Apakah Anda yakin ingin menghapus proyek ini? Tindakan ini tidak dapat dibatalkan.')) {
                try {
                    const response = await fetch(url, {
                        method: 'DELETE',
                        headers: apiHeaders
                    });

                    const result = await response.json();

                    if (!response.ok) {
                        throw new Error(result.message || 'Gagal menghapus proyek.');
                    }

                    alert(result.message);
                    window.location.href = '/';
                } catch (error) {
                    console.error('Error deleting project:', error);
                    alert('Terjadi kesalahan: ' + error.message);
                }
            }
        });
    }

    /**
     * ===================================================================
     * LOGIKA KIRIM KOMENTAR
     * Menambahkan komentar secara dinamis tanpa refresh halaman.
     * ===================================================================
     */
    const commentForm = document.getElementById('newCommentForm');
    if (commentForm) {
        commentForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const newCommentText = document.getElementById('newCommentText');
            const commentText = newCommentText.value.trim();
            const url = commentForm.action;
            const commentsList = document.querySelector('.comments-list');

            if (!commentText) {
                alert('Komentar tidak boleh kosong!');
                return;
            }

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: apiHeaders,
                    body: JSON.stringify({ body: commentText })
                });

                const result = await response.json();

                if (!response.ok) {
                    throw new Error(result.message || 'Gagal mengirim komentar.');
                }

                // Buat elemen HTML untuk komentar baru
                const newCommentHtml = `
                    <div class="comment-item">
                        <span class="comment-author">${result.data.user.name}</span> 
                        <span class="comment-date">(Baru saja):</span>
                        <p>${result.data.body}</p>
                    </div>`;

                commentsList.insertAdjacentHTML('beforeend', newCommentHtml);
                newCommentText.value = ''; // Kosongkan textarea

            } catch (error) {
                console.error('Error sending comment:', error);
                alert('Terjadi kesalahan: ' + error.message);
            }
        });
    }
});