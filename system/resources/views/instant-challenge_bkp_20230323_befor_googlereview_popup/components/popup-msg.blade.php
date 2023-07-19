<style>
    .head-bg {
        background: #fff0f0;
    }
    ul.action-name li::marker {
        color: #003f9e;
        font-size: 17px;
    }
    .modal.task-modal-bottom .modal-header .btn-close {
        font-size: 14px;
        border: none;
        border-radius: none;
    }
    .modal.task-modal-bottom .modal-dialog {
        position: fixed;
        margin: auto;
        width: 100%;
        max-width: 100%;
        height: auto;
    }
    .modal.task-modal-bottom .modal-content {
        height: auto;
        overflow-y: auto;
        border-radius: 0.8rem 0.8rem 0 0;
    }
    .modal.task-modal-bottom .modal-body {
        padding: 15px 15px;
    }
    .modal.task-modal-bottom .modal-dialog {
        bottom: -100%;
        -webkit-transition: opacity 0.3s linear, bottom 0.3s ease-out;
        -moz-transition: opacity 0.3s linear, bottom 0.3s ease-out;
        -o-transition: opacity 0.3s linear, bottom 0.3s ease-out;
        transition: opacity 0.3s linear, bottom 0.3s ease-out;
    }

    .modal.task-modal-bottom.show .modal-dialog {
        bottom: 0;
    }

    .modal.task-modal-bottom .modal-dialog {
        bottom: -100%;
    }
</style>

<div class="modal ol-modal popin task-modal-bottom task-modal" id="showPopupMsgModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" style="display:block_;">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Important</h5>
                <a type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
              </div>
            <div class="modal-body">
                <div class="media-logo-icon head-bg mb-3">
                    <p class="p-2"><span style="font-weight:bold">Note :</span> Please follow below steps before proceeding.</p>
                </div>

                {{-- Safari-Desktop --}}
                <ul class="action-name mb-5_" id="safari-desktop" style="display: none;">
                    <li>Click the <b>Safari menu</b> in the upper-left corner of the screen.</li>
                    <li>Select <b>Preferences</b>.</li>
                    <li>Click on the <b>Websites tab</b>.</li>
                    <li>Uncheck the <b>'Block pop-up windows'</b> checkbox.</li>
                    <li>Then click on <b>Close button</b> and <b>retry it</b>.</li>
                    <li><b>Settings may be varry as per Browser.</b></li>
                </ul>

                {{-- Safari-Mobile --}}
                <ul class="action-name mb-5_" id="safari-mobile" style="display: none">
                    <li>Open the <b>Settings app</b>.</li>
                    <li>Scroll down and select <b>Safari</b>.</li>
                    <li>Under the General section, <b>toggle off the 'Block Pop-ups' switch</b>.</li>
                    <li>Then click on <b>Close button</b> and <b>retry it</b>.</li>
                    <li><b>Settings may be varry as per Browser.</b></li>
                </ul>

                {{-- Chrome Browser --}}
                <ul class="action-name mb-5_" id="chrome-desktop" style="display: none">
                    <li>Click the <b>browser's settings menu</b> (usually located in the upper-right corner).</li>
                    <li>Click <b>'Settings'</b> or <b>'Preferences'</b>.</li>
                    <li>Scroll down to the <b>'Privacy and security'</b> section.</li>
                    <li>Click <b>'Site settings'</b>.</li>
                    <li>Scroll down to the <b>'Permissions'</b> section.</li>
                    <li>Find <b>'Pop-ups and redirects'</b> and click it.</li>
                    <li>Find this website in the list and set the option to <b>'Allow'</b>.</li>
                    <li>Then click on <b>Close button</b> and <b>retry it</b>.</li>
                    <li><b>Settings may be varry as per Browser.</b></li>
                </ul>

                {{-- Chrome-Mobile --}}
                <ul class="action-name mb-5_" id="chrome-mobile" style="display: none">
                    <li><b>Tap the three dots</b> in the upper-right corner of the screen.</li>
                    <li>Click <b>'Settings'</b> or <b>'Preferences'</b>.</li>
                    <li>Select <b>Site settings</b>.</li>
                    <li>Scroll down and select <b>Pop-ups and redirects</b>.</li>
                    <li><b>Toggle the switch</b> to <b>allow pop-ups and redirects</b> for the website.</li>
                    <li>Then click on <b>Close button</b> and <b>retry it</b>.</li>
                    <li><b>Settings may be varry as per Browser.</b></li>
                </ul>

                {{-- <div class="next-button text-center">
                    {{-- <p class="small" style="max-width: 230px;">Settings may be varry as per Browser.</p> --}
                    <button id="popupMsgCloseBtn" class="btn btn-success px-4" > 
                        <span>Close</span>
                    </button>
                </div> --}}
            </div>
        </div>
    </div>
</div>
