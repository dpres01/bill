function panier(elem, json) {

    //let elem = document.getElementById(id);
    let modal = document.getElementById('modal');
    //console.log( 'test');
    if (json != '') {
        let tableau = JSON.parse(json);
    
        for (var i = 0; i < tableau.length; i++) {
            let li = document.createElement("li");
            li.appendChild(document.createTextNode(tableau[i].firstName.concat(' ', tableau[i].lastName)));
            elem.append(li);
        }
        
        if (tableau.length) {
            modal.setAttribute('style','display:block');
        }
    }
    //return 'error';
}

export default panier;