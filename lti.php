<?php
// Configura tu clave de consumidor y secreto compartido
$consumerKey = 'yourConsumerKey';
$consumerSecret = 'yourConsumerSecret';

// Función para verificar la firma OAuth
function validate_oauth_signature($params, $secret, $url, $method) {
    $baseString = $method . '&' . urlencode($url) . '&' . urlencode(http_build_query($params));
    $key = urlencode($secret) . '&';
    $signature = base64_encode(hash_hmac('sha1', $baseString, $key, true));
    return $signature;
}

// Verifica la firma OAuth
$valid = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $params = $_POST;
    $receivedSignature = $params['oauth_signature'];
    unset($params['oauth_signature']);
    $calculatedSignature = validate_oauth_signature($params, $consumerSecret, 'http://yourdomain.com/lti.php', 'POST');

    if ($receivedSignature === $calculatedSignature) {
        $valid = true;
    }
}

// Redirige según el rol del usuario
if ($valid) {
    session_start();
    $_SESSION['id_usuario'] = $_POST['user_id'];
    $_SESSION['nombre_usuario'] = $_POST['lis_person_name_full'];
    $_SESSION['correo_usuario'] = $_POST['lis_person_contact_email_primary'];
    $roles = $_POST['roles'];

    if (strpos($roles, 'Instructor') !== false) {
        $_SESSION['id_maestro'] = $_POST['user_id'];
        header('Location: /maestro_home.html');
    } elseif (strpos($roles, 'Learner') !== false) {
        $_SESSION['id_estudiante'] = $_POST['user_id'];
        header('Location: /estudiante_home.html');
    } else {
        echo 'Acceso denegado: Usuario no autorizado';
    }
} else {
    echo 'Invalid LTI request';
}
?>
