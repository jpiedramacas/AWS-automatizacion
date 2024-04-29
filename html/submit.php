?php

require 'vendor/autoload.php';

use Aws\Exception\AwsException;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    try {
        // Insertar datos del formulario en la base de datos MySQL
        $mysqli = new mysqli("mysql", "my_user", "my_password", "my_database");

        // Verificar la conexión
        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }

        // Preparar y vincular
        $stmt = $mysqli->prepare("INSERT INTO form_data (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);

        // Ejecutar la consulta
        $stmt->execute();

        echo "Message sent successfully.";

        // Crear mensaje para enviar al tema de SNS
        $messageToSend = json_encode([
            'email' => $email,
            'name' => $name,
            'message' => $message
        ]);

        // Enviar mensaje a SNS
        $sns = new Aws\Sns\SnsClient([
            'region' => 'us-west-1', // Cambia la región según la configuración de tu cuenta
            'version' => 'latest',
            'credentials' => [
                'key' => 'YOUR_AWS_ACCESS_KEY_ID',
                'secret' => 'YOUR_AWS_SECRET_ACCESS_KEY'
            ]
        ]);

        $result = $sns->publish([
            'Message' => $messageToSend,
            'TopicArn' => 'arn:aws:sns:us-east-1:533266991023:prueba' // Cambia el ARN del tema con el tuyo
        ]);

        // Imprimir información de resultado
        print_r($result);
    } catch (AwsException $e) {
        echo "Error sending message: " . $e->getMessage();
    }
} else {
    http_response_code(405);
    echo "Method Not Allowed";
}

?>

