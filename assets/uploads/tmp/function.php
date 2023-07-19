<?php
function theme_info()
{
   	$data['theme_name']="CozaStore";
   	$data['theme_assets_root']="assets"; 
   	$data['assets_link_path']='frontend/cozastore'; //for assets

   	$data['theme_src_root']="src"; 
   	$data['theme_view_path']='frontend/cozastore'; //for return view path
    return $data; 
}
?>