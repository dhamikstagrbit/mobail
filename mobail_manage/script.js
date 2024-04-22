

function StaticVal(){
  var email = document.getElementById( "email" ).value;
  var title = document.getElementById( "title" ).value;
  var brand = document.getElementById( "brand" ).value;
  var Model = document.getElementById( "Model" ).value;
  var short = document.getElementById( "short_description" ).value;
  var image = document.getElementById( "image" ).value;
  var price = document.getElementById( "price" ).value;
  var char = document.querySelectorAll('input[name="characteristics[]"]:checked');
  var stock = document.querySelector('input[name="stock"]:checked');
 
  var email_err = document.getElementById('email_err');
  var title_err = document.getElementById('title_err');
  var brand_err = document.getElementById('brand_err');
  var model_err = document.getElementById('model_err');
  var short_err = document.getElementById('short_err');
  var image_err = document.getElementById("image_err");
  var price_err = document.getElementById("price_err");
  var stock_err = document.getElementById("stock_err");
  var char_err  = document.getElementById("Char_err");
  

  var valid = 1; 

  if(email == ""){
    email_err.textContent  = "Email is required";
    var valid = 0
   }else{
    email_err.textContent  = "";
   }

   if(title == ""){
      title_err.textContent  = "Title is required";
      var valid = 0
   }else{
    title_err.textContent  = "";
   }

   if(brand == ""){
    brand_err.textContent  = "select your brand name";
    var valid = 0
   }else{
    brand_err.textContent  ="";
   }

   if(Model == ""){
    model_err.textContent  = "required model name";
    var valid = 0
   }else{
     model_err.textContent  ="";
   }

   if(short == ""){
    short_err.textContent  = "description is required";
    var valid = 0
   }else{
    short_err.textContent  ="";
   }

   if(image == ""){
    image_err.textContent  = "image is required";
    var valid = 0
   }else{
    image_err.textContent  ="";
   }

   if(price == ""){
     price_err.textContent  = "price is required";
     var valid = 0
   }else{
     price_err.textContent  ="";
   }
   if(char.length==""){
      char_err.textContent  = "select checkbox";
      var valid = 0
    }else{
        char_err.textContent  = "";
    }

   if(!stock){
     stock_err.textContent  = "required";
     var valid = 0
    }else{
      stock_err.textContent  = "";
    }

   if(valid){
     return true;
   }else{
     return false;
   }

}


document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("search").addEventListener("change", function() {
        fetchData();
    });

    document.getElementById("sort").addEventListener("change", function() {
        fetchData();
    });
});

function fetchData() {
    var id = document.getElementById("search").value;
    var sorting = document.getElementById("sort").value;

    var xhr = new XMLHttpRequest();

    xhr.open("POST", "ser.php");
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                document.querySelector(".data-res").innerHTML = xhr.responseText;
            } else {
                console.error("Error:", xhr.status, xhr.statusText);
            }
        }
    };

    xhr.send("sid=" + encodeURIComponent(id) + "&sort=" + encodeURIComponent(sorting));
}