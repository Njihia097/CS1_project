

          <!-- Upgrade to Pro -->
          


          <div class="row">
            <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-9">
                      <div class="d-flex align-items-center align-self-start">
                        <h3 class="mb-0">{{$total_users}}</h3>
                        
                      </div>
                    </div>
                    <div class="col-3">
                      <div class="icon icon-box-success ">
                        <span class="mdi mdi-arrow-top-right icon-item"></span>
                      </div>
                    </div>
                  </div>
                  <h6 class="text-muted font-weight-normal">Total users</h6>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-9">
                      <div class="d-flex align-items-center align-self-start">
                        <h3 class="mb-0">{{$total_revenue}}</h3>
                        
                      </div>
                    </div>
                    <div class="col-3">
                      <div class="icon icon-box-success">
                        <span class="mdi mdi-arrow-top-right icon-item"></span>
                      </div>
                    </div>
                  </div>
                  <h6 class="text-muted font-weight-normal">Revenue </h6>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-9">
                      <div class="d-flex align-items-center align-self-start">
                        <h3 class="mb-0">{{$total_orders}}</h3>
                        
                      </div>
                    </div>
                    <div class="col-3">
                      <div class="icon icon-box-danger">
                        <span class="mdi mdi-arrow-bottom-left icon-item"></span>
                      </div>
                    </div>
                  </div>
                  <h6 class="text-muted font-weight-normal">Total orders</h6>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-9">
                      <div class="d-flex align-items-center align-self-start">
                        <h3 class="mb-0">{{$total_art}}</h3>
                        
                      </div>
                    </div>
                    <div class="col-3">
                      <div class="icon icon-box-success ">
                        <span class="mdi mdi-arrow-top-right icon-item"></span>
                      </div>
                    </div>
                  </div>
                  <h6 class="text-muted font-weight-normal">Total number of arts</h6>
                </div>
              </div>
            </div>
          </div>


          
          <div class="row">
            <div class="col-sm-4 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h5>Revenue</h5>
                  <div class="row">
                    <div class="my-auto col-8 col-sm-12 col-xl-8">
                      <div class="d-flex d-sm-block d-md-flex align-items-center">
                        <h2 class="mb-0">$32123</h2>
                        <p class="mb-0 ml-2 text-success font-weight-medium">+3.5%</p>
                      </div>
                      <h6 class="text-muted font-weight-normal">11.38% Since last month</h6>
                    </div>
                    <div class="text-center col-4 col-sm-12 col-xl-4 text-xl-right">
                      <i class="ml-auto icon-lg mdi mdi-codepen text-primary"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-4 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h5>Sales</h5>
                  <div class="row">
                    <div class="my-auto col-8 col-sm-12 col-xl-8">
                      <div class="d-flex d-sm-block d-md-flex align-items-center">
                        <h2 class="mb-0">$45850</h2>
                        <p class="mb-0 ml-2 text-success font-weight-medium">+8.3%</p>
                      </div>
                      <h6 class="text-muted font-weight-normal"> 9.61% Since last month</h6>
                    </div>
                    <div class="text-center col-4 col-sm-12 col-xl-4 text-xl-right">
                      <i class="ml-auto icon-lg mdi mdi-wallet-travel text-danger"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-4 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h5>Purchase</h5>
                  <div class="row">
                    <div class="my-auto col-8 col-sm-12 col-xl-8">
                      <div class="d-flex d-sm-block d-md-flex align-items-center">
                        <h2 class="mb-0">$2039</h2>
                        <p class="mb-0 ml-2 text-danger font-weight-medium">-2.1% </p>
                      </div>
                      <h6 class="text-muted font-weight-normal">2.27% Since last month</h6>
                    </div>
                    <div class="text-center col-4 col-sm-12 col-xl-4 text-xl-right">
                      <i class="ml-auto icon-lg mdi mdi-monitor text-success"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>




          <div class="col-12 grid-margin">
            <div class="card">
              <div class="card-body">
          
                <h4 class="card-title">Art vs Content</h4>

                
                <canvas id="artistContentChart" width="400" height="400"></canvas>
            </div>
        </div>
              </div>
           
    
    
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('artistContentChart').getContext('2d');
            var artistContentChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Artists', 'Content'],
                    datasets: [{
                        label: '# of Items',
                        data: [{{ $artistCount }}, {{ $contentCount }}],
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Artists vs Content'
                        }
                    }
                }
            });
        });
    </script>
    @endpush


          
        
          
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-center text-muted d-block text-sm-left d-sm-inline-block">Copyright © bootstrapdash.com
              2020</span>
            <span class="float-none mt-1 text-center float-sm-right d-block mt-sm-0"> Free <a
                href="https://www.bootstrapdash.com/bootstrap-admin-template/" target="_blank">Bootstrap admin
                templates</a> from Bootstrapdash.com</span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    
    <!-- page-body-wrapper ends -->
