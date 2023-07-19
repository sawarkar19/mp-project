<!-- new birthday template modal -->
<div class="modal popin ol-modal birthday-msg" tabindex="-1" role="dialog" id="birthdayTemplate">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
                
            <div class="modal-body px-3 py-0">
                <button type="button" class="close mr-3 my-3" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                    <div class="row">
                        <div class="col-md-4 px-0 birthday-images-section">
                            <div class="position-relative h-100">
                                <img src="{{ asset('assets/business/pop-up-images/personalised-message/birthday-design.png') }}" alt="" class="w-md-100 birthday-design img-fluid personalised-design-img">
                                <img src="{{ asset('assets/business/pop-up-images/personalised-message/cake.png') }}" alt="" class="birthday-inner personalised-inner-image img-fluid">
                            </div>
                            
                        </div>
                        <div class="col-md-8 mt-3 mt-sm-0">
                        <h6 class="modal-title my-3 text-color">Select Template</h6>
                            <div class="scroll_temp">
                                <div id="st_loader" style="display:none;">
                                    <p class="text-danger text-center mt-5"> Loading...</p>
                                </div>
                                <div class="grid elementDiv birthdayTemplate" id="st_grid">
                                    <div class="grid-col grid-col--1"></div>
                                    <div class="grid-col grid-col--2"></div>
                                    <div class="grid-col grid-col--3"></div>
                                    <div class="grid-col grid-col--4"></div>
                                 </div>
                            </div>
                            <div class="my-4 text-right">
                                <button type="button" class="btn btn-success" onclick="setTemplate(7)">Save changes</button>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>

<!-- new anniversary template modal -->
<div class="modal popin ol-modal anniversary-msg" tabindex="-1" role="dialog" id="anniversaryTemplate">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body px-3 py-0">
                <button type="button" class="close mr-3 my-3 d-none d-md-block" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <div class="row">
                    <div class="col-md-4 px-0 pb-4 anni-images-section">
                        <div class="position-relative h-100">
                            <button type="button" class="close mr-3 my-3 d-md-none d-block" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <img src="{{ asset('assets/business/pop-up-images/personalised-message/design-anni.png') }}" alt="" class="anni-flower personalised-design-img img-fluid">
                            <img src="{{ asset('assets/business/pop-up-images/personalised-message/anniversary.png') }}" alt="" class="anni-card-img personalised-inner-image img-fluid">
                        </div>
                    </div>
                    <div class="col-md-8">
                    <h6 class="modal-title my-3 text-color">Select Template</h6>
                        <div class="scroll_temp">
                            <div id="st_loader" style="display:none;">
                                <p class="text-danger text-center mt-5"> Loading...</p>
                            </div>
                            <div class="grid elementDiv pr-2 anniversaryTemplate" id="st_grid">
                                <div class="grid-col grid-col--1"></div>
                                <div class="grid-col grid-col--2"></div>
                                <div class="grid-col grid-col--3"></div>
                                <div class="grid-col grid-col--4"></div>
                            </div>
                            <div class="my-4 text-right">
                                <button type="button" class="btn btn-success" onclick="setTemplate(8)"> Save changes</button>
                            </div>
                        </div>
                    </div>  
                </div>      
            </div>
        </div>
    </div>
</div>

