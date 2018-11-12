var today = new Date();
if (year === undefined) {
     var year = today.getFullYear();
}
if (setMonth === undefined) {
     var setMonth = today.getMonth();
}
var firstDay = 1;
var setfirstDay = new Date(year, setMonth, firstDay).getDay();
var daysinCurrentmonth = new Date(year, setMonth + 1, 0).getDate();
var dateNumber = 0;
var jobTotal = 0;
var counter = 0;
var starting = 0;
var ending = 0;
var clickedDate = 0;

function returnCurrent() {
    setMonth = today.getMonth();
    year = today.getFullYear();
    makeCalendar();
}

function stopProp(event) {
     event.stopPropagation();
}

function resetMenu() {
     var current = document.getElementById("menu");
     if (window.getComputedStyle(current).getPropertyValue("display") == "none") {
          current.style.display = "inline-block";
     } else if (current.style.display == "inline-block") {
          current.style.display = "none";
     }
}

function makeCalendar() {
     var monthHeader = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
     var tableCells = document.getElementsByTagName("td");
     var weekDay = document.getElementsByTagName("th");

     if (today.getMonth() != setMonth) { // Shows/Hides the return button
          document.getElementById("returnCurrent").style.display = "inline-block";
     } else {
          document.getElementById("returnCurrent").style.display = "none";
     }
     if (today.getFullYear() != year) {
          document.getElementById("returnCurrent").style.display = "inline-block";
     }

     daysinCurrentmonth = new Date(year, setMonth + 1, 0).getDate(); // Resets variable
     setfirstDay = new Date(year, setMonth, firstDay).getDay(); // 0 Indexed. Determines which day of the week the calendar starts on.
     dateNumber = 0 // Resets the number which goes in cells

     document.getElementById("date").innerHTML = monthHeader[setMonth] + " " + year; // Inserts month and year in H1

     if (daysinCurrentmonth > 30 && setfirstDay == 5 || setfirstDay == 6) { // Determines whether or not to add the 6th row
          document.getElementById("addedPotato").style.display = "table-row";
     } else {
          document.getElementById("addedPotato").style.display = "none";
     }

     var filteredInput = [];  // Filters the rowArray down to only the current month
     if (typeof rowArray !== 'undefined') {
          for (i = 0; i < rowArray.length; i++) {
               if (rowArray[i].match(monthHeader[setMonth]) !== null) {
                    filteredInput.push(rowArray[i].match(monthHeader[setMonth]).input);
               }
          }
     }

     for (i = 0; i < daysinCurrentmonth; i++) { // For every day in the month
          tableCells[setfirstDay].innerHTML = dateNumber + 1;
          if (tableCells[setfirstDay].innerHTML != "") {
               tableCells[setfirstDay].addEventListener("click", clickedThis);
               tableCells[setfirstDay].setAttribute("class", "madeUp");
          }

          var containerThis = document.createElement("div"); // Creates div containing all daily events
          containerThis.setAttribute("class", "dayContainer");

          if (typeof filteredInput !== 'undefined') {
               for (f = 0; f < filteredInput.length; f++) {
                    var forEvent = filteredInput[f].split(" from "); // Splits Month/day/year from time

                    var monthDayYear = forEvent[0].split(" "); // Splits month/day/year into it's own var
                    var seteventDay = monthDayYear[1];
                    var seteventYear = monthDayYear[2];
                    var seteventMonth = monthHeader.indexOf(monthDayYear[0]);

                    if (year == seteventYear && setMonth == seteventMonth && seteventDay == tableCells[setfirstDay].firstChild.data) {
                         var createMe = document.createElement("div"); // Creates time div
                         var innerTime = forEvent[1].split(" with "); // splits timestart/end from breaktime and eventID

                         if (thePref == 12) { // If user prefers 12 hour time
                              var innerFixed = innerTime[0].split(" until "); // Split timestart from timeend
                              for (g = 0; g < innerFixed.length; g++) { // Will always be 2. First run cleans up timestart, second one cleans up timeend
                                   var splitColon = innerFixed[g].split(":"); // Split hour from minute
                                   splitColon[0] = parseInt(splitColon[0]); // Convert from string to integer
                                   if (splitColon[0] > 12) { // If it's in the PM
                                        splitColon[0] = Math.abs(12 - splitColon[0]);
                                        innerFixed[g] = splitColon[0] + ":" + splitColon[1] + "PM";
                                   } else if (splitColon[0] == 12) { // If it's noon
                                        innerFixed[g] = splitColon[0] + ":" + splitColon[1] + "PM";
                                   } else { // If it's in the AM
                                        innerFixed[g] = splitColon[0] + ":" + splitColon[1] + "AM";
                                   }
                              }
                              innerTime[0] = innerFixed[0] + " until " + innerFixed[1];
                         }
                         var extraStuff = innerTime[1].split(" event id "); // Splits breaktime from eventID
                         var breakTime = extraStuff[0]; // sets breakTime variable
                         var colour = extraStuff[1].split(" color='"); // splits jobID and colour
                         var jobId = colour[0]; // sets jobId
                         var theColour = colour[1].split(" jobName")[0]; // sets colour

                         // Builds div attribute
                         createMe.setAttribute("class", "event-info");
                         createMe.setAttribute("name", jobId);
                         createMe.setAttribute("onclick", "editEvent(event);");
                         createMe.setAttribute("style", "border-left-color: " + theColour + ";");
                         createMe.addEventListener("click", stopProp);
                         createMe.innerHTML = innerTime[0];
                         containerThis.appendChild(createMe); // Appends created event div to day event div
                    }
               }
          }
          // Cycles through custom events
          if (typeof customArray !== 'undefined') {
               for (f = 0; f < customArray.length; f++) {
                    var customSplit = customArray[f].split(" 56split698f "); // customSplit1 = Month, Day, Year // customSplit = customText & eventId
                    var customSplit1 = customSplit[0].split(" ");
                    var setEventMonth = monthHeader.indexOf(customSplit1[0]);
                    var setEventDay = customSplit1[1];
                    var setEventYear = customSplit1[2];
                    if (year == setEventYear && setMonth == setEventMonth && setEventDay == tableCells[setfirstDay].firstChild.data) { // If it's rendering the right day
                         var createMe = document.createElement("div");
                         var customText = customSplit[1];
                         var eventId = customSplit[2];
                         createMe.setAttribute("class", "event-info");
                         createMe.setAttribute("name", eventId);
                         createMe.setAttribute("onclick", "editEvent(event);");
                         createMe.addEventListener("click", stopProp);
                         createMe.innerHTML = customText;
                         containerThis.appendChild(createMe); // Appends created event div to day event div
                    }
               }
          tableCells[setfirstDay].appendChild(containerThis); // Appends entire day container to the corresponding day
          }
          if (today.getFullYear() == year && today.getMonth() == setMonth && today.getDate() == tableCells[setfirstDay].firstChild.data) {
               tableCells[setfirstDay].style.backgroundColor = "#5A5A5A";
               tableCells[setfirstDay].id = "gray";
          }
          setfirstDay++;
          dateNumber++;
     }

     for (i = 0; i < weekDay.length; i++) { // changes current weekdays colour
          if (today.getMonth() == setMonth && today.getDay() == weekDay[i].id) {
               weekDay[i].setAttribute("name", "today");
               weekDay[i].style.backgroundColor = "rgba(17, 45, 238, 0.75)";
          }
     }
}

