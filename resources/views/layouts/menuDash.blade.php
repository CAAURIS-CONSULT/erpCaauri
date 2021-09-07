          <div class="row ">
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15">Utilisateur</h5>
                          <h2 class="mb-3 font-18">{{ formatQte(getAllUser()->count()) }}</h2>
                          {{-- <p class="mb-0"><span class="col-green">10%</span> Increase</p> --}}
                        </div>
                      </div>
                      <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 pl-0">
                        <div class="banner-img">
                          <img src="assets/img/banner/1.png" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15"> Entreprise</h5>
                          <h2 class="mb-3 font-18">{{ formatQte(getAllEntr()->count()) }}</h2>
                        </div>
                      </div>
                      <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 pl-0">
                        <div class="banner-img">
                          <img src="assets/img/banner/2.png" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7 pr-0 pt-3">
                        <div class="card-contecxcnt">
                          <h5 class="font-15">Projet</h5>
                          <h2 class="mb-3 font-18">{{ formatQte(getAllPrj()->count()) }}</h2>
                          
                        </div>
                      </div>
                      <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 pl-0">
                        <div class="banner-img">
                          <img src="assets/img/banner/3.png" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15">Tache</h5>
                          <h2 class="mb-3 font-18"></h2>
                          <p class="mb-0"><span class="col-green">15</span> </p>
                        </div>
                      </div>
                      <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 pl-0">
                        <div class="banner-img">
                          <img src="assets/img/banner/4.png" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

  {{-- CUSTOM CSS --}}
  <style type="text/css">
    .font-15
    {
      text-transform: uppercase;
    }
  </style>