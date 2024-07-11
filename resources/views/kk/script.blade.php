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
  let table = $('#myTable').DataTable({
    processing:true,
    serverside:true,
    responsive: true,
    ajax:"{{ url('kkdata') }}",
    columns:[{
      data: 'DT_RowIndex',
      name: 'DT_RowIndex',
      orderable:false,
      searchable:false
    },{
      data:'no_kk',
      name: 'Nomor KK'
    },{
      data:'nama_kepala_keluarga',
      name:'Nama Kepala Keluarga'
    },{
      data:'alamat',
      name:'Alamat'
    },{
      data: 'rt_rw',
      name: 'RT/RW'
    },{
      data: 'jumlah_anggota',
      name: 'Jumlah Anggota'
    },{
      data: 'aksi',
      name: 'Aksi'
    }]
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
      $('#exampleModal').modal('show');
      
      // Memasang event handler untuk tombol simpan di dalam modal
      $('.tombol-simpan').off('click').click(function(){
          simpan();

      });
  });


  //03-Proses Edit
  $('body').on('click', '.tombol-edit', function(e){
    var id = $(this).data('id');
    $.ajax({
        url:'kkdata/' + id + '/edit',
        type: 'GET',
        success: function(response){
            $('#exampleModal').modal('show');
            var originalData = {
                no_kk: response.result.no_kk || '',
                nama_kepala_keluarga: response.result.nama_kepala_keluarga || '',
                alamat: response.result.alamat || '',
                rt_rw: response.result.rt_rw || '',
                kode_pos: response.result.kode_pos || '',
                desa_kelurahan: response.result.desa_kelurahan || '',
                kecamatan: response.result.kecamatan || '',
                kabupaten_kota: response.result.kabupaten_kota || '',
                provinsi: response.result.provinsi || ''
            };

            $('#no_kk').val(originalData.no_kk);
            $('#nama_kepala_keluarga').val(originalData.nama_kepala_keluarga);
            $('#alamat').val(originalData.alamat);
            $('#rt_rw').val(originalData.rt_rw);
            $('#kode_pos').val(originalData.kode_pos);
            $('#desa_kelurahan').val(originalData.desa_kelurahan);
            $('#kecamatan').val(originalData.kecamatan);
            $('#kabupaten_kota').val(originalData.kabupaten_kota);
            $('#provinsi').val(originalData.provinsi);

            // Hapus semua event handler sebelumnya untuk tombol simpan
            $('.tombol-simpan').off('click');

            // Disable tombol simpan saat modal dibuka
            $('.tombol-simpan').prop('disabled', true);

            // Fungsi untuk memeriksa perubahan data
            function checkChanges() {
                var isChanged = false;
                var currentData = {
                    no_kk: $('#no_kk').val(),
                    nama_kepala_keluarga: $('#nama_kepala_keluarga').val(),
                    alamat: $('#alamat').val(),
                    rt_rw: $('#rt_rw').val(),
                    kode_pos: $('#kode_pos').val(),
                    desa_kelurahan: $('#desa_kelurahan').val(),
                    kecamatan: $('#kecamatan').val(),
                    kabupaten_kota: $('#kabupaten_kota').val(),
                    provinsi: $('#provinsi').val()
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
            $('#exampleModal input, #exampleModal textarea, #exampleModal select').on('input change', checkChanges);

            // Tambahkan event handler baru untuk tombol simpan
            $('.tombol-simpan').click(function(){
                simpan(id);
            });
        },
        error: function(xhr, status, error){
            console.error(xhr.responseText);

            // Tampilkan SweetAlert untuk pesan error
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Terjadi kesalahan saat mengambil data.',
            });
        }
    });
});



  // 04-Proses Delete
  $('body').on('click', '.tombol-delete', function(e) {
    e.preventDefault();
    var id = $(this).data('id');

    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'kkdata/' + id,
                type: 'DELETE',
                success: function(response) {
                    Swal.fire('Terhapus!', 'Data berhasil dihapus.', 'success');
                    $('#myTable').DataTable().ajax.reload();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus data.', 'error');
                }
            });
        }
    });
});


  //05-Proses Detail
  $('body').on('click', '.tombol-detail', function(e){
      e.preventDefault();
      var id = $(this).data('id');
      window.location.href = '/kkdata/' + id;
  });


  //fungsi hideMessage
  function hideErrorMessage() {
    $('.alert-danger').addClass('d-none');
    $('.alert-danger').empty(); // Mengosongkan isi pesan error setelah beberapa detik
}

  // fungsi simpan dan update
  function simpan(id = '') {
  var var_url = id ? 'kkdata/' + id : 'kkdata';
  var var_type = id ? 'PUT' : 'POST';

  $.ajax({
    url: var_url,
    type: var_type,
    data: {
      no_kk: $('#no_kk').val(),
      nama_kepala_keluarga: $('#nama_kepala_keluarga').val(),
      alamat: $('#alamat').val(),
      rt_rw: $('#rt_rw').val(),
      kode_pos: $('#kode_pos').val(),
      desa_kelurahan: $('#desa_kelurahan').val(),
      kecamatan: $('#kecamatan').val(),
      kabupaten_kota: $('#kabupaten_kota').val(),
      provinsi: $('#provinsi').val()
    },
    success: function(response) {
      if (response.errors) {
        $('.alert-danger').removeClass('d-none').html("<ul></ul>");
        $.each(response.errors, function(key, value) {
          $('.alert-danger').find('ul').append("<li>" + value + "</li>");
        });
        setTimeout(hideErrorMessage, 10000);
      } else {
        $('.alert-success').removeClass('d-none').html(response.success);
        setTimeout(function() {
          $('.alert-success').addClass('d-none').empty();
        }, 10000);
        // $('#detailModal').modal('hide');
        if (var_type === 'POST') {
          Swal.fire('Sukses!', 'Data berhasil disimpan.', 'success');
        } else {
           Swal.fire('Sukses!', 'Data berhasil diupdate.', 'success')
           $('#detailModal').modal('hide');
        }
      }
      $('#myTable').DataTable().ajax.reload();
    },
    error: function(xhr, status, error) {
      console.error(xhr.responseText);
    }
  });
}


  $('#exampleModal').on('hidden.bs.modal', function(){
    $('#no_kk').val('');
    $('#nama_kepala_keluarga').val('');
    $('#alamat').val('')
    $('#rt_rw').val('')
    $('#kode_pos').val('')
    $('#desa_kelurahan').val('')
    $('#kecamatan').val('')
    $('#kabupaten_kota').val('')
    $('#provinsi').val('')

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