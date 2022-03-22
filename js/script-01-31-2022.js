//var siteURL = "http://phpdemo.accrueretail.com";
var siteURL = window.location.protocol + "//" + window.location.host;

$( document ).ready(function() {
  //var siteURL = "http://phpdemo.accrueretail.com";
  //var siteURL = "http://ec2-100-25-161-21.compute-1.amazonaws.com";
  var API_URL = "https://api.accrueretail.com/";
  //var API_URL = "https://stagingapi.accrueretail.com/";

  //to fetch featured products on click on category buttons in homepage
  $(".featured-btn").on("click", function () {
    pageNo=1;
    $(".progress").show();
    $(".featured-btn").removeClass("active");
    $(this).addClass("active");
    $("#prev").hide();
    //console.log($(this).attr('category'));
    var category = $(this).attr("category");
    if (category) {
      $.get(siteURL + "/api/getProductsByCategoryId/" + category).done(
        function (data) {
          //alert( "Data Loaded: " + data );
          $(".featured-products-container").html(data);

          setTimeout(function(){
            if(parseInt($("#featured_vals").attr("fmaxpages")) > 1){
              $("#next").show();
            }else{
              $("#next").hide();
            }
          }, 1000);
          $(".progress").hide();
        }
      );
    }
  });

  /*if ( $(".first-featured-btn").length ) {	
   $(".first-featured-btn").trigger("click");
  }*/

  //to fetch realted products in product details page
  var pathname = window.location.pathname;
  //console.log(pathname);
  if (pathname.indexOf("/product-details/") != -1) {
    var category = $("#product_category").attr("category");
    if (category) {
      $.get(siteURL + "/api/getRelatedProductsByCategory/" + category).done(
        function (data) {
          //alert( "Data Loaded: " + data );
          $(".related-products-container").html(data);
        }
      );
    }
  }

  //update product wishlist
  //$(".Main_bottlesection .fa-heart").on("click", function(){
  $(document.body).on(
    "click",
    ".Main_bottlesection .icon-favorites",
    function () {
      $(".progress").show();
      if ($(this).hasClass("active")) {
        var wishStatus = 0;
        $(this).removeClass("active");
        var msg = "Product removed from Favorites.";
      } else {
        var wishStatus = 1;
        $(this).addClass("active");
        var msg = "Product added to Favorites.";
      }
      var pid = $(this).attr("id");
      

      if (wishStatus == "0" && $(this).hasClass("fav-sec")) {
        
        //console.log($(".fav-prod").length);
        if ($(".fav-prod").length-1 <= 0) {
          $(this)
            .closest(".col-md--12")
            .append(
              '<div class="col-md-9 col-sm-9 col-lg-9 col-xs-12">No Products Found</div><br><br><br>'
            );
        }
        $(this).closest(".fav-prod").remove();

      }

      $.get(
        siteURL + "/api/FavoriteProductUpdate/" + wishStatus + "/" + pid
      ).done(function (data) {
        //alert( "Data Loaded: " + data );
        toast_message(msg);
        $(".progress").hide();
      });
    }
  );

  $(document.body).on(
    "click",
    ".favorite-selection .icon-favorites",
    function () {
      $(".progress").show();
      if ($(this).hasClass("active")) {
        var wishStatus = 0;
        $(this).removeClass("active");
        var msg = "Product removed from Favourites.";
      } else {
        var wishStatus = 1;
        $(this).addClass("active");
        var msg = "Product added to Favourites.";
      }
      var pid = $(this).attr("id");

      $.get(
        siteURL + "/api/FavoriteProductUpdate/" + wishStatus + "/" + pid
      ).done(function (data) {
        //alert( "Data Loaded: " + data );
        toast_message(msg);
        $(".progress").hide();
      });
    }
  );

  //update product wishlist
  $(document.body).on(
    "click",
    ".Main_bottlesection .icon-add-to-my-cart, .Main_bottlesection .icon-remove-cart",
    function () {
      $(".progress").show();
      if ($(this).hasClass("active")) {
        var wishStatus = 0;
        $(this).removeClass("active");

        $(this).addClass("icon-add-to-my-cart");
        $(this).removeClass("icon-remove-cart");
        var cart_count = parseInt($(".cart-block .round-circle").html()) - 1;
        $(".cart-block .round-circle").html(cart_count);
        var msg = "Product removed from Cart.";
      } else {
        var wishStatus = 1;
        $(this).addClass("active");

        $(this).addClass("icon-remove-cart");
        $(this).removeClass("icon-add-to-my-cart");

        var cart_count = parseInt($(".cart-block .round-circle").html()) + 1;
        $(".cart-block .round-circle").html(cart_count);
        var msg = "Product added to Cart.";
      }
      var pid = $(this).attr("id");

      $.get(siteURL + "/api/AddRemoveFromCart/" + wishStatus + "/" + pid).done(
        function (data) {
          //alert( "Data Loaded: " + data );
          toast_message(msg);
          $(".progress").hide();
        }
      );
    }
  );

  $(document.body).on("click", ".quantity_ok", function () {
    $(".addtocart").attr("less_inventory", "1");
    $(".addtocart").trigger("click");
  });

  $(document.body).on("click", ".modal-header .close", function () {
    $(".progress").hide();
  });
  $(document.body).on("change", ".selectsize", function () {
    $(".inputqty").val($(this).val());
  });

  $(document.body).on("input", ".inputqty", function () {
    $(".selectsize").val($(this).val());
  });

  //add product to cart from product details page
  $(document.body).on("click", ".addtocart", function () {
    $(".progress").show();
    var pid = $(this).attr("pid");

    if ($(this).hasClass("remove_from_cart")) {
      var wishStatus = 0;
      $(this).removeClass("remove_from_cart");
    } else {
      var wishStatus = 1;
      $(this).removeClass("remove_from_cart");
    }
    if (wishStatus == 1) {
      var quantity = parseInt($(".inputqty").val());

      if ($(".inputqty").val().trim() == "") {
        quantity = 0;
        $(".progress").hide();
        return false;
      }

      var quantity_available = parseInt($("#q_available").val());
      var less_inventory = $(this).attr("less_inventory");
      if (less_inventory != "1") {
        if (quantity > quantity_available) {
          //console.log('pop');
          $("#quan_req").html(quantity);
          quantity = quantity_available;
          $(".model_quanity_check").modal("toggle");
          return false;
        }
      }
      if (quantity > quantity_available) {
        quantity = quantity_available;
        $(".selectsize").val(quantity);
        $(".inputqty").val(quantity);
      }
      var cart_count =
        parseInt($(".cart-block .round-circle").html()) + parseInt(quantity);
      $(".cart-block .round-circle").html(cart_count);

      $.get(siteURL + "/api/AddToCart/" + quantity + "/" + pid).done(function (
        data
      ) {
        $(".addtocart").addClass("remove_from_cart");
        $(".addtocart").html("Remove from Cart");
        $(".selectsize").attr("disabled", "disabled");
        $(".inputqty").attr("disabled", "disabled");
        //console.log(data);
        toast_message("Product added to Cart.");
        $(".progress").hide();
      });
    } else {
      $(this).removeAttr("less_inventory");
      var quantity = parseInt($(".inputqty").val());
      var cart_count =
        parseInt($(".cart-block .round-circle").html()) - parseInt(quantity);
      $(".cart-block .round-circle").html(cart_count);

      $.get(siteURL + "/api/AddRemoveFromCart/" + wishStatus + "/" + pid).done(
        function (data) {
          //alert( "Data Loaded: " + data );
          $(".addtocart").removeClass("remove_from_cart");
          $(".addtocart").html("Add to Cart");
          $(".selectsize").val("1");
          $(".selectsize").removeAttr("disabled");
          $(".inputqty").val("1");
          $(".inputqty").removeAttr("disabled");
          toast_message("Product removed from Cart.");
          $(".progress").hide();
        }
      );
    }
  });

  //remove product from cart
  $(document.body).on("click", ".cancel_product", function () {
    $(".progress").show();
    var pid = $(this).attr("pid");
    var cart_item = $(this).attr("cart_item");
    var quantity = parseInt($(this).attr("quan"));

    var cart_count = parseInt($(".cart-block .round-circle").html()) - quantity;
    $(".cart-block .round-circle").html(cart_count);

    $(this).closest(".cart-item-row").hide();
    $(this).closest(".box-tile").removeClass("visible-lg");
    $(this).closest(".box-tile").removeClass("visible-md");
    $(this).closest(".box-tile").hide();

    if (cart_count <= 0) {
      //window.location.href = siteURL + "/cart";
      $(".res_table").hide();
      $(".res_table thead").hide();
      $(".box-tile").hide();
      $(".buttons-container").hide();
      $(".empty-cart").show();
    }

    $.get(siteURL + "/api/DeleteFromCart/" + cart_item + "/" + pid).done(
      function (data) {
        //console.log( data );
        toast_message("Product removed from Cart.");
        $(".progress").hide();
      }
    );
  });

  //get store info
  $.get(siteURL + "/api/getStoreDetails/1").done(function (data) {
    //alert( "Data Loaded: " + data );
    //console.log(data.CartItemCount);
    data1 = JSON.parse(data);
    if (
      data1.CartItemCount == null ||
      data1.CartItemCount == undefined ||
      data1.CartItemCount == ""
    ) {
      data1.CartItemCount = 0;
    }
    $(".cart-block .round-circle").html(data1.CartItemCount);
    //$(".location .storename").html(data1.StoreName);
  });

  //pagination click
  /*$(document.body).on('click', '.page-link', function(){
        $(this).parent(".page-item").css("background", "red");
        if($(this).parent(".page-item").hasClass('disabled')) {
            //console.log('disabled');
            return false;
        }
        if($(this).hasClass('prev_next')) {
            //console.log('prev_next');
            var page = parseInt($(this).attr('page'));
        }else{
        var page = parseInt($(this).html());
        }

        if(page > 0){
            var redirect_page   = window.location.href.split('?')[0];
            var pageSize = $("#products_per_page").val();
            //var minPrice = $("$products_per_page").val();
            //var maxPrice = $("$products_per_page").val();
            redirect_page += '?pageNumber='+page+'&pageSize='+pageSize+'&minPrice=0&maxPrice=0';
            //console.log(redirect_page);
            window.location.href = redirect_page;
        }
    });*/

  $(document.body).on("change", "#products_per_page", function () {
    $(".progress").show();
    //var page = parseInt($('.page-item.active .page-link').html());
    var pageSize = $("#products_per_page").val();

    if (pageSize > 0) {
      //var redirect_page = window.location.href.split('?')[0];
      //var minPrice = $("$products_per_page").val();
      //var maxPrice = $("$products_per_page").val();
      //redirect_page += '?pageNumber='+page+'&pageSize='+pageSize+'&minPrice=0&maxPrice=0';

      redirect_page = updateQueryStringParameter(
        window.location.href,
        "pageSize",
        pageSize
      );
      //console.log(redirect_page);
      window.location.href = redirect_page;
    }
  });

  $(document.body).on("click", ".allTypes", function () {
    var pid = "." + $(this).attr("id") + " input";
    //console.log(pid);
    if (this.checked) {
      $(pid).attr("checked", true);
      $(pid).prop("checked", true);
    } else {
      $(pid).attr("checked", false);
      $(pid).prop("checked", false);
    }
  });

  $(document.body).on("click", ".clear", function () {
    $(".progress").show();
    var sec_name = $(this).attr("id");
    var sec_id = $(this).attr("id_val");
    var type_name = "allTypes-" + sec_name;
    var varital_name = "allVaritals-" + sec_name;

    var pid1 = "." + type_name + " input";
    //console.log(pid1);
    $(pid1).attr("checked", false);
    $(pid1).prop("checked", false);
    var pid2 = "." + varital_name + " input";
    //console.log(pid2);
    $(pid2).attr("checked", false);
    $(pid2).prop("checked", false);
  });

  $(document.body).on("click", ".allVaritals", function () {
    var pid = "." + $(this).attr("id") + " input";
    //console.log(pid);
    if (this.checked) {
      $(pid).attr("checked", true);
      $(pid).prop("checked", true);
    } else {
      $(pid).attr("checked", false);
      $(pid).prop("checked", false);
    }
  });

  $(document.body).on("click", ".btn_right .filer_go", function () {
    $(".progress").show();
    var sec_name = $(this).attr("id");
    var sec_id = $(this).attr("id_val");
    var type_name = sec_name + "-typeId";
    var varital_name = sec_name + "-varietalId";

    var selected_types = jQuery
      .map(
        $(":checkbox[name=" + type_name + "\\[\\]]:checked"),
        function (n, i) {
          return n.value;
        }
      )
      .join(",");

    var selected_vars = jQuery
      .map(
        $(":checkbox[name=" + varital_name + "\\[\\]]:checked"),
        function (n, i) {
          return n.value;
        }
      )
      .join(",");

    //alert(selected_types);
    var redirect_page = siteURL + "/" + sec_name + "/" + sec_id;

    if (selected_types)
      redirect_page = updateQueryStringParameter(
        redirect_page,
        "typeId",
        selected_types
      );

    if (selected_vars)
      redirect_page = updateQueryStringParameter(
        redirect_page,
        "varietalId",
        selected_vars
      );

    window.location.href = redirect_page;
  });

  $(document.body).on("click", ".store-block .filer_go", function () {
    $(".progress").show();
    var sid = $(this).attr("store_id");

    $.get(siteURL + "/api/setStore/" + sid).done(function (data) {
      //alert( "Data Loaded: " + data );
      setCookie("store_selection", "1", 30);
      $(".modelchainstore").modal("toggle");

      var redirect_page = siteURL;
      var r_uri = window.location.href;
      if (r_uri.indexOf("online") != -1) {
        var result = r_uri.split("online/");
        product_page = result[1];

        if (product_page != "") {
          redirect_page = redirect_page+"/online/"+product_page;
        }
      }
      window.location.href = redirect_page;
    });
  });

  $(document.body).on("change", ".qnty_input", function () {
    //console.log("test");
    if ($(this).val() <= 0) {
      toast_message("Invalid Quantity.","E");
      //$(this).val($(this).attr("prev_val")).delay(1000);
      var that = $(this);
      setTimeout(function () {
        that.val(that.attr("prev_val"));
      }, 500);
      return false;
    }

    var cart_item = $(this).attr("cart_item");
    var row_select_class = ".cart-item-row-" + cart_item + " .select-quant";
    if ($(this).val() >= 1000000) {
      $(this).val(1);
    }
      if ($(this).val().trim() == "") {
        $(this).val(0);
      }
    $(this).attr("prev_val",$(this).val());
    $(row_select_class).val($(this).val());
    $(row_select_class).trigger("change");
  });

  $(document.body).on("change", ".select-quant", function () {
    $(".progress").show();
    var quantity = $(this).val();
    var cart_item = $(this).attr("cart_item");

    var row_input_class = ".cart-item-row-" + cart_item + " .qnty_input";

    if (parseInt(quantity) <= 100) {
      $(row_input_class).val(quantity);
    }
    var quantity = $(row_input_class).val();
    var prev_quantity = $(this).attr("quan");

    if (quantity.trim() == "" || quantity.trim() == " ") {
      quantity = 0;
    }

    var cart_count =
      parseInt($(".cart-block .round-circle").html()) -
      parseInt(prev_quantity) +
      parseInt(quantity);
    $(".cart-block .round-circle").html(cart_count);
    $(this).attr("quan", quantity);
    $(this)
      .parent()
      .parent()
      .parent()
      .find(".cancel_product")
      .attr("quan", quantity);

    var cartDetails = JSON.parse(localStorage.getItem("CartGetDetail"));

    for (var i = 0; i < cartDetails.ListCartItem.length; i++) {
      if (cartDetails.ListCartItem[i].CartItemId == cart_item) {
        cartDetails.ListCartItem[i].QuantityOrdered = quantity;
        break;
      }
    }

    //console.log(cartDetails);
    $.post(API_URL + "api/Cart/CartUpdate", cartDetails).done(function (data) {
      //console.log( data );
      var flag = 1;

      for (var i = 0; i < data.ListCartItem.length; i++) {
        if (data.ListCartItem[i].CartItemId == cart_item) {
          //cartDetails.ListCartItem[i].QuantityOrdered = quantity;
          //console.log(data.ListCartItem[i].QuantityOrdered);
          //console.log(data.ListCartItem[i].Quantity);
          if (
            data.ListCartItem[i].Quantity < data.ListCartItem[i].QuantityOrdered
          ) {
            flag = 0;
            var row_img_class = ".cart-item-row-" + cart_item + " .second_img";
            var imgpath = $(row_img_class).attr("src");
            $("#quan_img").attr("src", imgpath);

            var row_title_class =
              ".cart-item-row-" + cart_item + " .Product_name h5";
            var pro_title = $(row_title_class).html();
            $("#quan_title").html(pro_title);

            $("#quan_req").html(data.ListCartItem[i].QuantityOrdered);
            $("#quan_available").html(data.ListCartItem[i].Quantity);

            $("#quantity_ver_modal").modal("show");

            var row_input_qnty_class =
              ".cart-item-row-" + cart_item + " .qnty_input";
            $(row_input_qnty_class).val(data.ListCartItem[i].Quantity);

            var row_class_quant =
              ".cart-item-row-" + cart_item + " .select-quant";
            $(row_class_quant).attr("quan", data.ListCartItem[i].Quantity);
            $(row_class_quant).val(data.ListCartItem[i].Quantity);

            var row_class_cancel_quant =
              ".cart-item-row-" + cart_item + " .cancel_product";
            $(row_class_cancel_quant).attr(
              "quan",
              data.ListCartItem[i].Quantity
            );

            var cart_count =
              parseInt($(".cart-block .round-circle").html()) -
              parseInt(data.ListCartItem[i].QuantityOrdered) +
              parseInt(data.ListCartItem[i].Quantity);
            $(".cart-block .round-circle").html(cart_count);
          }
          var row_class = ".cart-item-row-" + cart_item + " .total_price";
          $(row_class).html(data.ListCartItem[i].FinalItemTotalDisplay);
          break;
        }
      }
      if (flag == 1) {
        toast_message("Cart updated.","S");
      }
      $(".progress").hide();
    });
  });

  /*$(document.body).on("click", ".quantity_chk_ok", function () {
    $(".progress").show();
    toast_message("Cart updated.");
    $(".progress").hide();
  });*/

  var typingTimer; //timer identifier
  var doneTypingInterval = 1000; //time in ms, 5 second for example

  $(document.body).on("keyup", ".form-search input", function () {
    var keyword = $(this).val();
    if (keyword.trim() == '') {
      $(".result-sec").attr("style", "display: none !important");
    }
    clearTimeout(typingTimer);
    

    typingTimer = setTimeout(function () {
    if (keyword != "") {
        $.get(siteURL + "/api/search/" + keyword).done(function (data) {
          $(".result-sec").html(data);
          if (data.trim() != "") {
            if ($(".form-search input").val() != "") {
              $(".result-sec").attr("style", "display: block !important");
            } else {
              $(".result-sec").attr("style", "display: none !important");
            }
          } else {
            $(".result-sec").attr("style", "display: none !important");
          }
        });
      } else {
        $(".result-sec").attr("style", "display: none !important");
      }
    }, doneTypingInterval);
  });



  $(document.body).on("keyup", ".mform-search input", function () {
    var keyword = $(this).val();
    if (keyword.trim() == '') {
      $(".mresult-sec").attr("style", "display: none !important");
    }
    clearTimeout(typingTimer);
    

    typingTimer = setTimeout(function () {
    if (keyword != "") {
        $.get(siteURL + "/api/search/" + keyword).done(function (data) {
          $(".mresult-sec").html(data);
          if (data.trim() != "") {
            if ($(".mform-search input").val() != "") {
              $(".mresult-sec").attr("style", "display: block !important");
            } else {
              $(".mresult-sec").attr("style", "display: none !important");
            }
          } else {
            $(".mresult-sec").attr("style", "display: none !important");
          }
        });
      } else {
        $(".mresult-sec").attr("style", "display: none !important");
      }
    }, doneTypingInterval);
  });

  //on keydown, clear the countdown
  $(document.body).on("keydown", ".form-search input", function () {
    clearTimeout(typingTimer);
  });

  $(document.body).on("keydown", ".mform-search input", function () {
    clearTimeout(typingTimer);
  });

  //hide searchbox
  $(document.body).on("focusout", ".form-search input", function () {
    setTimeout(function(){
	  $(".result-sec").attr("style",  "visibility: hidden");
    }, 200);
  });

  $(document.body).on("focusin", ".form-search input", function () {
    var keyword = $(this).val();
    if (keyword != "") {
      if ($(".result-sec").html().trim() != "") {
        $(".result-sec").attr("style", "display: block !important");
      } else {
        $(".result-sec").attr("style", "display: none !important");
      }
    }
  });


   //hide searchbox
   $(document.body).on("focusout", ".mform-search input", function () {
    setTimeout(function(){
	  $(".mresult-sec").attr("style",  "visibility: hidden");
    }, 200);
  });

  $(document.body).on("focusin", ".mform-search input", function () {
    var keyword = $(this).val();
    if (keyword != "") {
      if ($(".mresult-sec").html().trim() != "") {
        $(".mresult-sec").attr("style", "display: block !important");
      } else {
        $(".mresult-sec").attr("style", "display: none !important");
      }
    }
  });


function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}
  
  $(document.body).on("input", "#login input", function (e) {
    if ($("#login").hasClass("error")) {
      if ($(this).attr("type") == "email") {
        $(".login-email-err").remove();
        $(".login-pwd-err").remove();
        //empty email
        if ($(this).val().trim() == "") {
          $(".login-email-err").remove();
          if ($(".login-email-err").length === 0) {
            $(
              '<div class="alert alert-danger login-email-err"><div>E-Mail is required.</div></div>'
            ).insertAfter("#login #email");
          }
        }

        //invalid email
        if ($(this).val().trim() != "" && !isEmail($(this).val().trim())) {
          $(".login-email-err").remove();
          $(
            '<div class="alert alert-danger login-email-err"><div>Email must be a valid email address</div></div>'
          ).insertAfter("#login #email");
        }
      }
      if ($(this).attr("type") != "email") {
        if ($(this).val().trim() == "") {
          $(".login-pwd-err").remove();
          if ($(".login-pwd-err").length === 0) {
            $(
              '<div class="alert alert-danger login-pwd-err"><div>Password is required.</div></div>'
            ).insertAfter("#login #pawd");
          }
        }
      }
    }
  });

  $(document.body).on("input", "#signup input", function (e) {
    if ($("#signup").hasClass("error")) {
      if ($(this).attr("type") == "email") {
        $(".slogin-email-err").remove();
        $(".slogin-pwd-err").remove();
        //empty email
        if ($(this).val().trim() == "") {
          $(".slogin-email-err").remove();
          if ($(".slogin-email-err").length === 0) {
            $(
              '<div class="alert alert-danger slogin-email-err"><div>E-Mail is required.</div></div>'
            ).insertAfter("#signup #s_email");
          }
        }

        //invalid email
        if ($(this).val().trim() != "" && !isEmail($(this).val().trim())) {
          $(".slogin-email-err").remove();
          $(
            '<div class="alert alert-danger slogin-email-err"><div>Email must be a valid email address</div></div>'
          ).insertAfter("#signup #s_email");
        }
      }
      if ($(this).attr("type") != "email") {
        if ($(this).val().trim() == "") {
          $(".slogin-pwd-err").remove();
          if ($(".slogin-pwd-err").length === 0) {
            $(
              '<div class="alert alert-danger slogin-pwd-err"><div>Password is required.</div></div>'
            ).insertAfter("#signup #s_pawd");
          }
        }

        if ($(this).val().trim() != "") {
          $(".slogin-pwd-err").remove();
          if ($(this).val().length < 6) {
            $(
              '<div class="alert alert-danger slogin-pwd-err"><div>Password must be at least 6 characters.</div></div>'
            ).insertAfter("#signup #s_pawd");
          }
        }
      }
    }
  });


  $(document.body).on("keypress", "#login input", function (e) {
    if (e.keyCode == 13) {
      $("#login").removeClass("error");
      $(".progress").show();
      $(".login-email-err").hide();
      $(".login-pwd-err").hide();
      //alert('You pressed enter!');
      var email = $("#email").val();
      var pawd = $("#pawd").val();
      var flag = 0;
      if (email.trim() == "") {
        $(".login-email-err").remove();
        if ($(".login-email-err").length === 0) {
          $(
            '<div class="alert alert-danger login-email-err"><div>E-Mail is required.</div></div>'
          ).insertAfter("#login #email");
        }
        flag = 1;
      }

      if (pawd.trim() == "") {
        $(".login-pwd-err").remove();
        if ($(".login-pwd-err").length === 0) {
          $(
            '<div class="alert alert-danger login-pwd-err"><div>Password is required.</div></div>'
          ).insertAfter("#login #pawd");
        }
        flag = 1;
      }

      if (email.trim() != "" && !isEmail(email.trim())) {
        $(".login-email-err").remove();
        $(
          '<div class="alert alert-danger login-email-err"><div>Email must be a valid email address</div></div>'
        ).insertAfter("#login #email");
        flag = 1;
      }

      if (flag == 1) {
        $("#login").addClass("error");
        $(".progress").hide();
      }
	if ($("#remember").is(":checked")) {
      remember = 1;
    } else {
      remember = 0;
    }

      var returnURL = $("#returnURL").val();
      if (flag == 0 && email != "" && pawd != "") {
        $.get(siteURL + "/api/login/" + email + "/" + pawd+"-"+remember).done(function (
          data
        ) {
          if (data == 1) {
            if (typeof returnURL !== "undefined" && returnURL != "") {
              window.location.href = siteURL + "/" + returnURL;
            } else {
              window.location.href = siteURL;
            }
          } else {
            //$("#message_pop").html('Login Failed.');
            toast_message("Invalid login credentials.", "E");
            $(".progress").hide();
          }
        });
      }
    }
  });

  $(document.body).on("click", "#login_submit", function (event) {
    //console.log( "Handler for .submit() called." );
    //event.preventDefault();
    $(".progress").show();
    $("#login").removeClass("error");
    $(".login-email-err").hide();
    $(".login-pwd-err").hide();
    //alert('You pressed enter!');
    var email = $("#email").val();
    var pawd = $("#pawd").val();
    var flag = 0;
    if (email.trim() == "") {
      $(".login-email-err").remove();
      if ($(".login-email-err").length === 0) {
        $(
          '<div class="alert alert-danger login-email-err"><div>E-Mail is required.</div></div>'
        ).insertAfter("#login #email");
      }
      flag = 1;
    }

    if (pawd.trim() == "") {
      $(".login-pwd-err").remove();
      if ($(".login-pwd-err").length === 0) {
        $(
          '<div class="alert alert-danger login-pwd-err"><div>Password is required.</div></div>'
        ).insertAfter("#login #pawd");
      }
      flag = 1;
    }

    if (email.trim() != "" && !isEmail(email.trim())) {
      $(".login-email-err").remove();
      $(
        '<div class="alert alert-danger login-email-err"><div>Email must be a valid email address</div></div>'
      ).insertAfter("#login #email");
      flag = 1;
    }

    if (flag == 1) {
      $("#login").addClass("error");
      $(".progress").hide();
    }
    
	  if ($("#remember").is(":checked")) {
      remember = 1;
    } else {
      remember = 0;
    }

    var returnURL = $("#returnURL").val();
    if (flag == 0 && email != "" && pawd != "") {
      $.get(siteURL + "/api/login/" + email + "/" + pawd+"-"+remember).done(function (data) {
        if (data == 1) {
          if (typeof returnURL !== "undefined" && returnURL != "") {
            window.location.href = siteURL + "/" + returnURL;
          } else {
            window.location.href = siteURL;
          }
        } else {
          //$("#message_pop").html('Login Failed.');
          toast_message("Invalid login credentials.", "E");
          $(".progress").hide();
        }
      });
    }
  });

  $(document.body).on("click", "#signup_submit", function (event) {
    //console.log( "Handler for .submit() called." );
    //event.preventDefault();
    $(".progress").show();
    $("#signup").removeClass("error");
    $(".slogin-email-err").hide();
    $(".slogin-pwd-err").hide();
    var email = $("#s_email").val();
    var pawd = $("#s_pawd").val();
    var flag = 0;
    if (email.trim() == "") {
      $(".slogin-email-err").remove();
      if ($(".slogin-email-err").length === 0) {
        $(
          '<div class="alert alert-danger slogin-email-err"><div>E-Mail is required.</div></div>'
        ).insertAfter("#signup #s_email");
      }
      flag = 1;
    }

    if (pawd.trim() == "") {
      $(".slogin-pwd-err").remove();
      if ($(".slogin-pwd-err").length === 0) {
        $(
          '<div class="alert alert-danger slogin-pwd-err"><div>Password is required.</div></div>'
        ).insertAfter("#signup #s_pawd");
      }
      flag = 1;
    }

    if (email.trim() != "" && !isEmail(email.trim())) {
      $(".slogin-email-err").remove();
      $(
        '<div class="alert alert-danger slogin-email-err"><div>Email must be a valid email address</div></div>'
      ).insertAfter("#signup #s_email");
      flag = 1;
    }

    if (pawd.trim() != "") {
      $(".slogin-pwd-err").remove();
      if (pawd.length < 6) {
        $(
          '<div class="alert alert-danger slogin-pwd-err"><div>Password must be at least 6 characters.</div></div>'
        ).insertAfter("#signup #s_pawd");
        flag = 1;
      }
    }

    if (flag == 1) {
      $("#signup").addClass("error");
      $(".progress").hide();
    }

    var returnURL = $("#returnURL").val();
    if (flag == 0 && email != "" && pawd != "") {
      $.get(siteURL + "/api/signup/" + email + "/" + pawd).done(function (
        data
      ) {
        if (data == 1) {
			//Commented for above code is commented by manikanta for direct redirect to profile edit page on jan 24
          // if (
            // typeof returnURL !== "undefined" &&
            // returnURL != "" &&
            // returnURL.indexOf("online") == -1 &&
            // returnURL.indexOf("events") == -1
          // ) {
            // window.location.href = siteURL + "/" + returnURL;
          // } else {
            // if (
              // returnURL.indexOf("events") !== -1 ||
              // returnURL.indexOf("online") !== -1
            // )
              // window.location.href =
                // siteURL + "/myaccount/profile-edit?returnURL=" + returnURL;
            // else window.location.href = siteURL + "/myaccount/profile-edit";
          // }
		  //Commented for above code is commented by manikanta for direct redirect to profile edit page on jan 24
		  window.location.href = siteURL + "/myaccount/profile-edit";
        } else {
          //$("#message_pop").html('Login Failed.');
          toast_message(data, "E");
          $(".progress").hide();
        }
      });
    }
  });

  $(document.body).on("keypress", "#signup input", function (e) {
    if (e.keyCode == 13) {
      $(".progress").show();
      $("#signup").removeClass("error");
      $(".slogin-email-err").hide();
      $(".slogin-pwd-err").hide();
      var email = $("#s_email").val();
      var pawd = $("#s_pawd").val();
      var flag = 0;
      if (email.trim() == "") {
        $(".slogin-email-err").remove();
        if ($(".slogin-email-err").length === 0) {
          $(
            '<div class="alert alert-danger slogin-email-err"><div>E-Mail is required.</div></div>'
          ).insertAfter("#signup #s_email");
        }
        flag = 1;
      }

      if (pawd.trim() == "") {
        $(".slogin-pwd-err").remove();
        if ($(".slogin-pwd-err").length === 0) {
          $(
            '<div class="alert alert-danger slogin-pwd-err"><div>Password is required.</div></div>'
          ).insertAfter("#signup #s_pawd");
        }
        flag = 1;
      }

      if (email.trim() != "" && !isEmail(email.trim())) {
        $(".slogin-email-err").remove();
        $(
          '<div class="alert alert-danger slogin-email-err"><div>Email must be a valid email address</div></div>'
        ).insertAfter("#signup #s_email");
        flag = 1;
      }

      if (pawd.trim() != "") {
        $(".slogin-pwd-err").remove();
        if (pawd.length < 6) {
          $(
            '<div class="alert alert-danger slogin-pwd-err"><div>Password must be at least 6 characters.</div></div>'
          ).insertAfter("#signup #s_pawd");
          flag = 1;
        }
      }

      if (flag == 1) {
        $("#signup").addClass("error");
        $(".progress").hide();
      }

      var returnURL = $("#returnURL").val();
      if (flag == 0 && email != "" && pawd != "") {
        $.get(siteURL + "/api/signup/" + email + "/" + pawd).done(function (
          data
        ) {
          if (data == 1) {
			  //Commented for above code is commented by manikanta for direct redirect to profile edit page on jan 24
            // if (
              // typeof returnURL !== "undefined" &&
              // returnURL != "" &&
              // returnURL.indexOf("online") == -1 &&
              // returnURL.indexOf("events") == -1
            // ) {
              // window.location.href = siteURL + "/" + returnURL;
            // } else {
              // if (
                // returnURL.indexOf("events") !== -1 ||
                // returnURL.indexOf("online") !== -1
              // )
                // window.location.href =
                  // siteURL + "/myaccount/profile-edit?returnURL=" + returnURL;
              // else window.location.href = siteURL + "/myaccount/profile-edit";
            // }
			//Commented for above code is commented by manikanta for direct redirect to profile edit page on jan 24
			 window.location.href = siteURL + "/myaccount/profile-edit";
          } else {
            //$("#message_pop").html('Login Failed.');
            toast_message(data, "E");
            $(".progress").hide();
          }
        });
      }
    }
  });

  $(document.body).on("click", "#age_yes", function () {
    setCookie("age_verification", "1", 30);
    $(".modelageverification").modal("hide");
    //setCookie("store_selection", "1", 30);
    // if (getCookie("store_selection") == "") {
      // $(".modelchainstore").modal("show");
    // }
  });

  $(document.body).on("click", "#age_no", function () {
    setCookie("age_verification", "0", 30);
    $(".modal-footer").hide();
    $("#sorryDialogBody").show();
    $("#age_verf_sec").hide();
  });

  if (
    getCookie("age_verification") == "" ||
    getCookie("age_verification") == "0"
  ) {
    $(".modelageverification").modal("show");
  }

  $(document.body).on("click", ".type_sec", function () {
    var ele_id = "#" + $(this).attr("id");
    //console.log(ele_id);
    $(".menu_sec_div .menu_sec").hide();
    $(ele_id).show();
    //$(ele_id).show();
  });

  $(document.body).on("click", ".var_sec", function () {
    var ele_id = "#" + $(this).attr("id");
    //console.log(ele_id);
    $(ele_id).show();
  });

  $("#checkout").on("submit", function () {
    $(".progress").show();
    //alert($('input[name="PaymentTypeId"]:checked').val());
    if($('input[name="PaymentTypeId"]:checked').val() == '2'){
    	var cart_data = JSON.parse(localStorage.getItem("checkout_data"));
    }else{
    	var cart_data = localStorage.getItem("checkout_data");
    }
    //console.log(cart_data)
    $("#cartinfo").val(cart_data);
    if (
      $('input[name="PaymentTypeId"]:checked').val() == "" ||
      $("#cartinfo").val() == ""
    ) {
      toast_message("Please select payment method", "E");
      $(".progress").hide();
      //console.log("invalid data");
      return false;
    }
    //return false;
  });

  //get related products on prod details page
  var url = $(location).attr("href");
  parts = url.split("/");
  //console.log(parts);
  last_part = parts[parts.length - 1];
  last_before_part = parts[parts.length - 2];
  var last_sub_part = "";
  if (last_before_part == "online" && last_part != "") {
    (sub_parts = last_part.split("-")), (pid = sub_parts[sub_parts.length - 1]);

    var cat = $("#product_category").attr("category");
    //var cat = $("#product_category").attr('type');
	
    var type = parseInt($(".view_more").attr("type"));
    if (isNaN(type)) type = 0;

    if (type <= 0) { type = 0;}
    $.get(siteURL + "/api/relatedProducts/" + cat + "/1-"+type).done(function (data) {
      //  console.log(data);
      $(".related-products-container").html(data);
    });
  }

  $(document.body).on("click", ".view_more", function () {
    var cat = $("#product_category").attr("category");
    var type = parseInt($(this).attr("type"));
    if (isNaN(type)) type = 0;

    if (type <= 0) { type = 0;}
    var page = parseInt($(this).attr("page"));
    if (page < 1) { page = 1; }
    $(this).attr("page", page+1);
    $.get(siteURL + "/api/relatedProducts/" + cat + "/" + page+"-"+type ).done(function (
      data
    ) {
      //  console.log(data);
      $(".related-products-container").html(data);
    });
    
  });


  $(document.body).on("keyup", ".modelchainstore input", function () {
    var value = $(this).val().toLowerCase();
    //console.log(value);
    $(".modelchainstore .modal-body .row").filter(function () {
      //console.log($(this).text().toLowerCase());
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
  });

  //add address
  $(document.body).on("click", "#add-addr-btn", function () {
    $("#add-new-addr-form").show();
    $(".add-new-address").hide();
  });

  //delete address
  $(document.body).on("click", ".addr-del", function () {
    var addr_id = $(this).attr("addr");
    if (addr_id) {
      $(".progress").show();
      $.get(siteURL + "/api/AddressDelete/" + addr_id + "/1").done(function (
        data
      ) {
        //  console.log(data);
        //$(this).closest('address-table-tile').hide();
        window.location.href = siteURL + "/myaccount/manage-addresses/";
      });
    }
  });

  //fav address
  $(document.body).on("click", ".addr-fav", function () {
    var addr_id = $(this).attr("addr");
    if (addr_id) {
      $(".progress").show();
      $.get(siteURL + "/api/AddressFav/" + addr_id + "/1").done(function (
        data
      ) {
        //  console.log(data);
        //$(this).closest('address-table-tile').hide();
        window.location.href = siteURL + "/myaccount/manage-addresses/";
      });
    }
  });

  $(document.body).on("click", ".reset_pwd", function () {
    var r_email = $("#recipient-name").val();
    var device = $("#device_id").val();
    var app = $("#app_id").val();
    var post_data = {
      EmailId: r_email,
      SessionId: "",
      StoreId: 0,
      UserId: 0,
      DeviceType: "W",
      DeviceId: device,
      AppId: app,
    };

    if (r_email != "") {
      $(".progress").show();
      $.post(API_URL + "api/Login/ForgotPassword", post_data).done(function (
        data
      ) {
        //console.log(data);
        if (
          data.Mesaage ==
          "An email has been sent to the registered email address"
        ) {
          $(".forgot-password-container .modal-title").html('Reset your Password?');
          $("#rsec2").show();
          $("#rsec1").hide();
          $(".reset_pwd").addClass("token_submit").removeClass("reset_pwd");
          toast_message(data.Mesaage);
          $(".progress").hide();
        }else {
          $(".fn-err").remove();
          $(
            '<div class="alert alert-danger fn-err"><div>' +
              data.Mesaage +
              "</div></div>"
          ).insertAfter("#recipient-name");
          $(".progress").hide();
        }
      });
    } else {
      $(".fn-err").remove();
      $(
        '<div class="alert alert-danger fn-err"><div>E-Mail is required.</div></div>'
      ).insertAfter("#recipient-name");
    }
  });

  $(document.body).on("click", ".eye .fa", function () {
    if ($(this).hasClass("fa-eye-slash")) {
      $(this).parent().parent().find("input").attr("type", "text");
      $(this).removeClass("fa-eye-slash");
      $(this).addClass("fa-eye");
    } else if ($(this).hasClass("fa-eye")) {
      $(this).parent().parent().find("input").attr("type", "password");
      $(this).removeClass("fa-eye");
      $(this).addClass("fa-eye-slash");
    }
  });

  $(document.body).on("input", "#rsec2 input", function () {
    if ($(this).attr("id") == "fnewpassword") {
      if (
        $(this).val().trim() != "" &&
        $("#fconfirmpassword").val().trim() != ""
      ) {
        if ($(this).val() != $("#fconfirmpassword").val()) {
          $(".reset-pass1-err").remove();
          $(".reset-pass2-err").remove();
          $(
            '<div class="alert alert-danger reset-pass1-err"><div>Password and confirm password are different</div></div>'
          ).insertAfter("#fconfirmpassword");
          $(
            '<div class="alert alert-danger reset-pass2-err"><div>Password and confirm password are different</div></div>'
          ).insertAfter("#fnewpassword");
        } else {
          $(".reset-pass1-err").remove();
          $(".reset-pass2-err").remove();
        }
      } else {
        $(".reset-pass1-err").remove();
        $(".reset-pass2-err").remove();
      }
    }

    if ($(this).attr("id") == "fconfirmpassword") {
      if ($(this).val().trim() != "" && $("#fnewpassword").val().trim() != "") {
        if ($(this).val() != $("#fnewpassword").val()) {
          $(".reset-pass1-err").remove();
          $(".reset-pass2-err").remove();
          $(
            '<div class="alert alert-danger reset-pass2-err"><div>Password and confirm password are different</div></div>'
          ).insertAfter("#fconfirmpassword");
          $(
            '<div class="alert alert-danger reset-pass1-err"><div>Password and confirm password are different</div></div>'
          ).insertAfter("#fnewpassword");
        } else {
          $(".reset-pass1-err").remove();
          $(".reset-pass2-err").remove();
        }
      } else {
        $(".reset-pass1-err").remove();
        $(".reset-pass2-err").remove();
      }
    }

    if ($("#rsec2").hasClass("error")) {
      //console.log($(this).attr("id"));
      if ($(this).attr("id") == "ftoken") {
        if ($(this).val().trim() == "") {
          $(".reset-token-err").remove();
          $(
            '<div class="alert alert-danger reset-token-err"><div>Token is required.</div></div>'
          ).insertAfter("#ftoken");
        } else {
          $(".reset-token-err").remove();
        }
      }

      if ($(this).attr("id") == "fnewpassword") {
        if ($(this).val().trim() == "") {
          $(".reset-pass1-err").remove();
          $(
            '<div class="alert alert-danger reset-pass1-err"><div>Password is required.</div></div>'
          ).insertAfter("#fnewpassword");
        } else if (
          $(this).val().trim() != "" &&
          $("#fconfirmpassword").val().trim() != ""
        ) {
          if ($(this).val() != $("#fconfirmpassword").val()) {
            $(".reset-pass1-err").remove();
            $(".reset-pass2-err").remove();
            $(
              '<div class="alert alert-danger reset-pass2-err"><div>Password and confirm password are different</div></div>'
            ).insertAfter("#fconfirmpassword");
            $(
              '<div class="alert alert-danger reset-pass1-err"><div>Password and confirm password are different</div></div>'
            ).insertAfter("#fnewpassword");
          } else {
            $(".reset-pass1-err").remove();
            $(".reset-pass2-err").remove();
          }
        } else {
          $(".reset-pass1-err").remove();
        }
      }

      if ($(this).attr("id") == "fconfirmpassword") {
        if ($(this).val().trim() == "") {
          $(".reset-pass2-err").remove();
          $(
            '<div class="alert alert-danger reset-pass2-err"><div>Confirm password is required.</div></div>'
          ).insertAfter("#fconfirmpassword");
        } else if (
          $(this).val().trim() != "" &&
          $("#fnewpassword").val().trim() != ""
        ) {
          if ($(this).val() != $("#fnewpassword").val()) {
            $(".reset-pass1-err").remove();
            $(".reset-pass2-err").remove();
            $(
              '<div class="alert alert-danger reset-pass2-err"><div>Password and confirm password are different</div></div>'
            ).insertAfter("#fconfirmpassword");
            $(
              '<div class="alert alert-danger reset-pass1-err"><div>Password and confirm password are different</div></div>'
            ).insertAfter("#fnewpassword");
          } else {
            $(".reset-pass1-err").remove();
            $(".reset-pass2-err").remove();
          }
        } else {
          $(".reset-pass2-err").remove();
        }
      }
    }
  });


  //reset password token submit
  $(document.body).on("click", ".token_submit", function () {
    var token = $("#ftoken").val();
  var flag = 0;
  $("#rsec2").removeClass("error");
  if (token.trim() == "") {
    $(".reset-token-err").remove();
    $(
      '<div class="alert alert-danger reset-token-err"><div>Token is required.</div></div>'
    ).insertAfter("#ftoken");

    flag = 1;
  }

  if ($("#fnewpassword").val().trim() == "") {
    $(".reset-pass1-err").remove();
    $(
      '<div class="alert alert-danger reset-pass1-err"><div>Password is required.</div></div>'
    ).insertAfter("#fnewpassword");

    flag = 1;
  }

  if ($("#fconfirmpassword").val().trim() == "") {
    $(".reset-pass2-err").remove();
    $(
      '<div class="alert alert-danger reset-pass2-err"><div>Confirm password is required.</div></div>'
    ).insertAfter("#fconfirmpassword");

    flag = 1;
  }
    if ($("#fnewpassword").val().trim() != "" && $("#fconfirmpassword").val().trim() != "") {
      if ($("#fnewpassword").val() != $("#fconfirmpassword").val()) {
        $(".reset-pass1-err").remove();
        $(".reset-pass2-err").remove();
        $(
          '<div class="alert alert-danger reset-pass1-err"><div>Password and confirm password are different</div></div>'
        ).insertAfter("#fconfirmpassword");
        $(
          '<div class="alert alert-danger reset-pass2-err"><div>Password and confirm password are different</div></div>'
        ).insertAfter("#fnewpassword");

        flag = 1;
      }
    }

  if (flag == 1) {
    $("#rsec2").addClass("error");
    return false;
  } else {
  $(".progress").show();
  var post_data = {
    Token: token,
    SessionId: "",
    Password: $("#fnewpassword").val(),
  };

  if (token != "") {
    $.post(API_URL + "api/Login/ResetPassword", post_data).done(function (
      data
    ) {
      console.log(data);
      if (1) {
        $(".forgot-password-container .modal-title").html(
          "Forgot your Password?"
        );
        $(
          "#rsec1 input[type=text], #rsec1 input[type=email], #rsec1 input[type=password]"
        ).val("");
        $(
          "#rsec2 input[type=text], #rsec2 input[type=email], #rsec2 input[type=password]"
        ).val("");
        $("#rsec2").hide();
        $("#rsec1").show();
        //$("#forgotModal").modal("toggle");
        //toast_message("Password reset is succesful.");
        //$(".progress").hide();
        //window.location.href = siteURL + "/login?returnURL=s";
	if (data.message.includes("again") || data.message.includes("expired"))
         window.location.href = siteURL + "/login?returnURL=e";
        else
         window.location.href = siteURL + "/login?returnURL=s";
      }
    });
  }
}
  });

  //event register
  $(document.body).on("click", ".register-event", function () {
    var event_id = $(this).attr("event_id");

    $(this).attr("disabled", "disabled");
    if (event_id) {
      $(".progress").show();
      $.get(siteURL + "/api/EventRegister/" + event_id + "/1").done(function (
        data
      ) {
        $(this).attr("disabled", "disabled");
        toast_message("Successfully registered for event.");
        $(".progress").hide();
        //  console.log(data);
        //$(this).closest('address-table-tile').hide();
        //window.location.href = siteURL + "/events/";
      });
    }
  });

  //check address in chcekout
  $(document.body).on("click", ".check_address", function () {
    var addr_id = $(this).val();
    if (addr_id) {
      $(".progress").show();
	  var ctype = $("#ctype").val();
	  //console.log(ctype);
      window.location.href = siteURL + "/checkout/"+ctype+"/" + addr_id;
      /*$.get(siteURL + "/api/cartUpdate/" + addr_id + "/1").done(function (
        data
      ) {
          console.log(data);
          $(this).closest(".checkout-tile .checkout-content .addr_status").html(data);
          if (data != '') {
              $("#checkout_submit").attr('disable', true);
          } else {
              $("#checkout_submit").attr("disable", false);
          }
        //$(this).closest('address-table-tile').hide();
        //window.location.href = siteURL + "/myaccount/manage-addresses/";
      });*/
    }
  });

  $(document.body).on("click", ".checkout-addr-tile", function () {
    var addr_id = $(this).attr("CAddrId");
    if (addr_id) {
      $(".progress").show();
	  var ctype = $("#ctype").val();
	  //console.log(ctype);
      window.location.href = siteURL + "/checkout/"+ctype+"/" + addr_id;
    }
  });

  $(document.body).on("focus", ".tip-amount", function () {
    if($(this).val() == ''){
      $(this).removeAttr('placeholder');
    }
  });

  $(document.body).on("focusout", ".tip-amount", function () {
    if($(this).val() == ''){
      $(this).attr('placeholder', '00.00');
    }
  });

  $(document.body).on("click", ".tip", function () {
    var tip = $(this).attr("id");
    $(".progress").show();
    $(".tip-amount").val("");
    //console.log(tip);
    if (tip == 3) {
      $(".tip-container").show();
      var tip_amount = $(".tip-amount").val();
      $(".tip-amount").focus();
      //console.log(tip_amount);
      if (tip_amount) {
        //window.location.href = siteURL + "/checkout/delivery/to/" + tip_amount;
      }

      if(tip_amount == ''){
        $(".tip-amount").attr('placeholder', '00.00');
        if($("#fstate").val() == '1'){

        }else{
          $("#checkout_submit").attr("disabled", "disabled");
        }
      }else{
        if($("#fstate").val() == '1'){

        }else{
          $("#checkout_submit").removeAttr("disabled");
        }
      }
    } else {
      if($("#fstate").val() == '1'){

      }else{
        $("#checkout_submit").removeAttr("disabled");
      }

      $(".tip-container").hide();
      //window.location.href = siteURL + "/checkout/delivery/t/" + tip;

      var cartDetails = JSON.parse(localStorage.getItem("checkout_data"));

      //$tip_id = $routeParams['tip'];
      //cnt = 0;
      for (var i = 0; i < cartDetails.ListTipForDriver.length; i++) {
        if (i == tip) {
          //cartDetails.ListTipForDriver[i].IsDeafault = true;
          tip_charge = cartDetails.ListTipForDriver[i].TipAmount;
          tip_charge_display = cartDetails.ListTipForDriver[i].TipAmountDisplay;
        } else {
          cartDetails.ListTipForDriver[i].IsDeafault = false;
        }
        //cnt++;
      }

      for (var j = 0; j < cartDetails.ListCharge.length; j++) {
        if (cartDetails.ListCharge.ChargeType == "Tip For Driver") {
          cartDetails.ListCharge[j].ChargeAmount = tip_charge;
          cartDetails.ListCharge[j].ChargeAmountDisplay = tip_charge_display;
        }
      }
      cartDetails.TipForDriver = tip_charge;

      $.post(API_URL + "api/Cart/CartUpdate", cartDetails).done(function (
        data
      ) {
        if (data.MessageType == "E") {
          window.location.href = siteURL + "/checkout/delivery";
        }
        $(".Tip_sec").html(tip_charge_display);
        $(".total-main .total-right").html(data.TotalValueDisplay);
        toast_message("Tip Applied.", "S");
        localStorage.setItem("checkout_data", JSON.stringify(data));
        $(".progress").hide();
      });

    }
    $(".progress").hide();
  });

  /*$(document.body).on("input", ".tip-amount", function () {
    var tip = 3;
    if (tip == 3) {
      $(".progress").show();
      $(".tip-container").show();
      var tip_amount = $(".tip-amount").val();
      //console.log(tip_amount);
      //if (tip_amount) {
        window.location.href = siteURL + "/checkout/delivery/to/" + tip_amount;
      //}
      $(".progress").hide();
    }
  });*/

  $(document.body).on("focusout", ".tip-amount", function () {
    var tip = 3;
    if (tip == 3) {
      $(".progress").show();
      $(".tip-container").show();
      var tip_amount = $(".tip-amount").val();
      //console.log(tip_amount);
      //if (tip_amount) {
      // window.location.href = siteURL + "/checkout/delivery/to/" + tip_amount;
      //}
      
      if(tip_amount == ''){
        
          if($("#fstate").val() == '1'){
  
          }else{
            $("#checkout_submit").attr("disabled", "disabled");
          }
          $(".progress").hide();
          return false;
        //$('input[name=tip]:checked').trigger("click");

        /*$('.tip').each(function(e){
          //console.log($(this).attr('default'));
          if($(this).attr("default") == true || $(this).attr("default") == 'true'){
              console.log($(this).attr('id'));
              $(this).trigger("click");
              e.preventDefault();
              return false;
          }
        });*/
      }else{
        if($("#fstate").val() == '1'){
  
        }else{
          $("#checkout_submit").removeAttr("disabled");
        }
      }

      var cartDetails = JSON.parse(localStorage.getItem("checkout_data"));

      //$tip_id = $routeParams['tip'];
      //cnt = 0;
      for (var i = 0; i < cartDetails.ListTipForDriver.length; i++) {
        if (i == tip) {
          //cartDetails.ListTipForDriver[i].IsDeafault = true;
          cartDetails.ListTipForDriver[i].TipAmount = tip_amount;
          cartDetails.ListTipForDriver[i].TipAmountDisplay = "$".tip_amount;
        } else {
          //cartDetails.ListTipForDriver[i].IsDeafault = false;
        }
        //cnt++;
      }

      //$charge_cnt = 0;

      for (var j = 0; j < cartDetails.ListCharge.length; j++) {
        if (cartDetails.ListCharge.ChargeType == "Tip For Driver") {
          cartDetails.ListCharge[j].ChargeAmount = tip_amount;
          cartDetails.ListCharge[j].ChargeAmountDisplay = "$".tip_amount;
        }
        //$charge_cnt++;
      }
      cartDetails.TipForDriver = tip_amount;

      //console.log(cartDetails);
      $.post(API_URL + "api/Cart/CartUpdate", cartDetails).done(function (
        data
      ) {
        if (data.MessageType == "E") {
          window.location.href = siteURL + "/checkout/delivery";
        }
        var selected_tip;
        for (var i = 0; i < data.ListTipForDriver.length; i++) {
          if ((data.ListTipForDriver[i].IsDeafault = true)) {
            data.ListTipForDriver[i].IsDeafault = true;
            tip_charge = data.ListTipForDriver[i].TipAmount;
            tip_charge_display = data.ListTipForDriver[i].TipAmountDisplay;
            selected_tip = i;
            //$("#3").click();
            
            /*if (i != '3') {
                $(".tip-amount").hide();
              } else {
                $(".tip-amount").show();
              }*/
            //$("#" + i).attr("checked", 'checked');
          } else {
            data.ListTipForDriver[i].IsDeafault = false;
          }
          //cnt++;
        }

        if (tip_amount == "") {
          $("#" + selected_tip).click();
        }

        $(".Tip_sec").html(tip_charge_display);
        $(".tip-amount").val(parseFloat(tip_charge).toFixed(2));
        $(".total-main .total-right").html(data.TotalValueDisplay);
        if (tip_amount != "") {
          toast_message("Tip Applied.", "S");
        }
        localStorage.setItem("checkout_data", JSON.stringify(data));

        $(".progress").hide();
      });

      $(".progress").hide();
    }
  });


  $(document.body).on("click", ".coupon", function (e) {
    $(".progress").show();
    e.preventDefault();
    var coupon_code = $(".coupon_code").val();
    if(coupon_code.trim() != '') {
    var cartDetails = JSON.parse(localStorage.getItem("checkout_data"));

    cartDetails.CouponCode = $(".coupon_code").val();
    
    //console.log(cartDetails);
    $.post(API_URL + "api/Cart/CartUpdate", cartDetails).done(function (
        data
      ) {
        //console.log(data);
        if (data.CouponRemark == "") {
          //window.location.href = siteURL + "/checkout/delivery";
          $(".total-main .total-right").html(data.TotalValueDisplay);
          $(".tot_savings").html(data.TotalSavingsDisplay);

          for (var i = 0; i < data.ListCharge.length; i++) {
            if(data.ListCharge[i].ChargeTitle == 'Tax'){
            $(".Tax_sec").html(data.ListCharge[i].ChargeAmountDisplay);
            }
          }
         
          var tr_html = '<td colspan="3"><table><tbody>';
          for (var i = 0; i < data.ListDiscount.length; i++) {
            tr_html += '<tr><td width="25px"></td><td><h5>'+data.ListDiscount[i].DiscountTitle+'</h5></td><td class="text-right"><h4>'+data.ListDiscount[i].DiscountAmountDisplay+'</h4></td></tr>'
          }
          tr_html += '</tbody></table></td>';
          $(".saving_display_sec").html(tr_html);
          
          if(data.TotalSavings>0){
          $(".savings_label").html("<i class='savings_icon fa fa-plus-circle'></i> Savings");
          }else{
            $(".savings_label").html("Savings");
          }

          toast_message("Promo Applied Succesfully.", "S");
          $(".promo-sec").html('<span class="promo-msg"><img src="../../assets/images/icon-couponapplied.png" class="coupon-applied">Applied Promo ' + coupon_code + '<i class="fa fa-times coupon-close"></i></span>');

        }
        else {
          toast_message(data.CouponRemark, "E");
        }
        localStorage.setItem("checkout_data", JSON.stringify(data));

        $(".progress").hide();
      });

      $(".progress").hide();
    }else{
      toast_message("Please enter valid promo code", "E");
      $(".progress").hide();
    }
  });


  $(document.body).on("click", ".coupon-close", function (e) {
    $(".progress").show();
    //e.preventDefault();
    var coupon_code ='';
    
    var cartDetails = JSON.parse(localStorage.getItem("checkout_data"));

    cartDetails.CouponCode = '';
    
    //console.log(cartDetails);
    $.post(API_URL + "api/Cart/CartUpdate", cartDetails).done(function (
        data
      ) {
        //console.log(data);
        if (data.CouponRemark == "") {
          //window.location.href = siteURL + "/checkout/delivery";
          $(".total-main .total-right").html(data.TotalValueDisplay);
          $(".tot_savings").html(data.TotalSavingsDisplay);

          for (var i = 0; i < data.ListCharge.length; i++) {
            if(data.ListCharge[i].ChargeTitle == 'Tax'){
            $(".Tax_sec").html(data.ListCharge[i].ChargeAmountDisplay);
            }
          }

          var tr_html = '<td colspan="3"><table><tbody>';
          for (var i = 0; i < data.ListDiscount.length; i++) {
            tr_html += '<tr><td width="25px"></td><td><h5>'+data.ListDiscount[i].DiscountTitle+'</h5></td><td class="text-right"><h4>'+data.ListDiscount[i].DiscountAmountDisplay+'</h4></td></tr>'
          }
          tr_html += '</tbody></table></td>';
          $(".saving_display_sec").html(tr_html);

          if(data.TotalSavings>0){
            $(".savings_label").html("<i class='savings_icon fa fa-minus-circle'></i> Savings");
          }else{
            $(".savings_label").html("Savings");
          }

          toast_message("Promo revoked Succesfully.", "S");
          $(".promo-sec").html('<input class="form-control input-promo coupon_code" placeholder="Apply promo code"><button class="btn submit coupon">Apply</button>');

        }
        else {
          toast_message(data.CouponRemark, "E");
        }
        localStorage.setItem("checkout_data", JSON.stringify(data));

        $(".progress").hide();
      });

      $(".progress").hide();
    
  });

  $(document.body).on("click", ".savings_icon", function (e) {
    $(".saving_display_sec").toggle();
    if($(this).hasClass("fa-plus-circle"))
    $(this).removeClass("fa-plus-circle").addClass("fa-minus-circle");
    else
    $(this).removeClass("fa-minus-circle").addClass("fa-plus-circle");
  });

  $('form#checkout input:not([type="submit"])').keydown(function(e) {
    if (e.keyCode == 13) {
        e.preventDefault();
	//console.log($(this).attr('class'));
	$(this).trigger('focusout');
        return false;
    }
  });

  $(document.body).on("click", ".rating-icon a", function () {
    var curIndex = $(this).index();
    //console.log(curIndex);
    $("#rating_score").val(curIndex + 1);
    $(".rating-icon a").each(function (index) {
      if (index <= curIndex) {
        $(this).find(".fa").addClass("fa-star");
        $(this).find(".fa").removeClass("fa-star-o");
      } else {
        $(this).find(".fa").addClass("fa-star-o");
        $(this).find(".fa").removeClass("fa-star");
      }
    });
  });

  $(document.body).on("click", ".review-edit .edit-icon", function () {
    $(".add_review").show();
    $(".add_review h4").html("Edit Review");
    $(".add_review .hidden").removeClass("hidden");
    //console.log($(this).closest(".review_desc").html());
    //$(this).closest(".review_desc").css("background", "red");
    //$(".addreviewmsg").val($(this).closest(".review_desc").html());
  });

  $(document.body).on("click", ".dec_circle", function () {
    var block_cls = "." + $(this).attr("id");
    if ($(this).find(".fa").hasClass("fa-minus-circle")) {
      $(this).find(".fa").addClass("fa-plus-circle");
      $(this).find(".fa").removeClass("fa-minus-circle");
    } else {
      $(this).find(".fa").removeClass("fa-plus-circle");
      $(this).find(".fa").addClass("fa-minus-circle");
    }    

    $(block_cls).toggle();
  });

  //order cancel
  $(document.body).on("click", ".order_cancel", function () {
    var order_id = $(this).attr("order_id");
    $(".progress").show();
    var parent_class = "." + $(this).attr("id");
    var element1 = parent_class + " .first_sec .status";
    var element2 = parent_class + " .first_sec .delevary_color";
    $(element1).attr(
      "src",
      "http://console.accrueretail.com/Images/OrderStatus/OrderCancelled.png"
    );

    $(element2).html("Cancelled");

    $(this).parent("li").hide();

    if (order_id) {
      $.get(siteURL + "/api/OrderCancel/" + order_id + "/1").done(function (
        data
      ) {
        toast_message("Your order has been canceled successfully.");
        $(".progress").hide();
      });
    }
  });

  //re-order
  $(document.body).on("click", ".order_reorder", function () {
    var order_id = $(this).attr("order_id");
    if (order_id) {
      $(".progress").show();
      $.get(siteURL + "/api/ReOrder/" + order_id + "/1").done(function (data) {
        //toast_message("Your order has been added to cart successfully.");
        window.location.href = siteURL + "/cart";
      });
    }
  });

  //top menu click fix

  $(".navbar .dropdown").hover(
    function () {
      $(this)
        .find(".dropdown-menu")
        .first()
        .stop(true, true)
        .delay(250)
        .slideDown();
    },
    function () {
      $(this)
        .find(".dropdown-menu")
        .first()
        .stop(true, true)
        .delay(100)
        .slideUp();
    }
  );

  $(".navbar .dropdown > a").click(function () {
    location.href = this.href;
  });

   //refresh uri when clicks on menu
   /*$("#navbar ul").click(function () {
       $.get(siteURL + "/?refresh=1" );
  });*/

  $.urlParam = function (name, uri) {
    var results = new RegExp("[?&]" + name + "=([^&#]*)").exec(uri);
    if (results == null) {
      return null;
    } else {
      return results[1] || 0;
    }
  };

  $(document.body).on("click", ".m-menu", function () {
    //console.log("toggle classes");
    $(this).toggleClass("open");
    $("#hide-menu").toggleClass("show-menu");
  });

  $("input[name='phone'], input[name='pContactNo'], input[name='aContactNo']").keyup(function () {
    /*$(this).val(
      $(this)
        .val()
        .replace(/^(\d{3})(\d{3})(\d+)$/, "($1)-$2-$3")
    );*/
    let newVal = $(this).val().replace(/\D/g, "");

    if (newVal.length === 0) {
      newVal = "";
    } else if (newVal.length <= 3) {
      newVal = newVal.replace(/^(\d{0,3})/, "($1)");
    } else if (newVal.length <= 6) {
      newVal = newVal.replace(/^(\d{0,3})(\d{0,3})/, "($1)-$2");
    } else if (newVal.length <= 10) {
      newVal = newVal.replace(/^(\d{0,3})(\d{0,3})(\d{0,4})/, "($1)-$2-$3");
    } else {
      newVal = newVal.substring(0, 9);
      newVal = newVal.replace(/^(\d{0,3})(\d{0,3})(\d{0,4})/, "($1)-$2-$3");
    }
    $(this).val(newVal);
  });

  function toast_message(msg, state = "S") {
    $(".toast .toast-message").html(msg);
    $(".toast").removeClass("toast-success");
    $(".toast").removeClass("toast-error");
    $(".toast").show();
    if (state == "S") {
      $(".toast").addClass("toast-success");
    } else {
      $(".toast").addClass("toast-error");
    }
    setTimeout(function () {
      $(".toast").hide();
    }, 5000);
  }
  //Myprofile toast message form submit
  $( ".profile-edit-section form").submit(function( event ) {
    var pFirstName = $("input[name='pFirstName']").val(); 
  var pLastName = $("input[name='pLastName']").val();
  var pContactNo = $("input[name='pContactNo']").val().length;
  var pDOB  = $("input[name='pDOB']").val();
  var pEmail = $("input[name='pEmail']").val();
  if(pFirstName != '' && pLastName!='' && pContactNo>13 && pDOB!='' && pEmail!=''){
    //toast_message("Profile Updated Successfully");
  }

   
  });
//manage address form submit
$( "#manage_address" ).submit(function( event ) {

  var pFirstName = $("input[name='pFirstName']").val().length; 
  var pLastName = $("input[name='pLastName']").val();
  var pContactNo = $("input[name='pContactNo']").val().length;
  var aFirstName  = $("input[name='aFirstName']").val().length;
  var aLastName = $("input[name='aLastName']").val();
  var aAddress1 = $("input[name='aAddress1']").val();
  var aCity = $("input[name='aCity']").val();
  var aState  = $("input[name='aState']").val().length;
  var aContactNo = $("input[name='aContactNo']").val().length;
  var aZip  = $("input[name='aZip']").val();
  
 
  if(pFirstName == 2 && pLastName!='' && pContactNo == 14 && aFirstName == 2 && aLastName!='' && aAddress1!='' && aCity!='' &&aState ==2 && aZip!='' && aContactNo!=''){
    toast_message("Address added Successfully");
  }
  
  
 
 
});
  setTimeout(function () {
    $(".toast").hide();
  }, 5000);
  


  function getUrlParamVal(name, uri) {
    var results = new RegExp("[?&]" + name + "=([^&#]*)").exec(uri);
    //console.log(results)
    return results[1] || 0;
  }

  function updateQueryStringParameter(uri, key, value) {
    var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
    var separator = uri.indexOf("?") !== -1 ? "&" : "?";
    if (uri.match(re)) {
      return uri.replace(re, "$1" + key + "=" + value + "$2");
    } else {
      return uri + separator + key + "=" + value;
    }
  }

  function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
  }

  function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(";");
    for (var i = 0; i < ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) == " ") {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
  }

  $(".datepicker").on("input", function () {
    $(".datepicker").datepicker("hide");   
    if (!ValidateDOB()) {
      if ($(this).val() == '') {
        $(".dt-err").hide();
      } else {
        $(".dt-err").show();
      }
      //$(".profile_save").attr("disabled", "disabled");
    } else {
      $(".dt-err").hide();
     // $(".profile_save").removeAttr("disabled");
    }
  });

  function ValidateDOB() {
    var lblError = document.getElementById("dob_label");

    //Get the date from the TextBox.
    var dateString = document.getElementById("dob").value;
    if (dateString == '') {
      $(".dt-err").hide();
      lblError.innerHTML = "";
      return false;
    }
    //var regex = /(((0|1)[0-9]|2[0-9]|3[0-1])\/(0[1-9]|1[0-2])\/((19|20)\d\d))$/;
    var regex = /(0[1-9]|1[0-2])\/(((0|1)[0-9]|2[0-9]|3[0-1])\/((19|20)\d\d))$/;

    //Check whether valid dd/MM/yyyy Date Format.
    if (regex.test(dateString)) {
      var parts = dateString.split("/");
      var dtDOB = new Date(parts[2] + "/" + parts[0] + "/" + parts[1]);
      var dtCurrent = new Date();
      lblError.innerHTML = "Age should be greater than 21.";
      if (dtCurrent.getFullYear() - dtDOB.getFullYear() < 21) {
        return false;
      }

      if (dtCurrent.getFullYear() - dtDOB.getFullYear() == 21) {
        //CD: 11/06/2018 and DB: 15/07/2000. Will turned 18 on 15/07/2018.
        if (dtCurrent.getMonth() < dtDOB.getMonth()) {
          return false;
        }
        if (dtCurrent.getMonth() == dtDOB.getMonth()) {
          //CD: 11/06/2018 and DB: 15/06/2000. Will turned 18 on 15/06/2018.
          if (dtCurrent.getDate() < dtDOB.getDate()) {
            return false;
          }
        }
      }
      lblError.innerHTML = "";
      return true;
    } else {
      lblError.innerHTML = "Please provide a valid date of birth.";
      return false;
    }
  }

  $("#pImage").on("change", function (event) {
    var reader = new FileReader();
    reader.onload = function () {
      var output = document.getElementById("profile_imge_output");
      output.src = reader.result;
      $("#profile_imge_output").show();
      $("#profile_pic").val(reader.result);
    };
    reader.readAsDataURL(event.target.files[0]);
  });

  $(".profile-edit-section form").on("submit", function () {
    var flag = 0;
    if ($("input[name='pFirstName']").val().trim() == "") {
      if ($(".fn-err").length === 0) {
        $(
          '<div class="alert alert-danger fn-err"><div>FirstName is required.</div></div>'
        ).insertAfter("input[name='pFirstName']");
      }
      flag = 1;
    } else {
      $(".fn-err").remove();
    }

    if ($("input[name='pLastName']").val().trim() == "") {
      if ($(".ln-err").length === 0) {
        $(
          '<div class="alert alert-danger ln-err"><div>LastName is required.</div></div>'
        ).insertAfter("input[name='pLastName']");
      }
      flag = 1;
    } else {
      $(".ln-err").remove();
    }

    if ($("input[name='pContactNo']").val().trim() == "") {
      if ($(".cn-err").length === 0) {
        if ($(".cn2-err").length) {
          $(".cn2-err").remove();
        }
        $(
          '<div class="alert alert-danger cn-err"><div>Phone Number is required.</div></div>'
        ).insertAfter("input[name='pContactNo']");
      }
      flag = 1;
    } else if ($("input[name='pContactNo']").val().trim().length != 14) {
      if ($(".cn2-err").length === 0) {
        if ($(".cn-err").length) {
          $(".cn-err").remove();
        }
        $(
          '<div class="alert alert-danger cn2-err"><div>ENTER VALID PHONE NUMBER.</div></div>'
        ).insertAfter("input[name='pContactNo']");
      }
      flag = 1;
    } else {
      $(".cn-err").remove();
      $(".cn2-err").remove();
    }

    if ($("#dob").val().trim() == "") {
      $("#dob_label").html("DOB IS REQUIRED.");
      $(".dt-err").show();
      flag = 1;
    }else if (!ValidateDOB()) {
      $(".dt-err").show();
      flag = 1;
    }

    if (flag == 1) {
      return false;
    }
  });
  


  $(document.body).on("change", "#dateList", function () {
    var date_selected = $(this).val();
    $(".progress").show();
    if (date_selected != '')
    {
      date_selected = date_selected.replace("/", "-");
      date_selected = date_selected.replace("/", "-");
      window.location.href = siteURL + "/checkout/delivery/sd/" + date_selected;
    }
  });
  
  $(document.body).on("change", "#timeList", function () {
    var date_selected = $(this).val();
    $(".progress").show();
    //console.log(tip);
    if (date_selected != "") {
      window.location.href = siteURL + "/checkout/delivery/st/" + date_selected;
    }
  });


  $(document.body).on("click", ".tip-icon", function () {
    if ($(this).hasClass("exapand-icon")) {
      $(".tipdown").css("display", "none");
      $(this).removeClass("exapand-icon");
      $(this)
        .find(".fa")
        .removeClass("fa-minus-circle")
        .addClass("fa-plus-circle");
    }
    else {
      $(".tipdown").css("display", "table-cell");
      $(this).addClass("exapand-icon");
      $(this)
        .find(".fa")
        .removeClass("fa-plus-circle")
        .addClass("fa-minus-circle");
    }
  });

  $(document.body).on("change", ".payment-option-select input:radio", function () {
    $(".payment-option-select input:radio").attr("checked", false);
    $(this).attr("checked", true);
	  $(".payment-option-select input:radio").closest(".payatstorenew").removeClass("active");
    if ($(this).closest(".payatstorenew").hasClass("active")) {
      $(this).closest(".payatstorenew").removeClass("active");
    } else {
      $(this).closest(".payatstorenew").addClass("active");
    }
  });

  $(document.body).on("click", "#reviews .fa-angle-down", function () {
    //fetch reviews
    var product_id = $(".pro-detail").attr("id");
    var page_num = $(this).attr("page_num");

    //console.log("ptod= " + product_id);
    $(this).attr("page_num", parseInt(page_num) + 1);
    if (product_id) {
      $.get(siteURL + "/api/getReviews/" + product_id + "/" + page_num).done(
        function (data) {
          data1 = JSON.parse(data);
          //console.log(data1.TotalCount);
          //console.log(page_num);
          var html = "";
          var cnt = 1;
          //if (parseInt(page_num) * 3 <= data1.TotalCount) {
            for (var review_obj in data1.ListReview) {
              if (page_num == 1 && cnt == 1) {

              } else {
                html +=
                  '<div class="reviews listr" id="exreview"><div class="col-md-12"><div class="row">';

                html +=
                  '<div class="user-review-dp" ><img class="img-responsive" src="' +
                  data1.ListReview[review_obj].UserImage +
                  '"  style="width:54px;height:54px;border-radius:50%;"></div>';

                html +=
                  '<div class="user-review-content"><div class="name_date">';
                html +=
                  '<span class="title">' +
                  data1.ListReview[review_obj].UserName +
                  '</span> - <small class="text-muted"> ' +
                  data1.ListReview[review_obj].TimePeriod +
                  "</small></div>";

                html += '<div class="star_right rating-stars">';
                html +=
                  '<span class="star-rating" ><i class="fa fa-star"></i><span> ' +
                  data1.ListReview[review_obj].ReviewRating +
                  '</span></span></div><p class="caption"></p>';

                html +=
                  '<p class="word_break caption"> ' +
                  data1.ListReview[review_obj].ReviewDescription +
                  " </p>";
                html += "</div></div></div></div>";
              }
              cnt += 1;
            } //for
          //} //if

          //console.log(parseInt(page_num) * 3 + "" + data1.TotalCount);
          var cur_results = parseInt(page_num) * 3;
          var tot_results = parseInt(data1.TotalCount);
          if (cur_results >= tot_results) {
            //console.log("en of page");
            $(".more-reviews").attr("page_num", "1");
            $(".more-reviews").removeClass("fa-angle-down");
            $(".more-reviews").addClass("fa-angle-up");
          }
          $("#reviews_show").append(html);
        }
      );
    }
  });

  $(document.body).on("click", "#reviews .fa-angle-up", function () {
    $("#reviews_show").html('');
    $(".more-reviews").attr("page_num", "1");
    $(this).removeClass("fa-angle-up").addClass("fa-angle-down");
  });

  $("#forgotModal").on("hidden.bs.modal", function () {
    // put your default event here
    $("#rsec1 #recipient-name").val("");
    $("#rsec1 .fn-err").remove();
  });



});
//Manage addresses should be 2 digits

       
//  function checkState(){
  
