<?php
session_start();
require "../vendor/autoload.php";
require "./php_functions/redirect.php";
use Clases\UserDB;
use Clases\ExercicioDB;
use Clases\CursosDB;
use Clases\Exercicio;
if( !isset($_SESSION["rol"]) ) redirect("");

?>


<!DOCTYPE html> <!--Comenzáse nesta parte o HTML para que non falle a carga de TinyMCE, si non dá erro-->
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editor de exercicios</title>
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">          
    <link rel="stylesheet" href="./src/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- <script type="text/javascript" src="./js/modal.js" defer></script> -->
    <script type="text/javascript" src="./src/js/ajaxCursos.js" defer></script>
    <script type="text/javascript" src="./src/js/ajaxExercicios.js" defer></script>
    <script src="./tinymce/tinymce.min.js" referrerpolicy="origin"></script>
    <script type="text/javascript" src="./js/TinyMCE_eqneditor.js" defer></script>        
    <script>

      tinymce.init({
        selector: '#enunciado',
        language: 'es',
        width: '100%',
        height:600,
        plugins: ['fullscreen','save','table','code','searchreplace','eqneditor'],
        toolbar: 'fullscreen | undo redo | searchreplace | eqneditor | styles | fontfamily |' + 
        '| fontsizeinput | forecolor | backcolor | bold italic | alignleft aligncenter alignright alignjustify | outdent indent',
        // image_caption: true,
        // image_title: true,
        // entity_encoding: "raw",
        // /* enable automatic uploads of images represented by blob or data URIs*/
        // automatic_uploads: true,
        // /*
        //   URL of our upload handler (for more details check: https://www.tiny.cloud/docs/configure/file-image-upload/#images_upload_url)
        //   images_upload_url: 'postAcceptor.php',
        //   here we add custom filepicker only to Image dialog
        // */
        // file_picker_types: 'image',
        // /* and here's our custom image picker*/
        // file_picker_callback: (cb, value, meta) => {
        //   const input = document.createElement('input');
        //   input.setAttribute('type', 'file');
        //   input.setAttribute('accept', 'image/*');

        //   input.addEventListener('change', (e) => {
        //     const file = e.target.files[0];

        //     const reader = new FileReader();
        //     reader.addEventListener('load', () => {
        //       /*
        //         Note: Now we need to register the blob in TinyMCEs image blob
        //         registry. In the next release this part hopefully won't be
        //         necessary, as we are looking to handle it internally.
        //       */
        //       const id = 'blobid' + (new Date()).getTime();
        //       const blobCache =  tinymce.activeEditor.editorUpload.blobCache;
        //       const base64 = reader.result.split(',')[1];
        //       const blobInfo = blobCache.create(id, file, base64);
        //       blobCache.add(blobInfo);

        //       /* call the callback and populate the Title field with the file name */
        //       cb(blobInfo.blobUri(), { title: file.name });
        //     });
        //     reader.readAsDataURL(file);
        //   });

        //   input.click();
        // },
        // content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'


      });
    </script>   
</head>


<?php
$exercicio = new Exercicio(null,"","","","1",$_SESSION['user'],date("d-m-Y"));

if ( isset($_GET["id"]) ) {       //estamos editando ou consultando exercicio
  $db = new ExercicioDB();
  $exercicio = $db->getExercicioById($_GET["id"]);   //obtemos os datos do exercicio
  $db = new UserDB();
  $row = $db->getUserById($exercicio->getCreador());   //obtemos o nome de usuario do autor
  $exercicio->setId($_GET["id"]);
  $exercicio->setCreador( $row->usuario );
  $exercicio->setEnunciado( $exercicio->getEnunciado() ); 
  $row = null;  

  // var_dump($exercicio);
  $db->cerrarConexion();
}

