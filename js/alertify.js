  <script src="./js/jquery-1.10.2.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>

    <script>
        //function chksessionexpiredornt(chkhour, chkmin, chksec) {
        function chksessionexpiredornt(timerStart) {

            var timerStartnow = new Date();

            //var remaininghour  = timerStartnow.getHours() - chkhour ;
            //var remainingmin  =  timerStartnow.getMinutes() - chkmin ;
            //var remainingsec  =  timerStartnow.getSeconds() - chksec ;

            var diffMs = (timerStartnow - timerStart);
            var diffMins = Math.round(((diffMs % 86400000) % 3600000) / 60000);


            //if (remainingmin >= 6)
            if (diffMins >= 6) {
                var url = "/Home/signin/";
                $(window).attr("location", url);
            }
        }
    </script>
    <script type="text/javascript">
        var timerStart = new Date();

        //timerStart.getHours();
        //timerStart.getMinutes();
        //timerStart.getSeconds();

        var url = window.location.toString();
        var ssd = setInterval(function() {
            // chksessionexpiredornt( timerStart.getHours(),  timerStart.getMinutes(),timerStart.getSeconds(),timerStart);
            if (url.indexOf('/Home/signin') > 0) {
                chksessionexpiredornt(timerStart);
            }
            if (url.indexOf('/Home/signup') > 0) {
                chksessionexpiredornt(timerStart);
            }
            if (url.indexOf('/Home/help') > 0) {
                chksessionexpiredornt(timerStart);
            }
            if (url.indexOf('/Home/recoverfund') > 0) {
                chksessionexpiredornt(timerStart);
            }
            if (url.indexOf('/Home/resetpassword') > 0) {
                chksessionexpiredornt(timerStart);
            }
            if (url.indexOf('/Home/disable2fa') > 0) {
                chksessionexpiredornt(timerStart);
            }

        }, 30000);
    </script>

    <script>
        $window = $(window);
        $window.scroll(function() {
            $scroll_position = $window.scrollTop();
            if ($scroll_position > 1035) { // if body is scrolled down by 890 pixels
                $('#secondary-nav').addClass('sticky');

                $('#operacoin-accept-business').css('margin-top', '110px');

                // to get rid of jerk
                header_height = $('.your-header').innerHeight();
                $('body').css('padding-top', header_height);
            } else {
                //$('body').css('padding-top', '0');
                //$('.your-header').removeClass('sticky');
                $('#secondary-nav').removeClass('sticky');
                $('#operacoin-accept-business').css('margin-top', '0px');
            }
        });
    </script>
    <script>
        $('a[href*="#"]:not([href="#"])').click(function() {

            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                var target = $(this.hash);

                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top - 170
                    }, 500);
                    return false;
                }
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $(".fw-cc1").css("display", "none");
            $(".fw-cct1").click(function() {
                $(".fw-cc1").slideToggle();
            });
            $(".fw-cc").css("display", "none");
            $(".fw-cct").click(function() {
                $(".fw-cc").slideToggle();
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#GetCard").click(function() {
                $('#ComingSoon').modal('show');
            });

            
        });
    </script>