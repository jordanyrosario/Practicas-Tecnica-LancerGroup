<?= $this->extend('layouts/app') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="/css/datatable-bs4/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/css/fontawesome-free/css/solid.min.css">
<link rel="stylesheet" href="/css/datatables-select/select.bootstrap4.min.css">
<link rel="stylesheet" href="/css/datatables-buttons/buttons.bootstrap4.min.css">


<?= $this->endSection('styles') ?>
<?= $this->section('content') ?>

<div class="modal fade" id="modal-book-details">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Detalles de autor</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <table class="table">


            </table>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>


    <section class="row">
        <div class="col-12">
        <div class="card">
              <div class="card-header row">


              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="books" class="table table-bordered table-hover">
                  <thead>
                  <tr>

                    <th>Nombre</th>
                    <th>Edicion</th>
                    <th>Fecha de publicacion</th>



                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                    <td colspan="3">NO hay registros para mostrar</td>



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
<script src="/js/datatables-select/js/dataTables.select.min.js"></script>
<script src="/js/datatables-select/js/select.bootstrap4.min.js"></script>
<script src="/js/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/js/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="/js/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="/js/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="/js/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>

<script src="/js/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/js/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script>

$(document).ready(function () {

  const dataTableConfig =   {
     dom: 'Bfrtip',
    serverSide: true,
    rowId: 'id',
    ajax: {
        url: "<?= route_to('books.ajax') ?> ",
        type: 'POST',
      dataFilter: function(response, res){

        const data = JSON.parse(response);
        $('meta[name=X-CSRF-TOKEN]').attr("content", data.token);

         return response;
      },
     headers: {
                'X-CSRF-TOKEN': $('meta[name=X-CSRF-TOKEN]').attr("content"),
                'X-Requested-With': 'XMLHttpRequest'
        }
    },
columns:[
    { data: 'name'},
    { data: 'edition'},
    { data: 'publication_date'},

  ],
  select: true,

         responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal( {
                    header: function ( row ) {
                        var data = row.data();
                        return 'Details for '+data[0]+' '+data[1];
                    }
                } ),
                renderer: $.fn.dataTable.Responsive.renderer.tableAll()
            }
        },

  buttons: [
            {
                text: '<i class="fa fa-plus"></i>',
                className: 'btn-primary',
                action: function ( e, dt, node, config ) {
                     window.location.href = "<?= route_to('books.create')?>"
                }
            },
            {
                text: '<i class="fa fa-pen"></i>',
                className: 'btn-primary',
                action: function ( e, dt, node, config ) {
                      if (dt.rows( { selected: true } ).count() > 1) {
                         alert( 'Seleccione un solo Registro para editar' );
                        return;
                      }
                      if (dt.rows( { selected: true } ).count() < 1) {
                         alert( 'Debe selecionar un registro para editar' );
                        return ;
                      }

                      window.location.href = "/books/edit/" + dt.rows( { selected: true } ).data()[0].id
                }

            },
            {
                text: '<i class="fa fa-trash"></i>',
                className: 'btn-primary',
                action: function ( e, dt, node, config ) {


                $.ajax({
                  url: "/books/delete/" + dt.rows( { selected: true } ).data()[0].id,
                  method: 'POST',
                   headers: {
                          'X-Requested-With': 'XMLHttpRequest'
                  },
                  xhrFields: {
                    withCredentials: false
                },
                data:{

                   'csrf_token_name': $('meta[name=X-CSRF-TOKEN]').attr("content"),
                },
                  xhrFields: {
                      withCredentials: true
                  }
                }).done(function(data){
                  $('meta[name=X-CSRF-TOKEN]').attr("content", data.token);

                  table.destroy();
                  table = $('#books').DataTable(dataTableConfig);

                    }).fail(function(err){
                    console.log(err);
                  })
                }
            }
        ]

}




let table =   $('#books').DataTable(
  dataTableConfig
);

$('#books').on('preXhr.dt', function ( e, settings, data ) {
          settings.ajax.headers['X-CSRF-TOKEN'] =  $('meta[name=X-CSRF-TOKEN]').attr("content")
    } )


table.on('dblclick', 'tr', function(e){


     e.stopPropagation()

    const id = table.row( this ).id()

    $.get('books/details/'+ id, function(data){

    let details = '';

    for (const key in data) {
       details += `
      <tr>
        <td>${key}:</td>
        <td>${data[key]}</td>
       </tr>

      `;
}

    $('#modal-book-details table').html(details)
    $('#modal-book-details').modal('show')


    }, 'json').fail(function(err){
        console.log(err);
    })
    ;


  table.rows

    false
  });




});

</script>

<?= $this->endSection('javascript') ?>