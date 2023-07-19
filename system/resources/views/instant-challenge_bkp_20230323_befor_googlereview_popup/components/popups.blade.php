<div class="modal ol-modal popin task-modal" id="verifyPopUp__{{ $task_key }}Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-body d-flex flex-column justify-content-center align-items-center text-center">
                <div class="media-logo-icon mb-3">
                    {{-- Social Media Logo --}}
                    <img src="{{ asset('assets/instant_card/imgs/'.$image ?? NULL) }}" width="55" height="55">
                </div>
                <div class="action-name mb-5">
                    {{-- Name of the action --}}
                    <h6>{!! $name ?? NULL !!}</h6>
                </div>
                <div class="next-button">
                    <p class="small" style="max-width: 230px;">Please click next to continue your challenges</p>
                    {{-- Next Button --}}
                    <button id="nextBtn__{{ $task_key }}" class="nextTaskBtn btn btn-success px-4" data-instant_task_id="{{$task_id}}" data-task_key="{{$task_key}}"> 
                        <span>Next</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>