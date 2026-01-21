<div id="modalUser" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalUserTitle" class="card-title">Tambah Pengguna</h3>
            <button onclick="closeModal('modalUser')" class="alert-close" style="position:static;">&times;</button>
        </div>
        
        <form id="formUser" method="POST">
            @csrf
            <input type="hidden" id="userMethod" name="_method" value="POST">
            
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Email <span class="text-red">*</span></label>
                    <input type="email" name="email" id="userEmail" required class="form-control" placeholder="user@example.com">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Password <span class="text-red" id="passReq">*</span></label>
                    <input type="password" name="password" id="userPassword" class="form-control" placeholder="******">
                    <small class="text-gray" id="passHint" style="display:none;">Kosongkan jika tidak ingin mengubah password.</small>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" onclick="closeModal('modalUser')" class="btn btn-secondary">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
function openUserModal(id = null, email = '') {
    if (id) {
        document.getElementById('modalUserTitle').innerText = "Edit Pengguna";
        document.getElementById('userMethod').value = "PUT";
        document.getElementById('formUser').action = "/profile/users/" + id;
        
        document.getElementById('userEmail').value = email;
        
        // Ubah tampilan input password untuk mode Edit
        document.getElementById('userPassword').required = false;
        document.getElementById('passReq').style.display = 'none';
        document.getElementById('passHint').style.display = 'block';
    } else {
        document.getElementById('modalUserTitle').innerText = "Tambah Pengguna";
        document.getElementById('userMethod').value = "POST";
        document.getElementById('formUser').action = "{{ route('users.store') }}";
        document.getElementById('formUser').reset();
        
        // Ubah tampilan input password untuk mode Tambah
        document.getElementById('userPassword').required = true;
        document.getElementById('passReq').style.display = 'inline';
        document.getElementById('passHint').style.display = 'none';
    }
    openModal('modalUser');
}
</script>