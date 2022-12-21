@extends('layouts.dashboard')

@section('content')

<style>
    

    .find-overlay {
        float: right;
        position: absolute;
        bottom: 0;
        right: 0;
        z-index: 99
    }

    .find-overlay .find-overlay-top {
        background: #cea29d;
        height: 60px;
        padding: 10px 30px;
        position: relative;
        color: #fff;
        line-height: 40px;
        font-size: 24px;
        text-align: left
    }

    .find-overlay .find-overlay-top span {
        font-weight: 700
    }

    .find-overlay .find-overlay-top img {
        position: absolute;
        bottom: 0;
        right: 0
    }

    .find-overlay .find-overlay-bottom form input {
        font-size: 18px;
        width: 75%;
        float: left;
        border: none;
        border-radius: 2px;
        padding: 10px 30px;
        line-height: 40px
    }

    .find-overlay .find-overlay-bottom form button {
        background: #04403c;
        color: #FFF;
        font-weight: 700;
        width: 25%;
        float: right;
        border: none;
        padding: 10px;
        line-height: 40px
    }

    .dealer-search {
        max-width: 440px;
        margin: 15px auto 0
    }

    .dealer-search form {
        background: #008ad8;
        font-size: 16px
    }

    .dealer-search form input {
        background: none transparent;
        color: #fff;
        border: none;
        padding: 5px 15px;
        line-height: 30px;
        width: 400px
    }

    .dealer-search form button {
        background: none transparent;
        border: none;
        color: #fff;
        margin-right: 5px;
        padding: 5px;
        line-height: 20px
    }

    #find-dealer-row {
        background: #0072ce;
    }

    #find-dealer-row h2 {
        font-size: 32px;
        text-align: center;
        line-height: 1;
        margin: 0;
        color: #fff
    }

    .find-a-dealer-banner {
        position: relative;
        background: #dbdcdd;
        text-align: center;
        background-image: url("/assets/images/pinned_map.png");
        background-repeat: no-repeat;
        background-position: top right;
        background-attachment: fixed;
        background-size: auto 100%;
    }

    .find-a-dealer-banner .find-overlay {
        position: absolute;
        top: 40%;
        left: 50%;
        margin-top: -150px;
        margin-left: -400px;
        z-index: 10;
        width: 797px;
        /* box-shadow:0 20px 15px -15px rgba(0,0,0,0.25); */
    }

    .no-outline:focus {
       border: none;
       box-shadow: 0 0 5px #777;
       border-radius: 0px;
    }

    @media (max-width: 767px) {
        .find-a-dealer-banner {
            height: 400px
        }

        .find-a-dealer-banner .find-overlay {
            width: 90%;
            margin-left: 5%;
            left: 0
        }

        .find-a-dealer-banner .find-overlay .find-overlay-top {
            font-size: 16px;
            padding: 10px 15px;
            height: 50px;
            line-height: 30px
        }

        .find-a-dealer-banner .find-overlay .find-overlay-bottom {
            height: 50px
        }

        .find-a-dealer-banner .find-overlay .find-overlay-bottom form input {
            font-size: 16px;
            line-height: 30px;
            padding: 10px 15px
        }

        .find-a-dealer-banner .find-overlay .find-overlay-bottom form button {
            line-height: 30px
        }
    }


</style>


<section class="section dashboard">
    <div class="row">


        <div class="find-a-dealer-banner" style="height: calc(100vh - 80px);">
            <div class="find-overlay">
                <div class="find-overlay-top">
                    <p>Find a <span>Dealer</span> Near You</p> 
                    <!-- <img src="/assets/images/rep.png" width="275px" alt="Rep with arms crossed" class="lazyload-loading" style="right: -30px;"> -->
                </div>
                <div class="find-overlay-bottom">
                    <form method="GET" action="/dealer_locator/">
                        <input type="text" class="no-outline" name="location" placeholder="Enter your ZIP Code" required>
                        <button type="submit">SEARCH</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</section>


@endsection