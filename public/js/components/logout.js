document.getElementById('logoutBtn').addEventListener('submit', function(e) {
    e.preventDefault();

    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Anda akan keluar dari akun ini!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Logout!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            e.target.submit();
        }
    });
});