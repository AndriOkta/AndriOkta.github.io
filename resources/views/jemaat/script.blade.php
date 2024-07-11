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
    responsive:true,
    ajax:"{{ url('anggotadata') }}",
    columns:[{
      data: 'DT_RowIndex',
      name: 'DT_RowIndex',
      orderable:false,
      searchable:false
    },{
      data:'no_ktp',
      name: 'NIK'
    },{
      data:'nama',
      name:'Nama'
    },{
      data:'ttl',
      name:'TTL'
    },{
      data: 'jenis_kelamin',
      name: 'Jenis Kelamin'
    },{
      data: 'keluarga.alamat',
      name: 'Alamat'
    },{
      data: 'status',
      name: 'Status'
    },{
      data: 'pekerjaan',
      name: 'Pekerjaan'
    },{
      data: 'aksi',
      name: 'Aksi'
    }]
  });
  $('#myTable').closest('.dataTables_wrapper').addClass('card-body').addClass('d-flex flex-column justify-content-center').addClass('mb-0 text-sm');

  $('body').on('click', '.tombol-detail', function(e) {
        e.preventDefault();
        var kkId = $(this).data('kk-id');
        if (kkId) {
            window.location.href = '/kkdata/' + kkId;
        } else {
            alert('ID Keluarga tidak ditemukan');
        }
    });
  //Global Setup
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


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