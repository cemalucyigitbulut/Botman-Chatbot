<?php
namespace App\Http\Controllers;
   
use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;
use BotMan\BotMan\Messages\Incoming\Answer;
use App\Http\Controllers\BotManController;

$botman = resolve ('botman');

$botman->hears('hey' , function ($bot){

    $bot->reply('heyo');
       
});

