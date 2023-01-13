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

              <h3>Editar autor</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <form id="author_form" method="post" action="<?= route_to('authors.update')?>">
              <input type="hidden" name="id" value="<?=$record->id?>">
              <?= csrf_field() ?>
                <div class="card-body">
                  <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Nombre" value="<?= old('name') ? old('name'): $record->name  ?>">
                    <?php if(isset($errors, $errors['name'])) :?>
                        <p class="tex-dange" > <?= $errors['name'] ?> </p>
                      <?php endif?>

                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Apellidos</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Apellidos" value="<?= old('last_name')? old('last_name') : $record->last_name ?>">
                    <?php if(isset($errors, $errors['last_name'])) :?>
                        <p class="tex-dange" > <?= $errors['last_name'] ?> </p>
                      <?php endif?>
                  </div>
                  <div class="form-group">
                    <label for="country_id">Pais</label>
                    <select class="selectpicker form-control " name="country_id" id="country_id" data-style="btn form-control" data-live-search="true">
                    <?php 
                    $selected = old('country_id')? old('country_id'): $record->country_id;
                    foreach ($countries as $country): ?>

                          <option value="<?=$country->id ?>" <?=$country->id == $selected ? 'selected': '' ?> > <?=$country->name ?></option>
                        <?php endforeach ?>

                        </select>
                        <?php if(isset($errors, $errors['country_id'])) :?>
                        <p class="tex-dange" > <?= $errors['country_id'] ?> </p>
                      <?php endif?>
                  </div>

                <!-- /.card-body -->

                <div class="card-footer d-flex flex-row-reverse ">
                  <button type="submit" class="btn btn-primary ">Guardar</button>
                  <a href="<?= route_to('authors.index') ?>" class="btn btn-secondary mr-2">Cancelar</a>
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
  $('#author_form').validate({
    rules: {
      name: {
        required: true,

      },
      last_name: {
        required: true,

      },
      country_id: {
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