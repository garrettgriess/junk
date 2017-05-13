// ==UserScript==
// @name    Seconds on Page
// @include *
// @require http://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js
// @grant   none
// ==/UserScript==
$(document).ready(function () {
  if (window.top == window.self) {
    $('<link/>', {
      rel: 'stylesheet',
      type: 'text/css',
      href: 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'
    }).appendTo('head');
    html = '<div id="gg1"><div id="gg2">Time wasted looking at this box:<div id="gg3"><i class="fa fa-clock-o" aria-hidden="true"></i> <div id="gg4"></div></div></div></div>';
    $('body').append(html);
    $('#gg1').css({
      'position': 'fixed',
      'top': '30vh',
      'left': '50vw',
      'z-index': '99999'
    });
    $('#gg2').css({
      'position': 'relative',
      'top': '-90px',
      'left': '-335px',
      'width': '650px',
      'text-align': 'center',
      'color': '#666666',
      'background-color': '#202020',
      'font-family': 'Arial, sans-serif',
      'font-size': '32px',
      'line-height': '32px',
      'border-radius': '20px',
      'opacity': '0.6',
      'padding': '20px',
      'box-shadow': '0px 0px 40px #333333',
      'text-shadow': '2px 2px #000000'
    });
    $('#gg3').css({
      'position': 'relative',
      'top': '-20px',
      'font-size': '64px',
      'line-height': '64px',
      'color': '#999999'
    });
    $('#gg4').css({
      'display': 'inline',
      'position': 'relative',
      'top': '20px',
      'font-size': '128px',
      'line-height': '128px',
      'color': '#ffffff'
    });
    function secondsToString(seconds)
    {
      var numyears = Math.floor(seconds / 31536000);
      var numdays = Math.floor((seconds % 31536000) / 86400);
      var numhours = Math.floor(((seconds % 31536000) % 86400) / 3600);
      var numminutes = Math.floor((((seconds % 31536000) % 86400) % 3600) / 60);
      var numseconds = (((seconds % 31536000) % 86400) % 3600) % 60;
      var numreturn = '';
      if (numyears) {
        numreturn = numreturn + numyears + 'Y ';
      }
      if (numdays) {
        numreturn = numreturn + numdays + 'D ';
      }
      if (numhours) {
        numreturn = numreturn + numhours + ':';
      }
      if (numminutes !== 'undefined') {
        numreturn = numreturn + ('00' + numminutes).slice( - 2) + ':';
      }
      if (numseconds !== 'undefined') {
        numreturn = numreturn + ('00' + numseconds).slice( - 2);
      }
      return numreturn;
    }
    var start = (new Date).getTime();
    function ggLoopForever() {
      setInterval(function () {
        seconds = secondsToString(Math.floor(((new Date).getTime() - start) / 1000));
        $('#gg4').text(seconds);
      }, 1000);
    }
    $(ggLoopForever);
  }
});
