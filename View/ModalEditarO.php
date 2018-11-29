<div class = "modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <center><h3 class = ""> <i class = "glyphicon glyphicon-pencil"> </i>Editar Ocurrencia</h3></center>
</div>
    <form class="form-inline">
    <div class="modal-body">
      Comentario: 
     <textarea  id="UpdateOcurrencia<?=$IdOcurrencia?>" class="form-control"><?php echo utf8_encode($Comentario);?></textarea>
     <input id="IdAccion2" type="hidden" name="IdMaestro">
     <p>Acciones (seleccione alguna opccion)</p>
            <div style="text-align: center;">
            <?php
                    
                    foreach($Acciones as $vendedores) {
                        ?>
                        <i class="tooltip2 Accion" style="cursor:pointer" id='Accion<?=$vendedores['IdMaestro']?>'  onclick="EditarAccion(<?=$vendedores['IdMaestro']?>);" >
                        <i class='material-icons zoomIt' style="font-size:48px;margin:3px;"><?=$vendedores['AuxDet1']?></i>
                        <span class="tooltiptext2"><?=utf8_encode($vendedores['DescripCorta'])?></span>
                        </i>
                        <input type='hidden' value='<?=$vendedores['AuxDet1']?>' id='NomIcon<?=$vendedores['IdMaestro']?>'>
                        <?php
                       
                      
                        } ?>
            </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal"><span class = "glyphicon glyphicon-remove" ></span> </button> | 
      <button type="button" class="btn btn-success" value="<?=$IdOcurrencia?>" onclick="GuardarEditarO(<?=$IdOcurrencia?>)"><span class = "glyphicon glyphicon-floppy-disk"></span> </button>
    </div>
    </form>
    </div>
  </div>
</div>

<script>
        
var editor

ClassicEditor
    .create( document.querySelector('#UpdateOcurrencia<?=$IdOcurrencia?>'))
    .then( newEditor => {
        editor = newEditor;
    } )
    .catch( error => {
        console.error( error );
    } );

// Assuming there is a <button id="submit">Submit</button> in your application.

 

    // ...

//     //Update
//     function actualizar<?php echo $res['0']; ?>(a)
//     {
//       $uid=a;
//       console.log(a);
//       $('#edit'+$uid).modal('hide');
//       $('body').removeClass('modal-open');
//       $('.modal-backdrop').remove();
//       $ufirstname=$('#ufirstname'+$uid).val();
//       $ulastname=$('#ulastname'+$uid).val();
      
//         $.ajax({
//           type: "POST",
//           url: "php/update.php",
//           data: {
//             id: $uid,
//             firstname: editor<?php echo $res['0']; ?>.getData(),
//             lastname: $ulastname,
//             edit: 1,
//           },

//           success: function(data){
//             $(".mensaje"+$uid).html(editor<?php echo $res['0']; ?>.getData());
// //            ed($ulastname);
//           },error: function(error){
//             console.log(error);
// //            ed($ulastname);
//           }
//         });
    
//   }


       EditarAccion=(IdAccion)=>
    {
        console.log('1')
        $('.Accion').css({'opacity': '1'});
        $(`#Accion${IdAccion}`).css({'opacity': '0.5'});
        $('#IdAccion2').val(IdAccion)
    }
        
        
</script>