  <!-- navigation -->
  <header class="navigation fixed-top">
      <div class="container">
          <nav class="navbar navbar-expand-lg navbar-white">
              <a class="navbar-brand order-1" href="/">
                  <img class="img-fluid" width="100px" src="{{ asset('web/images/logo.png') }}"
                      alt="Reader | Hugo Personal Blog Template">
              </a>
              <div class="collapse navbar-collapse text-center order-lg-2 order-3" id="navigation">
                  <ul class="navbar-nav mx-auto">
                      <li class="nav-item dropdown">
                          <a class="nav-link" href="/">Homepage</a>
                      </li>

                      {{-- <li class="nav-item dropdown">
                          <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                              aria-expanded="false">
                              About <i class="ti-angle-down ml-1"></i>
                          </a>
                          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                              <a class="dropdown-item" href="#">About Me</a>
                              <a class="dropdown-item" href="#">About Us</a>
                          </div>
                      </li> --}}
                      <ul class="navbar-nav mx-auto">
                        @foreach ($navs as $nav)
                            @if ($nav->children && $nav->children->count() > 0)
                                <li class="nav-item dropdown">
                                    <a class="nav-link" href="{{$nav->url}}" role="button" data-toggle="dropdown"
                                       aria-haspopup="true" aria-expanded="false">
                                       {{ $nav->text }} <i class="ti-angle-down ml-1"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        @foreach ($nav->children as $child)
                                            <a class="dropdown-item" href="{{ $child->url }}">{{ $child->text }}</a>
                                        @endforeach
                                    </div>
                                </li>
                            @elseif (!$nav->parent_id)
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ $nav->url }}">{{ $nav->text }}</a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                    
{{--                     
                      <li class="nav-item">
                          <a class="nav-link" href="#">Contact</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="/">Blog</a>
                      </li> --}}
                  </ul>
                  @if (Auth::check())
                      <a href="{{ route('dashboard.home') }}" class="btn btn-sm btn-primary">Dashboard</a>
                  @else
                      <a href="{{ route('login') }}" class="btn btn-sm btn-primary">Login</a>
                  @endif
              </div>



              <div class="order-2 order-lg-3 d-flex align-items-center">
                  {{-- <select class="m-2 border-0 bg-transparent" id="select-language">
                      <option id="en" value="" selected>En</option>
                      <option id="fr" value="">Fr</option>
                  </select> --}}

                  <!-- search -->
                  <form class="search-bar">
                      <a href="{{ route('search-page') }}"> <input type="search"
                              placeholder="Type &amp; Hit Enter..."></a>
                  </form>

                  <button class="navbar-toggler border-0 order-1" type="button" data-toggle="collapse"
                      data-target="#navigation">
                      <i class="ti-menu"></i>
                  </button>
              </div>

          </nav>
      </div>
  </header>
  <!-- /navigation -->

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
      // Script to activate hover dropdown
      $(document).ready(function() {
          // Dropdown hover for statically and dynamically added items
          $('.nav-item.dropdown').hover(function() {
              $(this).addClass('show'); // Show dropdown on hover
              $(this).find('.dropdown-menu').addClass('show');
          }, function() {
              $(this).removeClass('show'); // Hide dropdown when not hovering
              $(this).find('.dropdown-menu').removeClass('show');
          });

          // Close dropdowns on click outside
          $(document).click(function(e) {
              if (!$(e.target).closest('.nav-item.dropdown').length) {
                  $('.nav-item.dropdown').removeClass('show');
                  $('.nav-item.dropdown').find('.dropdown-menu').removeClass('show');
              }
          });
      });
  </script>
