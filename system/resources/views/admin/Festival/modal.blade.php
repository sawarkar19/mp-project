<div class="modal popin ol-modal add-pr-msg" tabindex="-1" role="dialog" id="festivalMessages" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h6 class="modal-title text-color">Add Messages</h6>
                <button type="button" class="close mr-3 my-3" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
                <div class="row align-items-end">
                    <div class="col-md-9 order-2 order-md-1">
                        <div class="tab-select">
                            <ul class="nav nav-tabs my-3" id="myTabFest" role="tablist">
                                <li class="nav-item">
                                  <a class="nav-link container__tab active" data-type="dateAndTimeFest" id="home-tab-fest" data-toggle="tab" href="#homefest" role="tab" aria-controls="homefest" aria-selected="true">Select date & time</a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link container__tab" data-type="templateFest" id="profile-tab-fest" data-toggle="tab" href="#profilefest" role="tab" aria-controls="profilefest" aria-selected="false">Select Template</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content" id="myTabFestContent">
                            <div class="tab-pane fade show active" id="homefest" role="tabpanel" aria-labelledby="home-tab">
                                <div class="date-time">
                                    <div>
                                        <div class="form-group mb-0">
                                            <label for="festivalDate">Select Date <span>*</span></label>
                                            <input type="text" class="form-control" data-edit_temp_id="0" id="festivalDate" min="{{ Carbon\Carbon::tomorrow()->format('d-m-Y') }}" readonly="true">
                                        </div>
                                    </div>
                                    <div>
                                        <div class="form-group mb-0">
                                            <label for="festivalTime">Select Time <span>*</span></label>
                                            {{-- <input type="time" class="form-control" id="festivalTime"> --}}
                                            <select name="" class="from-control choices-time-festival" id="festivalTime" placeholder="Select time slot..." required>
                                                <option value="">- Time Slot -</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <div class="form-group">
                                            <label for="myGroupsFest" class="d-block_">Select Group <span>*</span></label>
                                            <select id="myGroupsFest" class="form-control choise-groups-festival" multiple="multiple" required>
                                                <option value="">- Select Groups -</option>
                                                {{-- @foreach($groups as $group)
                                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <button type="button" id="btnNextFest" class="btn btn-primary btnNextFest px-4">Next</button>
                                </div>
                            </div>
                            
                            
                            <div class="tab-pane fade" id="profilefest" role="tabpanel" aria-labelledby="profile-tab-fest">
                                <div class="">
                                    <div class="row">
                                        <div class="col-6 col-md-6">
                                            <div class="form-group mb-0 mb-md-3">
                                                <label>Select</label>
                                                <select class="form-control select_Temp_Content"  id="st_category_input_fest" name="contentname">
                                                    <option value="all">All</option>
                                                    @foreach($temp_categories as $cat)
                                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-6">
                                            <div class="form-group search">
                                                <label>&nbsp;</label>  
                                                <input type="text" class="form-control" name="searchtemplatesfest" id="st_text_input_fest" placeholder="Find Template">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="scroll_temp" style="height: 267px;">
                                    <div id="st_loader" style="display:none;">
                                        <p class="text-danger text-center mt-5"> Loading...</p>
                                    </div>
                                    <div class="grid elementDiv pr-2 festivalMessages add-msg-padding" id="st_grid">
                                        <div class="grid-col grid-col--1"></div>
                                        <div class="grid-col grid-col--2"></div>
                                        <div class="grid-col grid-col--3"></div>
                                        <div class="grid-col grid-col--4"></div>
                                        
                                     </div>
                                </div>
                                <div class="mt-4 d-flex justify-content-between">
                                    <button type="button" id="btnPreviousFest" class="btn btn btn-outline-secondary btnPreviousFest px-4">Back</button>
                                
                                    <button type="button" class="btn btn-success pers-msg-btn-fest px-4 mr-md-4" onclick="setTemplateFestival('2')">Save</button>
                                </div>
                            </div>
                        </div>  
                        
                            
                    </div>    
                    <div class="col-sm-3 order-1 order-md-2">
                        <div class="position-relative">
                             <div class="add-message-img-inner text-center text-md-right">
                                <img src="{{asset('assets/business/pop-up-images/personalised-message/add-message-new.png')}}" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <input type="hidden" name="checkFestTemplateCategory" id="checkFestTemplateCategory" /> 
                <input type="hidden" name="checkFestTemplateID" id="checkFestTemplateID" /> 
        </div>
    </div>
</div>
