<div class="modal-content">
    <div class = "modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <center><h3 class = ""> <i class = "glyphicon glyphicon-pencil"> </i>  Cambiar Vendedor </h3></center>
    </div>
    <form class="form-inline" name="FormularioVendedor" id="FormularioVendedor" >
        <div class="modal-body">
        <input type="hidden" name='IdPersonaCV' id='IdPersonaCV' value="<?=$IdCliente?>">
        <select id="IdVendedlor" class="form-control" name="IdVendedlor">
            <?php
            foreach($vendedoresL as $vendedores) {echo "<option value='".$vendedores['IdPersona']."'>".utf8_encode($vendedores['Nombre'])."</option>";}
            ?>
          
        </select>
     
  
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal" ><span class = "glyphicon glyphicon-remove"></span> </button> | 
      <button type="button" class=" btn btn-success" data-dismiss="modal" onclick="GuardarVendedor(<?=$IdCliente?>);">
          <span class = "glyphicon glyphicon-floppy-disk"></span> </button>
    </div>
    </form>
</div>


