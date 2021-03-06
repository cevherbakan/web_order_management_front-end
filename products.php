<?php include 'header.php';?>

<link href="css/style.css" rel="stylesheet">

</head>
<?php include 'menu.php';?>


<div style="margin-left:3%; margin-right:2%;">

   <br />
 
   <br />
    <div style="align:center;">

    </div>
    <table class="display" style="margin:2%;"> 
        <tr>
        <td><div id="product-id"></div></td>
        <td><input type="text" id="prd-name"  class="form-control" style="width:200px;" placeholder="Ürün Adı"></td>
        <td><input type="text" id="prd-price" class="form-control" style="width:200px;" placeholder="Fiyat"></td>
        <td><input type="text" id="prd-sellerId" class="form-control" style="width:200px;" placeholder="SellerId"></td>
        <td><input type="text" id="prd-unit" class="form-control" style="width:200px;" placeholder="Birim"></td>

        <td><button type="button" name="add" id="add" class="btn btn-info">Yeni Ekle</button></td>
        <td><button type="button" name="update" id="update" class="btn btn-info">Güncelle</button></td>
        <td><button type="button" name="remove" id="remove" class="btn btn-info">Kaldır</button></td>
        
        </tr>

    </table>
</div>
    <br/>
    <div id="alert" style="display:none;" role="alert">
</div>

<div style="margin:2%;">

    <table id="example" class="display" style="width:100%;">
        <thead>
            <tr>
                <th>id</th>
                <th>Ürün Adı</th>
                <th>Fiyat</th>
                <th>Seller Id</th>
                <th>Birim</th>
                <th>Tarih</th>
                <th>Silinme</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
        <tfoot>
            <tr>
            <th>id</th>
                <th>Ürün Adı</th>
                <th>Fiyat</th>
                <th>Seller Id</th>
                <th>Birim</th>
                <th>Tarih</th>
                <th>Silinme</th>


            </tr>
        </tfoot>
    </table>
    </div>

   </div>


 <?php include 'footer.php';?>

 <script src="js/check-login.js"></script>
 

<script>
 $('#product').addClass("nav-item active");

 </script>


<script>

$(document).ready(function() {
   var table = $('#example').DataTable();
    
   $('#example tbody').on('click', 'tr', function () {
       var data = table.row( this ).data();

       $('#product-id').html(data[0]);

       $('#prd-name').val(data[1]);
       $('#prd-price').val(data[2]);
       $('#prd-sellerId').val(data[3]);
       $('#prd-unit').val(data[4]);


       //table.row(this).remove().draw( false );
       //alert( 'You clicked on '+data);
       console.log(data);
   } );
} );
</script>



<script>

getData();

function getData(){ 
    var id = sessionStorage.getItem('admin_id');
    var token = sessionStorage.getItem('admin_token');
 
      $.ajax({
      url: '../methods/getAllProduct.php?key=123',
      dataType: 'json',
      type: 'post',
      contentType: 'application/json',
      data: JSON.stringify( { "admin_id":id ,"admin_token": token} ),
      processData: false,
      success: function( data, textStatus, jQxhr ){
  
          var obj= jQuery.parseJSON(JSON.stringify(data));
  
          if(obj.result==true){
            addTable(obj.data);

          }
          else{
              sessionStorage.clear();
              window.location.replace("login.php");
          }
      },
      error: function( jqXhr, textStatus, errorThrown ){
          console.log( errorThrown );

      }  

    });
}


function addTable(response) {
$(document).ready(function() {
    var t = $('#example').DataTable();
 
    $.each(response, function(index, value) {
        t.row.add( [
            value["id"],
            value["name"],
            value["price"],
            value["seller_id"],
            value["unit"],
            value["reg_date"],
            value["remove"]
        ] ).draw( false ); 

    } );
 

} );

}

