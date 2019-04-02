<header class="main-header">
        <nav class="indigo">
          <div class="container">
            <div class="nav-wrapper">
            @if(Auth::check())
              <a href="#" class="brand-logo">{{Auth::user()->name}}</a>
            @endif
              <a href="#" data-activates="mobile-nav" class="button-collapse">
                <i class="fa fa-bars"></i>
              </a>
              <ul class="right hide-on-med-and-down">
                <li>
                  <a class="active-link" href="#">Home</a>
                </li>
                <li>
                  <a href="#">search</a>
                </li>
                <li>
                    <a href="{{ route('logout') }}" class="btn purple"
                        onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                        Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>

                </li>

              </ul>
              <ul class="side-nav" id="mobile-nav">
                @if(Auth::check())
                <h4 class="purple-text text-darken-4 center">{{Auth::user()->name}}</h4>
                @endif
                <li>
                  <div class="divider"></div>
                </li>
                <li>
                  <a href="#">
                    <i class="fa fa-home grey-text text-darken-4"></i> Home</a>
                </li>
                <li>
                  <a href="#">
                    <i class="fa fa-cog grey-text text-darken-4"></i> Search</a>
                </li>
                <li>
                  <div class="divider"></div>
                </li>
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
        <!-- Showcase -->
        <div class="showcase container">
          <div class="row">
            <div class="col s12 m10 offset-m1 center">
              <h4>Latest Announcement</h4>
              <p class="abroadcast">Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque architecto quisquam ex voluptatibus dicta, incidunt autem ipsum quibusdam provident officiis similique atque! Voluptate quis quasi, maxime nisi nam autem ullam!
              Fuga, excepturi! Incidunt corporis dicta expedita? Qui nobis sit soluta officia deleniti modi veritatis, ratione illo possimus quia maiores facilis molestias aperiam reiciendis impedit voluptatibus itaque eligendi ex debitis ea!
              Quaerat error amet assumenda. Consectetur nostrum similique illo architecto ab consequatur iste totam. Laboriosam dolorum iusto officia facilis provident! Eos modi a libero doloremque veniam commodi quasi alias quos animi!
              Sequi magnam quo ut quae quia? Sequi laboriosam nam consequatur inventore impedit obcaecati molestias quis, numquam hic laborum ipsam ullam incidunt modi repellendus officiis minus quasi et voluptates nulla soluta.
              Nemo voluptate sunt doloremque laboriosam, maxime saepe delectus vero molestias nam ipsa recusandae sapiente repudiandae, dolorum rerum asperiores voluptatibus sit culpa consequuntur explicabo ipsam quas perferendis? Culpa ea totam quis.</p>
              <br>

            </div>
          </div>
        </div>
      </header>
