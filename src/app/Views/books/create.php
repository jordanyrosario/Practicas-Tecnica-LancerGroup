<?= $this->extend('layouts/app') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="/css/bootstrap-select/bootstrap-select.min.css">
<link rel="stylesheet" href="/css/form.default.css">

<?= $this->endSection('styles') ?>


<?= $this->section('content') ?>
  <?php $errors = session()->get('errors'); ?>
    <section class="row">
        <div class="col-12">
        <div class="card">
              <div class="card-header row">

              <h3>Crear Nuevo autor</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <form id="book_form" method="post" action="<?= route_to('books.store')?>">
              <?= csrf_field() ?>
                <div class="card-body">
                  <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Nombre" value="<?= old('name') ?>">
                    <?php if(isset($errors, $errors['name'])) :?>
                        <p class="tex-dange" > <?= $errors['name'] ?> </p>
                      <?php endif?>

                  </div>
                  <div class="form-group">
                    <label for="edition">Edicion</label>
                    <input type="text" class="form-control" id="edition" name="edition" placeholder="Edicion" value="<?= old('edition') ?>">
                    <?php if(isset($errors, $errors['last_name'])) :?>
                        <p class="tex-dange" > <?= $errors['edition'] ?> </p>
                      <?php endif?>
                  </div>
                  <div class="form-group">
                    <label for="publication_date">Fecha de publicacion</label>
                    <input type="date" class="form-control" id="publication_date" name="publication_date" placeholder="Edicion" value="<?= old('publication_date') ?>">
                    <?php if(isset($errors, $errors['last_name'])) :?>
                        <p class="tex-dange" > <?= $errors['edition'] ?> </p>
                      <?php endif?>
                  </div>
                  <div class="form-group">
                    <label for="country_id">Autor</label>
                    <?php
                      $options = [];

foreach($authors as $author) {
    $options[$author->id] = $author->name;
}

?>

                    <?= form_multiselect('authors[]', $options, old('authors') ?: [], 'class="selectpicker form-control "  data-style="btn form-control" data-live-search="true"')   ?>
                        <?php if(isset($errors, $errors['authors[]'])) :?>
                        <p class="tex-dange" > <?= $errors['authors[]'] ?> </p>
                      <?php endif?>
                  </div>

                <!-- /.card-body -->

                <div class="card-footer d-flex flex-row-reverse ">
                  <button type="submit" class="btn btn-primary ">Guardar</button>
                  <a href="<?= route_to('books.index') ?>" class="btn btn-secondary mr-2">Cancelar</a>
                </div>
              </form>
              </div>
              <!-- /.card-body -->
            </div>
        </div>

    </section>

<?= $this->endSection('content') ?>

<?= $this->section('javascript') ?>

<script src="/js/jquery-validation/jquery.validate.min.js"></script>
<script src="/js/jquery-validation/additional-methods.min.js"></script>
<script src="/js/bootstrap-select/bootstrap-select.min.js"></script>

<script>
$(function () {
  // $.validator.setDefaults({
  //   submitHandler: function () {
  //     alert( "Form successful submitted!" );
  //   }
  // });
  $('#boook_form').validate({
    rules: {
      name: {
        required: true,

      },
      edition: {
        required: true,

      },
      authors: {
        required: true
      },
    },
    messages: {
      name: {
        required: "El campo nombre es obligatorio.",

      },
      last_name: {
        required: "El campo Apellido es obligatorio,"

      },
      country_id: {
        required: "El campo pais es obligario.",
    }
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
});
</script>

<?= $this->endSection('javascript') ?>