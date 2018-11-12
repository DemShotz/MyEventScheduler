var today = new Date();
if (year === undefined) {
     var year = today.getFullYear();
}
if (setMonth === undefined) {
     var setMonth = today.getMonth();
}
var firstDay = 1;
var setDay = new Date(year, setMonth, firstDay).getDay();
var daysinCurrentmonth = new Date(year, setMonth + 1, 0).getDate();
var dateNumber = 0;
var jobTotal = 0;
var counter = 0;
var starting = 0;
var ending = 0;
var clickedDate = 0;

function stopProp(event) {
     event.stopPropagation();
}

function clickedThis(event) {
     thisDay(event);
     storeAcross();
     window.location.href = 'addEvent.php';
}

function resetMenu() {
     var current = document.getElementById("menu");

     if (window.getComputedStyle(current).getPropertyValue("display") == "none") {
          current.style.display = "inline-block";
          setTimeout(function() {current.style.opacity = "100"}, 1);
     } else if (current.style.display == "inline-block") {
          current.style.opacity = "0";
          setTimeout(function() {current.style.display = "none"}, 1000);
     }
}

function makeCalendar() {
     var monthHeader = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
     var firstDates = document.getElementsByTagName("td");
     var calendarDay = document.getElementsByTagName("th");

     if (today.getMonth() != setMonth) {
          document.getElementById("returnCurrent").style.display="inline-block";
     } else {
          document.getElementById("returnCurrent").style.display="none";
     }
     if (today.getFullYear() != year) {
          document.getElementById("returnCurrent").style.display="inline-block";
     }

     daysinCurrentmonth = new Date(year, setMonth + 1, 0).getDate();
     setDay = new Date(year, setMonth, firstDay).getDay();

     document.getElementById("date").innerHTML = monthHeader[setMonth] + " " + year;

     if (daysinCurrentmonth > 30 && setDay == 5 || setDay == 6) {
          document.getElementById("addedPotato").style.display = "table-row";
     } else {
          document.getElementById("addedPotato").style.display = "none";
     }

     var filteredInput = [];
     if (typeof rowArray !== 'undefined') {
          for (i = 0; i < rowArray.length; i++) {
               var forEvent = rowArray[i].split(" from ");
               var seteventMonth = forEvent[0].split(" ");
               var seteventDay = seteventMonth[1];
               var seteventYear = seteventMonth[2];
               seteventMonth = monthHeader.indexOf(seteventMonth[0]);

               if (setMonth == seteventMonth) {
                    filteredInput.push(rowArray[i].match(seteventMonth[0]).input);
               }
          }
     }

     for (i = 0; i < daysinCurrentmonth; i++) {
          firstDates[setDay].innerHTML = dateNumber + 1;
          if (firstDates[setDay].innerHTML != "") {
               firstDates[setDay].addEventListener("click", clickedThis);
               firstDates[setDay].setAttribute("class", "madeUp");
          }

          var containerThis = document.createElement("div");
          containerThis.setAttribute("class", "dayContainer");

          if (typeof filteredInput !== 'undefined') {
               for (f = 0; f < filteredInput.length; f++) {
                    var forEvent = filteredInput[f].split(" from ");
                    var seteventMonth = forEvent[0].split(" ");
                    var seteventDay = seteventMonth[1];
                    var seteventYear = seteventMonth[2];
                    seteventMonth = monthHeader.indexOf(seteventMonth[0]);

                    if (year == seteventYear && setMonth == seteventMonth && seteventDay == firstDates[setDay].firstChild.data) {
                         var createMe = document.createElement("div");
                         var innerTime = forEvent[1].split(" with ");

                         if (thePref == 12) {
                              var innerFixed = innerTime[0].split(" until ");
                              for (g = 0; g < innerFixed.length; g++) {
                                   var splitColon = innerFixed[g].split(":");
                                   splitColon[0] = parseInt(splitColon[0]);
                                   if (splitColon[0] >= 12) {
                                        if (splitColon[0] == 12) {
                                             innerFixed[g] = splitColon[0] + ":" + splitColon[1] + "PM";
                                        } else {
                                             splitColon[0] = Math.abs(12 - splitColon[0]);
                                             innerFixed[g] = splitColon[0] + ":" + splitColon[1] + "PM";
                                        }
                                   } else if (splitColon[0] == 0) {
                                        splitColon[0] = 12;
                                        innerFixed[g] = splitColon[0] + ":" + splitColon[1] + "AM";
                                   } else {
                                        innerFixed[g] = splitColon[0] + ":" + splitColon[1] + "AM";
                                   }
                              }
                              innerTime[0] = innerFixed[0] + " until " + innerFixed[1];
                         }

                         var extraStuff = innerTime[1].split(" event id ");
                         var breakTime = extraStuff[0];
                         var color = extraStuff[1].split(" color='")
                         var jobId = color[0];
                         var theColor = color[1];
                         createMe.setAttribute("class", "event-info");
                         createMe.setAttribute("name", jobId);
                         createMe.setAttribute("onclick", "editEvent(event);");
                         createMe.setAttribute("style", "border-left-color: " + theColor + ";");
                         createMe.addEventListener("click", stopProp);
                         createMe.innerHTML = innerTime[0];
                         containerThis.appendChild(createMe);
                    }
               }
          }


          if (typeof customArray !== 'undefined') {
               for (f = 0; f < customArray.length; f++) {
                    var forEvent = customArray[f].split(" 56split698f ");
                    var forEvent1 = forEvent[0].split(" ");
                    var setEventMonth = forEvent1[0];
                    var setEventDay = forEvent1[1];
                    var setEventYear = forEvent1[2];
                    setEventMonth = monthHeader.indexOf(setEventMonth);
                    if (year == setEventYear && setMonth == setEventMonth && setEventDay == firstDates[setDay].firstChild.data) {
                         var createMe = document.createElement("div");
                         var innerStuff = forEvent[1];
                         var eventId = forEvent[2];
                         createMe.setAttribute("class", "event-info");
                         createMe.setAttribute("name", eventId);
                         createMe.setAttribute("onclick", "editEvent(event);");
                         createMe.addEventListener("click", stopProp);
                         createMe.innerHTML = innerStuff;
                         containerThis.appendChild(createMe);
                    }
               }
          firstDates[setDay].appendChild(containerThis);
          }

          if(today.getMonth() == setMonth) {
               if (today.getDate() == firstDates[setDay].firstChild.data) {
                    firstDates[setDay].style.backgroundColor = "#5A5A5A";
                    firstDates[setDay].id = "gray";
               }
          }
          dateNumber++;
          setDay++;
     }

     for (i = 0; i < calendarDay.length; i++) {
          if(today.getMonth() == setMonth && today.getDay() == calendarDay[i].id) {
               calendarDay[i].setAttribute("name", "today");
               calendarDay[i].style.backgroundColor = "rgba(17, 45, 238, 0.75)";
          }
     }
}

