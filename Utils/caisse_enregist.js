// Fonctions  SNACKS
function saveSnacks(snacks){
    localStorage.setItem("snacks",JSON.stringify(snacks));
}
function getSnacks(){
    let snacks=localStorage.getItem("snacks");
    if(snacks){
        return JSON.parse(snacks);
}
    else{
        return [];
    }
}
function addSnacks(product){
    let snacks = getSnacks();
    let foundProduct = snacks.find(p => p.idpanier == product.idpanier);
    if (foundProduct != undefined){
        foundProduct.quantity++;
    }
    else{
        product.quantity = 1;
        product.price = 0.80;
        snacks.push(product);
    }
    localStorage.setItem("snacks",JSON.stringify(snacks));
    saveSnacks(snacks);}
    
    function removeSnacks(product){
        let snacks = getSnacks();
        snacks = snacks.filter(p =>p.idpanier != product.idpanier);
        saveSnacks(snacks);
    }

// Fonctions Boissons 

function saveBoissons(boissons){
    localStorage.setItem("boissons",JSON.stringify(boissons));
}
function getBoissons(){
    let boissons=localStorage.getItem("boissons");
    if(boissons){
        return JSON.parse(boissons);
}
    else{
        return [];
    }
}
function addBoissons(product){
    let boissons = getBoissons();
    let foundProduct = boissons.find(p => p.idpanier == product.idpanier);
    if (foundProduct != undefined){
        foundProduct.quantity++;
    }
    else{
        product.quantity = 1;
        product.price = 0.80;
        boissons.push(product);
    }
    localStorage.setItem("boissons",JSON.stringify(boissons));
    saveBoissons(boissons);}
    
    function removeBoissons(product){
        let boissons = getBoissons();
        boissons = boissons.filter(p =>p.idpanier != product.idpanier);
        saveBoissons(boissons);
    }

// Fonctions Sodas 

function saveSodas(sodas){
    localStorage.setItem("sodas",JSON.stringify(sodas));
}
function getSodas(){
    let sodas=localStorage.getItem("sodas");
    if(sodas){
        return JSON.parse(sodas);
}
    else{
        return [];
    }
}
function addSodas(product){
    let sodas = getSodas();
    let foundProduct = sodas.find(p => p.idpanier == product.idpanier);
    if (foundProduct != undefined){
        foundProduct.quantity++;
    }
    else{
        product.quantity = 1;
        product.price = 0.80;
        sodas.push(product);
    }
}

function getTotalPanier(){
        sodas = sodas.filter(p =>p.idpanier != product.idpanier);
        saveSodas(sodas);
    }


// Fonctions Sirops


function saveSirops(sirops){
    localStorage.setItem("sirops",JSON.stringify(sirops));
}
function getSirops(){
    let sirops=localStorage.getItem("sirops");
    if(sirops){
        return JSON.parse(sirops);
}
    else{
        return [];
    }
}
function addSirops(product){
    let sirops = getSirops();
    let foundProduct = sirops.find(p => p.idpanier == product.idpanier);
    if (foundProduct != undefined){
        foundProduct.quantity++;
    }
    else{
        product.quantity = 1;
        product.price = 0.80;
        sirops.push(product);
    }
    localStorage.setItem("sirops",JSON.stringify(sirops));
    saveSirops(sirops);}

    function removeSirops(product){
        let sirops = getSirops();
        sirops = sirops.filter(p =>p.idpanier != product.idpanier);
        saveSirops(sirops);
    }



// Fonction générales 

function changeQuantity(product, quantity){
    let snacks = getSnacks();
    let foundProduct = snacks.find(p => p.idpanier == product.idpanier);
    if (foundProduct!= undefined){
        foundProduct.quantity += quantity;
        if  (foundProduct.quantity<=0){
            removeSnacks(product);
        }
        else{
            saveSnacks(snacks);
        }
    }
}
function getNumberProducts(){
    
    let number = 0;
    let snacks = getSnacks();
    for(let product of snacks){
        number+=product.quantity;
    }
    let boissons = getBoissons();
    for(let product of boissons){
        number+=product.quantity;
    }
    let sodas = getSodas();
    for(let product of sodas){
        number+=product.quantity;
    }
    let sirops = getSirops();
    for(let product of sirops){
        number+=product.quantity;
    }

    return number;
}




function clickSnacks(){
    console.log('Ca marche');
    let list_snacks = document.querySelectorAll('.snacks .produit');
    for(let i=0;i<list_snacks.length;i++){
    list_snacks[i].addEventListener('click', function(event){
    console.log('click');
    let ligne = document.createElement('li');
    ligne.textContent=list_snacks[i].textContent;
    addSnacks(ligne);
    let panier = document.getElementById('panier');
    panier.append(ligne);
    let prix_ind = document.querySelectorAll('.snacks .prix');
    prix_temp=prix_temp+parseFloat(prix_ind[i].textContent);
    console.log(prix_temp);
    prix_total.textContent=Number((prix_temp).toFixed(1));
    // prix_total.textContent=parseFloat(String(prix_ind[i].textContent.substring(0,4)));
    let identifiant_produit=document.querySelectorAll('.snacks .hidden .id_prod');
    let form_ligne=document.createElement('input');
    form_ligne.setAttribute('type','hidden');
    form_ligne.setAttribute('name', 'produit_'+String(panier_id++));
    form_ligne.setAttribute('value',identifiant_produit[i].textContent);
    let panier_formulaire = document.getElementById('panier_input_formulaire');
    panier_formulaire.append(form_ligne);
    console.log(form_ligne);
    
    });
    
    }  
}             

