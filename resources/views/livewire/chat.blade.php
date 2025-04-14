<div class="col-md-9 d-flex flex-column h-100 p-0">
    @if($messages)
        <div class="border-bottom d-flex align-items-center p-3">
            <img src="https://i.pravatar.cc/40" alt="Avatar" class="rounded-circle me-2" width="40" height="40">
            @if ($chat->initiator->id == auth()->user()->id)
                <h5 class="mb-0">{{ $chat->recipient->user_name }}</h5>
            @else
                <h5 class="mb-0">{{ $chat->initiator->user_name }}</h5>
            @endif
        </div>

        {{-- Mensagens --}}
        <div id="chat-messages" class="flex-grow-1 overflow-auto p-4 bg-light">
            @foreach ($messages as $message)
                @if ($message->sender_id == auth()->user()->id)
                    <div class="d-flex justify-content-end mb-3">
                        <div class="bg-success text-white p-2 rounded">
                            {!! \Illuminate\Support\Str::of($message->body)->replaceMatches(
                                '/(https?:\/\/[^\s]+)/',
                                fn ($match) => '<a href="' . $match[0] . '" target="_blank" class="text-primary text-decoration-underline">' . $match[0] . '</a>'
                            ) !!}

                        </div>
                    </div>
                @else
                    <div class="d-flex mb-3">
                        <div class="bg-secondary text-white p-2 rounded">
                            {!! \Illuminate\Support\Str::of($message->body)->replaceMatches(
                                '/(https?:\/\/[^\s]+)/',
                                fn ($match) => '<a href="' . $match[0] . '" target="_blank" class="text-primary text-decoration-underline">' . $match[0] . '</a>'
                            ) !!}

                        </div>
                    </div>
                @endif
            @endforeach

            <script>
                function scrollToBottom() {
                    const chat = document.getElementById('chat-messages');
                    chat.scrollTop = chat.scrollHeight;
                }

                window.addEventListener('load', scrollToBottom);
            </script>

        </div>

        {{-- Campo de envio --}}
        <div class="border-top p-3 d-flex align-items-center">
            <textarea wire:model="newMessage" class="form-control me-2" rows="1" placeholder="Digite sua mensagem..."></textarea>
            <button wire:click="sendNewMessage" type="submit" class="btn btn-dark"><i class="bi bi-send"></i></button>
        </div>
    @else
        <div class="d-flex align-items-center justify-content-center h-100">
            <h1 class="text-center"><i class="bi bi-chat-left"></i> Sem Conversa selecionada</h1>
        </div>
    @endif

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
