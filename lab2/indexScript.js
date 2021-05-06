const xhr = new XMLHttpRequest();

function getDuties() {
    let shift = document.getElementById("shift").value;
    let department = document.getElementById("department").value;
    xhr.onreadystatechange = () => {
        if (xhr.readyState == 4 && xhr.status == 200) {
            let table = document.getElementById("dutiesTable");
            let result = "";
            let lastReqHtml = "";
            let duties = JSON.parse(xhr.responseText);
            let lastReq = JSON.parse(localStorage.getItem("dutiesByShiftAndDepartment"));
            for (let i = 0; i < duties.length; i++) {
                result += "<tr>";
                result += "<td style = 'border: 1px solid'>" + duties[i].shift + "</td>";
                result += "<td style = 'border: 1px solid'>" + duties[i].date + "</td>";
                result += "<td style = 'border: 1px solid'>" + duties[i].nurse + "</td>";
                result += "<td style = 'border: 1px solid'>" + duties[i].department + "</td>";
                result += "<td style = 'border: 1px solid'>" + duties[i].ward + "</td>";
                result += "</tr>";
            }
            table.innerHTML = result;
            if (lastReq == null) {
                lastReqHtml += "<tr><td style = 'border: 1px solid'> there are no recent reqs </td></tr>";
                document.getElementById("dutiesTablePrev").innerHTML = lastReqHtml;
            }
            else {
                for (let i = 0; i < lastReq.length; i++) {
                    lastReqHtml += "<tr>";
                    lastReqHtml += "<td style = 'border: 1px solid'>" + lastReq[i].shift + "</td>";
                    lastReqHtml += "<td style = 'border: 1px solid'>" + lastReq[i].date + "</td>";
                    lastReqHtml += "<td style = 'border: 1px solid'>" + lastReq[i].nurse + "</td>";
                    lastReqHtml += "<td style = 'border: 1px solid'>" + lastReq[i].department + "</td>";
                    lastReqHtml += "<td style = 'border: 1px solid'>" + lastReq[i].ward + "</td>";
                    lastReqHtml += "</tr>";
                }
                document.getElementById("dutiesTablePrev").innerHTML = lastReqHtml;
            }
            localStorage.setItem("dutiesByShiftAndDepartment", xhr.responseText);
        }
    }
    xhr.open("GET", "getDutiesByShiftAndDepartment.php?shift=" + shift + "&department=" + department);
    xhr.send(null);
}

function getNurses() {
    let department = document.getElementById("department2").value;
    xhr.onreadystatechange = () => {
        if (xhr.readyState == 4 && xhr.status == 200) {
            let table = document.getElementById("nursesTable");
            let result = "";
            let lastReqHtml = "";
            let lastReq = JSON.parse(localStorage.getItem("nursesByDepartment"));
            let nurses = JSON.parse(xhr.responseText);
            nurses.forEach(element => {
                result += "<tr><td style = 'border: 1px solid'>" + element + "</td></tr>";
            });
            table.innerHTML = result;
            if (lastReq == null) {
                lastReqHtml += "<tr><td style = 'border: 1px solid'> there are no recent reqs </td></tr>";
                document.getElementById("nursesTablePrev").innerHTML = lastReqHtml;
            }
            else {
                lastReq.forEach(element => {
                    lastReqHtml += "<tr><td style = 'border: 1px solid'>" + element + "</td></tr>";
                });
                document.getElementById("nursesTablePrev").innerHTML = lastReqHtml;
            }
            localStorage.setItem("nursesByDepartment", xhr.responseText);
        }
    }
    xhr.open("GET", "getNurseByDepartment.php?department=" + department);
    xhr.send(null);
}


function getWards() {
    let nurse = document.getElementById("nurse").value;
    xhr.onreadystatechange = () => {
        if (xhr.readyState == 4 && xhr.status == 200) {
            let table = document.getElementById("wardsTable");
            let result = "";
            let lastReqHtml = "";
            let lastReq = JSON.parse(localStorage.getItem("wardsByNurse"));
            let wards = JSON.parse(xhr.responseText);
            for (ward in wards) {
                result += "<tr><td style = 'border: 1px solid'>" + wards[ward] + "</td></tr>";
            }
            table.innerHTML = result;
            if (lastReq == null) {
                lastReqHtml += "<tr><td style = 'border: 1px solid'> there are no recent reqs </td></tr>";
                document.getElementById("wardsTablePrev").innerHTML = lastReqHtml;
            }
            else {
                for (element in lastReq) {
                    lastReqHtml += "<tr><td style = 'border: 1px solid'>" + lastReq[element] + "</td></tr>";
                }
                document.getElementById("wardsTablePrev").innerHTML = lastReqHtml;
            }
            localStorage.setItem("wardsByNurse", xhr.responseText);
        }
    }
    xhr.open("GET", "getWardsByNurse.php?nurse=" + nurse);
    xhr.send(null);
}