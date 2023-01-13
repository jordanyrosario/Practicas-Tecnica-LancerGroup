<?= $this->extend('layouts/app') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="/css/datatable-bs4/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/css/fontawesome-free/css/solid.min.css">
<link rel="stylesheet" href="/css/datatables-select/select.bootstrap4.min.css">
<link rel="stylesheet" href="/css/datatables-buttons/buttons.bootstrap4.min.css">

 
<?= $this->endSection('styles') ?>
<?= $this->section('content') ?>

    <section class="row">
        <div class="col-12">
        <div class="card">
              <div class="card-header row">

              <div class="col-3 col-sm-2 col-md-1 offset-9 offset-sm-10 offset-md-11"><a href="<?= route_to('authors.create') ?>" type="button" class="btn btn-block btn-primary"><i class="fa fa-plus"></i></a></div>

              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="authors" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Pais</th>
                    
                

                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                    <td>Juan</td>
                    <td>Domingo  </td>
                    <td>Cuba</td>
                    

                  </tr>

                  </tbody>

                </table>
              </div>
              <!-- /.card-body -->
            </div>
        </div>

    </section>

<?= $this->endSection('content') ?>

<?= $this->section('javascript') ?>
<script src="/js/datatables/jquery.dataTables.js"></script>
<script src="/js/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="/js/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/js/datatables-select/js/select.bootstrap4.min.js"></script>
<script src="/js/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="/js/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="/js/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>

<script src="/js/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/js/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script>

$(document).ready(function () {
    $('#authors').DataTable(
  {
     dom: 'Bfrtip',
    serverSide: true,
    ajax: {
        url: "<?=route_to('author.ajax') ?> ",
        type: 'POST',
     headers: {
                'X-CSRF-TOKEN': '<?=csrf_hash()?>',
                'X-Requested-With': 'XMLHttpRequest'
        }
    },
columns:[
    { data: 'name'},
    { data: 'last_name'},
    { data: 'country_id'},
    
  ],
  select: true,

  buttons: [
            {
                text: 'Nuevo',
                action: function ( e, dt, node, config ) {
                    alert( 'Button activated' );
                }
            }
        ]

}
);
});

</script>

<?= $this->endSection('javascript') ?>