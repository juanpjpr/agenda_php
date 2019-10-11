<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agenda";


$filtro="";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if(isset($_GET['nombre'])){
    $nombre= $_GET['nombre'];
    $apellido= $_GET['apellido'];

    $sql = "INSERT INTO contacto (nombre, apellido)
VALUES ('$nombre','$apellido')";
if ($conn->query($sql) === TRUE) {
    echo "<div class='container mt-4 alert alert-success' role='alert'>El registro se agrego con exito!</div>";
} else {
    echo "<div class='container mt-4 alert alert-warning' role='alert'>El registro no se pudo agregar</div>";
}
}

if(isset($_GET['filtro'])){
    $filtro=$_GET['filtro'];

    $sql = "SELECT * from contacto where nombre like '%$filtro%'
    union SELECT * from contacto where id like '$filtro'
    union SELECT * from contacto where apellido like '%$filtro%'
    ";
    
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            echo "<div class='container mt-4 alert alert-success' role='alert'><tr><td>Id: <strong>" . $row["id"]. "</strong> - </td><td>Nombre: <strong>" . $row["nombre"]. "</strong> - </td><td>Apellido: <strong>" . $row["apellido"]. "</strong></td><td> - <a href='index.php?edit=".$row['id']."' class='btn btn-outline-primary btn-sm'>Modificar</a><a href='index.php?delete=".$row['id']."' class='btn btn-outline-danger btn-sm'>Eliminar</a></td></tr></div>";
        }  
    } else {
        echo "<div class='container mt-4 alert alert-danger' role='alert'> No se encontro resultados </div>";
    }
}

if(isset($_GET['delete'])){
    $id=$_GET['delete'];
    $sql = "DELETE FROM contacto WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "<div class='container mt-4 alert alert-success' role='alert'>El registro se ha borrado con exito!</div>";
    } else {
        echo "<div class='container mt-4 alert alert-danger' role='alert'> No se pudo borrar el registro </div>";
    }
}




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body> 
<div class="container mt-4">
<form class="form-inline float-right>" accion="" method="GET">
      <input class="form-control mr-sm-2" type="search" aria-label="Search" name="filtro">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
    </form>
</div>
<div class="container mt-4">
<h2>Agregar </h2>
<form action="" method="GET">
  <div class="form-group">
    <label for="nombre">Nombre</label>
    <input type="text" class="form-control" name="nombre" id="nombre" required>
  </div>
  <div class="form-group">
    <label for="apellido">Apellido</label>
    <input type="text" class="form-control" name="apellido" id="apellido" required>
  </div>
  <button type="submit" class="btn btn-outline-primary">Agregar</button>
</form>
</div>


<div class="container mt-4">
<h2>Agenda </h2>
    <table class="table table-sm">
    <thead>
    <th>Id</th>
    <th>Nombre</th>
    <th>Apellido</th>
    <th>Acciones</th>
    <thead>
    <tbody>
    <?php
    $sql = "SELECT * FROM contacto";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["id"]. "</td><td>" . $row["nombre"]. "</td><td>" . $row["apellido"]. "</td><td><a href='index.php?edit=".$row['id']."' class='btn btn-outline-primary btn-sm'>Modificar</a><a href='index.php?delete=".$row['id']."' class='btn btn-outline-danger btn-sm'>Eliminar</a></td></tr>";
        }
    } else {
        echo "0 results";
    }
     ?>
    </tbody>
    </table>
    <div>
</body>
</html>