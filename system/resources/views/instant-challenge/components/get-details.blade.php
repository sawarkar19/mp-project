<div class="modal ol-modal popin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" id="user_data_modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title color-primary font-600">Details</h5>
            </div>
            <div class="modal-body">
                <div>
                    <p class="text-secondary">Please share your basic details to continue with the offer.</p>
                    <form action="#" class="form-type-one">
                        {{-- Mobile Number --}}
                        <div class="form-group mb-4" id="mobile_input">
                            <label for="mobile" class="mb-2"><span class="font-600">Whatsapp Number</span> <span class="text-danger">*</span> <small class="text-secondary">(10 Digit)</small> </label>
                            <input type="tel" name="mobile" value="" id="mobile" pattern="[6789][0-9]{9}" class="form-control indian-mobile-series no-space-validation" placeholder="Enter whatsapp number..." maxlength="10" minlength="10" required>
                            <span class="text-danger" id="mobile_error" style="display: none">Please enter a valid mobile number</span>
                        </div>
                        {{-- User Name --}}
                        <div class="form-group mb-4" id="name_input" style="display: none">
                            <label for="name" class="mb-2"><span class="font-600">Full Name</span> <span style="font-size: 10px;">(Optional)</span></label>
                            <input name="name" id="name" value="" type="text" class="form-control char-spcs-validation" placeholder="Enter your name...">
                        </div>
                        {{-- Date of Birth --}}
                        <div class="form-group mb-4" id="dob_input" style="display: none">
                            <label class="mb-2"><span class="font-600">Date of Birth</span> <span style="font-size: 10px;">(Optional)</span></label>
                            <input type="text" name="dob" value="" id="dob" placeholder="Select your date of birth..." class="form-control" onclick="openDobModal()" />
                        </div>
                        {{-- Anniversary date --}}
                        <div class="form-group mb-4" id="anniversary_input" style="display: none">
                            <label class="mb-2"><span class="font-600">Anniversary Date</span> <span style="font-size: 10px;">(Optional)</span></label>
                            <input type="text" name="anniversary" value="" id="anniversary" placeholder="Select your anniversary date..." class="form-control" onclick="openAnniversaryModal()" />
                        </div>
                        <div>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-primary px-4" id="continueBtn">Continue</button>

                                {{-- <button class="btn btn-primary btn-sm px-3 mt-4" id="finishSetup">Finish</button> --}}
                                {{-- <button class="btn btn-outline-secondary btn-sm px-3 mt-4" id="skipSetup">Skip Details</button> --}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Date Month picked Modal -->
<div class="modal ol-modal popin" aria-hidden="true" id="date-month-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="font-600 color-primary mb-0">Select Month & Date</h6>
                <a href="#" class="close_calendar" aria-hidden="true">&times;</a>
            </div>
            <div class="modal-body">
                <div class="custom_calendar form-type-one">
                    <div class="form-group mb-3">
                        <select id="monthNo" class="form-control monthChange">
                            <option value="1">January</option>
                            <option value="2">February</option>
                            <option value="3">March</option>
                            <option value="4">April</option>
                            <option value="5">May</option>
                            <option value="6">June</option>
                            <option value="7">July</option>
                            <option value="8">August</option>
                            <option value="9">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                    </div>
                    <div>
                        <ul class="days"> 
                            @for($x = 1; $x <= 31; $x++)
                                <li class="dateSelected" id="{{ $x }}">{{ $x }}</li>
                            @endfor
                        </ul>
                    </div>
                </div>
            </div>
            {{-- <div class="modal-footer">
                <button class="btn btn-primary" onclick="removeDate()">Remove Date</button>
            </div> --}}
        </div>
    </div>
</div>
<!-- /Modal -->