function swipeRight() {
     var tableCells = document.getElementsByTagName("td"); // Adds all table cells in one var
     if (document.getElementsByName("today") && document.getElementById("gray")) { // Adds all table cells in one var
          document.getElementsByName("today")[0].style.backgroundColor = "#3FB6FF";
          document.getElementById("gray").style.backgroundColor = "#32383d";
     }
     for (i = 0; i < tableCells.length; i++) { // Resets all innerHTML's
          tableCells[i].innerHTML = "";
     }

     setMonth = setMonth + 1; // Next month

     if (setMonth == 12) { // If you go into the next year
          year = year + 1;
          setMonth = 0;
     }
     makeCalendar(); // RENDER
}

function swipeLeft() {
     var tableCells = document.getElementsByTagName("td"); // Adds all table cells in one var
     if (document.getElementsByName("today") && document.getElementById("gray")) { // Adds all table cells in one var
          document.getElementsByName("today")[0].style.backgroundColor = "#3FB6FF";
          document.getElementById("gray").style.backgroundColor = "#32383d";
     }
     for (i = 0; i < tableCells.length; i++) { // Resets all innerHTML's
          tableCells[i].innerHTML = "";
     }

     setMonth = setMonth - 1; // Previous month

     if (setMonth == -1) { // Previous year
          year = year - 1;
          setMonth = 11;
     }
     makeCalendar(); // RENDER
}

