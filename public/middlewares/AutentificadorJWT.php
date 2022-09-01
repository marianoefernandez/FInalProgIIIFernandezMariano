<?php
use Firebase\JWT\JWT;

class AutentificadorJWT
{
    private static $claveSecreta = 'SuperOctavioVillegas666@!?.';
    private static $tipoEncriptacion = ['HS256'];
    private static $aud = null;
    
    public static function CrearToken($datos)
    {
        $ahora = time();
        $payload = array
        (
        	'iat'=>$ahora,
            'exp' => $ahora + (200000),
            'aud' => self::Aud(),
            'data' => $datos,
            'app'=> "Prueba JWT"
        );
        return JWT::encode($payload, self::$claveSecreta);
    }
    
    public static function VerificarToken($token)
    {
       
        if(empty($token)|| $token=="")
        {
            throw new Exception("El token esta vacio.");
        } 
        try 
        {
            $decodificado = AutentificadorJWT::ObtenerPayLoad($token);
        }
        catch (Exception $e) 
        {
           throw new Exception("Clave fuera de tiempo");
        }
        
        if($decodificado->aud !== self::Aud())
        {
            throw new Exception("No es el usuario valido");
        }
    }
    
   
    private static function ObtenerPayLoad($token)
    {
        return JWT::decode
        (
            $token,
            self::$claveSecreta,
            self::$tipoEncriptacion
        );
    }

    public static function ObtenerData($token)
    {
        return AutentificadorJWT::ObtenerPayLoad($token)->data;
    }

    private static function Aud()
    {
        $aud = '';
        
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) 
        {
            $aud = $_SERVER['HTTP_CLIENT_IP'];
        } 
        else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) 
        {
            $aud = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } 
        else if(!empty($_SERVER['REDIRECT_HTTP_AUTHORIZATION']))
        {
            $aud = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
        }
        else 
        {
            $aud = $_SERVER['REMOTE_ADDR'];
        }
        
        $aud .= @$_SERVER['HTTP_USER_AGENT'];
        $aud .= gethostname();
        
        return sha1($aud);
    }
}