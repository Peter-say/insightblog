@extends('dashboard.layouts.app')

@section('contents')
    <div class="row g-3 mb-3">
        <div class="col-xxl-6 col-xl-12">
            <div class="row g-3">
                <div class="col-12">
                    <div class="card bg-transparent-50 overflow-hidden">
                        <div class="card-header position-relative">
                            <div class="bg-holder d-none d-md-block bg-card z-1"
                                style="background-image:url(../assets/img/illustrations/ecommerce-bg.png);background-size:230px;background-position:right bottom;z-index:-1;">
                            </div>
                            <div class="position-relative z-2">
                                <div>
                                    <h3 class="text-primary mb-1">{{ $greeting }}, {{ Auth()->user()->name }}!</h3>
                                    <p>Here’s what happening with your store today</p>
                                </div>
                                <div class="d-flex py-3">
                                    {{-- <div class="pe-3">
                    <p class="text-600 fs--1 fw-medium">Today's visit</p>
                    <h4 class="text-800 mb-0">{{ number_format($todayViews) }}</h4>
                  </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="card h-md-100 ecommerce-card-min-width">
                                <div class="card-header pb-0">
                                    <h6 class="mb-0 mt-2 d-flex align-items-center">Total visit</h6>
                                </div>
                                <div class="card-body d-flex flex-column justify-content-end">
                                    <div class="row align-items-end">
                                        <div class="col">
                                            <p class="font-sans-serif lh-1 mb-1 fs-2">{{ number_format($totalViews) }}</p>
                                            <div class="d-flex justify-content-between">
                                                <span class="badge badge-subtle-success rounded-pill fs--2">+3.5%</span>
                                            </div>
                                        </div>
                                        <div class="col-auto ps-0">
                                            <div>
                                              <span class="badge badge-subtle-primary rounded-pill fs--2"><a href="{{route('dashboard.stats')}}">See more</a></span>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card product-share-doughnut-width">
                                <div class="card-header pb-0">
                                    <h6 class="mb-0 mt-2 d-flex align-items-center">Blog Posts</h6>
                                </div>
                                <div class="card-body d-flex flex-column justify-content-end">
                                    <div class="row align-items-end">
                                        <div class="col">
                                            <p class="font-sans-serif lh-1 mb-1 fs-2">{{ number_format($totalPosts) }}</p>
                                            <span class="badge badge-subtle-success rounded-pill"><span
                                                    class="fas fa-caret-up me-1"></span>3.5%</span>
                                        </div>
                                        <div class="col-auto ps-0">
                                           
                                            <span class="badge badge-subtle-primary rounded-pill fs--2"><a href="{{route('dashboard.blog.index')}}">See more</a></span>
                                                   
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <!-- Other Cards -->
                        <div class="col-md-6">
                            <div class="card h-md-100 h-100">
                                <div class="card-body">
                                    <div class="row h-100 justify-content-between g-0">
                                        <div class="col-5 col-sm-6 col-xxl pe-2">
                                            <h6 class="mt-1">Market Share</h6>
                                            <div class="fs--2 mt-3">
                                                <div class="d-flex flex-between-center mb-1">
                                                    <div class="d-flex align-items-center"><span
                                                            class="dot bg-primary"></span><span
                                                            class="fw-semi-bold">Falcon</span></div>
                                                    <div class="d-xxl-none">57%</div>
                                                </div>
                                                <div class="d-flex flex-between-center mb-1">
                                                    <div class="d-flex align-items-center"><span
                                                            class="dot bg-info"></span><span
                                                            class="fw-semi-bold">Sparrow</span></div>
                                                    <div class="d-xxl-none">20%</div>
                                                </div>
                                                <div class="d-flex flex-between-center mb-1">
                                                    <div class="d-flex align-items-center"><span
                                                            class="dot bg-warning"></span><span
                                                            class="fw-semi-bold">Phoenix</span></div>
                                                    <div class="d-xxl-none">22%</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto position-relative">
                                            <div class="echart-product-share"></div>
                                            <div class="position-absolute top-50 start-50 translate-middle text-dark fs-2">
                                                26M</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h6 class="mb-0 mt-2 d-flex align-items-center">Total Order</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row align-items-end">
                                        <div class="col">
                                            <p class="font-sans-serif lh-1 mb-1 fs-2">58.4K</p>
                                            <div class="badge badge-subtle-primary rounded-pill fs--2"><span
                                                    class="fas fa-caret-up me-1"></span>13.6%</div>
                                        </div>
                                        <div class="col-auto ps-0">
                                            <div class="total-order-ecommerce"
                                                data-echarts='{"series":[{"type":"line","data":[110,100,250,210,530,480,320,325]}],"grid":{"bottom":"-10px"}}'>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-6 col-xl-12">
            <div class="card py-3 mb-3">
                <div class="card-body py-3">
                    <div class="row g-0">
                        <div class="col-6 col-md-4 border-200 border-bottom border-end pb-4">
                            <h6 class="pb-1 text-700">Orders</h6>
                            <p class="font-sans-serif lh-1 mb-1 fs-2">15,450</p>
                            <div class="d-flex align-items-center">
                                <h6 class="fs--1 text-500 mb-0">13,675</h6>
                                <h6 class="fs--2 ps-3 mb-0 text-primary"><span class="me-1 fas fa-caret-up"></span>21.8%
                                </h6>
                            </div>
                        </div>
                        <div class="col-6 col-md-4 border-200 border-bottom border-end-md pb-4 ps-3">
                            <h6 class="pb-1 text-700">Items sold</h6>
                            <p class="font-sans-serif lh-1 mb-1 fs-2">1,054</p>
                            <div class="d-flex align-items-center">
                                <h6 class="fs--1 text-500 mb-0">13,675</h6>
                                <h6 class="fs--2 ps-3 mb-0 text-warning"><span class="me-1 fas fa-caret-up"></span>21.8%
                                </h6>
                            </div>
                        </div>
                        <div
                            class="col-6 col-md-4 border-200 border-bottom border-end border-end-md-0 pb-4 pt-4 pt-md-0 ps-md-3">
                            <h6 class="pb-1 text-700">Refunds</h6>
                            <p class="font-sans-serif lh-1 mb-1 fs-2">$145.65</p>
                            <div class="d-flex align-items-center">
                                <h6 class="fs--1 text-500 mb-0">13,675</h6>
                                <h6 class="fs--2 ps-3 mb-0 text-success"><span class="me-1 fas fa-caret-up"></span>21.8%
                                </h6>
                            </div>
                        </div>
                        <div
                            class="col-6 col-md-4 border-200 border-bottom border-bottom-md-0 border-end-md pt-4 pb-md-0 ps-3 pe-md-3">
                            <h6 class="pb-1 text-700">Gross sale</h6>
                            <p class="font-sans-serif lh-1 mb-1 fs-2">$100.26</p>
                            <div class="d-flex align-items-center">
                                <h6 class="fs--1 text-500 mb-0">$89.28</h6>
                                <h6 class="fs--2 ps-3 mb-0 text-primary"><span class="me-1 fas fa-caret-up"></span>15.8%
                                </h6>
                            </div>
                        </div>
                        <div
                            class="col-6 col-md-4 border-200 border-bottom border-bottom-md-0 border-end-md pt-4 pb-md-0 ps-3 pe-md-3">
                            <h6 class="pb-1 text-700">Avg. Check</h6>
                            <p class="font-sans-serif lh-1 mb-1 fs-2">$16.47</p>
                            <div class="d-flex align-items-center">
                                <h6 class="fs--1 text-500 mb-0">$15.89</h6>
                                <h6 class="fs--2 ps-3 mb-0 text-primary"><span class="me-1 fas fa-caret-up"></span>15.8%
                                </h6>
                            </div>
                        </div>
                        <div class="col-6 col-md-4 border-200 pt-4 ps-3 pe-md-3">
                            <h6 class="pb-1 text-700">Conversion</h6>
                            <p class="font-sans-serif lh-1 mb-1 fs-2">58.4%</p>
                            <div class="d-flex align-items-center">
                                <h6 class="fs--1 text-500 mb-0">13,675</h6>
                                <h6 class="fs--2 ps-3 mb-0 text-primary"><span class="me-1 fas fa-caret-up"></span>3.5%
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

{{-- @section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
      var ctx = document.getElementById('viewsChart').getContext('2d');
      var chart = new Chart(ctx, {
          type: 'line',
          data: {
              labels: {!! $weekViews->pluck('week')->toJson() !!}, // Extract 'week' field assuming it's a collection of models
              datasets: [{
                  label: 'Views',
                  data: {!! $weekViews->pluck('views')->toJson() !!}, // Extract 'views' field assuming it's a collection of models
                  borderColor: 'rgba(75, 192, 192, 1)',
                  backgroundColor: 'rgba(75, 192, 192, 0.2)',
                  borderWidth: 1,
                  fill: true
              }]
          },
          options: {
              scales: {
                  y: {
                      beginAtZero: true
                  }
              },
              responsive: true,
              maintainAspectRatio: false
          }
      });
  });
  </script>
  
@endsection --}}
