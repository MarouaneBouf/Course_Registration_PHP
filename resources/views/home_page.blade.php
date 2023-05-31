<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./style_homePage.css" />
    <link rel="icon" href="./images/metamask.png" />
    <script src="./script_homePage.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link
      href="https://api.fontshare.com/v2/css?f[]=switzer@700,400&f[]=gambarino@400&display=swap"
      rel="stylesheet"
    />
    <title>Challenge03</title>
  </head>
  <body>
    <div class="container">
      <div id="header">
        <a href="./home_page.html"><p>HOME</p></a>
        <div id="main_logo">
          <img src="./images/metamask-logo-white.png" alt="Logo" width="100%" />
        </div>
        <a href="./about.html"><p>ABOUT US</p></a>
      </div>
      <div id="line"></div>
      <div id="heading">
        <div id="info">
          <div id="circle"></div>
          <p>AVAILABLE FOR WORK</p>
        </div>
        <h2>Course Management</h2>
        <p>University courses registration</p>
        <div id="welcome_div" style="display: none">
          <a href="./choice.html"
            ><button id="welcome"><p>WELCOME</p></button></a
          >
        </div>
      </div>
    </div>
    <div class="second_section" id="why">
      <h2>WHY METAMASK?</h2>
    </div>
    <div class="third_section">
      <div class="third_left_section">
        Launch<br />
        in a click
      </div>
      <div class="third_right_section">
        <p>
          METAMASK simplifies course registration management in universities
          with a user-friendly web application built using PHP, HTML, CSS, and
          JS. Launch changes with one click and eliminate technicalities. Say
          goodbye to traditional systems with METAMASK.
        </p>
      </div>
    </div>
    <div class="third_section">
      <div class="third_left_section">
        Easy to<br />
        use
      </div>
      <div class="third_right_section">
        <p>
          METAMASK simplifies course registration with an intuitive interface,
          clear navigation, and customization options. Say goodbye to
          complicated processes and hello to effortless registration management.
        </p>
      </div>
    </div>
    <div class="third_section">
      <div class="third_left_section">Safe & Trusted<br /></div>
      <div id="companies">
        <img src="./images/footer2.png" alt="Companies" width="130%" />
      </div>
    </div>
    <div class="container1">
      <div id="line"></div>
      <div id="header">
        <a href="./home_page.html"><p>2023 METAMASK</p></a>
        <p>PROJET DEVELOPPEMENT WEB</p>
        <a href="./home_page.html#why"><p>Why METAMASK?</p></a>
      </div>
    </div>
  </body>
</html>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    $(document).ready(function () {
      $(window).scroll(function () {
        $(".second_section").css(
          "opacity",
          $(window).scrollTop() / $(".second_section").height()
        );
      });
    });
  });
</script>