function clickedThis(event) {
     clickedDate = event.target.firstChild.data;
     clickedDate = parseInt(clickedDate);
     sessionStorage.setItem("year", year);
     sessionStorage.setItem("month", setMonth);
     sessionStorage.setItem("day", clickedDate);
     window.location.href = "addEvent.php";
}

function deleteJob(event) { // Executes delete job function
     var confirmMe = confirm("Are you sure you want to delete this job?\nWARNING: This will delete all events set with this job!");
     if (confirmMe == true) {
          var jobName = event.target.parentElement.parentElement.firstChild.innerHTML;
          window.location.href = "sql-testing/deleteJob.php?name=" + jobName;
     } else {
          return;
     }
}

function editJob(event) { // Transfers job to editJob page
     var jobName = event.target.parentElement.parentElement.firstChild.innerHTML;
     window.location.href = "editJob.php?name=" + jobName;
}

function editEvent(event) { // Transfers event to editEvent page
     var jobId = event.target.getAttribute("name");
     window.location.href = "editEvent.php?eventId=" + jobId;
}

function addanotherEvent() { // Transfers clickedDate to addEvent page
     var monthHeader = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
     var addanotherDate = document.getElementById("clickedDate").value; // Gets RAW value
     addanotherDate = addanotherDate.split(" "); // Splits text into usable parts
     year = addanotherDate[2];
     setMonth = monthHeader.indexOf(addanotherDate[0]);
     clickedDate = addanotherDate[1];
     sessionStorage.setItem("year", year);
     sessionStorage.setItem("month", setMonth);
     sessionStorage.setItem("day", clickedDate);
}

function calculateFix() {
     window.location.href = "sql-testing/calculateHours.pre.inc.php?setMonth=" + setMonth + "&setYear=" + year;
}

function selectThis(event) { // Calculate Hours date range selection
     var monthHeader = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

     if (counter == 0) { // Starting date
          if (event.target.localName == "td") { // If you click over a cell
               starting = setMonth + ", " + event.target.firstChild.data + ", " + year;
               document.getElementById("startMe").style.color = "#5A5A5A";
               document.getElementById("startMe").innerHTML = monthHeader[starting.split(", ")[0]] + ", " + starting.split(", ")[1] + ", " + starting.split(", ")[2]; // Places date in Select Start Date Box
               event.target.style.backgroundColor = "#5A5A5A"; // Shows this date was selected
               event.target.className = event.target.className + " " + event.target.firstChild.data + "-" + setMonth + "-" + year; // Adds date as class name for ease of use
               document.getElementById("starting").value = starting; // Invisible data entry point
          } else if (event.target.className == "event-info") { // If you click over an event
               starting = setMonth + ", " + event.target.parentElement.parentElement.firstChild.data + ", " + year;
               document.getElementById("startMe").style.color = "#5A5A5A";
               document.getElementById("startMe").innerHTML = monthHeader[starting.split(", ")[0]] + ", " + starting.split(", ")[1] + ", " + starting.split(", ")[2];
               event.target.parentElement.parentElement.style.backgroundColor = "#5A5A5A";
               event.target.parentElement.parentElement.className = event.target.parentElement.parentElement.className + " " + event.target.firstChild.data + "-" + setMonth + "-" + year;
               document.getElementById("starting").value = starting;
          }
     }

     if (counter == 1) { // Ending date
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

     if (counter == 2) { // Once you've clicked two dates, submit form.
          document.forms[0].submit();
     }
}

function calculateReturn() {
     sessionStorage.setItem("month", setMonth);
     sessionStorage.setItem("year", year);
}

function limitText() { // For custom events text limitation
     var element = document.getElementById("customText");
     var limit = 50;

     if (element.value.length > limit) {
          element.value = element.value.substring(0, limit);
     } else {
          document.getElementsByClassName("limit")[0].innerHTML = element.value.length + "/" + limit;
     }
}

function regCheck(form, clickedDate, timeStart, timeEnd, breakTime, jobSelect) {
     if (clickedDate.value == "" || timeStart.value == "" || timeEnd.value == "" || breakTime.value == "" || jobSelect.value == "") {
          alert("You must provide all the requested details. Please try again");
          return false;
     }
}
