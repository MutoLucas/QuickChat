<div class="border-end d-flex flex-column p-3 overflow-auto">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0 d-none d-md-block">Chats</h4>
        <div class="d-none d-md-flex w-100 justify-content-end">
            <div class="input-group w-75">
                <input wire:model.live="searchName" type="text" class="form-control form-control-sm" placeholder="Buscar">
                <button role="button" class="btn btn-sm btn-outline-success" data-bs-target="#newChat" data-bs-toggle="modal"><i class="bi bi-plus-lg"></i></button>
            </div>

            <div class="modal fade" id="newChat" data-bs-backdrop="static">
                <div class="modal-dialog">

                    <div class="modal-content">

                        <div class="modal-header text-light bg bg-dark" data-bs-theme="dark">
                            <h1>Novo Chat</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <div class="form-floating mb-3">
                                <input type="text" wire:model="userNewChat" class="form-control" id="floatingInput" placeholder="Ex: Nefestos">
                                <label for="floatingInput">User Name</label>
                            </div>
                            <div class="form-floating">
                                <textarea class="form-control" wire:model="messageNewChat" placeholder="Digite a messagem aqui" id="floatingTextarea"></textarea>
                                <label for="floatingTextarea">Messagem</label>
                              </div>
                        </div>

                        <div class="modal-footer d-flex justify-content-center text-light bg bg-dark">
                            <button wire:click="newChat" data-bs-dismiss="modal" class="w-50 btn btn-outline-success">
                                <i class="bi bi-person-plus"></i> Enviar mensagem
                            </button>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>

    @if(Session::has('errorNewChat'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>{{ Session('errorNewChat') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @foreach ($chats as $chat)
    <a href="{{ route('lobby.index', ['id'=>$chat->id]) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2">
        <div class="d-flex align-items-center">
            <img src="https://i.pravatar.cc/40" alt="Avatar" class="rounded-circle me-2" width="40" height="40">
            <div>
                @if($chat->initiator->id == auth()->user()->id)
                    <div class="fw-bold">
                        {{ $chat->recipient->user_name }}
                        @if($chat->lastMessage->sender_id != auth()->user()->id && !$chat->lastMessage->read_receiver)
                        <span class="text-danger">
                            <i class="bi bi-circle-fill"></i>
                        </span>
                        @endif
                    </div>
                @else
                    <div class="fw-bold">
                        {{ $chat->initiator->user_name }}
                        @if($chat->lastMessage->sender_id != auth()->user()->id && !$chat->lastMessage->read_receiver)
                        <span class="text-danger">
                            <i class="bi bi-circle-fill"></i>
                        </span>
                        @endif
                    </div>
                @endif

                <small class="text-muted">{{ $chat->lastMessage->body }}</small>
            </div>
        </div>
        <small class="text-muted">{{ $chat->lastMessage->updated_at->format('H:i') }}</small>
    </a>
    @endforeach

    @if(Session::has('errorSendMessage'))
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="liveToast" class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
          <div class="toast-header bg bg-danger text-light" data-bs-theme="dark">
            <strong class="me-auto"><i class="bi bi-chat-dots-fill"></i> QuickChat</strong>
            <small>{{ now()->format('H:i') }}</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
          <div class="toast-body">
            {{ Session('errorSendMessage') }}
          </div>
        </div>
      </div>
    @endif
</div>
