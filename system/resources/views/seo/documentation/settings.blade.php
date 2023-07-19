@extends('layouts.seo')
@section('title', 'Setting')

@section('head')
@include('layouts.partials.headersection', ['title'=>'Blogs Settings'] )
@endsection

@section('content')

<section class="section">

    <div class="section-body">
      {{-- <h2 class="section-title">All About General Settings</h2>
      <p class="section-lead">
        You can adjust all general settings here
      </p> --}}

      <div id="output-status"></div>
      <div class="row">
        <div class="col-md-4 col-xl-3">
          <div class="card">
            <div class="card-header">
              <h4>Jump To</h4>
            </div>
            <div class="card-body">
                
              <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a href="#GenralSidebarCard" class="nav-link active" id="GS_" data-toggle="tab" role="tab" aria-controls="GenralSidebarCard" aria-selected="true">Genral</a>
                </li>
                <li class="nav-item">
                    <a href="#BlogsSidebarCard" class="nav-link" id="BS_" data-toggle="tab" role="tab" aria-controls="BlogsSidebarCard" aria-selected="false">Sidebar</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-8 col-xl-9">


            <div class="tab-content no-padding">

                {{-- GENRAL SETTING  --}}
                <div class="tab-pane fade show active" id="GenralSidebarCard">
                    <div class="card">
                        {{-- <form id="setting-form"> --}}
                        <form id="setting-form1" method="post" action="{{ route('seo.blogs.updateSettings1') }}">
                            @csrf
                            <div class="card-header">
                                <h4>Genral Settings</h4>
                            </div>
                            <div class="card-body">
                                <p class="text-muted">General settings such as, page title, page description.</p>
                                <div class="form-group row align-items-center">
                                <label for="site-title" class="form-control-label col-sm-3">Title</label>
                                <div class="col-sm-6 col-md-9">
                                    <input type="text" name="title" class="form-control" id="title" value="{{ $settings->title }}">
                                </div>
                                </div>
                                <div class="form-group row align-items-center">
                                <label for="description" class="form-control-label col-sm-3">Description</label>
                                <div class="col-sm-6 col-md-9">
                                    <textarea class="form-control" name="description" id="site-description">{{ $settings->description }}</textarea>
                                </div>
                                </div>
                            </div>
                            <div class="card-footer bg-whitesmoke text-md-right">
                                <button class="btn btn-primary" id="save-btn">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- BLOG SETTINGS  --}}
                <div class="tab-pane fade" id="BlogsSidebarCard">
                    <div class="card">
                        <form id="setting-form2" method="post" action="{{ route('seo.blogs.updateSettings2') }}">
                            @csrf
                            <div class="card-header">
                                <h4>Blogs Sidebar</h4>
                            </div>
                            <div class="card-body">
                                <p class="text-muted">Sidebar settings such as, Category, Top Post, Subscription form toggle view and so on.</p>
                                <hr>
                                <div>
                                    <div class="form-group row align-items-center">
                                        <label for="site-title" class="form-control-label col-sm-3">Subscription Form</label>
                                        <div class="col-md-9">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="subscribe_form" value="1" id="subscribe_form" @if($settings->show_subscription) checked @endif>
                                                <label class="custom-control-label" for="subscribe_form">Visible</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <label for="site-description" class="form-control-label col-sm-3">Categories</label>
                                        <div class="col-md-9">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="categories" value="1" id="categories" @if($settings->show_category) checked @endif>
                                                <label class="custom-control-label" for="categories">Visible</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <label for="site-description" class="form-control-label col-sm-3">Top Posts</label>
                                        <div class="col-md-9">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="top_posts" value="1" id="top_posts" @if($settings->show_top_post) checked @endif>
                                                <label class="custom-control-label" for="top_posts">Visible</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-whitesmoke text-md-right">
                                <button class="btn btn-primary" id="save-btn">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>


                {{-- other SETTING  --}}
                {{-- <div class="tab-pane fade" id="OtherCard">
                    <div class="card">
                        <form id="setting-form">
                            <div class="card-header">
                                <h4>Sidebar</h4>
                            </div>
                            <div class="card-body">
                                <p class="text-muted">General settings such as, site title, site description, address and so on.</p>
                                <div class="form-group row align-items-center">
                                <label for="site-title" class="form-control-label col-sm-3 text-md-right">Site Title</label>
                                <div class="col-sm-6 col-md-9">
                                    <input type="text" name="site_title" class="form-control" id="site-title">
                                </div>
                                </div>
                                <div class="form-group row align-items-center">
                                <label for="site-description" class="form-control-label col-sm-3 text-md-right">Site Description</label>
                                <div class="col-sm-6 col-md-9">
                                    <textarea class="form-control" name="site_description" id="site-description"></textarea>
                                </div>
                                </div>
                                <div class="form-group row align-items-center">
                                <label class="form-control-label col-sm-3 text-md-right">Site Logo</label>
                                <div class="col-sm-6 col-md-9">
                                    <div class="custom-file">
                                    <input type="file" name="site_logo" class="custom-file-input" id="site-logo">
                                    <label class="custom-file-label">Choose File</label>
                                    </div>
                                    <div class="form-text text-muted">The image must have a maximum size of 1MB</div>
                                </div>
                                </div>
                                <div class="form-group row align-items-center">
                                <label class="form-control-label col-sm-3 text-md-right">Favicon</label>
                                <div class="col-sm-6 col-md-9">
                                    <div class="custom-file">
                                    <input type="file" name="site_favicon" class="custom-file-input" id="site-favicon">
                                    <label class="custom-file-label">Choose File</label>
                                    </div>
                                    <div class="form-text text-muted">The image must have a maximum size of 1MB</div>
                                </div>
                                </div>
                                <div class="form-group row">
                                <label class="form-control-label col-sm-3 mt-3 text-md-right">Google Analytics Code</label>
                                <div class="col-sm-6 col-md-9">
                                    <textarea class="form-control codeeditor" name="google_analytics_code"></textarea>
                                </div>
                                </div>
                            </div>
                            <div class="card-footer bg-whitesmoke text-md-right">
                                <button class="btn btn-primary" id="save-btn">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div> --}}

            </div>
        </div>
      </div>
    </div>
</section>
@endsection
@section('end_body')
    @include('seo.article.customjs')
@endsection