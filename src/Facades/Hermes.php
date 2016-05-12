<?php namespace Csgt\Hermes\Facades;
 
use Illuminate\Support\Facades\Facade;
 
class Hermes extends Facade {
  protected static function getFacadeAccessor() { return 'hermes'; }
}