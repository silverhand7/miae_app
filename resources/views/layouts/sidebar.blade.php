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
                <form action="{{ route('resets', ['id' => Auth::user()->id ]) }}" method="post">
                <li class="{{ ($menu == 3 ? 'active' : '') }}">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}

                    <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                    <button type="submit" onclick="return confirm('are you sure? if you do resets, it means your data will be reseted and everything were be gone, it will make you to start from the beginning.')" style="color:red"><b>Resets Saldo</b></button>
                </li>
                </form>
               
            </ul>
    	</div>
    </div>