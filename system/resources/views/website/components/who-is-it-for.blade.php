{{-- Who is it for --}}
<style>
   #whoIs .owl-stage{
    display: flex;
    align-items: end;
   }
   @media(max-width:575px){
    .sub-heading{
        letter-spacing: normal;
    }
   }
</style>
<section id="who_is_it_for">
    <div class="py-5">
        <div class="container">
            <div class="bg-color-gradient who-is-it-for">
                <div class="inner">
                    <div class="text-center mb-4 mb-lg-5">
                        <h3 class="text-uppercase font-800 text-white h2">who it is for</h3>
                        <h6 class="text-uppercase font-400 text-white sub-heading">anyone can use it like</h6>
                    </div>

                    <div class="owl-carousel owl-theme" id="whoIs">
                        <div class="item">
                            <div class="whoIs-item">
                                <div>
                                    <div class="wstf-img mb-3">
                                        <img src="{{asset('assets/website/images/who-is-it-for/influencer.svg')}}" alt="Influencer" class="img-fluid">
                                    </div>
                                    <div>
                                        <h4 class="font-700 mb-0">Influencer</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="whoIs-item">
                                <div>
                                    <div class="wstf-img mb-3" style="max-width: 14rem;">
                                        <img src="{{asset('assets/website/images/who-is-it-for/e-commerce.svg')}}" alt="E-Commerce" class="img-fluid">
                                    </div>
                                    <div>
                                        <h4 class="font-700 mb-0">E-Commerce</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="item">
                            <div class="whoIs-item">
                                <div>
                                    <div class="wstf-img mb-3">
                                        <img src="{{asset('assets/website/images/who-is-it-for/offline-store.svg')}}" alt="Offline Store" class="img-fluid">
                                    </div>
                                    <div>
                                        <h4 class="font-700 mb-0">Offline Store</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        

                        <div class="item">
                            <div class="whoIs-item">
                                <div>
                                    <div class="wstf-img mb-3">
                                        <img src="{{asset('assets/website/images/who-is-it-for/agency.svg')}}" alt="Agency" class="img-fluid">
                                    </div>
                                    <div>
                                        <h4 class="font-700 mb-0">Agency</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        

                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@push('end_body')
    <script>
    $(document).ready(function(){
        //for product
        $('#whoIs').owlCarousel({
            items:4,
            loop: true,
            margin:15,
            stagePadding: 1,
            responsive:{
                991:{
                    items:4
                },
                768:{
                    items:2
                },
                0:{
                    items:1
                }
            }
        
        });
    
    });
</script>
@endpush