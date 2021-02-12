<!doctype html>

<!--
    Nombre alumno: Julio Cesar Ramirez Hernandez
    Nombre profesor: Octavio Aguirre Lozano
    Materia: Computacion en el servidor web
    Actividad: Manejo de datos en el servidor e interacción con el cliente mediante una aplicación web
-->

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- https://getbootstrap.com/ -->
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- https://timepicker.co/ -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">

    <!-- https://jquery.com/ -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <!-- https://timepicker.co/ -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

    <title>Reservacion</title>
</head>
<body>
<div class="container">
    <div class="border mt-3 p-3">

        <!-- Formulario con los campos de entrada -->
        <div class="alert alert-primary" role="alert">
            {{$titulo}}
        </div>
        <!-- Envia los datos del formulario a traves de metodo post al archivo save.php -->
        <form action="{{ url($url) }}" method="post" >

            <!--Agregamos le token csrf-->
            {{ csrf_field() }}
            <div class="form-group">
                <label for="name">Nombre del Cliente</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Nombre">
                <small id="nameHelp" class="form-text text-muted">Ingrese su nombre</small>
            </div>
            <div class="form-group">
                <label for="date">Fecha</label>
                <input type="date" name="date" class="form-control" id="date">
                <small id="dateHelp" class="form-text text-muted">Ingrese la fecha para su reservacion</small>
            </div>
            <div class="form-group">
                <label for="hour">Hora</label>
                <input type="text" class="form-control timepicker" autocomplete="off" id="hour" name="hour" placeholder="HH:MM">
                <small id="hourHelp" class="form-text text-muted">Ingrese la hora para su reservacion</small>
            </div>
            <div class="form-group">
                <label for="guests">Numero de Invitados - Precio por invitado $150</label>
                <input type="number" min="1" class="form-control" id="guests" name="guests" value="1">
            </div>


            <button id="sendButton" type="submit" class="btn btn-primary">Reservar</button>
        </form>
    </div>
</div>
</body>
<script type="text/javascript">
    // Script para inicialiazar time picker con jQuery
    $(document).ready(function(){
        $('input.timepicker').timepicker({
            scrollbar:true,
            minTime: '10',
            startTime: '10:00',
            maxTime: '11:00pm',
        });
    });
</script>
</html>
