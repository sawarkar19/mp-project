"use strict";

$("#redeem-modal").fireModal({
  title: 'Redeem',
  body: $("#redeem-body"),
  footerClass: 'bg-whitesmoke',
  autoFocus: false,
  onFormSubmit: function(modal, e, form) {
    console.log('as');
    e.preventDefault();

    $('#div-error').remove();

    $.ajax({
      type: 'POST',
      url: this.action,
      data: new FormData(this),
      dataType: 'json',
      contentType: false,
      cache: false,
      processData:false,
      success: function(response){ 
        form.stopProgress();
        console.log(response);
        if(response.status == 'success'){
            $('.redeem-box').hide();
            console.log(response);
            //modal.find('.modal-body').prepend('<div class="table-responsive"><table class="table table-striped" id="sortable-table"><tbody><tr><td><div class="sort-handler"><i class="fas fa-th"></i></div></td><td><b>Offer Title:</b> '+response.data.title+'</td></tr><tr><td><div class="sort-handler"><i class="fas fa-th"></i></div></td><td><b>Offer Title:</b> '+response.data.description+'</td></tr><tr><td><div class="sort-handler"><i class="fas fa-th"></i></div></td><td><b>Offer Title:</b> '+response.data.end_date+'</td></tr><tr><td><div class="sort-handler"><i class="fas fa-th"></i></div></td><td><b>Offer Title:</b> '+response.data.count+'</td></tr></tbody></table><div class="alert alert-success">'+response.message+'</div></div>');
              modal.find('.modal-body').prepend('<div>ok</div>');

        }else{  
            modal.find('.modal-body').prepend('<div id="div-error" class="alert alert-danger">'+response.message+'</div>');
        }
      },
      error: function(xhr, status, error) 
      {
        form.stopProgress();
        modal.find('.modal-body').prepend('<div id="div-error" class="alert alert-danger">Something went wrong.</div>');
      }
    });

    
  },
});