function getLastData(){
    var id = sessionStorage.getItem('admin_id');
    var token = sessionStorage.getItem('admin_token');
 
      $.ajax({
      url: '../methods/getLastProduct.php?key=123',
      dataType: 'json',
      type: 'post',
      contentType: 'application/json',
      data: JSON.stringify( { "admin_id":id ,"admin_token": token} ),
      processData: false,
      success: function( data, textStatus, jQxhr ){
  
          var obj= jQuery.parseJSON(JSON.stringify(data));
  
          if(obj.result==true){
            //console.log(obj.data);
            addTable(obj.data);
            

          }
          else{
              sessionStorage.clear();
              window.location.replace("login.php");
          }
      },
      error: function( jqXhr, textStatus, errorThrown ){
          console.log( errorThrown );

      }  

    });

}




 
$('#add').on( 'click', function () {
       var name= $('#prd-name').val();
       var price = $('#prd-price').val();
       var sellerId = $('#prd-sellerId').val();
       var unit = $('#prd-unit').val();

       var id = sessionStorage.getItem('admin_id');
    var token = sessionStorage.getItem('admin_token');
 
      $.ajax({
      url: '../methods/create-product.php?key=123',
      dataType: 'json',
      type: 'post',
      contentType: 'application/json',
      data: JSON.stringify( { "admin_id":id,"admin_token":token,"name":name ,"price": price, "seller_id":sellerId, "unit":unit} ),
      processData: false,
      success: function( data, textStatus, jQxhr ){
  
          var obj= jQuery.parseJSON(JSON.stringify(data));

  
          if(obj.result==true){
            $('#prd-name').val("");
            $('#prd-price').val("");
            $('#prd-sellerId').val("");
            $('#prd-unit').val("");

         $('#product-id').html("");


         $('#alert').addClass("alert alert-primary");
         $('#alert').show().html("başarıyla eklendi");

   

            getLastData();


          }
          else{
            $('#alert').addClass("alert alert-danger");
          }
      },
      error: function( jqXhr, textStatus, errorThrown ){
          console.log( errorThrown );

      }  

    });
 

    } );



$('#update').on( 'click', function () {
        var id = $('#product-id').html();
       var name= $('#prd-name').val();
       var price = $('#prd-price').val();
       var seller_id = $('#prd-sellerId').val();
       var unit = $('#prd-unit').val();

       var admin_id = sessionStorage.getItem('admin_id');
    var admin_token = sessionStorage.getItem('admin_token');


 
      $.ajax({
      url: '../methods/updateProduct.php?key=123',
      dataType: 'json',
      type: 'post',
      contentType: 'application/json',
      data: JSON.stringify( { "admin_id":admin_id,"admin_token":admin_token,"id":id,"name":name ,"price": price, "seller_id":seller_id, "unit":unit} ),
      processData: false,
      success: function( data, textStatus, jQxhr ){
  
          var obj= jQuery.parseJSON(JSON.stringify(data));


  
          if(obj.result==true){
        $('#product-id').html("");
         $('#prd-name').val("");
         $('#prd-price').val("");
         $('#prd-sellerId').val("");
         $('#prd-unit').val("");

         $('#alert').addClass("alert alert-primary");
         $('#alert').show().html("başarıyla güncellendi");

   



          }
          else{
            $('#alert').addClass("alert alert-danger");
          }
      },
      error: function( jqXhr, textStatus, errorThrown ){
          console.log( errorThrown );

      }  

    });
 

    } );




$('#remove').on( 'click', function () {
        var id = $('#product-id').html();

       var admin_id = sessionStorage.getItem('admin_id');
       var admin_token = sessionStorage.getItem('admin_token');
 
      $.ajax({
      url: '../methods/deleteProduct.php?key=123',
      dataType: 'json',
      type: 'post',
      contentType: 'application/json',
      data: JSON.stringify( { "admin_id":admin_id,"admin_token":admin_token,"id":id} ),
      processData: false,
      success: function( data, textStatus, jQxhr ){
  
          var obj= jQuery.parseJSON(JSON.stringify(data));

          console.log(obj.result);
  
          if(obj.result==true){
            $('#product-id').html("");
         $('#prd-name').val("");
         $('#prd-price').val("");
         $('#prd-sellerId').val("");
         $('#prd-unit').val("");


         $('#alert').addClass("alert alert-primary");
         $('#alert').show().html("başarıyla kaldırıldı");





          }
          else{
            $('#alert').addClass("alert alert-danger");
          }
      },
      error: function( jqXhr, textStatus, errorThrown ){
          console.log( errorThrown );

      }  

    });
 

    } );
 

</script>


 <script src="js/main.js"></script>


 </body>

</html>

