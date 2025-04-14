<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

use App\Events\sendMessage;

use App\Models\Message;
use App\Models\Conversation;
use App\Models\Block;
use App\Models\User;

class Chat extends Component
{
    public $convId;
    public $newMessage;
    public $userId;

    public $messages;

    public function mount(){
        $this->userId = auth()->user()->id;
    }

    public function getListeners(){
        return [
            "echo-private:chat.{$this->userId},sendMessage" => 'receiveMessage'
        ];
    }

    public function render()
    {
        if($this->convId){
            $this->messages = Message::where('conversation_id', $this->convId)->get();

            $chat = Conversation::where('id', $this->convId)->first();
        }else{
            $messages = null;
            $chat = null;
        }

        return view('livewire.chat', [
                        'messages'=>$this->messages,
                        'chat'=>$chat
                    ]);
    }


    public function sendNewMessage(){
        $conversation = Conversation::find($this->convId);
        if($conversation->user_one_id == auth()->user()->id){
            $receiver = User::find($conversation->user_two_id);
        }else{
            $receiver = User::find($conversation->user_one_id);
        }

        if(Block::where('user_who_blocked_id',$this->userId)->where('user_blocked_id',$receiver->id)->exists()){
            $this->newMessage = null;
            session()->flash('errorSendMessage','Você bloqueou '.$receiver->user_name);
        }else if(Block::where('user_who_blocked_id',$receiver->id)->where('user_blocked_id',$this->userId)->exists()){
            $this->newMessage = null;
            session()->flash('errorSendMessage','Não foi possivel completar o envio da mensagem');
        }else{
            if($this->newMessage){
                Message::create([
                    'conversation_id'=>$conversation->id,
                    'sender_id'=>auth()->user()->id,
                    'body'=>$this->newMessage,
                    'read_sender'=>true
                ]);

                $this->newMessage = null;

                if($conversation->user_one_id == auth()->user()->id){
                    broadcast(new sendMessage($conversation->user_two_id,$conversation->id));
                }else{
                    broadcast(new sendMessage($conversation->user_one_id,$conversation->id));
                }

                $this->dispatch('sendMessage');
            }else{
                dd('Ta null padrão');
            }
        }

    }

    public function receiveMessage($payload){
        $payload = $payload['convId'];

        if($this->convId == $payload){
            $this->messages = Message::where('conversation_id', $this->convId)->get();
        }
    }


}
