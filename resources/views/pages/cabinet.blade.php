@extends('layouts.app')

@section('content')
    <div class="pcabinet">
        <div class="header-block --border" style="background-image: url(img/cabinet-bg.jpg);">
            <div class="container">
                <div class="header-block__wrap">
                    <h1>My cabinet</h1>
                </div>
            </div>
        </div>
        <div class="container">
            <!--Wrap-->
            <div class="pcabinet__wrap">
                <!--Tab Button-->
                <div class="pcabinet__tab">
                    <button class="active" data-cabinet-btn><span>Personal data</span></button>
                    <button data-cabinet-btn><span>Tickets</span></button>
                </div>
                <!--cabinet-->
                <section class="pcabinet__cabinet active" data-cabinet-content>
                    <header>
                        <h4>Personal data</h4><a href="#Edit">Edit</a>
                    </header>
                    <form class="js-form-validator">
                        <div class="input-block --half"><em>First name</em>
                            <input name="name" required>
                        </div>
                        <div class="input-block --half"><em>Last name</em>
                            <input name="last-name" required>
                        </div>
                        <div class="input-block"><em>Email</em>
                            <input name="email" type="email" required>
                        </div>
                        <div class="input-block"><em>Day of birth</em>
                            <input name="day-of-birth" id="dayofbirth" placeholder="__.__.____" required>
                        </div>
                        <div class="input-block input-phone"><em>Phone number</em>
                            <input type="tel" id="phone" name="phone" required>
                        </div>
                        <button class="btn-submit --simple"><span>save</span></button>
                    </form>
                </section>
                <!--Ticket-->
                <section class="pcabinet__ticket" data-cabinet-content>
                    <header>
                        <h4>Tickets</h4>
                    </header>
                    <div class="tickets">
                        <div class="tickets__item js-ticket">
                            <div class="tickets__wrap">
                                <div class="tickets__fromto">
                                    <div class="tickets__ft"><b>Prague</b><em>Departure: Tue, Feb 9, 9:00 AM</em></div>
                                    <div class="tickets__between">
                                        <svg class="icon">
                                            <use xlink:href="img/sprites/sprite.svg#arrow-long"></use>
                                        </svg>
                                    </div>
                                    <div class="tickets__ft --last"><b>Passau</b><em>Estimated arrival: Tue, Feb 9, 12:05 PM</em></div>
                                </div>
                                <div class="tickets__amount">
                                    <div><span>3</span>
                                        <svg class="icon">
                                            <use xlink:href="img/sprites/sprite.svg#users"></use>
                                        </svg>
                                    </div>
                                    <div><span>3</span>
                                        <svg class="icon">
                                            <use xlink:href="img/sprites/sprite.svg#suitecase"></use>
                                        </svg>
                                    </div>
                                </div>
                                <div class="tickets__price"><b>€136</b></div>
                                <div class="tickets__arrow">
                                    <svg class="icon">
                                        <use xlink:href="img/sprites/sprite.svg#arrow-down"></use>
                                    </svg>
                                </div>
                            </div>
                            <div class="tickets__content">
                                <div class="tickets__list"><em>With stops in</em>
                                    <div class="tickets__list-item"><i><img src="img/cabinet-list-1.jpg" alt="IMG"></i>
                                        <div>
                                            <h4>Sacra di San Michele</h4><em>9:48 AM - 11:03 AM</em>
                                        </div><span>€23</span>
                                    </div>
                                    <div class="tickets__list-item"><i><img src="img/cabinet-list-2.jpg" alt="IMG"></i>
                                        <div>
                                            <h4>Eiffel Tower</h4><em>13:11 AM - 15:11 AM</em>
                                        </div><span>€29</span>
                                    </div>
                                </div>
                                <div class="tickets__footer"><i><img src="img/sedan.png" alt="sedan"></i>
                                    <div class="tickets__footer-info">
                                        <h4>Luxury sedan</h4><em>Mercedes Benz E-Class</em>
                                        <div><span>1-3</span>
                                            <svg class="icon">
                                                <use xlink:href="img/sprites/sprite.svg#users"></use>
                                            </svg>
                                        </div>
                                        <div><span>3x</span>
                                            <svg class="icon">
                                                <use xlink:href="img/sprites/sprite.svg#suitecase"></use>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="tickets__footer-price"><em>Total</em><b>€929</b></div>
                                    <div class="tickets__footer-bottom">
                                        <div class="tickets__amount">
                                            <div><span>3</span>
                                                <svg class="icon">
                                                    <use xlink:href="img/sprites/sprite.svg#users"></use>
                                                </svg>
                                            </div>
                                            <div><span>3</span>
                                                <svg class="icon">
                                                    <use xlink:href="img/sprites/sprite.svg#suitecase"></use>
                                                </svg>
                                            </div>
                                        </div><b>€136</b>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tickets__item js-ticket">
                            <div class="tickets__wrap">
                                <div class="tickets__fromto">
                                    <div class="tickets__ft"><b>Prague</b><em>Departure: Tue, Feb 9, 9:00 AM</em></div>
                                    <div class="tickets__between">
                                        <svg class="icon">
                                            <use xlink:href="img/sprites/sprite.svg#arrow-long"></use>
                                        </svg>
                                    </div>
                                    <div class="tickets__ft --last"><b>Passau</b><em>Estimated arrival: Tue, Feb 9, 12:05 PM</em></div>
                                </div>
                                <div class="tickets__amount">
                                    <div><span>3</span>
                                        <svg class="icon">
                                            <use xlink:href="img/sprites/sprite.svg#users"></use>
                                        </svg>
                                    </div>
                                    <div><span>3</span>
                                        <svg class="icon">
                                            <use xlink:href="img/sprites/sprite.svg#suitecase"></use>
                                        </svg>
                                    </div>
                                </div>
                                <div class="tickets__price"><b>€136</b></div>
                                <div class="tickets__arrow">
                                    <svg class="icon">
                                        <use xlink:href="img/sprites/sprite.svg#arrow-down"></use>
                                    </svg>
                                </div>
                            </div>
                            <div class="tickets__content">
                                <div class="tickets__list"><em>With stops in</em>
                                    <div class="tickets__list-item"><i><img src="img/cabinet-list-1.jpg" alt="IMG"></i>
                                        <div>
                                            <h4>Sacra di San Michele</h4><em>9:48 AM - 11:03 AM</em>
                                        </div><span>€23</span>
                                    </div>
                                    <div class="tickets__list-item"><i><img src="img/cabinet-list-2.jpg" alt="IMG"></i>
                                        <div>
                                            <h4>Eiffel Tower</h4><em>13:11 AM - 15:11 AM</em>
                                        </div><span>€29</span>
                                    </div>
                                </div>
                                <div class="tickets__footer"><i><img src="img/sedan.png" alt="sedan"></i>
                                    <div class="tickets__footer-info">
                                        <h4>Luxury sedan</h4><em>Mercedes Benz E-Class</em>
                                        <div><span>1-3</span>
                                            <svg class="icon">
                                                <use xlink:href="img/sprites/sprite.svg#users"></use>
                                            </svg>
                                        </div>
                                        <div><span>3x</span>
                                            <svg class="icon">
                                                <use xlink:href="img/sprites/sprite.svg#suitecase"></use>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="tickets__footer-price"><em>Total</em><b>€929</b></div>
                                    <div class="tickets__footer-bottom">
                                        <div class="tickets__amount">
                                            <div><span>3</span>
                                                <svg class="icon">
                                                    <use xlink:href="img/sprites/sprite.svg#users"></use>
                                                </svg>
                                            </div>
                                            <div><span>3</span>
                                                <svg class="icon">
                                                    <use xlink:href="img/sprites/sprite.svg#suitecase"></use>
                                                </svg>
                                            </div>
                                        </div><b>€136</b>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tickets__item js-ticket">
                            <div class="tickets__wrap">
                                <div class="tickets__fromto">
                                    <div class="tickets__ft"><b>Prague</b><em>Departure: Tue, Feb 9, 9:00 AM</em></div>
                                    <div class="tickets__between">
                                        <svg class="icon">
                                            <use xlink:href="img/sprites/sprite.svg#arrow-long"></use>
                                        </svg>
                                    </div>
                                    <div class="tickets__ft --last"><b>Passau</b><em>Estimated arrival: Tue, Feb 9, 12:05 PM</em></div>
                                </div>
                                <div class="tickets__amount">
                                    <div><span>3</span>
                                        <svg class="icon">
                                            <use xlink:href="img/sprites/sprite.svg#users"></use>
                                        </svg>
                                    </div>
                                    <div><span>3</span>
                                        <svg class="icon">
                                            <use xlink:href="img/sprites/sprite.svg#suitecase"></use>
                                        </svg>
                                    </div>
                                </div>
                                <div class="tickets__price"><b>€136</b></div>
                                <div class="tickets__arrow">
                                    <svg class="icon">
                                        <use xlink:href="img/sprites/sprite.svg#arrow-down"></use>
                                    </svg>
                                </div>
                            </div>
                            <div class="tickets__content">
                                <div class="tickets__list"><em>With stops in</em>
                                    <div class="tickets__list-item"><i><img src="img/cabinet-list-1.jpg" alt="IMG"></i>
                                        <div>
                                            <h4>Sacra di San Michele</h4><em>9:48 AM - 11:03 AM</em>
                                        </div><span>€23</span>
                                    </div>
                                    <div class="tickets__list-item"><i><img src="img/cabinet-list-2.jpg" alt="IMG"></i>
                                        <div>
                                            <h4>Eiffel Tower</h4><em>13:11 AM - 15:11 AM</em>
                                        </div><span>€29</span>
                                    </div>
                                </div>
                                <div class="tickets__footer"><i><img src="img/sedan.png" alt="sedan"></i>
                                    <div class="tickets__footer-info">
                                        <h4>Luxury sedan</h4><em>Mercedes Benz E-Class</em>
                                        <div><span>1-3</span>
                                            <svg class="icon">
                                                <use xlink:href="img/sprites/sprite.svg#users"></use>
                                            </svg>
                                        </div>
                                        <div><span>3x</span>
                                            <svg class="icon">
                                                <use xlink:href="img/sprites/sprite.svg#suitecase"></use>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="tickets__footer-price"><em>Total</em><b>€929</b></div>
                                    <div class="tickets__footer-bottom">
                                        <div class="tickets__amount">
                                            <div><span>3</span>
                                                <svg class="icon">
                                                    <use xlink:href="img/sprites/sprite.svg#users"></use>
                                                </svg>
                                            </div>
                                            <div><span>3</span>
                                                <svg class="icon">
                                                    <use xlink:href="img/sprites/sprite.svg#suitecase"></use>
                                                </svg>
                                            </div>
                                        </div><b>€136</b>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tickets__item js-ticket">
                            <div class="tickets__wrap">
                                <div class="tickets__fromto">
                                    <div class="tickets__ft"><b>Prague</b><em>Departure: Tue, Feb 9, 9:00 AM</em></div>
                                    <div class="tickets__between">
                                        <svg class="icon">
                                            <use xlink:href="img/sprites/sprite.svg#arrow-long"></use>
                                        </svg>
                                    </div>
                                    <div class="tickets__ft --last"><b>Passau</b><em>Estimated arrival: Tue, Feb 9, 12:05 PM</em></div>
                                </div>
                                <div class="tickets__amount">
                                    <div><span>3</span>
                                        <svg class="icon">
                                            <use xlink:href="img/sprites/sprite.svg#users"></use>
                                        </svg>
                                    </div>
                                    <div><span>3</span>
                                        <svg class="icon">
                                            <use xlink:href="img/sprites/sprite.svg#suitecase"></use>
                                        </svg>
                                    </div>
                                </div>
                                <div class="tickets__price"><b>€136</b></div>
                                <div class="tickets__arrow">
                                    <svg class="icon">
                                        <use xlink:href="img/sprites/sprite.svg#arrow-down"></use>
                                    </svg>
                                </div>
                            </div>
                            <div class="tickets__content">
                                <div class="tickets__list"><em>With stops in</em>
                                    <div class="tickets__list-item"><i><img src="img/cabinet-list-1.jpg" alt="IMG"></i>
                                        <div>
                                            <h4>Sacra di San Michele</h4><em>9:48 AM - 11:03 AM</em>
                                        </div><span>€23</span>
                                    </div>
                                    <div class="tickets__list-item"><i><img src="img/cabinet-list-2.jpg" alt="IMG"></i>
                                        <div>
                                            <h4>Eiffel Tower</h4><em>13:11 AM - 15:11 AM</em>
                                        </div><span>€29</span>
                                    </div>
                                </div>
                                <div class="tickets__footer"><i><img src="img/sedan.png" alt="sedan"></i>
                                    <div class="tickets__footer-info">
                                        <h4>Luxury sedan</h4><em>Mercedes Benz E-Class</em>
                                        <div><span>1-3</span>
                                            <svg class="icon">
                                                <use xlink:href="img/sprites/sprite.svg#users"></use>
                                            </svg>
                                        </div>
                                        <div><span>3x</span>
                                            <svg class="icon">
                                                <use xlink:href="img/sprites/sprite.svg#suitecase"></use>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="tickets__footer-price"><em>Total</em><b>€929</b></div>
                                    <div class="tickets__footer-bottom">
                                        <div class="tickets__amount">
                                            <div><span>3</span>
                                                <svg class="icon">
                                                    <use xlink:href="img/sprites/sprite.svg#users"></use>
                                                </svg>
                                            </div>
                                            <div><span>3</span>
                                                <svg class="icon">
                                                    <use xlink:href="img/sprites/sprite.svg#suitecase"></use>
                                                </svg>
                                            </div>
                                        </div><b>€136</b>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
