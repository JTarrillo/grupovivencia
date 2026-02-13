<!doctype html>
<html lang="es-PE">
<?php echo view("admin/head"); ?>

<body data-new-gr-c-s-check-loaded="14.1042.0" data-gr-ext-installed="">
   <?php echo view("admin/header"); ?>
   <section class="pcoded-main-container">
      <div class="pcoded-wrapper">
         <div class="pcoded-content">
            <div class="pcoded-inner-content">
               <div class="page-header">
                  <div class="page-block">
                     <div class="row align-items-center">
                        <div class="col-md-12">
                           <div class="page-header-title">
                              <h5 class="m-b-10">Formulario de Comentarios</h5>
                           </div>
                           <ul class="breadcrumb">
                              <li class="breadcrumb-item"><a href="/dashboard">Panel</a></li>
                              <li class="breadcrumb-item"><a href="/dashboard/comentarios">Listado de Comentarios</a></li>
                              <li class="breadcrumb-item"><a>Formulario de Comentarios</a></li>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="main-body">
                  <div class="page-wrapper">
                     <div class="row">
                        <div class="col-sm-12">
                           <div class="card">
                              <div class="card-header">
                                 <h5>Datos</h5>
                              </div>
                              <div class="card-body">
                                 <form name="form" enctype="multipart/form-data" method="post" action="javascript:void(0);" ; onsubmit="validate();">
                                    <div class="form-row">
                                       <?php
                                       if (isset($obj_comments)) { ?>
                                          <div class="form-group col-md-12">
                                             <div class="form-group">
                                                <label>ID</label>
                                                <input class="form-control" type="text" value="<?php echo isset($obj_comments->id) ? $obj_comments->id : null; ?>" class="input-xlarge-fluid" placeholder="ID" disabled="">
                                             </div>
                                          </div>
                                       <?php } ?>
                                       <input type="hidden" id="id" name="id" value="<?php echo isset($obj_comments->id) ? $obj_comments->id : null; ?>">
                                       <div class="form-group col-md-6">
                                          <div class="form-group">
                                             <label>Nombre</label>
                                             <input class="form-control" type="text" id="name" name="name" value="<?php echo isset($obj_comments->name) ? $obj_comments->name : ""; ?>" class="input-xlarge-fluid" readonly>
                                          </div>
                                          <div class="form-group">
                                             <label>Teléfono</label>
                                             <input class="form-control" type="text" id="phone" name="phone" value="<?php echo isset($obj_comments->phone) ? $obj_comments->phone : ""; ?>" class="input-xlarge-fluid" readonly>
                                          </div>
                                          <div class="form-group">
                                             <label>Email</label>
                                             <input class="form-control" type="text" id="email" name="email" value="<?php echo isset($obj_comments->email) ? $obj_comments->email : ""; ?>" class="input-xlarge-fluid" readonly>
                                          </div>
                                          <div class="form-group">
                                             <label>Fecha</label>
                                             <input class="form-control" type="text" id="date" name="date" value="<?php echo isset($obj_comments->date) ? formato_fecha_dia_mes_anio_abrev($obj_comments->date) . " - " . formato_fecha_minutos($obj_comments->date) : ""; ?>" class="input-xlarge-fluid" readonly>
                                          </div>
                                          <div class="form-group">
                                             <label for="inputState">Estado</label>
                                             <select name="active" id="active" class="form-control">
                                                <option value="">[ Seleccionar ]</option>
                                                <option value="1" <?php if (isset($obj_comments)) {
                                                                     if ($obj_comments->active == 1) {
                                                                        echo "selected";
                                                                     }
                                                                  } else {
                                                                     echo "";
                                                                  } ?>>No Atendido</option>
                                                <option value="0" <?php if (isset($obj_comments)) {
                                                                     if ($obj_comments->active == 0) {
                                                                        echo "selected";
                                                                     }
                                                                  } else {
                                                                     echo "";
                                                                  } ?>>Atendido</option>
                                             </select>
                                          </div>
                                       </div>
                                       <div class="form-group col-md-6">
                                          <div class="form-group">
                                             <label>Título</label>
                                             <input class="form-control" type="text" id="subject" name="subject" value="<?php echo isset($obj_comments->subject) ? $obj_comments->subject : ""; ?>" class="input-xlarge-fluid" readonly>
                                          </div>
                                          <div class="form-group">
                                             <label>Comentario</label>
                                             <textarea class="form-control" name="comment" id="mytextarea" placeholder="Descripción" style="height: 300px;width: 100% !important" placeholder="Comentario"><?php echo isset($obj_comments->comment) ? $obj_comments->comment : ""; ?></textarea>
                                          </div>
                                       </div>
                                    </div>
                                    <button id="submit" type="submit" class="btn btn-primary">Guardar</button>
                                    <button class="btn btn-danger" type="reset" onclick="cancel();"><i class="fa fa-arrow-left" aria-hidden="true"></i>Cancelar</button>
                                 </form>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
   <script>
      tinymce.init({
         selector: 'textarea#mytextarea',
         height: 300,
         menubar: false,
         plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste code help wordcount'
         ],
         toolbar: 'undo redo | formatselect | ' +
            'bold italic backcolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'removeformat | help',
         content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
      });
   </script>
   <script src="<?php echo base_url('assets/admin/js/script/comments.js'); ?>"></script>
   <!-- [ Main Content ] end -->
   <?php echo view("admin/footer"); ?>