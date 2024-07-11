<!--   Core JS Files   -->
<script src="{{ asset('template/assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('template/assets/js/core/bootstrap.min.js') }}"></script>
<script src="{{ asset('template/assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('template/assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
<script>
  var win = navigator.platform.indexOf('Win') > -1;
  if (win && document.querySelector('#sidenav-scrollbar')) {
    var options = {
      damping: '0.5'
    }
    Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
  }
</script>
<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
<script src="{{ asset('template/assets/js/material-dashboard.min.js?v=3.0.0') }}"></script>
<!-- DataTable JS -->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.min.js"></script>
<script>
 $(document).ready(function() {
    let kkId = "{{ $kkId }}"; 

    let table = $('#myTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "{{ url('kkdata') }}/" + kkId + "/anggotadata",
            type: 'GET',
        },
        columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false
        },{
            data: 'no_ktp',
            name: 'no_ktp'
        },{
            data: 'nama',
            name: 'nama'
        },{
            data: 'ttl',
            name: 'ttl'
        },{
            data: 'jenis_kelamin',
            name: 'jenis_kelamin'
        },{
            data: 'status',
            name: 'status'
        },{
            data: 'pekerjaan',
            name: 'pekerjaan'
        },{
            data: 'baptis',
            name: 'baptis'
        },{
          data: 'aksi',
          name: 'aksi'
        }]
    });
});

  $('#myTable').closest('.dataTables_wrapper').addClass('card-body').addClass('d-flex flex-column justify-content-center').addClass('mb-0 text-sm');

  //Global Setup
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

 //02-proses simpan
 $('body').on('click', '.tombol-tambah', function(e){
    e.preventDefault();
    var kkId = $(this).data('id');
    $('#detailModal').modal('show');
    $('.tombol-simpan').off('click'); 
    $('.tombol-simpan').click(function(){
        simpan(kkId);
    })
  });

  //03-Proses Edit
  $('body').on('click', '.tombol-edit', function(e) {
    e.preventDefault();
    var kkId = $(this).data('kk-id');
    var anggotaId = $(this).data('id');

    $.ajax({
        url: '/kkdata/' + kkId + '/anggotadata/' + anggotaId,
        type: 'GET',
        success: function(response) {
            if (response.result) {
                $('#detailModal').modal('show');

                var originalData = {
                    no_ktp: response.result.no_ktp || '',
                    nama: response.result.nama || '',
                    ttl: response.result.ttl || '',
                    jenis_kelamin: response.result.jenis_kelamin || '',
                    status: response.result.status || '',
                    pekerjaan: response.result.pekerjaan || '',
                    baptis: response.result.baptis || ''
                };

                $('#no_ktp').val(originalData.no_ktp);
                $('#nama').val(originalData.nama);
                $('#ttl').val(originalData.ttl);
                $('#jenis_kelamin').val(originalData.jenis_kelamin);
                $('#status').val(originalData.status);
                $('#pekerjaan').val(originalData.pekerjaan);
                $('#baptis').val(originalData.baptis);

                // Hapus semua event handler sebelumnya untuk tombol simpan
                $('.tombol-simpan').off('click');

                // Disable tombol simpan saat modal dibuka
                $('.tombol-simpan').prop('disabled', true);

                // Fungsi untuk memeriksa perubahan data
                function checkChanges() {
                    var isChanged = false;
                    var currentData = {
                        no_ktp: $('#no_ktp').val(),
                        nama: $('#nama').val(),
                        ttl: $('#ttl').val(),
                        jenis_kelamin: $('#jenis_kelamin').val(),
                        status: $('#status').val(),
                        pekerjaan: $('#pekerjaan').val(),
                        baptis: $('#baptis').val()
                    };

                    // Periksa apakah ada perbedaan dengan data asli
                    for (var key in originalData) {
                        if (originalData[key] !== currentData[key]) {
                            isChanged = true;
                            break;
                        }
                    }

                    // Aktifkan atau nonaktifkan tombol simpan
                    $('.tombol-simpan').prop('disabled', !isChanged);
                }

                // Tambahkan event listener untuk memeriksa perubahan data
                $('#detailModal input, #detailModal textarea, #detailModal select').on('input change', checkChanges);

                // Tambahkan event handler baru untuk tombol simpan
                $('.tombol-simpan').click(function() {
                    simpan(kkId, anggotaId);
                });
            } else {
                Swal.fire('Error!', 'Data tidak ditemukan.', 'error');
                console.error('Response result is undefined');
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            Swal.fire('Error!', 'Terjadi kesalahan saat mengambil data.', 'error');
        }
    });
});


  // 04-Proses Delete
  $('body').on('click', '.tombol-delete', function(e) {
    e.preventDefault();
    var kkId = $(this).data('kk-id');
    var anggotaId = $(this).data('id');
    if (!kkId || !anggotaId) {
        Swal.fire('Error', 'ID KK atau Anggota tidak ditemukan', 'error');
        return;
    }
      Swal.fire({
          title: 'Apakah Anda yakin?',
          text: 'Data yang dihapus tidak dapat dikembalikan!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, hapus!',
          cancelButtonText: 'Batal'
      }).then((result) => {
          if (result.isConfirmed) {
              $.ajax({
                  url: '/kkdata/' + kkId + '/anggotadata/' + anggotaId,
                  type: 'DELETE',
                  success: function(response) {
                      $('#myTable').DataTable().ajax.reload();
                      Swal.fire('Terhapus!', 'Data anggota berhasil dihapus.', 'success');
                  },
                  error: function(xhr, status, error) {
                      console.error(xhr.responseText);
                      Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus data.', 'error');
                  }
              });
          }
      });
  });




  //fungsi hideMessage
  function hideErrorMessage() {
    $('.alert-danger').addClass('d-none');
    $('.alert-danger').empty(); // Mengosongkan isi pesan error setelah beberapa detik
}

  // fungsi simpan dan update
  function simpan(kkId, anggotaId = '') {
    var var_url;
    var var_type;

    if (anggotaId === '') {
        var_url = '/kkdata/' + kkId + '/anggotadata';
        var_type = 'POST';
    } else {
        var_url = '/kkdata/' + kkId + '/anggotadata/' + anggotaId;
        var_type = 'PUT';
    }

    $.ajax({
        url: var_url,
        type: var_type,
        data: {
            no_ktp: $('#no_ktp').val(),
            nama: $('#nama').val(),
            ttl: $('#ttl').val(),
            jenis_kelamin: $('#jenis_kelamin').val(),
            status: $('#status').val(),
            pekerjaan: $('#pekerjaan').val(),
            baptis: $('#baptis').val(),
            kk_id: kkId
        },
        success: function(response) {
            if (response.errors) {
                $('.alert-danger').removeClass('d-none');
                $('.alert-danger').html("<ul>");
                $.each(response.errors, function(key, value) {
                    $('.alert-danger').find('ul').append("<li>" + value + "</li>");
                });
                $('.alert-danger').append("</ul>");
                setTimeout(hideErrorMessage, 10000);
            } else {
                $('.alert-success').removeClass('d-none');
                $('.alert-success').html(response.success);
                setTimeout(function() {
                    $('.alert-success').addClass('d-none');
                    $('.alert-success').empty();
                }, 10000);
                // $('#detailModal').modal('hide');
                if (var_type === 'POST') {
                    Swal.fire('Sukses!', 'Data berhasil disimpan.', 'success');
                } else {
                    Swal.fire('Sukses!', 'Data berhasil diupdate.', 'success');
                    $('#detailModal').modal('hide');
                }
            }
            $('#myTable').DataTable().ajax.reload();
        }
    });
}


  $('#detailModal').on('hidden.bs.modal', function(){
    $('#no_ktp').val('');
    $('#nama').val('');
    $('#ttl').val('');
    $('#jenis_kelamin').val('');
    $('#status').val('');
    $('#pekerjaan').val('');
    $('#baptis').val('');

    $('.alert-danger').addClass('d-none');
    $('.alert-danger').html('');

    $('.alert-success').addClass('d-none');
    $('.alert-success').html('');
  })
</script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
      document.getElementById('logout-btn').addEventListener('click', function(event) {
          event.preventDefault(); // Mencegah aksi default dari link

          Swal.fire({
              title: 'Anda akan keluar!',
              text: "Apakah Anda Yakin?",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Ya, Keluar!',
              cancelButtonText: 'Batalkan'
          }).then((result) => {
              if (result.isConfirmed) {
                  // Kirim formulir logout jika pengguna mengonfirmasi logout
                  document.getElementById('logout-form').submit();
              }
          });
      });
  });
</script>

<script>
  function setModalTitle(action) {
  const modalTitle = document.getElementById('exampleModalLabel');
  modalTitle.textContent = action;
}
</script>