//   var astate = $('#astate').val();
//    $('#astate-error').html(''); 
//    if(astate.length!="2"){
//   $('#astate-error').html('State Should be Max 2 Characters'); 
//  }
// }
//manage address total form validations
// input fields can't be blank
jQuery(document).ready(function() {
  jQuery(".add_manage_address").validate({
    
     rules: {
      pFirstName: {
           required: true,
         
         minlength: 2,
         maxlength:100,
        },
        pLastName: {
                required: true,
             
             maxlength:100,
       },
       aFirstName: {
              required: true,
            minlength: 2,
            maxlength:100,
     },
     aLastName: {
             required: true,
            maxlength:1000,
    },
    pContactNo: {
      minlength: 14,
      maxlength: 14,
      required: true,
         },
    
  aAddress1:{
    required: true,
     maxlength: 100000,
  },
  aCity:{
    required: true,
        maxlength: 100000,
  },
  aState:{
    required: true,
    lettersonly: true,
    minlength:2,
    maxlength:2,
    
  },
  aZip:{
    required: true,
    alphanumeric: true,
     minlength: 5,
  },
  aContactNo:{
    required: true,
    minlength: 14,
      maxlength: 14,
   
  }
        
     },
   messages: {
    pFirstName: {
       required: "First Name is required",
       minlength: "FIRST NAME SHOULD BE AT LEAST 2 CHARACTERS"
     },
     pLastName: {
      required: "Last Name is required",
       
     },
     aFirstName: {
      required: "First Name is required",
      minlength: "FIRST NAME SHOULD BE AT LEAST 2 CHARACTERS"
     },
     
     aLastName: {
      required: "Last Name is required",
   },
     aContactNo: {
    required: "Phone Number is required",
    minlength : "ENTER VALID PHONE NUMBER",
    },
     pContactNo: {
       required: "Phone Number is required",
       minlength : "ENTER VALID PHONE NUMBER",
      },
     aState:{
      lettersonly: "Please Provide 2 Characters",
      required: "State is required",
      minlength:"State Should be Max 2 Characters",
      maxlength:"Please Provide only 2 Characters",
    },
    aCity:{
     required: "City is required",
   },
    aZip:{
      required: "Zip is required"
  },
     aAddress1:{
      required: "Address is required"
    }
 }
  

  
 
  });
});
//letters only
jQuery.validator.addMethod("lettersonly", function(value, element) {
  return this.optional(element) || /^[a-z]+$/i.test(value);
 }, "Please enter only letters "); 
 //email validation
 jQuery.validator.addMethod("customEmail", function(value, element) {
  return this.optional(element) || /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i.test(value);
 }, "Please enter valid email address!");
 //alpha numeric
 jQuery.validator.addMethod("alphanumeric", function(value, element) {
    return this.optional(element) || /^[a-zA-Z0-9]+$/i.test(value);
 }, "Letters and Numbers only please");

 //featured product pagination
