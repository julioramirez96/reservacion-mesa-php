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

    <title>Reservacion</title>
</head>
<body>
<div class="container">
    <div class="border mt-3 p-3">
        <div class="alert alert-success" role="alert">
            Reservacion Confirmada
        </div>

        <!-- El formulario recupera el nuevo valor de los invitados para que sea actualizo -->
        <form action="/reservacion/{{$id ?? ''}}" method="post" >

            <!-- Agregamo el token csrf y marcamos que este formulario sera tratado a traves de un metodo patch-->
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
            <div class="form-group">
                <label for="name">Nombre del Cliente</label>
                <input disabled value="{{$nombre}}" type="text" name="name" class="form-control" id="name" placeholder="Nombre">
            </div>
            <div class="form-group">
                <label for="date">Fecha</label>
                <input disabled value="{{$fecha}}" type="date" name="date" class="form-control" id="date">
            </div>
            <div class="form-group">
                <label for="hour">Hora</label>
                <input disabled value="{{$hora}}" type="text" class="form-control timepicker" autocomplete="off" id="hour" name="hour" placeholder="HH:MM">
            </div>
            <div class="form-group">
                <label for="guests">Mesa Selccionada</label>
                <input disabled type="text" class="form-control" id="guests" name="guests" value="{{$mesa}}">
            </div>
            <div class="form-group">
                <label for="guests">Subtotal</label>
                <input disabled type="number" min="1" class="form-control" id="guests" name="guests" value="{{$subtotal}}">
            </div>
            <div class="form-group">
                <label for="guests">Precio Total</label>
                <input disabled type="number" class="form-control" id="guests" name="guests" value="{{$total}}">
            </div>

            <!-- Numero de invitados es el unica campo habilitado para ser actualizado-->
            <div class="form-group">
                <label for="guests">Numero de Invitados</label>
                <input type="number" class="form-control" id="guests" name="guests" value="{{$invitados}}">
            </div>


            <button id="updateButton" type="submit" class="btn btn-primary mb-2">Actualizar numero de invitados</button>
        </form>
        <form  method="POST" action="/reservacion/{{$id ?? ''}}">
            <!-- Agregamo el token csrf y marcamos que este formulario sera tratado a traves de un metodo delete-->
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button type="submit" class="btn btn-danger mt-2" value="Delete user">Eliminar Reservacion</button>
        </form>
    </div>
</div>
</body>
</html>
