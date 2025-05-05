<?php

namespace App\Livewire;

use Livewire\Component;

use App\Events\sendMessage;

use App\Models\Conversation;
use App\Models\User;
use App\Models\Message;
use App\Models\Block;

class ChatBar extends Component
{

    public $searchName;
    public $chat;
    public $userId;
    public $userNewChat;
    public $messageNewChat;
    public $convId;


    public function mount(){
        $this->searchName = null;
        $this->userId = auth()->user()->id;
    }

    public function getListeners(){
        return [
            "echo-private:chat.{$this->userId},sendMessage" => 'receiveMessage',
            'sendMessage'=>'render'
        ];
    }

    public function render()
    {
        $query = Conversation::query();

        $query->where(function ($q) {
            $q->where('user_one_id', auth()->user()->id)
            ->orWhere('user_two_id', auth()->user()->id);
        });

        if ($this->searchName) {
            $search = '%' . $this->searchName . '%';
            $query->where(function($q) use ($search) {
                $q->whereHas('initiator', function($q) use ($search) {
                    $q->where('user_name', 'like', $search);
                })
                ->orWhereHas('recipient', function($q) use ($search) {
                    $q->where('user_name', 'like', $search);
                });
            });
        }

        $query->orderBy('updated_at', 'desc');
        $this->chats = $query->get();

        Message::where('conversation_id', $this->convId)
            ->where('sender_id', '!=', $this->userId)
            ->where('read_receiver', false)
            ->update([
                'read_receiver' => true
            ]);

        return view('livewire.chat-bar', [
            'chats' => $this->chats
        ]);
    }


    public function receiveMessage($payload){
        if($this->convId == $payload['convId']){



            $this->chats = Conversation::where('user_one_id', auth()->user()->id)->orWhere('user_two_id', auth()->user()->id)->orderBy('updated_at', 'desc')->get();
        }
    }

    public function newChat(){
        $user = User::where('user_name',$this->userNewChat)->first();

        if(!$this->userNewChat || !$this->messageNewChat){
            session()->flash('errorNewChat','Necessario preencher todos os campos');
        }else if(Block::where('user_who_blocked_id',$user->id)->where('user_blocked_id',$this->userId)->exists()){
            session()->flash('errorSendMessage','Não foi possivel completar o envio da mensagem');
        }else if(Block::where('user_who_blocked_id',$this->userId)->where('user_blocked_id',$user->id)->exists()){
            session()->flash('errorSendMessage','Você bloqueou '.$user->user_name);
        }else{
            if(!User::where('user_name',$this->userNewChat)->first()){
                session()->flash('errorNewChat','User Name inexistente');
            }else{
                $userRecevier = User::where('user_name',$this->userNewChat)->first();

                $exists = Conversation::where('user_one_id', $this->userId)
                ->where('user_two_id',$userRecevier->id)
                ->exists()
                ||
                Conversation::where('user_one_id', $userRecevier->id)
                ->where('user_two_id',$this->userId)
                ->exists();

                if(!$exists){

                    $newConv = Conversation::create([
                        'user_one_id'=>$this->userId,
                        'user_two_id'=>$userRecevier->id
                    ]);

                    $newMessage = Message::create([
                        'conversation_id'=>$newConv->id,
                        'sender_id'=>$this->userId,
                        'body'=>$this->messageNewChat,
                    ]);

                    broadcast(new sendMessage($userRecevier->id, $newConv->id));
                    $this->redirectRoute('lobby.index', ['id'=>$newConv->id]);
                }else{
                    session()->flash('errorNewChat','Chat já existente');
                }
            }
        }
    }
}
