<?php

/*
    Nombre alumno: Julio Cesar Ramirez Hernandez
    Nombre profesor: Octavio Aguirre Lozano
    Materia: Computacion en el servidor web
    Actividad: Manejo de datos en el servidor e interacción con el cliente mediante una aplicación web
*/

namespace App\Http\Controllers;
use Illuminate\Http\Request;

// Creamos nuestra clase controlador y heredamos de la clase Controller
class MostrarReservacionController extends Controller {
    private $id = 0;
    private $nombre = '';
    private $fecha = '';
    private $hora = '';
    private $mesa = '';
    private $invitados = 0;
    private $subtotal = 0;
    private $total = 0;


    public function mostrar(Request $request, $id) {
        // Conexion a la base de datos mysql
        $conn = mysqli_connect('127.0.0.1', 'root', '', 'curso');

        // Generamos el query para obtener el registro que corresponda con el id
        $sql = "SELECT * FROM reservaciones WHERE id = $id";

        // Ejecutamos query
        $result = $conn->query($sql);

        // Mapeamos las propiedades del registro a nuestro objeto
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $this ->id = $row["id"];
                $this ->nombre = $row["nombre"];
                $this ->fecha = $row["fecha"];
                $this ->hora = $row["hora"];
                $this ->mesa = $row["mesa"];
                $this ->invitados = $row["no_invitados"];
                $this ->subtotal = $row["subtotal"];
                $this ->total = $row["precio_total"];
            }
        } else {
            echo "0 results";
        }

        // Cerramos Conexion
        $conn->close();

        return view("mostrar-reservacion", [
            'id' => $this -> id,
            'nombre' => $this -> nombre,
            'fecha' => $this -> fecha,
            'hora' => $this -> hora,
            'invitados' => $this -> invitados,
            'mesa' => $this -> mesa,
            'subtotal' => $this -> subtotal,
            'total' => $this -> total
        ]);
    }

    public function actualizar(Request $request, $id) {
        // Conexion a la base de datos mysql
        $conn = mysqli_connect('127.0.0.1', 'root', '', 'curso');

        // Recuperamos el nuevo numero de invitados
        $invitados = $request->input('guests');


        // Ejecutamos la logica de negocio
        define('GUEST_PRICE', 150); // Precio por invitado
        $discount = $this->calculateDiscount($invitados); // Calcula el descuento otorgado dependiendo del numero de invitados
        $tablesArray = array('Mesa Grande', 'Mesa Mediana', 'Mesa Chica'); // Inicializa el arreglo que contiene los tipos de mesas del restaurante
        $table = $this->selectTable($invitados, $tablesArray); // Selecciona que mesa ocuparan dependiendo del numero de invitados
        $subtotalPrice = GUEST_PRICE * $invitados; // Subtotal = 150 * numero de invitados
        $precio = $this->calculateTotalPrice($invitados, $discount); // Precio total = subtotal menos el descuento calculado


        // Generamos el query para actualizar el registro
        $sql = "UPDATE reservaciones SET no_invitados=$invitados, subtotal=$subtotalPrice, precio_total=$precio, mesa='$table' WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            return redirect("/reservacion/$id");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }

    public function eliminar(Request $request, $id) {
        // Conexion a la base de datos mysql
        $conn = mysqli_connect('127.0.0.1', 'root', '', 'curso');

        // Generamos el query para generar el registro
        $sql = "DELETE FROM reservaciones WHERE id=$id";

        // Si fue exitosa la eliminacion del registro muestra un alert al usuario para notificar
        if ($conn->query($sql) === TRUE) {
            echo '<script language="javascript">';
            echo 'alert("Se elimino la reservacion")';
            echo '</script>';
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Se cierra la conexion con mysql
        $conn->close();

    }

    // Genera el descuento otorgado dependiendo el numero de invitados
    private function calculateDiscount($guestsNumber){
        if ($guestsNumber >= 10){
            return 300;
        } elseif ($guestsNumber >=5 && $guestsNumber <=9) {
            return 150;
        } else {
            return 0;
        }
    }

    // Calcula el precio total = (numero de invitados * precio invitado) - descuento
    protected function calculateTotalPrice($guestsNumber, $discount) {
        $count = 0;
        $price = 0;
        while ($count < $guestsNumber) {
            $price += GUEST_PRICE;
            $count++;
        }
        return $price - $discount;
    }

    // Selecciona la mesa dependiendo del numero de invitados
    private function selectTable($guestsNumber, $tablesArray) {
        $table = '';

        switch ($guestsNumber) {
            case $guestsNumber >= 10:
                $table = $tablesArray[0];
                break;
            case $guestsNumber >=5 && $guestsNumber <=9:
                $table = $tablesArray[1];
                break;
            default:
                $table = $tablesArray[2];
                break;
        }
        return $table;
    }

}
