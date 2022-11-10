<?php
include('../templates/head.php');
include_once('../modules/connection.php');
session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST'){


  $nombre = $_REQUEST['title'];
  $colegio = $_REQUEST['school'];
  $nivel = $_REQUEST['level'];
  $curso = $_REQUEST['curso'];
  $codigo = mt_rand(10000,99999);



  $query = $miPDO->prepare('INSERT INTO grupo (codigo,nombre,id_centro,nivel,curso,profesor) VALUES (:codigo, :nombre,:centro,:nivel,:curso,:profesor)');
  $query->execute(['codigo' => $codigo, 
                   'nombre' => $nombre, 
                   'centro' => $_REQUEST['school'],
                   'nivel' => $nivel, 
                   'curso' => $curso, 
                   'profesor' => $_SESSION['nickname']]);
                   
  header('Location: ../views/groups.php');
}
?>
<script src="../src/js/profile.js" defer></script>
<script src="../src/js/new_book_validation.js" defer></script>
<link rel="stylesheet" href="../styles/new_class.css">
  <title>Gela sortu | IGKlub</title>
  </head>
<body>
<header>
        <figure>
            <img src="../src/img/logo/logo.png">
        </figure>
        <section>
            <button id="profile">
                <i class="fa-solid fa-bars"></i>
            </button>
            <aside class="profile">
                <?php
                if ($_SESSION['role'] === 'ikasle') {
                    echo '<h1>' . $_SESSION['nickname'] . '</h1>';
                    echo '<h1><a href="../views/personal_area.php">Area Pertsonala</a> </h1>';
                    echo '<h1><a href="../views/main_menu.php">Liburutegia</a></h1>';
                } else
                    echo '<h1>' . $_SESSION['nickname'] . '</h1>';
                echo '<h1><a href="../views/personal_area.php">Area Pertsonala</a> </h1>';
                echo '<h1><a href="../views/main_menu.php">Liburutegia</a></h1>';
                echo '<h1><a href="../views/class.php">Gela</a></h1>';
                echo '<h1><a href="../views/requests.php">Eskaerak</a></h1>';
                ?>
            </aside>
        </section>
    </header>
    <main>

<form action="" method="post">
    <h1>Talde bat sortu</h1>
    <!-- Nombre del grupo -->
    <div class="input-container">
      <i class="fa-solid fa-heading"></i>
      <input type="text" name="title" id="title" placeholder="Taldearen izena" autofocus value="<?php if (isset($_REQUEST['nickname'])) echo $_REQUEST['nickname'] ?>">
    </div>
    <!-- Error: Nombre del grupo -->
    <div class="error hidden" id="title-error">
      <i class="fa-solid fa-circle-exclamation"></i>
      <p>.</p>
    </div>
    <!-- Centro -->
    <div class="input-container">
      <i class="fa-solid fa-school"></i>
      <select name="school" id="school">
          <option value="-" selected>Ikastetxea</option>
      <?php
          $query = $miPDO->prepare('SELECT * FROM centro ORDER BY nombre ASC');
          $query->execute();
          $results = $query->fetchAll();

          foreach ($results as $position => $school) {
              echo '<option value="'.$school['id_centro'].'">'.$school['nombre'].'</option>';
          }
      ?>
      </select>
    </div>
    <!-- Nivel -->
    <div class="input-container">
      <i class="fa-solid fa-heading"></i>
      <input type="text" name="level" id="level" placeholder="Maila" value="<?php if (isset($_REQUEST['nickname'])) echo $_REQUEST['nickname'] ?>">
    </div>
    <!-- Error: Nivel -->
    <div class="error hidden" id="title-error">
      <i class="fa-solid fa-circle-exclamation"></i>
      <p>.</p>
    </div>
    <!-- Curso -->
    <div class="input-container">
      <i class="fa-solid fa-heading"></i>
      <input type="text" name="curso" id="title" placeholder="Kurtzoa" value="<?php if (isset($_REQUEST['nickname'])) echo $_REQUEST['nickname'] ?>">
    </div>
    <!-- Error: Curso -->
    <div class="error hidden" id="title-error">
      <i class="fa-solid fa-circle-exclamation"></i>
      <p>.</p>
    </div>
    <button>Gorde gela</button>
  </form>
  </main>
</body>