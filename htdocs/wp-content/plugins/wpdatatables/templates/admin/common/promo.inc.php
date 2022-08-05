<?php
?>
<div class="notice notice-info is-dismissible wpdt-promo-notice">
            <div id="wpdt-promo-section">
                <div id="wpdt-first-section">
                    <img class="wpdt-promo-logo" src="<?php echo WDT_ROOT_URL ?>assets/img/logo-promo.png" alt="">
                </div>
                <div id="wpdt-second-section">
                    <div class="wpdt-promo-upgrade-text">
                        <p>Upgrade to Premium today and <span style="color: #FFFFFF; font-weight: 700;"> get 30% off on all prices!</span> </p>
                    </div>
                    <div class="wpdt-promo-upgrade-btn">
                        <span class="wpdt-promo-dismiss-text">Don't show again</span>
                        <i class="wpdt-icon-times-thin wpdt-notice-dismiss"></i>
                        <button id="wpdt-grab-it" class="tms-store-checkout-wpdatatables">Grab yours!</button>
                    </div>
                </div>
            </div>
</div>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@200;700&family=Kaushan+Script&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@200;500;700&display=swap');
    .wpdt-promo-notice {
        border: none !important;
        padding: 0 !important;
    }
    #wpdt-first-section:after {
        content: '';
        display: inline-block;
        position: absolute;
        width: 30px;
        height: 141px;
        right: -15px;
        top: 0;
        border-radius: 50%;
        border: none;
        background-color: #FFFFFF;
    }
    #wpdt-promo-section,
    #wpdt-first-section,
    #wpdt-second-section {
        height: 141px;
    }

    #wpdt-first-section {
        width: 40%;
        float: left;
        position: relative;
        background: #FFFFFF;
    }
    #wpdt-second-section {
        width: 60%;
        display: flex;
        padding-top: 15px;
        padding-right: 20%;
        float: right;
        background: #6ED1FD;
    }

    .wpdt-promo-logo {
        margin: 6% 0 0 45%;
        width: 350px;
    }
    .wpdt-promo-upgrade-text {
        width: 90%;
        padding-top: 0;
        padding-right: 10px;
        margin-right: 30px;
        padding-left: 50px;
    }
    .wpdt-promo-upgrade-text p{
        font-family: 'Inter';
        font-style: normal;
        font-weight: 500;
        padding: 0;
        margin: 0;
        font-size: 33px;
        line-height: 37px;
        color: #181059;
    }

    .wpdt-promo-upgrade-btn {
        width: 50%;
    }
    .wpdt-promo-upgrade-btn button#wpdt-grab-it {
        padding: 12px 20px;
        background: #140964;
        border-radius: 10px;
        border: none;
        font-family: 'Inter';
        font-style: normal;
        font-weight: 700;
        font-size: 20px;
        line-height: 24px;
        margin: 38px 0 15px 0;
        text-align: center;
        color: #FFFFFF;
        width: 200px;
    }
    .wpdt-promo-dismiss-text {
        font-family: 'Inter';
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        margin-left: 65px;
        line-height: 19px;
        text-align: center;;
        opacity: 0.8;
        color: #FFFFFF;
    }
    .wpdt-icon-times-thin{
        margin-left: 10px;
        opacity: 0.8;
        cursor: pointer;
        color: #FFFFFF;
    }
    .wpdt-promo-notice .notice-dismiss {
        display: none !important;
    }
    @media(max-width: 1441px) {
        .wpdt-promo-logo {
            margin: 8% 0 0 15%;
        }
        #wpdt-second-section {
            padding-right: 5%;
        }
    }
    @media(max-width: 1025px) {
        #wpdt-promo-section {
            position: relative;
        }
        #wpdt-promo-section,
        #wpdt-first-section,
        #wpdt-second-section {
            height: auto;
        }
        #wpdt-first-section {
            width: 100%;
            float: none;
            margin: 0 auto;
            padding: 34px 0;
            position: relative;
            text-align: center;
            background: #FFFFFF;
        }
        #wpdt-second-section {
            width: 100%;
            display: flex;
            padding: 15px 20px;
            float: none;
            background: #6ED1FD;
        }
        #wpdt-first-section:after{
            display: none;
        }
        .wpdt-promo-logo {
            width: 50%;
            margin: 0;
            padding: 0 10px;
        }
        .wpdt-promo-upgrade-btn {
            width: auto;
            text-align: right;
        }
        .wpdt-promo-upgrade-btn button#wpdt-grab-it {
            margin: 15px 0;
        }
        .wpdt-promo-upgrade-text {
            width: 100%;
            padding: 10px 0 0 0;
            margin-right: 0;
        }
        .wpdt-icon-times-thin {
            top: 5px;
            right: 10px;
            position: absolute;
            color: #140964;
        }
        .wpdt-promo-dismiss-text {
            position: absolute;
            top: 2px;
            right: 25px;
            color: #140964;
            font-size: 12px;
        }
    }
    @media(max-width: 625px) {
        .wpdt-promo-logo {
            width: 70%;
        }
        #wpdt-second-section {
            flex-direction: column;
        }
        .wpdt-promo-upgrade-btn {
            text-align: center;
        }
        .wpdt-promo-upgrade-btn button#wpdt-grab-it {
            margin: 25px 0 15px 0;
        }
        #wpdt-first-section {
            padding: 40px 0;
        }
    }
</style>