function swipeRight() {
     var monthHeader = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
     var firstDates = document.getElementsByTagName("td");
     var calendarDay = document.getElementsByTagName("th");

     setMonth = setMonth + 1;

     daysinCurrentmonth = new Date(year, setMonth + 1, 0).getDate();

     if(setMonth == 12) {
          setMonth = 0;
          year = year + 1;
     }

     dateNumber = 0;

     setDay = new Date(year, setMonth, firstDay).getDay();

     if (today.getMonth() != setMonth) {
          document.getElementById("returnCurrent").style.display="inline-block";
     } else {
          document.getElementById("returnCurrent").style.display="none";
     }
     if (today.getFullYear() != year) {
          document.getElementById("returnCurrent").style.display="inline-block";
     }

     if (document.getElementById("gray")) {
          document.getElementById("gray").style.backgroundColor = "transparent";
     }
     if (document.getElementsByName("today")[0]) {
          document.getElementsByName("today")[0].style.backgroundColor = "#3FB6FF";
     }

     document.getElementById("date").innerHTML = monthHeader[setMonth] + " " + year;

     if (daysinCurrentmonth > 30 && setDay == 5 || setDay == 6) {
          document.getElementById("addedPotato").style.display = "table-row";
     } else {
          document.getElementById("addedPotato").style.display = "none";
     }

     for (i = 0; i < firstDates.length; i++) {
          firstDates[i].innerHTML = "";
     }

     for (i = 0; i < daysinCurrentmonth; i++) {
          firstDates[setDay].innerHTML = dateNumber + 1;
          if (firstDates[setDay].innerHTML != "") {
               firstDates[setDay].addEventListener("click", clickedThis);
               firstDates[setDay].setAttribute("class", "madeUp");
          }

          var containerThis = document.createElement("div");
          containerThis.setAttribute("class", "dayContainer");

          if (typeof rowArray !== 'undefined') {
               for (f = 0; f < rowArray.length; f++) {
                    var forEvent = rowArray[f].split(" from ");
                    var seteventMonth = forEvent[0].split(" ");
                    var seteventDay = seteventMonth[1];
                    var seteventYear = seteventMonth[2];
                    seteventMonth = monthHeader.indexOf(seteventMonth[0]);
                    if (year == seteventYear && setMonth == seteventMonth && seteventDay == firstDates[setDay].firstChild.data) {
                         var createMe = document.createElement("div");
                         var innerTime = forEvent[1].split(" with ");

                         if (thePref == 12) {
                              var innerFixed = innerTime[0].split(" until ");
                              for (g = 0; g < innerFixed.length; g++) {
                                   var splitColon = innerFixed[g].split(":");
                                   splitColon[0] = parseInt(splitColon[0]);
                                   if (splitColon[0] >= 12) {
                                        splitColon[0] = Math.abs(12 - splitColon[0]);
                                        innerFixed[g] = splitColon[0] + ":" + splitColon[1] + "PM";
                                   } else {
                                        innerFixed[g] = splitColon[0] + ":" + splitColon[1] + "AM";
                                   }
                              }
                              innerTime[0] = innerFixed[0] + " until " +innerFixed[1];
                         }

                         var extraStuff = innerTime[1].split(" event id ");
                         var breakTime = extraStuff[0];
                         var color = extraStuff[1].split(" color='")
                         var jobId = color[0];
                         var theColor = color[1];
                         createMe.setAttribute("class", "event-info");
                         createMe.setAttribute("name", jobId);
                         createMe.setAttribute("onclick", "editEvent(event);");
                         createMe.setAttribute("style", "border-left-color: " + theColor + ";");
                         createMe.addEventListener("click", stopProp);
                         createMe.innerHTML = innerTime[0];
                         containerThis.appendChild(createMe);
                    }
               }
          }

          if (typeof customArray !== 'undefined') {
               for (f = 0; f < customArray.length; f++) {
                    var forEvent = customArray[f].split(" 56split698f ");
                    var forEvent1 = forEvent[0].split(" ");
                    var setEventMonth = forEvent1[0];
                    var setEventDay = forEvent1[1];
                    var setEventYear = forEvent1[2];
                    setEventMonth = monthHeader.indexOf(setEventMonth);
                    if (year == setEventYear && setMonth == setEventMonth && setEventDay == firstDates[setDay].firstChild.data) {
                         var createMe = document.createElement("div");
                         var innerStuff = forEvent[1];
                         var eventId = forEvent[2];
                         createMe.setAttribute("class", "event-info");
                         createMe.setAttribute("name", eventId);
                         createMe.setAttribute("onclick", "editEvent(event);");
                         createMe.addEventListener("click", stopProp);
                         createMe.innerHTML = innerStuff;
                         containerThis.appendChild(createMe);
                    }
               }
          firstDates[setDay].appendChild(containerThis);
          }

          if(today.getMonth() == setMonth && today.getDate() == firstDates[setDay].firstChild.data) {
               firstDates[setDay].style.backgroundColor = "#5A5A5A";
               firstDates[setDay].id = "gray";
          }
          dateNumber++;
          setDay++;
     }

     for(i = 0; i < firstDates.length; i++) {
          if (firstDates[i].innerHTML == "") {
               firstDates[i].removeAttribute("onclick", "showEvent(event)");
               firstDates[i].removeAttribute("class", "madeUp");
          }
     }

     for (i = 0; i < calendarDay.length; i++) {
          if(today.getMonth() == setMonth && today.getFullYear() == year && today.getDay() == calendarDay[i].id) {
               calendarDay[i].setAttribute("name", "today");
               calendarDay[i].style.backgroundColor = "rgba(17, 45, 238, 0.75)";
          }
     }
}

