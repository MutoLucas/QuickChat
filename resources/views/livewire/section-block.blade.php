<div class="nav-item">
    <button class="nav-link" data-bs-target="#blockUser" data-bs-toggle="modal"><i class="bi bi-person-fill-slash"></i> Block User</button>

    <div class="modal fade" id="blockUser" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg bg-dark text-light" data-bs-theme="dark">
                    <h1>Bloquear Usuário</h1>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <h5 class="mb-3 text-center text-danger">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        Confirmar Bloqueio
                    </h5>
                    <p>Ao bloquear um usuário, vocÊ não estará mais apto a enviar nem receber mensagens do mesmo</p>

                    <div class="form-floating mb-3">
                        <input wire:model="userBlock" type="text" class="form-control" id="userBlock" placeholder="Ex: Nefestos">
                        <label for="">User Name</label>
                    </div>
                </div>

                <div class="modal-footer d-flex justify-content-center text-light bg bg-dark">
                    <button wire:click="blockUser" data-bs-dismiss="modal" class="w-25 btn btn-outline-danger">
                        <i class="bi bi-person-slash"></i> Bloquear Usuário
                    </button>
                </div>
            </div>
        </div>
    </div>

    @if(Session::has('errorBlockUser'))
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="liveToast" class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
          <div class="toast-header bg bg-danger text-light" data-bs-theme="dark">
            <strong class="me-auto"><i class="bi bi-chat-dots-fill"></i> QuickChat</strong>
            <small>{{ now()->format('H:i') }}</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
          <div class="toast-body">
            {{ Session('errorBlockUser') }}
          </div>
        </div>
      </div>
    @endif

    @if(Session::has('successBlockUser'))
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="liveToast" class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
          <div class="toast-header bg bg-success text-light" data-bs-theme="dark">
            <strong class="me-auto"><i class="bi bi-chat-dots-fill"></i> QuickChat</strong>
            <small>{{ now()->format('H:i') }}</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
          <div class="toast-body">
            {{ Session('successBlockUser') }}
          </div>
        </div>
      </div>
    @endif
</div>
