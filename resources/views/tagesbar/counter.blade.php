
<html>
    <head>
        <link rel="stylesheet" href="/css/wun-counter.css">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="/js/jquery.min.js"></script>
    </head>
    <body class="counter-body">
        <div class="max-width">
            <form method="POST" class="counter-logout" action="{{ route('logout') }}">
                @csrf
                <a href="route('logout')"
                onclick="event.preventDefault();
                                    this.closest('form').submit();">
                    {{ __('Logout') }}
                </a>
            </form>
        </div>
        <div class="counter-elements">
            <div class="counter-buttons">
                <div class="button-row">
                    <button data-type="one_euro" data-price="1" class="one_euro">+ 1,00€</button>
                    <button data-type="smoothie" data-price="4.5" class="smoothie">4,50€<br />Smoothie</button>
                    <button data-type="waffel" data-price="1.4" class="waffel">1,40€<br /><p>Waffel/<br />Sahne</p></button>
                    <button data-type="eis" data-price="1.2" class="eis">1,20€<br />Eis</button>
                </div>
                <div class="button-row">
                    <button data-type="fifty_cent" data-price="0.5" class="fifty_cent">+ 0,50€</button>
                    <button data-type="spritz" data-price="6.5" class="spritz">6,50€<br />Spritz</button>
                    <button data-type="cappuccino" data-price="2.8" class="cappuccino">2,80€<br />Cappuccino</button>
                    <button data-type="espresso" data-price="2.2" class="espresso">2,20€<br />Espresso</button>
                </div>
                <div class="button-row">
                    <button data-type="ten_cent" data-price="0.1" class="ten_cent">+ 0,10€</button>
                    <button data-type="fife_euro" data-price="5" class="fife_euro">5,00€</button>
                    <button data-type="spezi" data-price="3.4" class="spezi">3,40€<br />Spezi</button>
                    <button data-type="bier" data-price="3.8" class="bier">3,80€<br />Bier</button>
                </div>
            </div>
            <div class="counter-calc">
                <div class="calc">
                    <div class="gloss-left"></div>
                    <div class="gloss-right"></div>
                    <div class="inner-calc"></div>
                    <div class="total"><span>Gesamt</span><div class="total-calc"><span class="totalprice">0.00</span><span>EUR</span></div></div>
                </div>
                <div class="calc-buttons">
                    <button class="c-button">C</button>
                    <button class="send-button">Bestellen</button>
                </div>
            </div>
        </div>
        <script src="/js/counter.custom.js"></script>
    </body>
</html>


