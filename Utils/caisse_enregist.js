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

function getTotalPanier(){
    let total = 0;
    let snacks = getSnacks();
    for(let product of snacks) {
        total+=product.quantity*product.price;}
    let boissons = getBoissons();
    for(let product of boissons){
        total+=product.quantity*product.price;
    }
    let sodas = getSodas();
    for(let product of sodas){
        total+=product.quantity*product.price;
    }
    let sirops = getSirops();
    for(let product of sirops){
        total+=product.quantity*product.price;
    }
    return total;
}



function clickSnacks(){
    console.log('Ca marche');
    let list_snacks = document.querySelectorAll('.snacks .produit');
    for(let i=0;i<list_snacks.length;i++){
    list_snacks[i].addEventListener('click', function(event){
    console.log('click');//});
    let ligne = document.createElement('li');
    ligne.textContent=event.target.textContent;
    addSnacks(ligne);
    let panier = document.querySelectorAll('panier li');
    panier.append(ligne);
            for(var value of panier.values()){
            if (ligne.textContent==value){
                panier.remove(ligne);
                j++;
                console.log(j);
            }
        }
        });
    }  
}             


//initialisation addeventlistener
clickSnacks();


let pdt_snacks = document.querySelectorAll('.produit');
for(let i=0;i<pdt_snacks.length;i++){
pdt_snacks[i].addEventListener('click',function(){
    console.log('Test1');
});}