// if ( isset($_POST["crearEx"]) ) {
//   $db = new UserDB();
//   $exercicio = new Exercicio(null,$_POST["tema"],$_POST["enunciado"],$_POST["asignatura"],$_POST["exercActivo"],$db->getUserId($_POST["creador"]),$_POST["fechaCreacion"]);
//   var_dump($exercicio);
//   $db = new ExercicioDB();
//   if ( $db->insertExercicio($exercicio) ) {
//     echo "Insertado correctamente";
//   }

//   $db->cerrarConexion();
// }
?>


<body>
  <header class="headerExerc">
        <div class="d-flex flex-row align-items-center justify-content-between">
        <div>
            <a class="navbar-brand" href="index.php">
                <img src="src/img/logo_256.png" alt="Logo" loading="lazy" />
            </a>
        </div>
        
            <div class="me-auto p-2">
                <h1>Editor de exercicios</h1>
            </div>
            <!-- <div class="p-2">
                <input type="text" size='10px' value="<?php echo $_SESSION["user"]?>" class="form-control bg-transparent" disabled>
            </div>  -->
            <div class="p-2 d-flex flex-row align-items-center align-self-start headerUsuario">
                <input type="text" size='10px' value="<?php echo $_SESSION["user"]?>" class="form-control bg-transparent" disabled>
                <a href="./php_functions/closeSession.php" title="cerrar sesión">
                    <span class="fa-solid fa-right-from-bracket fa-xl" style="color: #d71919;"></span>
                </a>
            </div>       
        </div> 
    </header>

  <div class="container mt-3">
    <div class="row mt-1" id="msgExercicio"></div>
    <div class="row mt-1">
      <!-- <form class="row g-3 align-items-center"  method="post" >    -->
      <div class="col-md-4"><!--columna datos exercicio-->
        <input type="hidden" name="idExerc" id="idExerc" value="<?php echo isset($_GET["id"]) ? $_GET["id"] : ""?>">

        <div class="row g-3"><!--Autor,fecha-->
          <div class="form-group col-md-6">
            <label for="creador" class="form-label">Autor:</label>
            <input type="text" name="creador" id="creador" class="form-control" placeholder="Creador" 
              value="<?php echo $exercicio->getCreador()?>"  readonly>
          </div>
          <div class="form-group col-md-6">
            <label for="fechaCreacion" class="form-label">Fecha de creción:</label>
            <input type="text" name="fechaCreacion" id="fechaCreacion" class="form-control" placeholder="Fecha de creacion" 
              value="<?php echo date('d-m-Y', strtotime($exercicio->getFechaCreacion()) )?>" readonly>
          </div>
        </div>

        <div class="row g-3 mt-3"><!--tema-->
          <div class="form-group col-md-12">
            <label for="tema" class="form-label">Tema: </label>
            <input type="text" name="tema" id="tema" class="form-control" placeholder="Escribe o tema do exercicio" 
              value="<?php echo $exercicio->getTema()?>" 
            <?php echo $_SESSION["rol"] == "estudiante" ? "readonly" : ""?> required>
          </div>
        </div>

        <div class="row g-3 mt-3"><!--Curso-->
          <div class="form-group col-md-12">
            <label for="curso" class="form-label">Curso:</label>
            <select id="curso" name="curso" class="form-select" <?php echo $_SESSION["rol"] == "estudiante" ? "disabled" : ""?>>
              <option value="0">Selecciona curso...</option>
              <?php
              $db = new CursosDB();
              $cursos = $db->getCursos();
              $curso = $db->getCursoByAsignatura( $exercicio->getAsignatura() );  //obtemos o curso da asignatura
              $db->cerrarConexion();
              
              foreach ($cursos as $key => $value) {
                if( $key == $curso ) {
                  echo "<option value=$key selected>$value</option>";
                }else {
                  echo "<option value=$key>$value</option>";
                }
              }
              ?>
            </select>
          </div>
        </div> 

        <div class="row g-3 mt-3"><!--Asignatura-->
          <div class="form-group col-md-12">
            <label for="asignatura" class="form-label">Asignatura:</label>
            <select id="asignatura" name="asignatura" class="form-select" <?php echo $_SESSION["rol"] == "estudiante" ? "disabled" : ""?>>
              <option value="0">Sin asignaturas</option>
              <?php
              $db = new CursosDB();
              $asignaturas = $db->getAsignaturas($curso);
              $db->cerrarConexion();

              foreach ($asignaturas as $key => $value) {
                if ( $key == $exercicio->getAsignatura() ) {
                  echo "<option value=$key selected>$value</option>";
                }else {
                  echo "<option value=$key>$value</option>"; 
                }               
              }
              ?>
            </select>
          </div>
        </div>
            
        <div class="row g-3 align-items-center"><!--Exercicio visible-->
        <?php  
        if ( $_SESSION["rol"] != "estudiante" ) {
        ?>  
          <div class="form-group col-md-12 mt-5">
            <input class="form-check-input" type="checkbox" name="exercActivo" id="exercActivo" 
            title="Exercicio visible para os estudiantes" value="1" <?php echo $exercicio->getActivo() == 1 ? "checked" : ""?>
            <?php echo $_SESSION["rol"] == "estudiante" ? "disabled" : ""?>>
            <label class="form-check-label" for="exercActivo">Exercicio visible</label>
          </div>
        <?php  
        }
        ?>
        </div>

        <div class="row g-3 mt-3"><!--boton crear-->
          <?php
            if ( $_SESSION["rol"] != "estudiante" ) {
              if( isset($_GET["id"]) ) {
                ?>
                <div class="row g-3">
                  <div class="form-group col-md mt-0">
                    <button type="submit" class="btn btn-success" name="crearEx" id="crearEx" value="enviado" onclick="updateExercicio()">Actualizar exercicio
                    <span class="ms-1 fa-solid fa-plus" style="color: #ffffff;"></span></button>
                  </div>
                </div>
                <?php
              }else { 
                ?>
                <div class="row g-3">
                  <div class="form-group col-md mt-0">
                    <button type="submit" class="btn btn-success" name="crearEx" id="crearEx" value="enviado" onclick="saveExercicio()">Crear exercicio
                    <span class="ms-1 fa-solid fa-plus" style="color: #ffffff;"></span></button>
                  </div>
                </div>
                <?php
              }        
            }
            ?>
        </div>
      </div>

      <div class="col-md-8"><!--columna Enunciado-->
        <div class="row g-3">
          <div class="form-group col-md mb-3">
            <label for="enunciado" class="form-label">Enunciado: </label>
            <textarea class="form-control" aria-label="With textarea" name="enunciado" id="enunciado" ></textarea>
          </div>
        </div>
      </div>
        
      <!-- </form> -->
    </div>
  </div>
  <script src="./bootstrap/js/bootstrap.bundle.min.js"></script> 

  <script>
  //listener para cargar as asignaturas correspondentes co curso seleccionado
  let cursoExercicio = document.getElementById("curso");
  cursoExercicio.addEventListener("change", () => {
    cargarAsignaturas(cursoExercicio.value,"asignatura");
  });

  // getCursos("curso");

  //carga o contido do textarea TinyMCE
  window.addEventListener('load', function() {
    let cadena = <?php echo '`'.$exercicio->getEnunciado().'`'?>;
    setTimeout(function() {
      tinymce.activeEditor.setContent(cadena);  //carga do exercicio no editor
    }, 500);
   
    
    // fetch("./php_functions/loadEnunciado.php", {
    //   method: "POST",
    //   headers: {
    //       "Content-Type": "application/json",
    //   },
    //   body: JSON.stringify(datos),
    //   })
    // .then(response => response.json())
    // .then(data => {
    //   tinymce.activeEditor.setContent(response);
    // }).catch(err => {
    //     console.error("ERROR: ", err.message)
    //   }); 

     
  });
  </script>
<footer class="text-center py-1 fixed-bottom">
    <div class="container">
        <div class="row mt-2">
            <div class="col">2024 TaskVaultAcademy
            </div>
        </div>
    </div>
</footer>   
</body>
</html>


