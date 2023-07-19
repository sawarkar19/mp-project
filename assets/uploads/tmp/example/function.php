<?php 

//assets root or source code file are root name same but both file should be separated make sure the root path is must be unique

//the zip file name must be without space 


function theme_info()
{
   	$data['theme_name']="Arafa Cart";
   	$data['theme_assets_root']="assets"; 
   	$data['assets_link_path']='frontend/arafa-cart'; //for assets

   	$data['theme_src_root']="src"; 
   	$data['theme_view_path']='frontend/arafa-cart'; //for return view path
    return $data; 
}

?>