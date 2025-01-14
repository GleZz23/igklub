<?php
  include('../templates/head.php');
  include_once('../modules/connection.php');
  include_once('../modules/session_control.php');

  $book = $_REQUEST['liburua'];

  $query = $miPDO->prepare('SELECT libro.*, solicitud_libro.estado AS estado FROM libro, solicitud_libro WHERE libro.id_libro = :book AND libro.id_libro = solicitud_libro.id_libro');
  $query->execute(['book' => $book]);
  $results = $query->fetch();

  $title = $results['titulo'];

  $book_language_error = false;

  $rate_book = true;
  $new_language = true;

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form-action'])) {
    switch ($_REQUEST['form-action']) {
      case 'ratebook':
        // Si el idioma es por defecto
        if ($_REQUEST['language'] === '-') {
          $rate_book = false;
          $book_language_error = true;
        }

        if ($rate_book) {
          // VALORACION DEL LIBRO
          $query = $miPDO->prepare('INSERT INTO valoracion (nickname, nota, edad, idioma, id_libro, fecha, estado) VALUES (:nickname, :nota, :edad, :idioma, :id_libro, NOW(), "espera")');        
          $query->execute([
            'nickname' => $_SESSION['nickname'],
            'nota' => $_REQUEST['note'],
            'edad' => ($_REQUEST['age']),
            'idioma' => $_REQUEST['language'],
            'id_libro' => $_GET['liburua']
          ]);

          if ($_SESSION['role'] !== 'ikasle') {
            $id_valoracion = $miPDO->lastInsertId();
            $query = $miPDO->prepare('UPDATE valoracion SET estado = "aceptado" WHERE id_valoracion = :id_valoracion');        
            $query->execute(['id_valoracion' => $id_valoracion]);
          }

          // OPINION DEL LIBRO
          $query = $miPDO->prepare('INSERT INTO comentario (nickname, id_libro, mensaje, estado, fecha) VALUES (:nickname, :id_libro, :mensaje, "espera", NOW())');
          $query->execute([
            'nickname' => $_SESSION['nickname'],
            'id_libro' => $_GET['liburua'],
            'mensaje' => nl2br($_REQUEST['opinion'])
          ]);

          $id_comentario = $miPDO->lastInsertId();
          $query = $miPDO->prepare('UPDATE valoracion SET id_comentario = :id_comentario WHERE id_valoracion = :id_valoracion');        
          $query->execute(['id_comentario' => $id_comentario, 'id_valoracion' => $id_valoracion]);

          if ($_SESSION['role'] !== 'ikasle') {
            $query = $miPDO->prepare('UPDATE comentario SET estado = "aceptado" WHERE nickname = :nickname AND id_libro = :id_libro AND mensaje = :mensaje');
            $query->execute(['nickname' => $_SESSION['nickname'], 'id_libro' => $_GET['liburua'], 'mensaje' => nl2br($_REQUEST['opinion'])]);
          }

          // ACTUALIZAR DATOS DEL LIBRO
          $query = $miPDO->prepare('SELECT COUNT(id_valoracion) AS lectores, ROUND(AVG(nota), 0) AS nota, ROUND(AVG(edad), 0) AS edad FROM valoracion WHERE id_libro = :id_libro');
          $query->execute(['id_libro' => $_GET['liburua']]);
          $media = $query->fetch();

          $query = $miPDO->prepare('UPDATE libro SET nota_media = :nota_media, num_lectores = :lectores, edad_media = :edad_media WHERE id_libro = :id_libro');
          $query->execute(['nota_media' => $media['nota'], 'lectores' => $media['lectores'], 'edad_media' => $media['edad'], 'id_libro' => $_GET['liburua']]);

          // RECARGAR PAGINA
          header('Location: book_info.php?liburua='.$_GET['liburua']);
        }
        break;

      case 'newlanguage':
        // Si el idioma es por defecto
        if ($_REQUEST['language'] === '-') {
          $new_language = false;
          $book_language_error = true;
        }

        if ($new_language) {


          if ($_REQUEST['language'] === 'other') {
            $query = $miPDO->prepare('INSERT INTO solicitud_idioma VALUES (:nickname, :idioma, :id_libro, :titulo, "espera")');
            $query->execute(['nickname' => $_SESSION['nickname'] , 'idioma' => $_REQUEST['new-language'], 'id_libro' => $_GET['liburua'], 'titulo' => $_REQUEST['title']]);
          } else {
            $query = $miPDO->prepare('SELECT nombre FROM idioma WHERE id_idioma = :id_idioma');
            $query->execute(['id_idioma' => $_REQUEST['language']]);
            $idioma = $query->fetch();

            $query = $miPDO->prepare('INSERT INTO solicitud_idioma VALUES (:nickname, :idioma, :id_libro, :titulo, "espera")');
            $query->execute(['nickname' => $_SESSION['nickname'] , 'idioma' => $idioma['nombre'], 'id_libro' => $_GET['liburua'], 'titulo' => $_REQUEST['title']]);
          }
          
          // RECARGAR PAGINA
          header('Location: book_info.php?liburua='.$_GET['liburua']);
        }

        break;
    }
  }
