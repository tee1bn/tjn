  function payWithPaystack($order){


    var handler = PaystackPop.setup({
      key: $order.api_keys,
      email: $order.email,
      amount: $order.amount,
      currency: $order.currency,
      ref: $order.ref, // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
      metadata: {
         custom_fields: $order.custom_fields
      },
      callback: function(response){
        /*
        console.log(response);
        console.log($order);*/

        // post to server to verify transaction before giving value
     
        var verifying = $.get($base_url+"/shop/callback?order_unique_id="+$order.order_unique_id+"&item_purchased="+$order.name_in_shop);
        
        verifying.done(function( data ) { 

              /* give value saved in data */ 
                  console.log(data);
                  if (data.order.paid_at != null) {
                      location.href = data.url;
                  }


        });
      },
      onClose: function(){
          // alert('window closed');
      }
    });
    handler.openIframe();
  }


