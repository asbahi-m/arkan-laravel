@extends('site.layout')

@section('content')
    <section class="no-gutters main-slider">
        <div class="carousel slide main">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="container">
                        <div class="item-caption">
                            <!-- <div class="sub-title uppercase">Arkan Pro</div>
                            <h2 class="item-title uppercase">IT Services</h2>
                            <p class="item-desc">
                            Software Development - Enterprise Resource Planning - Design and Branding ...
                            </p> -->
                            <div class="buttons">
                                <a href="services.html" class="btn btn-secondary" type="button">
                                    Our Services <i class="fas fa-chevron-right"></i>
                                </a>
                                <a href="about-us.html" class="btn btn-dark btn-outline" type="button">More About US</a>
                            </div>
                        </div>
                    </div>
                    <div class="item-img overlay-img" style="background-image: url(images/slider-1.jpg)"></div>
                </div>
                <div class="carousel-item" style="display: none">
                    <div class="item-img overlay-img" style="background-image: url(images/slider-2.jpg)"></div>
                </div>
                <div class="carousel-item" style="display: none">
                    <div class="item-img overlay-img" style="background-image: url(images/slider-3.jpg)"></div>
                </div>
            </div>
            <div class="carousel-control">
                <a href="#prev" class="prev" aria-controls="prev"></a>
                <a href="#next" class="next" aria-controls="next"></a>
            </div>
        </div>
    </section>

    <section id="about-us" class="about-us">
        <div class="container">
            <div class="text-center">
                <h1 class="head-title"><a href="#">Arkan <span>Pro</span></a></h1>
                <div class="sub-title text-primary uppercase">Always close together</div>
                <p class="sub-text text-center">
                    It is a long established fact that a reader will be distracted by
                    the readable content of a page when looking at its layout. The point
                    of using Lorem Ipsum is that it has a more-or-less normal
                    distribution of letters ...
                </p>
            </div>

            <article class="card row">
                <div class="card-img">
                    <div class="img">
                        <img class="lazyload" data-src="images/pic-about.jpg" alt="About Us" />
                    </div>
                    <div class="overlay-bg">
                        <div class="buttons">
                            <a href="about-us.html" class="icon icon-primary" type="button"><i class="fas fa-link"></i></a>
                            <button class="icon icon-primary modal-open" type="button" data-image="images/pic-about.jpg">
                                <i class="fas fa-expand"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h2 class="card-title uppercase">
                        United Vision <i class="fas fa-quote-right text-large text-primary"></i>
                    </h2>
                    <p class="card-desc">
                        It is a long established fact that a reader will be distracted
                        by the readable content of a page when looking at its layout.
                        The point of using Lorem Ipsum is that it has a more-or-less
                        normal distribution of letters ...
                    </p>
                    <a href="about-us.html" class="btn btn-primary">Read More <i class="fas fa-chevron-right"></i></a>
                    <span class="mark arrow">
                        <img src="images/logo-white.png" alt="Arkan Pro" />
                        <span><strong>Arkan</strong>Pro</span>
                    </span>
                </div>
            </article>
        </div>
    </section>

    <section id="unlimited-tech" class="unlimited-tech animate">
        <div class="container">
            <h1 class="underline"><a>Unlimited <span>Technolgoy</span></a></h1>
            <div class="items">
                <div class="item">
                    <span class="img-circle">
                        <img class="lazyload" data-src="images/icon-committed.png" alt="Committed to result" />
                    </span>
                    <h2>Committed to result</h2>
                    <p>
                        It is a long established fact that a reader will be distracted
                        by the readable content of a page when looking at its layout.
                    </p>
                    <a class="more" href="#"><i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="item">
                    <span class="img-circle">
                        <img class="lazyload" data-src="images/icon-sale.png" alt="After-sales service" />
                    </span>
                    <h2>After-sales service</h2>
                    <p>
                        It is a long established fact that a reader will be distracted
                        by the readable content of a page when looking at its layout.
                    </p>
                    <a class="more" href="#"><i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="item special">
                    <span class="img-circle">
                        <img class="lazyload" data-src="images/icon-guarantee.png" alt="Measure of success" />
                    </span>
                    <h2>Measure of success</h2>
                    <p>
                        It is a long established fact that a reader will be distracted
                        by the readable content of a page when looking at its layout.
                    </p>
                    <a class="more" href="#"><i class="fas fa-arrow-down"></i></a>
                </div>
                <div class="item">
                    <span class="img-circle">
                        <img class="lazyload" data-src="images/icon-saudi.png" alt="Saudi identity" />
                    </span>
                    <h2>Saudi identity</h2>
                    <p>
                        It is a long established fact that a reader will be distracted
                        by the readable content of a page when looking at its layout.
                    </p>
                    <a class="more" href="#"><i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </section>

    <section id="services" class="services animate">
        <div class="container">
            <div class="shuflle">
                <h1 class="underline"><a>Services <span>web provide</span></a></h1>
                <ul class="list">
                    <li class="active" data-list="all">All</li>
                    <li data-list="it">IT</li>
                    <li data-list="security">Security</li>
                    <li data-list="design">Design</li>
                    <li data-list="hosting">Hosing</li>
                </ul>
                <div class="items card-grid">
                    <div class="card" data-sort="it">
                        <div class="card-img">
                            <div class="img">
                                <img class="lazyload" data-src="images/pic-serv-1.jpg" alt="Design and Branding" />
                            </div>
                            <div class="overlay-bg">
                                <div class="buttons">
                                    <a href="service-view.html" class="icon icon-primary" type="button"><i class="fas fa-link"></i></a>
                                    <button class="icon icon-primary modal-open" type="button" data-image="images/pic-serv-1.jpg">
                                        <i class="fas fa-expand"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h2 class="card-title"><a href="service-view.html">Design and Branding</a></h2>
                            <div class="card-meta">IT Service</div>
                        </div>
                    </div>
                    <div class="card" data-sort="security">
                        <div class="card-img">
                            <div class="img">
                                <img class="lazyload" data-src="images/pic-serv-2.jpg" alt="Design and Branding" />
                            </div>
                            <div class="overlay-bg">
                                <div class="buttons">
                                    <a href="service-view.html" class="icon icon-primary" type="button"><i class="fas fa-link"></i></a>
                                    <button class="icon icon-primary modal-open" type="button" data-image="images/pic-serv-2.jpg">
                                        <i class="fas fa-expand"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h2 class="card-title"><a href="service-view.html">Design and Branding</a></h2>
                            <div class="card-meta">Security Service</div>
                        </div>
                    </div>
                    <div class="card" data-sort="design">
                        <div class="card-img">
                            <div class="img">
                                <img class="lazyload" data-src="images/pic-serv-3.jpg" alt="Design and Branding" />
                            </div>
                            <div class="overlay-bg">
                                <div class="buttons">
                                    <a href="service-view.html" class="icon icon-primary" type="button"><i class="fas fa-link"></i></a>
                                    <button class="icon icon-primary modal-open" type="button" data-image="images/pic-serv-3.jpg">
                                        <i class="fas fa-expand"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h2 class="card-title"><a href="service-view.html">Design and Branding</a></h2>
                            <div class="card-meta">Design Service</div>
                        </div>
                    </div>
                    <div class="card" data-sort="hosting">
                        <div class="card-img">
                            <div class="img">
                                <img class="lazyload" data-src="images/pic-serv-4.jpg" alt="Design and Branding" />
                            </div>
                            <div class="overlay-bg">
                                <div class="buttons">
                                    <a href="service-view.html" class="icon icon-primary" type="button"><i class="fas fa-link"></i></a>
                                    <button class="icon icon-primary modal-open" type="button" data-image="images/pic-serv-4.jpg">
                                        <i class="fas fa-expand"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h2 class="card-title"><a href="service-view.html">Design and Branding</a></h2>
                            <div class="card-meta">Hosting Service</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="benner">
                <a href="#"><img class="lazyload" data-src="images/benner.jpg" alt="Benner" /></a>
            </div>
        </div>
    </section>

    <section class="boxlight animate">
        <div class="img">
            <img class="lazyload" data-src="images/ipad-pos.png" alt="Develope Your Work" />
        </div>
        <div class="container">
            <div class="card row custom-card">
                <div class="card-body">
                    <h2 class="card-title uppercase">Develope Your Work</h2>
                    <p class="card-desc">
                        It is a long established fact that a reader will be distracted
                        by the readable content of a page when looking at its layout.
                        The point of using Lorem Ipsum is that it has a more-or-less
                        normal distribution of letters, as opposed to using "Content
                        here, content here", making it look like readable English.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section id="clients" class="clients animate">
        <div class="container">
            <h1 class="underline uppercase"><a href="clients.html">Our <span>Clients</span></a></h1>
            <a href="clients.html" class="btn btn-primary more">More</a>
            <div class="slider">
                <div class="MS-content items">
                    <div class="item">
                        <a class="img" href="#">
                            <img class="lazyload" data-src="images/pic-client1.png" alt="Abu Ayyan" />
                        </a>
                    </div>
                    <div class="item">
                        <a class="img" href="#">
                            <img class="lazyload" data-src="images/pic-client2.png" alt="Abu Ayyan" />
                        </a>
                    </div>
                    <div class="item">
                        <a class="img" href="#">
                            <img class="lazyload" data-src="images/pic-client3.png" alt="Abu Ayyan" />
                        </a>
                    </div>
                    <div class="item">
                        <a class="img" href="#">
                            <img class="lazyload" data-src="images/pic-client4.png" alt="Abu Ayyan" />
                        </a>
                    </div>
                    <div class="item">
                        <a class="img" href="#">
                            <img class="lazyload" data-src="images/pic-client1.png" alt="Abu Ayyan" />
                        </a>
                    </div>
                </div>
                <div class="MS-controls">
                    <button class="MS-left prev" type="button"></button>
                    <button class="MS-right next" type="button"></button>
                </div>
            </div>
        </div>
    </section>

    <section id="subscribe" class="subscribe boxlight bg-secondary animate">
        <div class="container">
            <div class="card row">
                <div class="card-body">
                    <h1 class="card-title">Request one of our services</h1>
                    <p class="card-desc">
                        Remember that customers always want their orders to arrive on time, so go ahead and think of the Smart
                        Delivery application that helps you achieve their satisfaction in the first place, especially if you seek
                        to grow and expand your customer base. Don't bother looking for experienced drivers, just choose to
                        subscribe to the Smart Delivery application to get highly skiled drivedrs to deliver your customer's
                        requiests wherever he is.
                    </p>
                </div>
                <form action="" method="">
                    <div class="field">
                        <label for="input-name">Your Name</label>
                        <input type="text" name="name" id="input-name" required>
                    </div>
                    <div class="form-group">
                        <div class="field">
                            <label for="input-email">Email</label>
                            <input type="email" name="email" id="input-email" required>
                        </div>
                        <div class="field">
                            <label for="input-phone">Phone</label>
                            <input type="tel" name="phone" id="input-phone">
                        </div>
                    </div>
                    <div class="field">
                        <label for="input-service">Service</label>
                        <select name="service" id="input-service" required>
                            <option value="" disabled selected>Please Select Service</option>
                            <option value="it">IT Service</option>
                            <option value="security">Security Service</option>
                            <option value="design">Design Service</option>
                            <option value="hosting">Hosting Service</option>
                        </select>
                    </div>
                    <button class="btn btn-primary center" type="submit">Subscribe</button>
                </form>
            </div>
        </div>
    </section>
@endsection