<!-- new d2c template modal -->
<div class="modal popin ol-modal add-pr-msg" tabindex="-1" role="dialog" id="personalisedMessages" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h6 class="modal-title text-color">Add Messages</h6>
                <button type="button" class="close mr-3 my-3 closeModalTemp" id="value_blnk" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
                <div class="row align-items-end">
                    <div class="col-md-9 order-2 order-md-1">
                        <div class="tab-select">
                            <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
                                <li class="nav-item">
                                  <a class="nav-link container__tab active" data-type="dateAndTime" id="date-time-tab" data-toggle="tab" href="#date-time" role="tab" aria-controls="date-time" aria-selected="true">Select date & time</a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link container__tab" data-type="template" id="template-tab" data-toggle="tab" href="#template" role="tab" aria-controls="template" aria-selected="false">Select Template</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="date-time" role="tabpanel" aria-labelledby="date-time-tab">
                                <div class="date-time">
                                    <div>
                                        <div class="form-group mb-0">
                                            <label for="personalisedDate">Select Date <span>*</span></label>
                                            <input type="text" class="form-control" data-edit_temp_id="0" id="personalisedDate" min="{{ Carbon\Carbon::tomorrow()->format('d-m-Y') }}" readonly="true">
                                        </div>
                                    </div>
                                    <div>
                                        <div class="form-group mb-0">
                                            <label for="personalisedTime">Select Time <span>*</span></label>
                                            {{-- <input type="time" class="form-control" id="personalisedTime"> --}}
                                            <select name="" class="from-control choices-time" id="personalisedTime" placeholder="Select time slot..." required>
                                                <option value="">- Time Slot -</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <div class="form-group">
                                            <label for="myGroups" class="d-block_">Select Group <span>*</span></label>
                                            <select id="myGroups" class="form-control choise-groups" multiple="multiple" required>
                                                <option value="">- Select Groups -</option>
                                                {{-- @foreach($groups as $group)
                                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <button type="button" id="btnNext" class="btn btn-primary btnNext px-4">Next</button>
                                </div>
                            </div>  
                            <div class="tab-pane fade" id="template" role="tabpanel" aria-labelledby="template-tab">
                                <div class="">
                                    <div class="row">
                                        <div class="col-6 col-md-6">
                                            <div class="form-group mb-0 mb-md-3">
                                                <label>Select</label>
                                                <select class="form-control select_Temp_Content"  id="st_category_input" name="contentname">
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
                                                <input type="text" class="form-control" name="searchtemplates" id="st_text_input" placeholder="Find Template">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="scroll_temp" style="height: 267px;">
                                    <div id="st_loader" style="display:none;">
                                        <p class="text-danger text-center mt-5"> Loading...</p>
                                    </div>
                                    <div class="grid elementDiv pr-2 personalisedMessages add-msg-padding" id="st_grid">
                                        <div class="grid-col grid-col--1"></div>
                                        <div class="grid-col grid-col--2"></div>
                                        <div class="grid-col grid-col--3"></div>
                                        <div class="grid-col grid-col--4"></div>
                                        
                                     </div>
                                </div>
                                <div class="mt-4 d-flex justify-content-between">
                                    <button type="button" id="btnPrevious" class="btn btn btn-outline-secondary btnPrevious px-4">Back</button>
                                
                                    <button type="button" class="btn btn-success pers-msg-btn px-4 mr-md-4" onclick="setTemplate('1')">Save</button>
                                </div>
                            </div>
                        </div>  
                    </div>    
                    <div class="col-md-3 order-1 order-md-2">
                            <div class="add-message-img-inner text-center text-md-right">
                                <img src="{{asset('assets/business/pop-up-images/personalised-message/add-message-new.png')}}" alt="" class="img-fluid">
                            </div>
                    </div>
                </div>
            </div>
                <input type="hidden" name="checkTemplateCategory" id="checkTemplateCategory" /> 
                <input type="hidden" name="checkTemplateID" id="checkTemplateID" /> 
        </div>
    </div>
</div>

<!-- Festivals modal -->
<!-- <div class="modal fade add-pr-msg" tabindex="-1" role="dialog" id="festivalMessages" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            {{-- <div class="modal-header">
                <h5 class="modal-title text-primary">Add Messages</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div> --}}
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 tempSec_Bg">
                        <div class="">
                            <div class="d-flex justify-content-between">
                                <h5 class="text-primary mb-4">Add Messages</h5>
                                <button type="button" class="close btn-cls-outline closeModalTemp d-block d-md-none mb-4" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </div>
                            
                            </button>
                            <div class="col-12 px-0">
                                <div class="form-group">
                                    <label for="festivalDate">Select Date <span>*</span></label>
                                    <input type="text" class="form-control" data-edit_temp_id="0" id="festivalDate" min="{{ Carbon\Carbon::tomorrow()->format('d-m-Y') }}" readonly="true">
                                </div>
                            </div>
                            <div class="col-12 px-0">
                                <div class="form-group">
                                    <label for="festivalTime">Select Time <span>*</span></label>
                                    {{-- <input type="time" class="form-control" id="festivalTime"> --}}
                                    <select name="" class="from-control choices-time-festival" id="festivalTime" placeholder="Select time slot..." required>
                                        <option value="">- Time Slot -</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-12 px-0">
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

                            <input type="hidden" name="checkFestTemplateCategory" id="checkFestTemplateCategory" /> 
                            <input type="hidden" name="checkFestTemplateID" id="checkFestTemplateID" /> 

                            <button type="button" class="btn btn-primary pers-msg-btn" onclick="setTemplateFestival('2')">Save</button>
                            <button type="button" class="btn btn-primary pers-msg-btn closeModalTemp" data-dismiss="modal" aria-label="Close">Cancel</button>
                        </div>
                    </div>
                    <div class="col-md-8" style="padding: 25px;">
                        <div class="">
                            <div class="row">
                                <div class="col-lg-12 mb-3 mb-sm-4">
                                    <div class="d-flex justify-content-between align-content-center">
                                        <h5 class="mb-0">Select Template</h5>
                                        <button type="button" class="close btn-cls-outline closeModalTemp d-none d-md-block" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                </div>

                               
                              
                                <div class="col-6 col-md-6 pr-1">
                                    <div class="form-group mb-0 mb-md-3">
                                        <label>Select</label>
                                        <select class="form-control select_Temp_Content"  id="st_category_input_fest" name="contentname">
                                            <option value="all">All</option>
                                            @foreach($temp_categories as $cat)
                                            <option value="{{ $cat->id }}" >{{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6 col-md-6 pl-1">
                                    <div class="form-group search pr-2 pr-md-0">
                                        <label>&nbsp;</label>  
                                        <input type="text" class="form-control" name="searchtemplatesfest" id="st_text_input_fest" placeholder="Find Template">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="scroll_temp">
                            <div id="st_loader" style="display:none;">
                                <p class="text-danger text-center mt-5"> Loading...</p>
                            </div>
                            <div class="grid elementDiv pr-2 festivalMessages" id="st_grid">
                                <div class="grid-col grid-col--1"></div>
                                <div class="grid-col grid-col--2"></div>
                                <div class="grid-col grid-col--3"></div>
                                <div class="grid-col grid-col--4"></div>
                                
                             </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

    </div>
</div> -->


<div class="modal popin ol-modal add-pr-msg" tabindex="-1" role="dialog" id="festivalMessages" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h6 class="modal-title text-color">Add Messages</h6>
                <button type="button" class="close mr-3 my-3 closeModalTemp" data-dismiss="modal" aria-label="Close">
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

<!-- new share offer message schedule modal -->
<div class="modal fade add-pr-msg" tabindex="-1" role="dialog" id="shareOfferMessage" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h6 class="modal-title text-color">Share Offer</h6>
                <button type="button" class="close mr-3 my-3" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
                <div class="row align-items-end">
                    <div class="col-md-9 order-2 order-md-1">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="date-time" role="tabpanel" aria-labelledby="date-time-tab">
                                <div class="date-time">
                                    <div>
                                        <div class="form-group mb-0">
                                            <label for="start_date">Select Date <span>*</span></label>
                                                <input type="text" value="{{ $busnessDetails->share_offer_scheduled_date}}" class="form-control" data-edit_temp_id="0" id="start_date" min="{{ Carbon\Carbon::tomorrow()->format('d-m-Y') }}" readonly="true" required>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="form-group">
                                            <label for="myGroups" class="d-block_">Select Group <span>*</span></label>
                                            <select id="myGroupsContacts" class="form-control choice-group" multiple="multiple" required>
                                                <option value="">- Select Groups -</option>
                                                @foreach($groups as $group)
                                                    <option value="{{ $group->id }}" @if(in_array($group->id, $busnessDetails->selected_groups)) selected @endif >{{ $group->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>   
                                </div>
                                <div class="text-left my-4">
                                    <button type="button" class="btn btn-success pers-msg-btn px-4 mr-4" onclick="shareOffer()">Save</button>
                                </div>
                            </div>  
                        </div>  
                    </div>    
                    <div class="col-md-3 order-1 order-md-2">
                            <div class="add-message-img-inner text-center text-md-right">
                                <img src="{{asset('assets/business/pop-up-images/personalised-message/add-message-new.png')}}" alt="" class="img-fluid">
                            </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>
