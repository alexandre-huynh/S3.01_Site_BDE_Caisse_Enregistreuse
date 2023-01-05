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
        let snacks = getSnacks();
        let number = 0;
        for(let product of snacks) {
            number+=product.quantity;
    }
        return number;
    }
    function getTotalPanier(){
        let snacks = getSnacks();
        let total = 0;
        for(let product of snacks) {
            total+=product.quantity*product.price;}
        return total;
    }