function swipeLeft() {
     var monthHeader = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
     var firstDates = document.getElementsByTagName("td");
     var calendarDay = document.getElementsByTagName("th");

     setMonth = setMonth - 1;

     daysinCurrentmonth = new Date(year, setMonth + 1, 0).getDate();

     if(setMonth < 0) {
          setMonth = 11;
          year = year - 1;
     }

     dateNumber = 0;

     setDay = new Date(year, setMonth, firstDay).getDay();

     if (today.getMonth() != setMonth) {
          document.getElementById("returnCurrent").style.display="inline-block";
     } else {
          document.getElementById("returnCurrent").style.display="none";
     }
     if (today.getFullYear() != year) {
          document.getElementById("returnCurrent").style.display="inline-block";
     }

     if (document.getElementById("gray")) {
          document.getElementById("gray").style.backgroundColor = "transparent";
     }
     if (document.getElementsByName("today")[0]) {
          document.getElementsByName("today")[0].style.backgroundColor = "#3FB6FF";
     }

     document.getElementById("date").innerHTML = monthHeader[setMonth] + " " + year;

     if (daysinCurrentmonth > 30 && setDay == 5 || setDay == 6) {
          document.getElementById("addedPotato").style.display = "table-row";
     } else {
          document.getElementById("addedPotato").style.display = "none";
     }

     for (i = 0; i < firstDates.length; i++) { // RESET ALL TD'S
          firstDates[i].innerHTML = "";
     }

     for (i = 0; i < daysinCurrentmonth; i++) {
          firstDates[setDay].innerHTML = dateNumber + 1;
          if (firstDates[setDay].innerHTML != "") {
               firstDates[setDay].addEventListener("click", clickedThis);
               firstDates[setDay].setAttribute("class", "madeUp");
          }

          var containerThis = document.createElement("div");
          containerThis.setAttribute("class", "dayContainer");

          if (typeof rowArray !== 'undefined') {
               for (f = 0; f < rowArray.length; f++) {
                    var forEvent = rowArray[f].split(" from ");
                    var seteventMonth = forEvent[0].split(" ");
                    var seteventDay = seteventMonth[1];
                    var seteventYear = seteventMonth[2];
                    seteventMonth = monthHeader.indexOf(seteventMonth[0]);
                    if (year == seteventYear && setMonth == seteventMonth && seteventDay == firstDates[setDay].firstChild.data) {
                         var createMe = document.createElement("div");
                         var innerTime = forEvent[1].split(" with ");

                         if (thePref == 12) {
                              var innerFixed = innerTime[0].split(" until ");
                              for (g = 0; g < innerFixed.length; g++) {
                                   var splitColon = innerFixed[g].split(":");
                                   splitColon[0] = parseInt(splitColon[0]);
                                   if (splitColon[0] > 12) {
                                        splitColon[0] = Math.abs(12 - splitColon[0]);
                                        innerFixed[g] = splitColon[0] + ":" + splitColon[1] + "PM";
                                   } else {
                                        innerFixed[g] = splitColon[0] + ":" + splitColon[1] + "AM";
                                   }
                              }
                              innerTime[0] = innerFixed[0] + " until " +innerFixed[1];
                         }

                         var extraStuff = innerTime[1].split(" event id ");
                         var breakTime = extraStuff[0];
                         var color = extraStuff[1].split(" color='")
                         var jobId = color[0];
                         var theColor = color[1];
                         createMe.setAttribute("class", "event-info");
                         createMe.setAttribute("name", jobId);
                         createMe.setAttribute("onclick", "editEvent(event);");
                         createMe.setAttribute("style", "border-left-color: " + theColor + ";");
                         createMe.addEventListener("click", stopProp);
                         createMe.innerHTML = innerTime[0];
                         containerThis.appendChild(createMe);
                    }
               }
          }

          if (typeof customArray !== 'undefined') {
               for (f = 0; f < customArray.length; f++) {
                    var forEvent = customArray[f].split(" 56split698f ");
                    var forEvent1 = forEvent[0].split(" ");
                    var setEventMonth = forEvent1[0];
                    var setEventDay = forEvent1[1];
                    var setEventYear = forEvent1[2];
                    setEventMonth = monthHeader.indexOf(setEventMonth);
                    if (year == setEventYear && setMonth == setEventMonth && setEventDay == firstDates[setDay].firstChild.data) {
                         var createMe = document.createElement("div");
                         var innerStuff = forEvent[1];
                         var eventId = forEvent[2];
                         createMe.setAttribute("class", "event-info");
                         createMe.setAttribute("name", eventId);
                         createMe.setAttribute("onclick", "editEvent(event);");
                         createMe.addEventListener("click", stopProp);
                         createMe.innerHTML = innerStuff;
                         containerThis.appendChild(createMe);
                    }
               }
          firstDates[setDay].appendChild(containerThis);
          }

          if(today.getMonth() == setMonth && today.getDate() == firstDates[setDay].firstChild.data) {
               firstDates[setDay].style.backgroundColor = "#5A5A5A";
               firstDates[setDay].id = "gray";
          }
          dateNumber++;
          setDay++;
     }

     for(i = 0; i < firstDates.length; i++) {
          if (firstDates[i].innerHTML == "") {
               firstDates[i].removeAttribute("onclick", "showEvent(event)");
               firstDates[i].removeAttribute("class", "madeUp");
          }
     }

     for (i = 0; i < calendarDay.length; i++) {
          if(today.getMonth() == setMonth && today.getFullYear() == year && today.getDay() == calendarDay[i].id) {
               calendarDay[i].setAttribute("name", "today");
               calendarDay[i].style.backgroundColor = "rgba(17, 45, 238, 0.75)";
          }
     }
}

