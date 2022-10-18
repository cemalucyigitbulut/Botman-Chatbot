<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Attachments;
use BotMan\BotMan\Messages;



class NewBotmanConversation extends Conversation
{

     protected $name;
     protected $surname;
     protected $age;
     protected $gender;


     public function run(){
    
      //$this->say('Hi');
      $this->ask('Hi , What is your name ?', function ($answer){
               $value = $answer->getText();
               if($value === 'name'){
               //$this->say('not look like a name to me');
               return $this->repeat('not look like a name to me , please provide your real name');
               }
               
               $this->say('Nice name '.$this->name.' , now i will ask your surname');

               $this->askSurname();
      });
     }

    protected function askSurname(){
        $this->ask('your surname , can you write it now ?', function ($answer){
            $this->surname = $answer->getText();
            $this->say('hmm okay so your surname is '.$this->surname.' , good stuff , now i will ask your age and gender');
               
            $this->askAge();
    });
    }

      protected function askAge(){

        $this->ask('okay, can you write your age please', function ($answer){
            $this->age = $answer->getText();
            $this->say('hmm so you are '.$this->age.' , years old');
            
            $this->askGender();

     });
    }

    protected function askGender(){
        $this->ask('okay, can you write your gender please ?', function ($answer){
            $this->gender = $answer->getText();
            $this->say('so you are '.$this->gender.' okay thanks, thats everything i wanted , goodbye');
            
    });
    }
}

