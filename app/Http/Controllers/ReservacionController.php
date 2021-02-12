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
class ReservacionController extends Controller {

    private $titulo = "Reservacion Mesa de Restaurante";
    private $url = "/reservacion";

    public function __invoke() {
        // Agregamos las propiedades de titulo y url al modelo y retornamos la vista "reservacion"
        return view('reservacion', [
            'titulo' => $this -> titulo,
            'url' => $this -> url
        ]);
    }

    public function reservar(Request $request) {
        // Conexion a la base de datos mysql
        $conn = mysqli_connect('127.0.0.1', 'root', '', 'curso');

        //Obtenermos las variables del formulario
        $nombre = $request->input('name');
        $fecha = $request->input('date');
        $hora = $request->input('hour');
        $invitados = $request->input('guests');


        // Ejecutamos la logica de negocio
        define('GUEST_PRICE', 150); // Precio por invitado
        $discount = $this->calculateDiscount($invitados); // Calcula el descuento otorgado dependiendo del numero de invitados
        $tablesArray = array('Mesa Grande', 'Mesa Mediana', 'Mesa Chica'); // Inicializa el arreglo que contiene los tipos de mesas del restaurante
        $table = $this->selectTable($invitados, $tablesArray); // Selecciona que mesa ocuparan dependiendo del numero de invitados
        $subtotalPrice = GUEST_PRICE * $invitados; // Subtotal = 150 * numero de invitados
        $precio = $this->calculateTotalPrice($invitados, $discount); // Precio total = subtotal menos el descuento calculado


        // Generamos el query para hacer el registro
        $sql = "INSERT INTO reservaciones (nombre, fecha, hora, no_invitados, subtotal, precio_total, mesa) VALUES ('$nombre', '$fecha', '$hora', $invitados, $subtotalPrice, $precio, '$table')";

        // Si el registro fue exitoso, redirigimos al usuario a la pagina de confrimacion
        if ($conn->query($sql) === TRUE) {
            $last_id = $conn->insert_id;
            return redirect("/reservacion/$last_id");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Cerramos la conexion a base de datos
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