function deleteJob(event) {
     var confirmMe = confirm("Are you sure you want to delete this job?\nWARNING: This will delete all events set with this job!");
     if (confirmMe == true) {
          var jobName = event.target.parentElement.parentElement.firstChild.innerHTML;
          window.location.href = "sql-testing/deleteJob.php?name=" + jobName;
     } else {
          return;
     }
}

function editJob(event) {
     var jobName = event.target.parentElement.parentElement.firstChild.innerHTML;
     window.location.href = "editJob.php?name=" + jobName;
}

function thisDay(event) {
     clickedDate = event.target.firstChild.data;
     clickedDate = parseInt(clickedDate);
     var test = document.getElementById("clickedDate");
}

function storeAcross() {
     sessionStorage.setItem("year", year);
     sessionStorage.setItem("month", setMonth);
     sessionStorage.setItem("day", clickedDate);
}

function regCheck(form, clickedDate, timeStart, timeEnd, breakTime, jobSelect) {
     if (clickedDate.value == "" || timeStart.value == "" || timeEnd.value == "" || breakTime.value == "" || jobSelect.value == "") {
          alert("You must provide all the requested details. Please try again.");
          return false;
     }
}

function editEvent(event) {
     var jobId = event.target.getAttribute("name");
     window.location.href = "editEvent.php?eventId=" + jobId;
}

