
<header>
        <nav class="indigo">
          <div class="container">
              <div class="nav-wrapper">
                <div class="brand-logo">
                   @if (Auth::guest())
                      <li><a href="{{ route('login') }}">Login</a></li>
                      <li><a href="{{ route('register') }}">Register</a></li>
                   @else
                          
                              
                    <form class="search-form valign-wrapper center-align" method="post" action="{{route('search_by_ref')}}">
                      <div class="input-field search-top valign-wrapper center-align">
                        <input id="search" class="search-input" type="search" name="input_reference"required placeholder="Search By Reference">
                        {{-- <label class="label-icon " for="search"><i class="material-icons search-icon">search</i></label>  --}}
                      </div>
                      {{csrf_field()}}
                    </form>
                          
                  @endif
              </div>
                <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
                <ul class="right hide-on-med-and-down">
      
                  
                  @if(Auth::user()->rockpos == 1)
                     <li><a href="{{URL::route('homepage')}}">New Customer</a></li>
                  @endif
                  <li><a href="{{URL::route('homepage')}}">Pre-Own Orders</a></li>
      
                  @if(Auth::user()->rockpos == 0)
                    <li><a href="{{URL::route('reward_orders')}}">Voucher Orders</a></li>
                  @elseif(Auth::user()->rockpos == 1)
                    <li><a href="{{URL::route('remaining_voucher')}}">RockPos Vouchers</a></li>
                  @endif
                  
                  @if(Auth::user()->rockpos == 1)
                    <li><a href="{{URL::route('search_voucher')}}">Pull the Vouchers</a></li>
                  @endif
                  <li>
                      <a href="{{ route('logout') }}" 
                          onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                          Logout
                      </a>
      
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                          {{ csrf_field() }}
                      </form>
                     
                  </li>
                </ul>
                <ul class="side-nav" id="mobile-demo">
                  @if(Auth::user()->rockpos == 1)
                     <li><a href="{{URL::route('homepage')}}">New Customer</a></li>
                  @endif
                  <li><a href="{{URL::route('homepage')}}">Pre-Own Orders</a></li>
      
                  @if(Auth::user()->rockpos == 0)
                    <li><a href="{{URL::route('reward_orders')}}">Voucher Orders</a></li>
                  @elseif(Auth::user()->rockpos == 1)
                    <li><a href="{{URL::route('remaining_voucher')}}">RockPos Vouchers</a></li>
                  @endif
                  
                  @if(Auth::user()->rockpos == 1)
                    <li><a href="{{URL::route('search_voucher')}}">Pull the Vouchers</a></li>
                  @endif
                  <li>
                      <a href="{{ route('logout') }}" 
                          onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                          Logout
                      </a>
      
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                          {{ csrf_field() }}
                      </form>
                     
                  </li>
                </ul>
              </div>
          </div>
        </nav>
                
      </header>
      