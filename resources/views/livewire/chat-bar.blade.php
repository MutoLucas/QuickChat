<div class="col-12 col-md-3">
    <div class="d-block d-md-none">

        <div class="offcanvas offcanvas-start" tabindex="-1" id="chats" aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasExampleLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mt-0">
                <h2 class="text-center"><i class="bi bi-chat-left-text"></i> Chat List</h2>
                @include('contents.chat-bar-content')
            </div>
        </div>

    </div>

    <div class="d-none d-md-block">
        @include('contents.chat-bar-content')
    </div>
</div>
