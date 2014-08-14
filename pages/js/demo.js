/**
 * Created by jacky on 14-8-11.
 */

function getData(){
    var req;
    if (window.XMLHttpRequest){
        req = new XMLHttpRequest();
        req.onreadystatechange = function(){
            if (req.readyState == 4 && req.status == 200){
                var oldText = document.getElementById('userTbl').innerHTML;
                document.getElementById('userTbl').innerHTML = oldText + parseUserDetail(req.responseText);
            }
        }

        req.open('GET', 'http://127.0.0.1:8080/myjober/api?r=user/detail&uid=1&id=1', true);
        req.send();

        return req.onreadystatechange.returnValue;
    }

    return null;
}
function loadUserInfo(){
    getData();
}

function parseUserDetail(data){
    var parsedData = JSON.parse(data);
    var output = '';
    if (parsedData['return number'] > 0){
        for (var i=0; i < parsedData['data'].length; i++){
            output += parseUserData(parsedData['data'][i]);
        }
    }

    return output;
}

function parseUserData(data){
    var output = '';
//    for(var i = 0; i< data.length; i++){
    output += "<tr><td style='text-align: left'>user name:</td><td>" + data['username'] + "</td></tr>";
    output += "<tr><td style='text-align: left'>profile:</td><td>" + data['profile'] + "</td></tr>";

//    }

    return output;
}