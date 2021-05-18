<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- <link rel="icon" href="<%= BASE_URL %>favicon.ico"> -->

    <title>Learnable</title>
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset(mix('css/main.css')) }}">
      <head>
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      </head>

      <style>
          body {
              font-family: Arial;
          }

          body p {
              text-align: justify;
              font-family: Arial;
          }
          .text span{
              font-weight: normal;
              font-size: 24pt;
              transition: 150ms linear;
              color: grey;
              text-align: left !important;

          }
          .text span.red{
              font-weight:bold;
              color: #0541E0;
              text-align: left !important;

          }
          </style>
      <script type="text/javascript">


          $(function () {


          var text = $('.text').text();
          initText(text);
          function initText(text){
              newText = '';
              for(var i = 0;i<text.length;i++){
                  let letter = text[i];
                  if(letter!=' ')
                      newText += '<span>'+text[i]+'</span>';
                  else
                      newText += ' ';
              }
              $('.text').html(newText);
          }



function goClear(interval) {
    var vid = document.getElementById("vid");

              vid.play();
    clearInterval(interval)

}

          var i = 0;
          var length = $('.text span').length;
          var interval = setInterval(function(){
              let el = $('.text span').get(i);
              $(el).addClass('red');
              i++;
              if(i>length)

                  goClear(interval)
          },70);
          });

          </script>

  </head>
  <body>

  <video id="vid" width="100%" preload="auto">
      <source src="{{asset('newtontrimmed.mp4')}}#t=0.017" type="video/mp4">
  </video>

  <div class="text">Pull one of the spheres side-ways and release it.</div>
<p>
    When one sphere at the end is lifted and released, it strikes the stationary spheres, transmitting a force through the stationary spheres that pushes the last sphere upward.


</p>

  <p>The last sphere swings back and strikes the still nearly stationary spheres, repeating the effect in the opposite direction. The device is named after 17th-century English scientist Sir Isaac Newton. It is also known as Newton's pendulum, Newton's balls, Newton's rocker or executive ball clicker (since the device makes a click each time the balls collide, which they do repeatedly in a steady rhythm).</p>

  <p>
                       Newton's cradle can be modeled fairly accurately with simple mathematical equations with the assumption that the balls always collide in pairs. If one ball strikes four stationary balls that are already touching, these simple equations can not explain the resulting movements in all five balls, which are not due to friction losses. For example, in a real Newton's cradle the fourth has some movement and the first ball has a slight reverse movement. All the animations in this article show idealized action (simple solution) that only occurs if the balls are not touching initially and only collide in pairs.


  </p>

  <p>

      When one of the end balls ("the first") is pulled sideways, the attached string makes it follow an upward arc. When it is let go, it strikes the second ball and comes to nearly a dead stop. The ball on the opposite side acquires most of the velocity of the first ball and swings in an arc almost as high as the release height of the first ball. This shows that the last ball receives most of the energy and momentum of the first ball. </p>

  <p>The impact produces a compression wave that propagates through the intermediate balls. Any efficiently elastic material such as steel does this, as long as the kinetic energy is temporarily stored as potential energy in the compression of the material rather than being lost as heat. There are slight movements in all the balls after the initial strike but the last ball receives most of the initial energy from the impact of the first ball. When two (or three) balls are dropped, the two (or three) balls on the opposite side swing out. Some say that this behavior demonstrates the conservation of momentum and kinetic energy in elastic collisions. However, if the colliding balls behave as described above with the same mass possessing the same velocity before and after the collisions, then any function of mass and velocity is conserved in such an event.


  </p>

  </body>
</html>
