<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD"
      crossorigin="anonymous"
    />
</head>
<body>
    <div class="container mt-5">
    <form action="index.html" method="post" class="mt-4">
                    <button type="submit" class="btn btn-danger">Cerrar sesión</button>
                </form>
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <?php
                if ($_SERVER["REQUEST_METHOD"] === "POST") {
                    
                    $password = $_POST['password'];
                    $keyFile = $_FILES['key']['tmp_name'];
                    $cerFile = $_FILES['cer']['tmp_name'];

                    if (!file_exists($keyFile) || !file_exists($cerFile)) {
                        echo "<div class='alert alert-danger'>Error: No se encontraron los archivos subidos.</div>";
                        exit;
                    }

                    $encryptedKey = file_get_contents($keyFile);
                    $encryptedCer = file_get_contents($cerFile);

                  
                    $method = "AES-256-CBC";
                    $key = hash("sha256", $password, true); 
                    $iv = substr($key, 0, 16); 

                    
                    $decryptedKey = openssl_decrypt($encryptedKey, $method, $key, 0, $iv);
                    if ($decryptedKey === false) {
                        echo "<div class='alert alert-danger'>Error: No se pudo desencriptar el archivo .key. Verifica la contraseña.</div>";
                        exit;
                    }

                    $decryptedCer = openssl_decrypt($encryptedCer, $method, $key, 0, $iv);
                    if ($decryptedCer === false) {
                        echo "<div class='alert alert-danger'>Error: No se pudo desencriptar el archivo .cer. Verifica la contraseña.</div>";
                        exit;
                    }

                    echo "<div class='alert alert-success'>Contenido desencriptado:</div>";
                    echo "<div class='text-start'>";
                    echo "<h4><strong>Archivo .key:</strong><br>" . nl2br(htmlspecialchars($decryptedKey)) . "</h4>";
                    echo "<h4><strong>Archivo .cer:</strong><br>" . nl2br(htmlspecialchars($decryptedCer)) . "</h4>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76A2emsAqE3PzUU9W9hK3tZWjHARiUp3H9jrM2EAUOU6zV6BRzGhPcJhA8BL6h2" crossorigin="anonymous"></script>
</body>
</html>