?>
    <link rel="stylesheet" href="../styles/book_info.css">
    <title> <?php echo $results['titulo'] ?> | IGKlub</title>
    <script src="../src/js/book_info.js" defer></script>
</head>
<body>
  <main>
  <?php
    if ($results['estado'] === "aceptado") {
      echo ' <a class="back" href="main_menu.php"><i class="fa-solid fa-house"></i> Hasiera joan</a>';
    } else if ($results['estado'] === "espera") {
      echo ' <a class="back" href="management.php"><i class="fa-solid fa-house"></i> Administrazioara joan</a>';
    }
    ?>
    <figure>
      <?php echo '<img src="../src/img/books/'.$results['portada'].'" alt="'.$results['titulo'].'">' ?>
    </figure>
    <section>
      <!-- Titulo y escritor -->
      <header>
        <?php
          echo '<h1>'.$results['titulo'].'</h1>
                <h2>'.$results['escritor'].'</h2>';
        ?>
        <div class="stars">
          <?php
            if ($results['nota_media'] === 0) {
              for ($i = 0; $i <= 4; $i++) {
                echo '<i class="fa-solid fa-star"></i>';
              }
            } else {
              for ($i = 0; $i <= $results['nota_media']-1; $i++) {
                echo '<i class="calification fa-solid fa-star"></i>';
              }
              for ($i = 0; $i <= 4-$results['nota_media']; $i++) {
                echo '<i class="fa-solid fa-star"></i>';
              }
            }
          ?>
        </div>
      </header>
      <div class="info-container">
        <header>
          <p>Sinopsia</p>
          <p>Fitxa teknikoa</p>
        </header>
        <div class="container">
          <!-- Sinopsis -->
          <div class="sinopsis">
            <?php
              echo '<p>'.$results['sinopsis'].'</p>';
            ?>
          </div>
          <!-- Demas datos -->
          <div class="more-info">
            <div>
              <div>
                <h3>Formatua:</h3>
                <?php echo '<p>'.$results['formato'].'</p>';?>
              </div>
              <div>
                <h3>Adina:</h3>
                <?php echo '<p>'.$results['edad_media'].'</p>'; ?>
              </div>
              <div>
                <h3>Irakurleak:</h3>
                <?php echo '<p>'.$results['num_lectores'].'</p>'; ?>
              </div>
            </div>
            <div>
              <?php
                  $query = $miPDO->prepare('SELECT * FROM idioma_libro WHERE libro = :book');
                  $query->execute(['book' => $book]);
                  $results = $query->fetchAll();
                  
                  if ($results) {
                    echo '<h3>Hizkuntzak:</h3>';
                    foreach ($results as $position => $book) {

                      $query = $miPDO->prepare('SELECT nombre FROM idioma WHERE id_idioma = :id_idioma');
                      $query->execute(['id_idioma' => $book['idioma']]);
                      $idioma = $query->fetch();

                      echo '<div>
                              <h3>- '.$book['titulo'].'</h3>
                              <p>('.$idioma['nombre'].')</p>
                            </div>';
                    }
                  } else {
                    echo '<h3>Liburu hau ez dauka beste hizkuntzirik</h3>';
                  }
              ?>
              <span class="new-language-button"><i class="fa-solid fa-language"></i> Hizkuntza berria gehitu</span>
            </div>
          </div>
        </div>
      </div>
      <!-- Acciones -->
      <?php
        $query = $miPDO->prepare('SELECT * FROM valoracion WHERE nickname = :nickname AND id_libro = :id_libro');
        $query->execute(['nickname' => $_SESSION['nickname'], 'id_libro' => $_REQUEST['liburua']]);
        $results = $query->fetch();

        echo '<div class="actions">';
        if ($results) {
          echo '<div><i class="fa-solid fa-star"></i> Liburu hau baloratu duzu</div>';
        } else {
          echo '<div class="rateBookButton"><i class="fa-regular fa-star"></i> Liburu hau baloratu</div>';
        }
        echo '</div>';
      ?>
    </section>
  </main>
  <!-- Reviews -->
  <section class="reviews">
    <header>
      <div>
        <h1>Iruzkinak</h1>
        <button><i class="fa-solid fa-comment"></i> Komentatu</button>
      </div>
    </header>
    <!-- Formulario para comentar -->
    <div class="user-comment">
      <header>
        <h1><?php echo $_SESSION['nickname'] ?></h1>
      </header>
      <div class="mensaje">
        <form action="../modules/new_comment.php" method="get">
          <textarea placeholder="Liburu honi buruz uste dut..." id="mensaje" name="mensaje" autofocus required autocomplete="off" maxlength="2300"></textarea>
          <input type="hidden" name="book" value="<?php echo $_REQUEST['liburua'] ?>">
          <input type="hidden" name="nickname" value="<?php echo $_SESSION['nickname'] ?>">
          <input type="hidden" name="id_comment" value="<?php echo $comment['id_comentario'] ?>">
          <button>Komentatu</button>
        </form>
      </div>
    </div>
    <?php
    $query = $miPDO->prepare('SELECT * FROM comentario WHERE id_libro = :book AND estado = "aceptado" ORDER BY fecha DESC');
    $query->execute(['book' => $_GET['liburua']]);
    $results = $query->fetchAll();

    if ($results) {
      foreach ($results as $position => $comment) {
        $id_comentario = $comment['id_comentario'];
        echo '<section class="comments">
                <div class="main-comment">
                  <header>
                    <h1>'.$comment['nickname'].'</h1>';
                    if ($comment['nickname'] === $_SESSION['nickname']) {
                      echo '<form action="../modules/delete_comment.php" method="get">
                              <input type="hidden" name="book" value="'.$_REQUEST['liburua'].'">
                              <input type="hidden" name="id_comment" value="'.$id_comentario.'">
                              <button><i class="fa-solid fa-trash-can"></i></button>
                            </form>';
                    } else {
                      echo '<button class="answer-button"><i class="fa-solid fa-reply"></i> Erantzun</button>';
                    }
                    
        echo      '</header>
                  <div class="mensaje">
                    '.$comment['mensaje'].'
                    <div class="date">
                      <p>'.date_format(date_create($comment['fecha']), 'G:i').'</p>
                      <p>'.date_format(date_create($comment['fecha']), 'Y/m/j').'</p>
                    </div>
                  </div>
                </div>';
    ?>
      <div class="user-answer">
        <header>
          <h1><?php echo $_SESSION['nickname'] ?></h1>
        </header>
        <div class="mensaje">
          <form action="../modules/new_answer.php" method="get">
            <textarea placeholder="Erantzuna eman" id="mensaje" name="mensaje" autofocus required autocomplete="off" maxlength="2300"></textarea>
            <input type="hidden" name="book" value="<?php echo $_REQUEST['liburua'] ?>">
            <input type="hidden" name="nickname" value="<?php echo $_SESSION['nickname'] ?>">
            <input type="hidden" name="id_comment" value="<?php echo $comment['id_comentario'] ?>">
            <button>Erantzuna eman</button>
          </form>
        </div>
      </div>
    <?php
        $query = $miPDO->prepare('SELECT * FROM respuesta WHERE id_libro = :book AND id_comentario = :id_comentario AND estado = "aceptado" ORDER BY fecha DESC');
        $query->execute(['book' => $_REQUEST['liburua'], 'id_comentario' => $id_comentario]);
        $results = $query->fetchAll();

        if ($results) {
          foreach ($results as $position => $answer) {
            echo '<div class="answer">
                    <header>
                      <h1>'.$answer['nickname'].'</h1>';
                      if ($answer['nickname'] === $_SESSION['nickname']) {
                        echo '<form action="../modules/delete_answer.php" method="get">
                                <input type="hidden" name="book" value="'.$_REQUEST['liburua'].'">
                                <input type="hidden" name="id_answer" value="'.$answer['id_respuesta'].'">
                                <button><i class="fa-solid fa-trash-can"></i></button>
                              </form>';
                      }
            echo    '</header>
                    <div class="mensaje">
                      '.$answer['mensaje'].'
                      <div class="date">
                        <p>'.date_format(date_create($comment['fecha']), 'G:i').'</p>
                        <p>'.date_format(date_create($comment['fecha']), 'Y/m/j').'</p>
                      </div>
                    </div>
                  </div>';
          }
        }
        echo '</section>';
      }
    } else {
      echo '<h1 class="empty">Oraindik ez dago komentariorik</h1>';
    }
    ?>
    </section>
  </section>

  <!-- VALORAR LIBRO -->
  <div class="rate-book">
  <button class="closeButton"><i class="fa-solid fa-x"></i></button>
  <form id="rateBookForm" action="" method="post">
    <h1><?php echo $title ?> baloratu</h1>
    <!-- Nota -->
    <div class="stars-container">
      <input type="radio" name="rate" id="5">
      <label for="5" class="fa-solid fa-star"></label>
      <input type="radio" name="rate" id="4">
      <label for="4" class="fa-solid fa-star"></label>
      <input type="radio" name="rate" id="3">
      <label for="3" class="fa-solid fa-star"></label>
      <input type="radio" name="rate" id="2">
      <label for="2" class="fa-solid fa-star"></label>
      <input type="radio" name="rate" id="1">
      <label for="1" class="fa-solid fa-star"></label>
      <input type="hidden" name="note" id="note" value="0">
    </div>
    <!-- Error: Nota -->
    <div class="error hidden" id="note-error">
        <i class="fa-solid fa-circle-exclamation"></i>
        <p>Nahitaezkoa da liburuari nota ematea.</p>
    </div>
    <!-- Edad en la que leyo el libro -->
    <div class="input-container">
      <i class="fa-solid fa-calendar-day"></i>
      <input type="number" name="age" id="age" placeholder="Zenbat urterekin irakurri zenuen liburua?" min="5" max="70">
    </div>
    <!-- Error: Edad -->
    <div class="error hidden" id="age-error">
      <i class="fa-solid fa-circle-exclamation"></i>
      <p>Adina 5 eta 70 artekoa izan behar da.</p>
    </div>
    <!-- Idioma -->
    <div class="input-container">
        <i class="fa-solid fa-language"></i>
        <select name="language" id="language">
            <option value="-" selected>Zein hizkuntzatan irakurri zenuen liburua?</option>
            <?php
            $query = $miPDO->prepare('SELECT * FROM idioma ORDER BY id_idioma ASC');
            $query->execute();
            $results = $query->fetchAll();

            foreach ($results as $position => $language) {
                echo '<option value="'.$language['id_idioma'].'">'.$language['nombre'].'</option>';
            }
            ?>
        </select>
    </div>
    <!-- Error: Idioma -->
    <div class="error hidden" id="language-error">
      <i class="fa-solid fa-circle-exclamation"></i>
      <p>Aukeratu hizkuntza bat.</p>
    </div>
    <!-- Opinion -->
    <div class="input-container">
      <i class="fa-solid fa-comment"></i>
      <textarea placeholder="Liburu honi buruz uste dut..." id="opinion" name="opinion" autocomplete="off" maxlength="2300"></textarea>
    </div>
    <!-- Error: Opinion -->
    <div class="error hidden" id="opinion-error">
        <i class="fa-solid fa-circle-exclamation"></i>
        <p>Sinopsia nahitaezkoa da.</p>
    </div>
    <!-- Error: Formulario -->
    <div class="error hidden" id="form-error">
        <i class="fa-solid fa-circle-exclamation"></i>
        <p>Bete formularioa behar bezala.</p>
    </div>
    <input type="hidden" name="form-action" value="ratebook">
    <button>Liburua baloratu</button>
  </form>
  </div>
  <!-- AÑADIR NUEVO IDIOMA -->
  <div class="new-language">
  <button class="closeButton"><i class="fa-solid fa-x"></i></button>
  <form id="newLanguageForm" action="" method="post">
    <h1>Hizkuntza berria gehitu</h1>
    <!-- Idioma -->
    <div class="input-container">
      <i class="fa-solid fa-language"></i>
      <select name="language" id="language">
        <option value="-" selected>Hizkuntza</option>
        <?php
        $query = $miPDO->prepare('SELECT * FROM idioma ORDER BY id_idioma ASC');
        $query->execute();
        $results = $query->fetchAll();

        foreach ($results as $position => $language) {
          echo '<option value="' . $language['id_idioma'] . '">' . $language['nombre'] . '</option>';
        }
        ?>
        <option value="other">Hizkuntza berria</option>
      </select>
    </div>
    <!-- Error: Idioma -->
    <?php
    if ($book_language_error) {
      echo '<div class="error php-error">
              <i class="fa-solid fa-circle-exclamation"></i>
              <p>Aukeratu hizkuntza bat.</p>
            </div>';
    }
    ?>
    <!-- Nuevo idioma -->
    <section class="new-language-section">
      <div class="input-container">
        <input type="text" name="new-language" id="new-language" placeholder="Hizkuntza berria">
      </div>
    </section>
    <!-- Titulo del libro -->
    <div class="input-container">
      <i class="fa-solid fa-heading"></i>
      <input type="text" name="title" id="title" placeholder="Izenburua hizkuntza berrian" autofocus value="<?php if (isset($_REQUEST['title']))
          echo $_REQUEST['title'] ?>">
    </div>
    <!-- Error: Titulo del libro -->
    <div class="error hidden" id="title-error">
      <i class="fa-solid fa-circle-exclamation"></i>
      <p>Egiaztatu izenburua ondo idatzita dagoela.</p>
    </div>
    <!-- Error: Formulario -->
    <div class="error hidden" id="form-error">
        <i class="fa-solid fa-circle-exclamation"></i>
        <p>Bete formularioa behar bezala.</p>
    </div>
    <input type="hidden" name="form-action" value="newlanguage">
    <button>Hizkuntza berria gehitu</button>
  </form>
  </div>
</body>
</html>