var pageNo=1;
$("#prev").hide();
function productsPagination(type){
  $(".progress").show();
  //let pageNo = pageNumber;
 // $(".featured-products-container").html("<h1 class='text-center'>Loading...</h1>");
 var no_of_pages = $("#next").attr("no_of_pages");
  //var totalPages = Math.ceil(totalProducts/12);
  //console.log("no_of_pages:"+no_of_pages);
  if(type == 'Next' ){
    //$("#next").show();

    pageNo++;
    if(parseInt(pageNo)<no_of_pages){
      setTimeout(function () {
        $("#next").show();
      }, 1000);
      
    }else{
      setTimeout(function () {
        $("#next").hide();
      }, 1000);
      
    }

    if(parseInt(pageNo)<=no_of_pages){
      setTimeout(function () {
        $("#prev").show();
      }, 1000);
    }
    
  }else if(type == 'Previous'){
   
      pageNo--;
      //console.log("pageno"+pageNo);
        if(parseInt(pageNo)>1){
          setTimeout(function () {
            $("#next").show();
            $("#prev").show();
          }, 1000);
          
        //console.log("if");
        }else{
          //console.log("else");
          setTimeout(function () {
            $("#prev").hide();
          }, 1000);
     
      }

      if(parseInt(no_of_pages)>1){
        setTimeout(function () {
          $("#next").show();
          
        }, 1000);
      }

  }else{
    
  }
  // console.log(pageNo);
  // console.log(no_of_pages);
  var category = $("#featured_vals").attr("fcategory");
   if (pageNo) {
      $.get(siteURL + "/api/getPagination/" + pageNo+"/"+category).done(
        function (data) {
          // alert( "Data Loaded: " + data );
        //console.log("Data Loaded: " + data);
         $(".featured-products-container").html(data);
          $(".progress").hide();
          
        }

      );
    }
 
}

