function spatne_reseni(id){
    var datastring = {"id" : id};
    $.ajax({
        type: "GET",
        url: "chybne_reseni.php",
        data: datastring,
        success: function(msg){

            alert("Vaše připomínka byla uložena a bude posouzena administrátorem. Děkujeme.");
            }
        });
    }