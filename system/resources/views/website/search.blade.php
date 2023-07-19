@extends('layouts.website')

@section('title', 'Search - MouthPublicity.io')
@section('description', '')
@section('keywords', '')
{{-- @section('keywords', $seo->keywords) --}}

@push('css')
    <style>
        .search_bar{
            max-width: 800px;
        }
        .btn-theme{
            color: #ffffff;
            font-weight: 600;
            padding: .5rem 1.5rem;
            border: 0px;
            background-image: linear-gradient(to right, rgb(0,36,156) 0%, #00ffdc 50%, rgb(0,36,156) 100%);
            background-size: 200% auto;
            transition: 0.5s;
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
       }
       .btn-theme:hover{
            color: #FFFFFF;
            background-position: right center;
            box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.2);
        }
       .search_bar input:focus{
            border:1px solid #ced4da;
            box-shadow: none;
       }
       .searchbar-form{
            border: 1px solid #e3e3e3;
        }
        .content a{
            text-decoration: none;
            color: #2e2e2e;
        }
        .hr-line{
            max-width: 827px;
            height: 0.5px;
            background-color: #d7d7d7;
        }
        .pull-right .pageArrow{
            padding: 8.7px 16px !important;
        }
        .pull-right .page-link{
            color: #0d6efd !important;
        }
        .pull-right .pagination .page-item.active > .page-link{
            color: #fff !important;
        }
    </style>
@endpush

@section('content')
{{-- Banner Section --}}
<section id="search">
    <div class="py-5">
        <div class="container">
            <div class="">
                <div class="search_bar">
                    <form action="{{ route('searchResults') }}" method="GET">
                        @csrf
                        <div class="form-group floating-addon floating-addon-not-append my-4">
                            <div class="input-group">
                                <input type="text" class="form-control three-space-validation char-spcs-validation" placeholder="Search" name="keyword" value="{{ $keyword }}">
                                <div class="input-group-append">
                                    <button class="btn btn-lg btn-theme" type="submit" id="submit">Search</button>
                                </div>
                            </div>
                        </div>
                    </form> 
                    @if(!empty($error))
                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <div> {{ $error }} </div>
                    </div>
                    @endif

                </div>
                <div class="mt-5 mb-4">
                    @foreach($results as $result)
                        <div class="content mt-4">
                            <div class="title">
                                <a href="{{ url($result->path) }}"><h5 class="fw-bold">{{ $result->name }}</h5></a>
                            </div>
                            <div class="discribtion">
                                <a href="{{ url($result->path) }}"><p>{{ $result->description }}</p></a>
                            </div>
                        </div>
                        <div class="hr-line my-4"></div>
                    @endforeach
                </div> 
                <div class="Page navigation example">
                    <div class="row pagination">
                        <div class="col-md-6 col-xs-12">
                            @if($results->total() > 0)
                                <p class="pagi-counter">Showing {{ $results->firstItem() }} to {{ $results->lastItem() }} of {{ $results->total() }} entries</p>
                            @else
                            <p class="pagi-counter">Results not found</p>
                            @endif
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="pull-right float-md-end">
                                {!! $results->appends(['keyword'=>$keyword])->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</section>

@endsection

<script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
<script src="{{ asset('assets/js/input-validation.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $("body").on("keypress", 'input', function (e) {
            // console.log(e.which);
            if (e.which === 13) {
            $('#submit').click();
                return false;    //<---- Add this line
            }
        });
    });
</script>

@push('js')
  
@endpush

@push('end_body')

@endpush