<?= $this->extend('admin/template'); ?>

<?= $this->section('content'); ?>

<main id="main" class="main">
  <div class="pagetitle">
    <h1>Artikel</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
        <li class="breadcrumb-item active">Artikel</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <!-- Notifikasi -->
  <?php if (session()->has('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <?= session('success') ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif; ?>
  <!-- End Notifikasi -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">

            <h5 class="card-title">Artikel</h5>
            <p>Informasi pada tabel di bawah akan ditampilkan pada halaman Berita Web Pariwisata</p>
            <a href="/tambahartikel" class="btn btn-primary mb-3"><i class="bi bi-plus-circle me-2"></i>Tambah Artikel</a>

            <!-- Table with stripped rows -->
            <table class="table datatable">
              <thead>
                <tr>
                  <th class="col-1">No</th>
                  <th class="col-2">Judul</th>
                  <th class="col-1" data-type="date" data-format="DD/MM/YYYY">Tanggal</th>
                  <th class="col-3" style="width: 250px;">Foto</th>
                  <th class="col-4">Deskripsi</th>
                  <th class="col-1">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1; ?>
                <?php foreach ($artikel as $a) : ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $a['judul'] ?></td>
                    <td><?= date('d/m/Y', strtotime($a['tanggal'])) ?></td>
                    <td>
                      <?php if ($a['foto']) : ?>
                        <img src="<?= base_url('uploads/artikel/' . $a['foto']) ?>" alt="<?= $a['judul'] ?>" class="img-fluid">
                      <?php else : ?>
                        <span>Tidak ada foto</span>
                      <?php endif; ?>
                    </td>
                    <td><?= truncate($a['deskripsi'], 150) ?></td>
                    <td>
                      <a href="/artikel/edit/<?= $a['id_artikel'] ?>" class="btn btn-primary btn-sm"><i class="bi bi-pencil"></i></a>
                      <a href="/artikel/delete/<?= $a['id_artikel'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus artikel ini?');"><i class="bi bi-trash"></i></a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
            <!-- End Table with stripped rows -->

          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Ubah nilai default dropdown datatable-selector menjadi 5
    var datatableSelector = document.querySelector('.datatable-selector');
    if (datatableSelector) {
      datatableSelector.value = 5;
      var event = new Event('change', {
        bubbles: true
      });
      datatableSelector.dispatchEvent(event);
    }

    // Inisialisasi DataTable dengan pengaturan yang diubah
    var table = $('.datatable').DataTable({
      pageLength: 5 // Atur nilai default halaman menjadi 5
    });

    // Ubah nilai dropdown saat DataTable diinisialisasi
    table.on('init', function() {
      datatableSelector.value = 5;
      datatableSelector.dispatchEvent(new Event('change', {
        bubbles: true
      }));
    });

    // Fungsi pencarian custom
    $.fn.dataTable.ext.search.push(
      function(settings, data, dataIndex) {
        var searchTerm = $('div.dataTables_filter input').val().toLowerCase();
        var title = data[1].toLowerCase(); // Kolom Judul
        var description = data[4].toLowerCase(); // Kolom Deskripsi

        if (title.includes(searchTerm) || description.includes(searchTerm)) {
          return true;
        }
        return false;
      }
    );

    // Perbarui pencarian ketika input berubah
    $('div.dataTables_filter input').on('keyup', function() {
      table.draw();
    });
  });
</script>

<?= $this->endSection(); ?>