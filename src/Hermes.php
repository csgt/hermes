<?php 

namespace Csgt\Hermes;
use Config, View, Response, Redirect, Mail, Exception, Auth, 
  Request, Log, App, Input;

class Hermes {

	private static $view;
	private static $data;
	private static $subject;
	private static $to          = [];
	private static $cc          = [];
	private static $bcc         = [];
	private static $attachments = [];
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
		$response = ['error'=>false,'message'=>''];

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
		} catch (\Exception $e) {
			$response['error']   = true;
			$response['message'] = $e->getMessage();
		}

		return $response;
	}

	//=== SEND ERROR NOTIFICATIONS ===
	public static function notificarError($excepcion) {
		$mensaje='--'; $archivo='--'; $linea='--'; $codigo='--';
		try {
			$mensaje   = $excepcion->getMessage();
			$archivo   = $excepcion->getFile();
			$linea     = $excepcion->getLine();
			$codigo    = $excepcion->getCode();
		} 
		catch (\Exception $e) {}
		
		if ($excepcion instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
			$codigo = 404;
    	Log::error('NotFoundHttpException Route: ' . Request::url() );
		}
  
  	else if ($excepcion instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException) {
  		$codigo = 405;
	    Log::error('MethodNotAllowedHttpException Route: ' . Request::url() );
  	}
	  
	  Log::error($excepcion);

		if(App::environment() == 'local') return;

		if(in_array($codigo, config("csgthermes.ignorecodes"))) return;

		try {
			$parametros = array(
				'codigo'    => $codigo,
				'mensaje'   => $mensaje,
				'url'       => Request::url(),
				'vars'			=> Input::all(),
				'ip'        => $_SERVER['REMOTE_ADDR'],
				'useragent' => $_SERVER['HTTP_USER_AGENT'],
				'userid'    => Auth::check() ? Auth::id() : '--',
				'rolid'     => Auth::check() ? Auth::user()->rolid : '--',
				'request'   => Request::method(),
				'archivo'   => $archivo,
				'linea'     => $linea
			);

			Mail::send(config("csgthermes.notificacionview"), $parametros, function($message) use ($codigo) {
				$message->from(config("csgthermes.notificacionemail"), config("csgthermes.notificacionfrom").' | '.config("csgthermes.notificaciontitulo"));
	     	$message->subject(config("csgthermes.notificaciontitulo") . ' - Error ' . $codigo);
	     	$message->to(config("csgthermes.notificarerrores"));
			});
		} catch (\Exception $e) {
				Log::error($e);
			}
	}
}