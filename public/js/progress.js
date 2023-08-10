/* const $progressBarEl = document.getElementById("barra_ingresos");

let remainingTime = 60; // seconds
const totalTime = remainingTime;

function countdown() {
  if (remainingTime > 0) {
    // update countdown timer

    // update progress bar
    const progress = ((totalTime - remainingTime) / totalTime) * 1000;
    $progressBarEl.style.width = `${progress}%`;

    remainingTime--;
    setTimeout(countdown, 1000);
  } else {
    // countdown finished
    $progressBarEl.style.width = "100%";
  }
}

countdown(); */


var elementos = document.getElementsByClassName('counter');
//alert(elementos);


elementos.each(function() {
  var $this = $(this),
      countTo = $this.attr('data-count');
  
  $({ countNum: $this.text()}).animate({
    countNum: countTo
  },
  {
    duration: 5000,
    easing:'linear',
    step: function() {
      $this.text(Math.floor(this.countNum));
    },
    complete: function() {
      $this.text(this.countNum);
      //alert('finished');
    }

  });  
  
});