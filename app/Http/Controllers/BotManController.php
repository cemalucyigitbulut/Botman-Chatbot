<?php
namespace App\Http\Controllers;
   
use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Attachments\Attachment;
use BotMan\BotMan\Messages\Attachments\Video;
use BotMan\BotMan\Messages\Attachments\Audio;
use BotMan\BotMan\Messages\Attachments\File;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages;
use App\Http\Controllers\BotmanAsk;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;

class BotManController extends Controller
{
    // yeni bir class açarken web.php ye route ekle

    
    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        $botman = app('botman');

        $botman->fallback(function($bot){
            $message = $bot->getMessage();
            $bot->reply('Sorry, I did not understand "' .$message->getText().'"');
            $bot->reply('Here is a list of commands I understand: (my name is [name]) , (say my name) ,(video) , (audio)  ,(show me buttons)    ');
        });
   
        $botman->hears('Hi|hi|hey|hello|howdy|HI|Hİ|yo|Yo|YO (.*)', function($botman) {
   
            $this->askName($botman);

            // if ($message == 'Hi' OR $message == 'hi' OR $message == 'hey' OR $message == 'hello' OR $message == 'howdy'  OR $message == 'HI' OR $message == 'Hİ' OR $message == 'yo' OR $message == 'Yo' OR $message == 'YO') {
            //     $this->askName($botman);
            // }         

            // elseif ($message == 'show me buttons'){
            //     $this->showButtons($botman);
            //   }
            

            // else{
            //       $botman->reply("Sorry, I did not understand these commands. Here is a list of commands I understand: ......... ");
            //  }
   
        });

        $botman->hears('my name is {name}',function($botman,$name){
                      $botman->userStorage()->save(['name' => $name]);
                      $botman->reply('Hi '.$name);
        });

        $botman->hears('say my name',function($botman){
            $name = $botman->userStorage()->get('name');
            $botman->reply('your name is '.$name.' and i am god damn right');
        });



        $botman->hears('show me buttons (.*)', function($botman, $message2){
                $botman->startConversation(new BotmanAsk);
        });


        // üstekinin aynısı ama farklı hali

        // $botman->hears('{message}', function($botman, $message2){
        //     if ($message2 == 'show me buttons bro'){
        //         $botman->startConversation(new BotmanAsk);
        //     }
            
        // });

        $botman->hears('video', function($botman){
              $message=OutgoingMessage::create('This is the video i like')->withAttachment(
                
                new Video('https://www.w3schools.com/html/mov_bbb.mp4'));

            $botman->reply($message);
        });

        $botman->hears('audio', function($botman){
            $message=OutgoingMessage::create('This is the audio i like')->withAttachment(
              
              new Audio('https://www.w3schools.com/html/mov_bbb.mp4'));

          $botman->reply($message);
      });


      $botman->receivesImages(function($botman,$images){
                $image = $images[0];
                $botman->reply(OutgoingMessage::create('I received your image')->withAttachment($image));
      });


        $botman->listen();
    }
   
    /**
     * Place your BotMan logic here.
     */
    public function askName($botman)
    {
        $botman->ask('Hello! What is your Name?', function(Answer $answer) {
            
            $name = $answer->getText();
   
            $this->say('Nice to meet you '.$name);
        });
    }

    //  public function showButtons($botman){
    //      $botman->ask('you want me to show buttons ?' , function(Answer $answer2){
            
    //          if ($answer2 == 'yes'){
    //             $this->say('sure let me show you');
    //             //   $this->ShowingTheButtons();
    //             //   $this->askImage();
    //          }
            
    //          if ($answer2 == 'no'){
    //             $this->say('okey not showing');
    //         } 
    //      });
    //  }

    //  public function ShowingTheButtons(){

    //     $question =  Question::create('want me to show some buttons ?')
    //     ->fallback('cant show the buttons')
    //     ->callbackId('buttons_showed')
    //     ->addButtons([
    //     Button::create('yes button')->value('yes'),
    //     Button::create('no button')->value('no')
    //     ]);

    //     $this->ask($question, function (Answer $answer3){
    //         if($answer3->isInteractiveMessageReply()){
    //         $selectedValue = $answer3->getValue(); // yes or no
    //         $selectedText = $answer3->getText();  // yes button or no button
    //         }
    //     });
    //  }

    //  public function askImage(){
    //     $this->askForImages('Please upload a image', function($images){

    //     },function (Answer $answer){

    //     });
    //  }

    //  public function showPhoto($botman){
    //     $show = Message::create('here you go')
    //     ->image('https://www.istockphoto.com/photos/secret-love');

    //     $botman->reply($show);
    //  }






}



