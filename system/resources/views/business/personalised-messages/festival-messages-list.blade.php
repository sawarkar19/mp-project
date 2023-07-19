<div class="col-12 col-md-12 col-lg-12">
    <div class="card">
        <div class="card-header px-3 @if($planData['userData']->current_account_status == 'free') __pro__  @endif">
            <h4>List of Festival Messages</h4>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive custom-table">
                <table class="table mb-0" id="fest_msgs_list_datatable">
                    <thead>
                        <tr class="text-center">
                            <th>Sr. No.</th>
                            <th>Date</th>
                            <th>Status</th> 
                            <th>Message</th>
                            <th>Action</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>