<?php
namespace IBShippingExt;

class Basic
{
  public function __construct()
   {
       //And ...ACTION(S)!
       add_action('woocommerce_shipping_instance_form_fields_flat_rate', array($this, 'add_carrier_id_field_to_shipping'));
       add_action('woocommerce_shipping_instance_form_fields_free_shipping', array($this, 'add_carrier_id_field_to_shipping'));
       add_action('woocommerce_order_status_changed', array($this, 'add_carrier_id_as_meta_on_order_status_changed_to_processing'));
   }

   public function add_carrier_id_field_to_shipping($settings)
    {
        $fields = array();
        foreach ($settings as $key => $value)
        {
            //Adding 'Carrier ID' field after the 'Cost' field
            if($key=='cost')
            {
                $fields[$key] = $value;
                $fields['carrier_id'] = array(
                    'title'         => __( 'Carrier ID', 'ib-shipping-ext' ),
                    'type'             => 'text',
                    'placeholder'    => '123',
                );
            }
            //Adding 'Carrier ID' field after the 'Requires' field
            if($key=='requires')
            {
                $fields[$key] = $value;
                $fields['carrier_id'] = array(
                    'title'         => __( 'Carrier ID', 'ib-shipping-ext' ),
                    'type'             => 'text',
                    'placeholder'    => '123',
                );
            }
            else
            {
                $fields[$key] = $value;
            }
        }
        return $fields;
    }

    public function add_carrier_id_as_meta_on_order_status_changed_to_processing($order_id)
    {
          $order = wc_get_order( $order_id );

          //Checking if order has 'flat_rate' or 'free_shipping' method
          if($order->has_shipping_method('flat_rate') || $order->has_shipping_method('free_shipping'))
          {

            //Getting carrier id of current shipping method
            $shipping_items = $order->get_items( 'shipping' );
            $shipping_method_instance_id = 0;
            $carrier_id="";

            foreach( $order->get_items( 'shipping' ) as $item => $item_obj ){

              $shipping_method_instance_id = $item_obj->get_instance_id();

            }

            if($shipping_method_instance_id > 0)
            {

              //Getting all shipping zones
              $shipping_zones = \WC_Shipping_Zones::get_zones();

              //Iterating through all shipping zones to get shipping method with order's shipping method instance id
              foreach($shipping_zones as $key => $zone)
              {
                 foreach($zone["shipping_methods"] as $method => $method_obj)
                 {

                   if($method_obj->instance_id == $shipping_method_instance_id)
                   {
                      $carrier_id = $method_obj->instance_settings["carrier_id"];
                   }

                 }

              }

              //Adding/updating meta data in order
              if($order->meta_exists('carrier_id'))
              {
                $order->update_meta_data( '_carrier_id', $carrier_id );
              }
              else {
                $order->add_meta_data( '_carrier_id', $carrier_id );
              }
              $order->save();
            }

          }


      }
    }

 ?>
