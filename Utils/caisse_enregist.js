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
    let list_snacks = document.getElementByID('#snacks');
    list_snacks.addEventListener('click',function(event){console.log('click');
    if(event.target.nodeName!=='TD'){return;}
    let ligne= document.createElement('li');
    ligne.textContent=event.target.textContent;
    let panier = getElementByID('panier');
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
    saveSnacks(snacks);});};
    
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
    localStorage.setItem("sodas",JSON.stringify(sodas));
    saveSodas(sodas);}

    function removeSodas(product){
        let sodas = getSodas();
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





    let list_snacks = document.querySelectorAll('#snacks td');
    for(let i=0; i<list_snacks.length;i++){
        list_snacks[i].addEventListener('click',function(event){
            console.log('click');
            if(event.target.nodeName!=='TD'){
                return;
            }

            
    
        }
        )
    }