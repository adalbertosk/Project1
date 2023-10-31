window.addEventListener('load', function (event) {
    var url = 'index.php';
    let newItem = '';
    fetch(url, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
        .then((response) => response.json())
        .then((data) => {
            data.message.forEach((itemLine) => {
                newItem += "<tr>";
                newItem += `<td><input type="number" value="` + itemLine.id + `" readonly></td>`;
                newItem += `<td><input type="text" value="` + itemLine.name + `"></td>`;
                newItem += `<td><input type="date" value="` + itemLine.birthdate + `"></td>`;
                newItem += `<td><input type="text" value="` + itemLine.gender + `"></td>`;
                newItem += `<td><input type="text" value="` + itemLine.maritalstatus + `"></td>`;
                newItem += `<td><input type="text" value="` + itemLine.taxid + `"></td>`;
                newItem += `<td><input type="text" value="` + itemLine.phone + `"></td>`;
                newItem += `<td><input type="email" value="` + itemLine.email + `"></td>`;
                newItem += `<td><input type="text" value="` + itemLine.created_at + `" readonly></td>`;
                newItem += `<td><input type="button" value="Delete" onclick="deleteRow(this)"></td>`
                newItem += "</tr>";
            });
            document.getElementById("data").innerHTML = newItem;
        });
});

function deleteRow(r) {
    var i = r.parentNode.parentNode.rowIndex;
    var delItem = document.getElementById("myTable").rows[i].cells[0].childNodes[0].value;
    var url = 'index.php?id=' + delItem;
    fetch(url, {
        method: 'DELETE',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
        .then((response) => response.json())
        .then((data) => {
            console.log(data.message);
        });

    document.getElementById("myTable").deleteRow(i);
}

document.getElementById("btn_create").onclick = function () {
    openForm();
/* 
    var name = document.getElementById("in_name").value;
    var birthdate = document.getElementById("in_birthdate").value;
    var gender = document.getElementById("sel_gender").value;
    var maritalstatus = document.getElementById("sel_maritalstatus").value;
    var taxid = document.getElementById("in_taxid").value;
    var phone = document.getElementById("in_phone").value;
    var email = document.getElementById("in_email").value;
    fetch('index.php', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify({
            //		                id:
            name: name,
            birthdate: birthdate,
            gender: gender,
            maritalstatus: maritalstatus,
            taxid: taxid,
            phone: phone,
            email: email
            //                        created_at: 
        })
    })
        .then((response) => response.json())
        .then((data) => {
            console.log(data.message);
        });
 */    
}

document.getElementById("btn_save").onclick = function () {
    var myTable = document.getElementById("myTable");
    for (let i = 1; i < myTable.rows.length; i++) {
        var id = myTable.rows[i].cells[0].childNodes[0].value;
        var name = myTable.rows[i].cells[1].childNodes[0].value;
        var birthdate = myTable.rows[i].cells[2].childNodes[0].value;
        var gender = myTable.rows[i].cells[3].childNodes[0].value;
        var maritalstatus = myTable.rows[i].cells[4].childNodes[0].value;
        var taxid = myTable.rows[i].cells[5].childNodes[0].value;
        var phone = myTable.rows[i].cells[6].childNodes[0].value;
        var email = myTable.rows[i].cells[7].childNodes[0].value;

        var url = "index.php?id=" + id;
        fetch(url, {
            method: 'PUT',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify({
                id: id,
                name: name,
                birthdate: birthdate,
                gender: gender,
                maritalstatus: maritalstatus,
                taxid: taxid,
                phone: phone,
                email: email
                //                        created_at: 
            })
        })
            .then((response) => response.json())
            .then((data) => {
                console.log(data.message);
            });
    }
}

function openForm() {
    document.getElementById("myForm").style.display = "block";
  }
  
  function closeForm() {
    document.getElementById("myForm").style.display = "none";
  }
  