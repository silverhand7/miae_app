<div class="sidebar" data-background-color="black" data-active-color="danger">

    <!--
		Tip 1: you can change the color of the sidebar's background using: data-background-color="white | black"
		Tip 2: you can change the color of the active button using the data-active-color="primary | info | success | warning | danger"
	-->

    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="http://www.creative-tim.com" class="simple-text">
                    MIAE App
                </a>
            </div>

            <ul class="nav">
                <li class="{{ ($menu == 1 ? 'active' : '') }}">
                    <a href="{{ route('home') }}">
                        <i class="ti-wallet"></i>
                        <p>Wallet</p>
                    </a>
                </li>
                <li class="{{ ($menu == 2 ? 'active' : '') }}">
                    <a href="{{ route('atm') }}">
                        <i class="ti-money"></i>
                        <p>ATM</p>
                    </a>
                </li>
              
               
            </ul>
    	</div>
    </div>