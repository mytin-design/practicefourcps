//Tabs for log in

function startlogTab(evt, logger) {
    let logtabbtn, logtabcontent, l;
  
  
    //Get all tabcontents and hide
  
    logtabcontent = document.getElementsByClassName('logtabcontent');
  
    for(l = 0; l < logtabcontent.length;l++) {
      logtabcontent[l].style.display = "none";
    }
  
  //Get buttons, and hide the active class
  logtabbtn = document.getElementsByClassName('logtabbtn');
  
  for(l = 0; l < logtabbtn.length; l++ ) {
    logtabbtn[l].className = logtabbtn[l].className.replace('active', "");
  
  }
  
  
  //Show the current tab, and add the active class to the button that opened it;
  
  document.getElementById(logger).style.display = "block";
  evt.currentTarget.className += "active";
  
  }
  
  document.getElementById("defaultLog").click();
  
  