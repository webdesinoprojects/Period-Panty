<?php
function get_authority()
{
    $ci = get_instance(); // CI_Loader instance
    $item =  $ci->config->item('authority');
   return $item;
}

function create_slug($string)
{
   $slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
   return strtolower($slug);
}

function get_timeago($ptime)
{
    $estimate_time = time() - $ptime;
    if( $estimate_time < 1 )
    {
        return 'less than 1 second ago';
    }
    $condition = array( 
                12 * 30 * 24 * 60 * 60  =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                1                       =>  'second'
    );
    foreach( $condition as $secs => $str )
    {
        $d = $estimate_time / $secs;
        if( $d >= 1 )
        {
            $r = round( $d );
            //return 'about ' . $r . ' ' . $str . ( $r > 1 ? 's' : '' ) . ' ago';
			return  $r . ' ' . $str . ( $r > 1 ? 's' : '' ) . ' ago';
        }
    }
}

function get_date_with_time($date)
{
	return date('d-m-Y h:i:A',strtotime($date));
}

function encode_url($str)
{
	return $str; //urlencode(base64_encode($str));
}

function decode_url($str)
{
	return $str; //urldecode(base64_decode($str));
}

function get_cat_id($str)
{
	$create_array = explode('_',$str);
	return $create_array[1];
}

function create_image_unique($file_name)
{
	$array = explode('.',$file_name);
	$file_extension = end($array);
	$new_file = substr(str_shuffle('12345678910'),0,1).str_shuffle(time()).substr(str_shuffle('12345678910'),0,1).'.'.$file_extension;
	return $new_file;
}

function image_extension($file_name)
{
	$array = explode('.',$file_name);
	$file_extension = end($array);
	return $file_extension;
}

function check_profile_pic($dir,$file)
{
	if(is_file($dir.$file))
	{
		return base_url($dir).$file;
	}
	else
	{
		return base_url("assets/front/images/")."default-avatar.png";
	}
}

function delete_file($dir,$file)
{
	if(is_file($dir.$file))
	{
		return unlink($dir.$file);
	}	
}

function admin_caregory_breadcrumbs($data)
{
	if($data=='Root')
	{
		echo '<strong>Root</strong>';
	}
	else
	{
		echo $data;
	}	
}

function check_product_in_cart($id='')
{	
	$data	= [
		  		 'class' => 'buybutton add-to-cart',
           		 'title' => 'Add to Cart'
				];

	$ci = &get_instance();
    $ci->load->library('cart');	

    if (count($ci->cart->contents())>0){
      foreach ($ci->cart->contents() as $item){
        if ($item['id']==$id){
           
            $data	= [
		   'class' => 'addedbutton',
            'title' => 'Added'

			];


            
        }
      }
    }		


    return $data;
}

    
?>