<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\User;
use App\Models\Block;

class SectionBlock extends Component
{
    public $userBlock;
    public $userId;

    public function mount(){
        $this->userBlock = null;
        $this->userId = auth()->user()->id;
    }

    public function render()
    {
        return view('livewire.section-block', [

        ]);
    }

    public function blockUser(){
        $user = User::where('user_name',$this->userBlock)->first();

        if(!$user){
            session()->flash('errorBlockUser','Usuário não existente');
        }else if($user->id == $this->userId){
            session()->flash('errorBlockUser','Você não pode bloquear a si mesmo');
        }else if(Block::where('user_who_blocked_id',$this->userId)->where('user_blocked_id',$user->id)->exists()){
            session()->flash('errorBlockUser','Você já bloqueou '.$user->user_name);
        }else{
            Block::create([
                'user_who_blocked_id'=>$this->userId,
                'user_blocked_id'=>$user->id
            ]);

            session()->flash('successBlockUser',$user->user_name.' bloquedo com sucesso');
        }

    }
}