function addanotherEvent() {
     var monthHeader = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
     var addanotherDate = document.getElementById("clickedDate").value;
     addanotherDate = addanotherDate.split(" ");
     year = addanotherDate[2];
     setMonth = monthHeader.indexOf(addanotherDate[0]);
     clickedDate = addanotherDate[1];
}

function selectThis(event) {
     var monthHeader = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

     if (counter == 0) {
          if (event.target.localName == "td") {
               starting = setMonth + ", " + event.target.firstChild.data + ", " + year;
               document.getElementById("startMe").style.color = "#5A5A5A";
               document.getElementById("startMe").innerHTML = monthHeader[starting.split(", ")[0]] + ", " + starting.split(", ")[1] + ", " + starting.split(", ")[2];
               event.target.style.backgroundColor = "#5A5A5A";
               event.target.className = event.target.className + " " + event.target.firstChild.data + "-" + setMonth + "-" + year;
               document.getElementById("starting").value = starting;
          } else if (event.target.className == "event-info") {
               starting = setMonth + ", " + event.target.parentElement.parentElement.firstChild.data + ", " + year;
               document.getElementById("startMe").style.color = "#5A5A5A";
               document.getElementById("startMe").innerHTML = monthHeader[starting.split(", ")[0]] + ", " + starting.split(", ")[1] + ", " + starting.split(", ")[2];
               event.target.parentElement.parentElement.style.backgroundColor = "#5A5A5A";
               event.target.parentElement.parentElement.className = event.target.parentElement.parentElement.className + " " + event.target.firstChild.data + "-" + setMonth + "-" + year;
               document.getElementById("starting").value = starting;
          }
     }

     if (counter == 1) {
          if (event.target.localName == "td") {
               ending = setMonth + ", " + event.target.firstChild.data + ", " + year;
               document.getElementById("endMe").style.color = "#5A5A5A";
               document.getElementById("endMe").innerHTML = monthHeader[ending.split(", ")[0]] + ", " + ending.split(", ")[1] + ", " + ending.split(", ")[2];
               event.target.style.backgroundColor = "#5A5A5A";
               event.target.className = event.target.className + " " + event.target.firstChild.data + "-" + setMonth + "-" + year;
               document.getElementById("ending").value = ending;
          } else if (event.target.className == "event-info") {
               ending = setMonth + ", " + event.target.parentElement.parentElement.firstChild.data + ", " + year;
               document.getElementById("endMe").style.color = "#5A5A5A";
               document.getElementById("endMe").innerHTML = monthHeader[ending.split(", ")[0]] + ", " + ending.split(", ")[1] + ", " + ending.split(", ")[2];
               event.target.parentElement.parentElement.style.backgroundColor = "#5A5A5A";
               event.target.parentElement.parentElement.className = event.target.parentElement.parentElement.className + " " + event.target.firstChild.data + "-" + setMonth + "-" + year;
               document.getElementById("ending").value = ending;
          }
     }

     counter = counter + 1;

     if (counter == 2) {
          document.forms[0].submit();
     }
}

function limitText() {
     var element = document.getElementById("customText");
     var limit = 50;

     if (element.value.length > limit) {
          element.value = element.value.substring(0, limit);
     } else {
          document.getElementsByClassName("limit")[0].innerHTML = element.value.length + "/" + limit;
     }
}

function returnCurrent() {
     var resetBoxes = document.getElementsByClassName("madeUp");
     for (i = 0; i < resetBoxes.length; i++) {
          resetBoxes[i].innerHTML = "";
     }
     dateNumber = 0;
     setMonth = today.getMonth();
     year = today.getFullYear();
     makeCalendar();
}

function calculateFix() {
     window.location.href = "sql-testing/calculateHours.pre.inc.php?setMonth=" + setMonth + "&setYear=" + year;
}

function calculateReturn() {
     sessionStorage.setItem("month", setMonth);
     sessionStorage.setItem("year", year);
}
