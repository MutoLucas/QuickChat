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

        <div id="chat-messages" class="flex-grow-1 overflow-auto p-4 bg-light">
            @foreach ($messages as $message)

                    <div class="d-flex @if($message->sender_id == auth()->user()->id) justify-content-end @endif mb-3">

                        <div class="@if($message->sender_id == auth()->user()->id) bg-success @else bg-dark @endif text-white p-2 rounded">
                            <div>
                                @if($message->type == 'image')
                                    <img src="{{ asset('storage/'.$message->media_path) }}" class="img-fluid rounded mt-2" style="max-width: 300px;">
                                @elseif($message->type == 'video')
                                    <video class="img-fluid rounded mt-2" controls style="max-width: 300px;">
                                        <source src="{{ asset('storage/' . $message->media_path) }}" type="video/mp4">
                                        Seu navegador não suporta vídeos.
                                    </video>
                                @elseif($message->type == 'audio')
                                    <div class="audio-message" style="width: 150px">
                                        <audio class="d-none" id="audioPlayer">
                                            <source src="{{ asset('storage/' . $message->media_path) }}" type="audio/mpeg">
                                            Seu navegador não suporta o elemento de áudio.
                                        </audio>

                                        <div class="d-flex align-items-center bg-dark rounded p-2 w-100 audio-bar" onclick="togglePlay()">
                                            <div class="audio-play-btn me-2">
                                                <i class="bi bi-play-fill" id="playPauseBtn"></i>
                                            </div>
                                            <div class="flex-grow-1 bg-secondary rounded-3" style="height: 6px;">
                                                <div class="audio-progress bg-success rounded-3" style="height: 100%; width: 0%;" id="audioProgress"></div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-around mt-2">
                                            <span id="currentTime">00:00</span> / <span id="totalDuration">00:00</span>
                                        </div>
                                    </div>


                                    <script>
                                        let audioPlayer = document.getElementById('audioPlayer');
                                        let playPauseBtn = document.getElementById('playPauseBtn');
                                        let progressBar = document.getElementById('progressBar');
                                        let audioProgress = document.getElementById('audioProgress');
                                        let currentTimeElem = document.getElementById('currentTime');
                                        let totalDurationElem = document.getElementById('totalDuration');

                                        audioPlayer.onloadedmetadata = function() {
                                            totalDurationElem.innerText = formatTime(audioPlayer.duration);
                                        };

                                        audioPlayer.ontimeupdate = function() {
                                            updateProgress();
                                        };

                                        function togglePlay() {
                                            if (audioPlayer.paused) {
                                                audioPlayer.play();
                                                playPauseBtn.classList.replace('bi-play-fill', 'bi-pause-fill');
                                            } else {
                                                audioPlayer.pause();
                                                playPauseBtn.classList.replace('bi-pause-fill', 'bi-play-fill');
                                            }
                                        }

                                        function updateProgress() {
                                            let currentTime = audioPlayer.currentTime;
                                            let duration = audioPlayer.duration;
                                            let progress = (currentTime / duration) * 100;

                                            audioProgress.style.width = progress + '%';
                                            currentTimeElem.innerText = formatTime(currentTime);
                                        }

                                        function formatTime(seconds) {
                                            let minutes = Math.floor(seconds / 60);
                                            let remainingSeconds = Math.floor(seconds % 60);
                                            return `${minutes < 10 ? '0' : ''}${minutes}:${remainingSeconds < 10 ? '0' : ''}${remainingSeconds}`;
                                        }
                                    </script>
                                @endif
                            </div>
                            <div class="text-break" style="max-width: 300px">
                                {!! \Illuminate\Support\Str::of($message->body)->replaceMatches(
                                    '/(https?:\/\/[^\s]+)/',
                                    fn ($match) => '<a href="' . $match[0] . '" target="_blank" class="text-primary text-decoration-underline">' . $match[0] . '</a>'
                                ) !!}
                            </div>

                        </div>
                    </div>

            @endforeach

            <script>
                function scrollToBottom() {
                    const chat = document.getElementById('chat-messages');
                    if (chat) {
                        chat.scrollTop = chat.scrollHeight;
                    }
                }

                window.addEventListener('load', scrollToBottom);

                document.addEventListener('livewire:init',() => {
                    Livewire.on('scroll', ()=>{
                        setTimeout(scrollToBottom, 100);
                    });
                });
            </script>

        </div>

        <div class="border-top p-3 d-flex align-items-center">
            <div class="input-group">
                <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#sendMidia"><i class="bi bi-upload"></i></button>

                <input type="text" wire:model.live="newMessage" class="form-control me-2" rows="1" placeholder="Digite sua mensagem..."></input>

                @if($this->newMessage)
                    <button wire:click="sendNewMessage" type="submit" class="btn btn-dark"><i class="bi bi-send"></i></button>
                @else
                    <button type="button" class="btn btn-danger"><i class="bi bi-send-slash"></i></button>
                @endif
            </div>
        </div>

        <div class="modal fade" wire:ignore.self id="sendMidia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Enviar Mídia</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="mediaInput" class="form-label">Selecione uma imagem ou vídeo</label>
                        <input type="file" wire:model="newMidia" class="form-control" id="mediaInput" accept="image/*,video/*,audio/*">
                    </div>

                    <div class="mb-3" wire:ignore id="mediaPreviewContainer" style="display: none;">
                        <label class="form-label">Preview:</label>
                        <div id="mediaPreview"></div>
                    </div>

                    <div class="mb-3">
                        <label for="textInput" class="form-label">Texto</label>
                        <textarea class="form-control" wire:model="newMessage" id="textInput" rows="1"></textarea>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const mediaInput = document.getElementById('mediaInput');
                            const previewContainer = document.getElementById('mediaPreviewContainer');
                            const mediaPreview = document.getElementById('mediaPreview');

                            mediaInput.addEventListener('change', function () {
                                const file = this.files[0];
                                if (!file) {
                                    previewContainer.style.display = 'none';
                                    mediaPreview.innerHTML = '';
                                    return;
                                }

                                const url = URL.createObjectURL(file);
                                previewContainer.style.display = 'block';

                                if (file.type.startsWith('image/')) {
                                    mediaPreview.innerHTML = `<img src="${url}" class="img-fluid rounded" alt="Preview da imagem">`;
                                } else if (file.type.startsWith('video/')) {
                                    mediaPreview.innerHTML = `
                                        <video class="img-fluid rounded" controls>
                                            <source src="${url}" type="${file.type}">
                                            Seu navegador não suporta o elemento de vídeo.
                                        </video>`;
                                } else {
                                    mediaPreview.innerHTML = '<p class="text-danger">Tipo de mídia não suportado.</p>';
                                }
                            });
                        });
                    </script>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                  <button type="button" class="btn btn-primary" data-bs-dismiss="modal" wire:click="sendNewMessage">Enviar Mídia <i class="bi bi-send"></i></button>
                </div>
              </div>
            </div>
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
