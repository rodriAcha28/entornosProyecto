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
    $roles = $_POST['roles'];
    if (strpos($roles, 'Instructor') !== false) {
        header('Location: /dashboard/docente.php');
    } else {
        header('Location: /dashboard/estudiante.php');
    }
} else {
    echo 'Invalid LTI request';
}
?>
