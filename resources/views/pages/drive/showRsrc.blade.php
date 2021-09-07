@extends('layouts.master')

@section('pageCustomStyle')
  <link href="{{ asset('assets/bundles/lightgallery/dist/css/lightgallery.css') }}" rel="stylesheet">
@stop

@section('content')
      <div class="main-content">
        <section class="section">
          <div class="section-body">
            <div class="row clearfix">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Ressources</h4>
                  </div>
                  <div class="card-body">
                    <div id="aniimated-thumbnials" class="list-unstyled row clearfix">
                      @foreach($files as $file)
                      <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-4">
                        <a href="{{ asset($file->lienFichier) }}" data-sub-html="{{ $file->nomFichier }}">
                          {{-- <div class="img-responsive thumbnail" style="background-image:url({{ $file->lienFichier }});background-position: center; background-size: cover; height: 200px; width: 200px;"></div --}}
                          <img class="img-responsive thumbnail " style="background-image:url({{ $file->lienFichier }});background-position: center; background-size: cover; height: 180px; border-radius: 12px" src="{{ $file->lienFichier }}" alt="{{ $file->nomFichier }}">
                        </a>
                      </div>
                      @endforeach

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
@endsection

@section('pageCustomScript')
    <!-- Page Specific JS File -->
  <script src="assets/bundles/dropzonejs/min/dropzone.min.js"></script>
  <!-- Page Specific JS File -->

  <script src="assets/bundles/lightgallery/dist/js/lightgallery-all.js"></script>
  <!-- Page Specific JS File -->
  <script src="assets/js/page/light-gallery.js"></script>
@stop

