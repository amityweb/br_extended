<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(PATH_THIRD.'brilliant_retail/mod.brilliant_retail.php');

$plugin_info = array(  	'pi_name' => 'BR Extended',
					    'pi_version' => '1.0.0',
					    'pi_author' => 'Laurence Cope',
					    'pi_author_url' => 'http://www.amitywebsolutions.co.uk',
					    'pi_description' => 'BR Extended Functions',
					    'pi_usage' => Br_extended_usage::instructions() );

class Br_extended extends Brilliant_retail
{
	function __construct()
	{
		parent::__construct();
	}
	
	/******************************************************************** 
	Output raw options values for creating a Quantity Discounts table ***/
	
	function quantity_discounts($product_id='')
	{
		include_once(APPPATH.'modules/channel/mod.channel.php');
		
		$product_id = $this->EE->TMPL->fetch_param('product_id');
		$products 	= $this->_get_product($product_id);
		$templatedata = $this->EE->TMPL->tagdata;
		
		$products_options = $products[0]['options'];

		$count = 0;
		$output = '';
		if( count($products_options) > 0 )
		{
			foreach($products_options AS $products_option)
			{
				if( $products_option['title'] == 'Quantity Discount')
				{
					$total = count($products_option['opts']);
	
					foreach($products_option['opts'] AS $products_option_opts)
					{
						if( $products_option_opts['title'] != "" )
						{
							$count++;
							$options = array(
								'options_total' => $total,
								'options_count' => $count,
								'options_title' => $products_option_opts['title'],
								'options_price' => str_replace('-','-£',$products_option_opts['price'])
							);
							$output .= $this->EE->TMPL->parse_variables_row($templatedata, $options);
	
						}
					}
				}
				
			}
			return $output;
		}
		
		
	}
	
	/******************************************************************** 
	Just get raw product data with no processing like in the original
	original: core/class/core.brilliant_retail.php **********/
		
	function _get_product($product_id)
	{
		if($product_id == '')
		{
			// Get product by param or dynamically 
			$product_id = $this->EE->TMPL->fetch_param('product_id');
			$url_title = $this->EE->TMPL->fetch_param('url_title');
			if($product_id != '')
			{
				$products = $this->EE->product_model->get_products($product_id);			
			}
			else
			{
				// get by url key 
				$key = ($url_title == '') ? $this->EE->uri->segment(2) : $url_title;
				if(!$products = $this->EE->product_model->get_product_by_key($key))
				{
					 // Not a product page 
					 return false;
				}
			}
		}
		
		return $products;
		
	}
		

	/******************************************************************** 
	Countries function to add a default country selection
	original: mod.brilliant_retail.php *********/

	function countries()
	{
		// Set the parameters
		$name = $this->EE->TMPL->fetch_param('name');
		$id =  $this->EE->TMPL->fetch_param('id');
		$class =  $this->EE->TMPL->fetch_param('class');
		$value =  $this->EE->TMPL->fetch_param('value');
		$default =  $this->EE->TMPL->fetch_param('default');

		$countries = $this->EE->product_model->get_countries();
		$output =  '<select name="'.$name.'" id="'.$id.'" class="'.$class.'">';

		foreach($countries as $key => $val)
		{
			$selected = '';
			if($key == $default) $selected = ' selected="selected"';
			
			$sel = ($key == $value) ? 'selected="selected"' : '' ;
			$output .=	'<option value="'.$key.'" class="{zone_id:'.$val["zone_id"].'}" '.$sel.$selected.'>'.$val["title"].'</option>';
		} 			
		$output .= '</select>';
		return $output;
	}
				
}


class Br_extended_usage
{
	function instructions()
	{
		ob_start();
		?>
		
		No instructions at this time sorry
		
		<?php
		$buffer = ob_get_contents();
		ob_end_clean();
		return $buffer;
	}
}
