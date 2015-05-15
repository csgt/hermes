<?php 

namespace Csgt\Hermes;
use Config, View, Response, Redirect, Mail, Exception, Auth, Request, Log, App;

class Hermes {

	private static $view;
	private static $data;
	private static $subject;
	private static $to          = array();
	private static $cc          = array();
	private static $bcc         = array();
	private static $attachments = array();
	private static $fromemail   = 'hermes@cs.com.gt';
	private static $from        = 'Hermes';
	
	//=== SETTERS ===
	public static function setView($aView) {
		self::$view = $aView;
	}

	public static function setData($aData) {
		self::$data = $aData;
	}

	public static function setSubject($aSubject) {
		self::$subject = $aSubject;
	}

	public static function setTo($aTo) {
		self::$to = $aTo;
	}

	public static function setCc($aCc) {
		self::$cc = $aCc;
	}

	public static function setBcc($aBcc) {
		self::$bcc = $aBcc;
	}

	public static function setAttachment($aAttachment) {
		if(!file_exists($aAttachment))
			dd('Archivo seleccionado no existe. ('.$aAttachment.')');

		self::$attachments[] = $aAttachment;
	}

	//=== SEND EMAIL ===
	public static function sendEmail() {
		$response = array('error'=>false,'message'=>'');

		try {
			Mail::send(self::$view, self::$data, function($message) {
				$message->from(self::$fromemail, self::$from);
	     	$message->subject(self::$subject);
	     	$message->to(self::$to);
	     	$message->cc(self::$cc);
	     	$message->bcc(self::$bcc);

	     	foreach(self::$attachments as $attachment) {
	     		$message->attach($attachment);
	     	}
			});
		} catch (Exception $e) {
			$response['error']   = true;
			$response['message'] = $e->getMessage();
		}

		return $response;
	}

	//=== SEND ERROR NOTIFICATIONS ===
	public static function notificarError($aParametros) {
		if(!array_key_exists('excepcion', $aParametros)) {
			$mensaje   = 'Parametros incorrectos en Hermes';
			$archivo   = 'Parametros incorrectos en Hermes';
			$linea     = 'Parametros incorrectos en Hermes';
			$excepcion = null;
		}

		else {
			$mensaje   = $aParametros['excepcion']->getMessage();
			$archivo   = $aParametros['excepcion']->getFile();
			$linea     = $aParametros['excepcion']->getLine();
			$excepcion = $aParametros['excepcion'];
		}

		if($excepcion) {
			if ($excepcion instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException)
	    	Log::error('NotFoundHttpException Route: ' . Request::url() );
	  
	  	else if ($excepcion instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException)
		    Log::error('MethodNotAllowedHttpException Route: ' . Request::url() );
		  
		  Log::error($excepcion);
		}

		if(App::environment() == 'local') return;

		try {
			$codigo = array_key_exists('codigo', $aParametros) ? $aParametros['codigo'] : 'Parametros incorrectos en Hermes';
			$parametros = array(
				'codigo'    => $codigo,
				'mensaje'   => $mensaje,
				'url'       => Request::url(),
				'ip'        => $_SERVER['REMOTE_ADDR'],
				'useragent' => $_SERVER['HTTP_USER_AGENT'],
				'userid'    => Auth::check() ? Auth::id() : 'Usuario no autenticado',
				'rolid'     => Auth::check() ? Auth::user()->rolid : 'Usuario no autenticado',
				'request'   => Request::method(),
				'archivo'   => $archivo,
				'linea'     => $linea
			);

			Mail::send(Config::get('hermes::notificacionview'), $parametros, function($message) use ($codigo) {
				$message->from(Config::get('hermes::notificacionemail'), Config::get('hermes::notificacionfrom'));
	     	$message->subject(Config::get('hermes::notificaciontitulo') . '| Error ' . $codigo);
	     	$message->to(Config::get('hermes::notificarerrores'));
			});
		} catch (Exception $e) { }
		
	}
}