$(".menu_sec_div a.nav-link").on("click", function(){
  $(this).closest(".nav-pills").find('.nav-link').removeClass("fade").removeClass("active").removeClass("in");
  $(this).addClass("fade").addClass("active").addClass("in");
});


$(".payment-option-select .radio-custom").on("click", function(){
	if($(".payment-option-select .radio-custom:checked").val() == '8'){
		// $(".agree-pickup").html('<div class="col-md-12"><input type="checkbox" name="ack" id="ack"><span class="ccd">For orders $'+$(".agree-pickup").attr('limit')+' or more, I agree to present my ID and Credit Card used for the order at time of pickup.</span> <span class="checkmark"></span> </div>');
		$(".agree-pickup").html('<div class="col-md-12"><div class="text"> <input type="checkbox" name="ack" id="ack"><span class="ccd">For orders $'+$(".agree-pickup").attr('limit')+' or more, I agree to present my ID and Credit Card used for the order at time of pickup.</span> <span class="checkmark"></span> </div></div>'); //Added By Manikanata
	}
	else{
		$(".agree-pickup").html('');
	}
	checkCheckoutButton();
});


$(document.body).on("click", "#ack", function () {
	if($("#ack").is(":checked")){
		$("#checkout_submit").removeAttr("disabled");
	}
	else{
		$("#checkout_submit").attr("disabled", "disabled");
	}
});