function clickBoissons(){
    console.log('Ca marche');
    let list_boissons = document.querySelectorAll('.boissons .produit');
    for(let i=0;i<list_boissons.length;i++){
    list_boissons[i].addEventListener('click', function(event){
    console.log('click');
    let ligne = document.createElement('li');
    ligne.textContent=list_boissons[i].textContent;
    addBoissons(ligne);
    let panier = document.getElementById('panier');
    panier.append(ligne);
    let prix_ind = document.querySelectorAll('.boissons .prix');
    prix_temp=prix_temp+parseFloat(prix_ind[i].textContent);
    console.log(prix_temp);
    prix_total.textContent=Number((prix_temp).toFixed(1));
    let identifiant_produit=document.querySelectorAll('.boissons .hidden .id_prod');
    let form_ligne=document.createElement('input');
    form_ligne.setAttribute('type','hidden');
    form_ligne.setAttribute('name', 'produit_'+String(panier_id++));
    form_ligne.setAttribute('value',identifiant_produit[i].textContent);
    let panier_formulaire = document.getElementById('panier_input_formulaire');
    panier_formulaire.append(form_ligne);
    console.log(form_ligne)});
    }  
}      

function clickSodas(){
    console.log('Ca marche');
    let list_sodas = document.querySelectorAll('.sodas .produit');
    for(let i=0;i<list_sodas.length;i++){
    list_sodas[i].addEventListener('click', function(event){
    console.log('click');
    let ligne = document.createElement('li');
    ligne.textContent=list_sodas[i].textContent;
    addBoissons(ligne);
    let panier = document.getElementById('panier');
    panier.append(ligne);
    let prix_ind = document.querySelectorAll('.sodas .prix');
    prix_temp=prix_temp+parseFloat(prix_ind[i].textContent);
    console.log(prix_temp);
    prix_total.textContent=Number((prix_temp).toFixed(1));
    let identifiant_produit=document.querySelectorAll('.sodas .hidden .id_prod');
    let form_ligne=document.createElement('input');
    form_ligne.setAttribute('type','hidden');
    form_ligne.setAttribute('name', 'produit_'+String(panier_id++));
    form_ligne.setAttribute('value',identifiant_produit[i].textContent);
    let panier_formulaire = document.getElementById('panier_input_formulaire');
    panier_formulaire.append(form_ligne);
    console.log(form_ligne)});
    }  
}             

function clickSirops(){
    console.log('Ca marche');
    let list_sirops = document.querySelectorAll('.sirops .produit');
    for(let i=0;i<list_sirops.length;i++){
    list_sirops[i].addEventListener('click', function(event){
    console.log('click');//});
    let ligne = document.createElement('li');
    ligne.textContent=list_sirops[i].textContent;
    addBoissons(ligne);
    let panier = document.getElementById('panier');
    panier.append(ligne);
    let prix_ind = document.querySelectorAll('.sirops .prix');
    prix_temp=prix_temp+parseFloat(prix_ind[i].textContent);
    console.log(prix_temp);
    prix_total.textContent=Number((prix_temp).toFixed(1));
    let identifiant_produit=document.querySelectorAll('.sirops .hidden .id_prod');
    let form_ligne=document.createElement('input');
    form_ligne.setAttribute('type','hidden');
    form_ligne.setAttribute('name', 'produit_'+String(panier_id++));
    form_ligne.setAttribute('value',identifiant_produit[i].textContent);
    let panier_formulaire = document.getElementById('panier_input_formulaire');
    panier_formulaire.append(form_ligne);
    console.log(form_ligne)});
    }  
}
function choisirMethodePaiement(){
    let carte = document.getElementById('carte');
    let espece = document.getElementById('espece');
    carte.addEventListener('click',function(){
        console.log('ok');
        let dejapayer = document.querySelector('.dejapayer');
        dejapayer.textContent="";
        let reste = document.querySelector('.reste');
        reste.textContent="";
        let paiement = document.querySelector('#paiement');
        paiement.textContent="Carte Bancaire";
        let select_paiement = document.getElementById('select_paiement');
        select_paiement.setAttribute('value','Cartebancaire');
        console.log(select_paiement);
    });
    espece.addEventListener('click',function(){
        let p_dejapaye = document.createElement('p');
        


    });
}

//initialisation addeventlistener
let panier_id=0;
let prix_temp=0;
let prix_total = document.getElementById('totalprix');
clickSnacks();
let tab_snack=document.querySelectorAll('.snacks .produit');
clickBoissons();
clickSodas();
clickSirops();
choisirMethodePaiement();


let pdt_snacks = document.querySelectorAll('.produit');
for(let i=0;i<pdt_snacks.length;i++){
pdt_snacks[i].addEventListener('click',function(){
    console.log('Test1');
});}



