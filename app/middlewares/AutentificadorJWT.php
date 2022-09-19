<?php
//require __DIR__ . '/../vendor/autoload.php';
use Firebase\JWT\JWT;

class AutentificadorJWT
{
    private static $claveSecreta = 'SuperOctavioVillegas666';
    private static $tipoEncriptacion = ['HS256'];
    private static $aud = null;

    public static function CrearToken($data) 
    {
        $ahora = time();
        $payload = array(
            'iat' => $ahora,
            'exp' => $ahora + 86400,
            'aud' => self::Aud(),
            'data' => $data,
            'app' => "La comanda Fernandez Mariano"
        );
        return JWT::encode($payload, self::$claveSecreta);
    }

    public static function VerificarToken($token) 
    {
        if (empty($token) || $token == "") 
        {
            throw new Exception("El token está vacio");
        }
        try 
        {
            $decodificado = JWT::decode(
                $token,
                self::$claveSecreta,
                self::$tipoEncriptacion
            );

        } 
        catch (Exception $e) 
        {
            throw new Exception("Clave fuera de tiempo");
        }
        if ($decodificado->aud !== self::Aud())
        {
            throw new Exception("Usuario Incorrecto");
        }
    }

    public static function ObtenerPayload($token) 
    {
        return JWT::decode(
            $token,
            self::$claveSecreta,
            self::$tipoEncriptacion
        );
    }

    public static function ObtenerData($token) 
    {
        $array = JWT::decode(
            $token,
            self::$claveSecreta,
            self::$tipoEncriptacion
        )->data;
        return $array;
    }

    private static function Aud() 
    {
        $aud = '';

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $aud = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $aud = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $aud = $_SERVER['REMOTE_ADDR'];
        }

        $aud .= @$_SERVER['HTTP_USER_AGENT'];
        $aud .= gethostname();

        return sha1($aud);
    }
}
?>