function checkCheckoutButton(){
	if($('#ack').length > 0){
		if($("#ack").is(":checked")){
			$("#checkout_submit").removeAttr("disabled");
		}
		else{
			$("#checkout_submit").attr("disabled", "disabled");
		}
	}
	else{
		$("#checkout_submit").removeAttr("disabled");
	}
}
//checkCheckoutButton();
function checkCheckoutButton(){
	if($('#ack').length > 0){
		$("#checkout_submit").click(function(){
      $("#ack").change(function() {
        if(this.checked) {
          $('.text').css('backgroundColor','white');
          $('.text').css('color','black');
        }else{
          $('.text').css('backgroundColor','#a82c2e');
          $('.text').css('padding','5px');
          $('.text').css('color','white');
          $("#checkout_submit").attr("disabled", "disabled");
        }
    });
      if($("input[id='ack']").is(':checked')){
         
          $('.text').css('backgroundColor','white');
          $('.text').css('color','black');
         }else{
            $('.text').css('backgroundColor','#a82c2e');
            $('.text').css('padding','5px');
            $('.text').css('color','white');
            $("#checkout_submit").attr("disabled", "disabled");
         }
    
    });
	}
	else{
		$("#checkout_submit").removeAttr("disabled");
	}
}

//Added By Sagar
if($("#reorder_ver_modal").length > 0){
	$("#reorder_ver_modal").modal("show");
}								 